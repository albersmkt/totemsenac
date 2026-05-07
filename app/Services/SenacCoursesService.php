<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SenacCoursesService
{
    private const CACHE_PATH = 'courses_cache.json';
    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';

    public function getCourses(): array
    {
        $source = config('totem.courses_source', []);
        $ttl = (int) config('totem.courses_cache_ttl', 21600);

        $cached = $this->readCache();
        if ($cached && $this->isFresh($cached['fetched_at'] ?? null, $ttl)) {
            return $this->buildResponse($cached['items'] ?? [], $cached['fetched_at'] ?? null, true, $source);
        }

        $fresh = $this->fetchFromSource($source['url'] ?? null);
        if (! empty($fresh['items'])) {
            $this->writeCache($fresh);
            return $this->buildResponse($fresh['items'], $fresh['fetched_at'], false, $source);
        }

        if ($cached) {
            return $this->buildResponse($cached['items'] ?? [], $cached['fetched_at'] ?? null, true, $source, true);
        }

        return $this->buildResponse([], null, false, $source, true);
    }

    private function fetchFromSource(?string $url): array
    {
        if (empty($url)) {
            return ['items' => [], 'fetched_at' => null];
        }

        try {
            $context = $this->fetchContext($url);
            if (! $context) {
                return ['items' => [], 'fetched_at' => null];
            }

            $unitCategoryId = $this->fetchUnitCategoryId($context['friendly_unidade']);
            if (! $unitCategoryId) {
                return ['items' => [], 'fetched_at' => null];
            }

            $themes = $this->fetchThemes($context);
            if (empty($themes)) {
                return ['items' => [], 'fetched_at' => null];
            }

            $types = config('totem.courses_types', ['Livre']);
            $items = [];

            foreach ($types as $typeName) {
                $typeCategoryId = $this->fetchCourseTypeId($context['group_id'], $typeName);
                if (! $typeCategoryId) {
                    continue;
                }

                foreach ($themes as $theme) {
                    $courses = $this->fetchCoursesByTheme(
                        $context['group_id'],
                        $typeCategoryId,
                        $unitCategoryId,
                        $theme['categoryId'] ?? null
                    );

                    foreach ($courses as $course) {
                        $title = $course['toDisplay']['title'] ?? null;
                        if (! $title) {
                            continue;
                        }

                        $items[$title] = [
                            'title' => $title,
                            'type' => $course['toDisplay']['tipoName'] ?? $typeName,
                            'modality' => $course['toDisplay']['formatoName'] ?? 'Presencial',
                            'area' => $theme['name'] ?? null,
                        ];
                    }
                }
            }

            return [
                'items' => array_values($items),
                'fetched_at' => now()->toIso8601String(),
            ];
        } catch (\Throwable $e) {
            return ['items' => [], 'fetched_at' => null];
        }
    }

    private function fetchContext(string $url): ?array
    {
        $response = Http::withHeaders([
            'User-Agent' => self::USER_AGENT,
            'Accept-Language' => 'pt-BR,pt;q=0.9',
        ])->timeout(12)->get($url);

        if (! $response->successful()) {
            return null;
        }

        $html = $response->body();

        $groupId = $this->matchValue($html, "/getScopeGroupId\\s*:\\s*function\\(\\)\\s*\\{\\s*return\\s*'(\\d+)'/");
        $companyId = $this->matchValue($html, "/getCompanyId\\s*:\\s*function\\(\\)\\s*\\{\\s*return\\s*'(\\d+)'/");
        $vocabId = $this->matchValue($html, "/id=\"ssp-vocabulary-id-tema-mercadologico\"[^>]*value=\"(\\d+)\"/");
        $friendlyUnidade = $this->matchValue($html, "/id=\"friendlyUnidade\"[^>]*>([^<]+)</");

        if (! $friendlyUnidade) {
            $parts = parse_url($url);
            $path = trim($parts['path'] ?? '', '/');
            $friendlyUnidade = explode('/', $path)[0] ?? null;
        }

        if (! $groupId || ! $companyId || ! $vocabId || ! $friendlyUnidade) {
            return null;
        }

        return [
            'group_id' => (int) $groupId,
            'company_id' => (int) $companyId,
            'vocab_id' => (int) $vocabId,
            'friendly_unidade' => trim($friendlyUnidade),
        ];
    }

    private function fetchUnitCategoryId(string $friendlyUnidade): ?int
    {
        $url = 'https://www.sp.senac.br/o/senac-unidade-services/categoriaPorFriendlyURL/' . $friendlyUnidade . '/0';
        $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])->timeout(12)->get($url);
        if (! $response->successful()) {
            return null;
        }

        $data = $this->decodeJson($response->body());
        if (! is_array($data) || empty($data[0]['categoryId'])) {
            return null;
        }

        return (int) $data[0]['categoryId'];
    }

    private function fetchCourseTypeId(int $groupId, string $typeName): ?int
    {
        $url = 'https://www.sp.senac.br/o/senac-content-services/idTipoCursoPorNome/' . $groupId . '/' . rawurlencode($typeName);
        $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])->timeout(12)->get($url);
        if (! $response->successful()) {
            return null;
        }

        $value = trim($response->body());
        return is_numeric($value) ? (int) $value : null;
    }

    private function fetchThemes(array $context): array
    {
        $query = http_build_query([
            'companyId' => $context['company_id'],
            'groupIds' => $context['group_id'],
            'parentCategoryIds' => 0,
            'vocabularyIds' => $context['vocab_id'],
        ]);

        $url = 'https://www.sp.senac.br/o/senac-category-services/categories?' . $query;
        $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])->timeout(12)->get($url);
        if (! $response->successful()) {
            return [];
        }

        $data = $this->decodeJson($response->body());
        return is_array($data) ? $data : [];
    }

    private function fetchCoursesByTheme(int $groupId, int $typeCategoryId, int $unitCategoryId, ?int $themeCategoryId): array
    {
        if (! $themeCategoryId) {
            return [];
        }

        $limit = 200;
        $url = 'https://www.sp.senac.br/o/senac-content-services/cursosPorCategoriasComFiltrosBolsaECompra/'
            . $groupId . '/0/0/1/0/' . $limit
            . '?categoryIds=' . $themeCategoryId
            . '&categoryIds=' . $typeCategoryId
            . '&categoryIds=' . $unitCategoryId;

        $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])->timeout(12)->get($url);
        if (! $response->successful()) {
            return [];
        }

        $data = $this->decodeJson($response->body());
        if (! is_array($data)) {
            return [];
        }

        return $data['cursos'] ?? [];
    }

    private function decodeJson(string $body): ?array
    {
        $decoded = json_decode($body, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        $converted = mb_convert_encoding($body, 'UTF-8', 'ISO-8859-1');
        $decoded = json_decode($converted, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }

    private function matchValue(string $html, string $pattern): ?string
    {
        if (preg_match($pattern, $html, $matches)) {
            return $matches[1] ?? null;
        }

        return null;
    }

    private function buildResponse(array $items, ?string $fetchedAt, bool $fromCache, array $source, bool $fallback = false): array
    {
        return [
            'items' => $items,
            'meta' => [
                'fetched_at' => $fetchedAt,
                'from_cache' => $fromCache,
                'fallback' => $fallback,
                'source_label' => $source['label'] ?? null,
                'source_url' => $source['url'] ?? null,
            ],
        ];
    }

    private function readCache(): ?array
    {
        $disk = Storage::disk('local');
        if (! $disk->exists(self::CACHE_PATH)) {
            return null;
        }

        $raw = $disk->get(self::CACHE_PATH);
        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : null;
    }

    private function writeCache(array $data): void
    {
        Storage::disk('local')->put(self::CACHE_PATH, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    private function isFresh(?string $fetchedAt, int $ttl): bool
    {
        if (! $fetchedAt) {
            return false;
        }

        $timestamp = strtotime($fetchedAt);
        if (! $timestamp) {
            return false;
        }

        return (time() - $timestamp) < $ttl;
    }
}
