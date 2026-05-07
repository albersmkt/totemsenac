<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SenacProxyController extends Controller
{
    private const TARGET_HOST = 'https://www.sp.senac.br';
    private const PROXY_PREFIX = '/senac-proxy/';
    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';

    public function handle(Request $request, ?string $path = null)
    {
        $safePath = ltrim((string) $path, '/');
        if (Str::startsWith($safePath, ['http://', 'https://'])) {
            return response('Invalid proxy path', 400);
        }

        $url = rtrim(self::TARGET_HOST, '/') . '/' . $safePath;
        $query = $request->getQueryString();
        if ($query) {
            $url .= '?' . $query;
        }

        $response = Http::withHeaders([
            'User-Agent' => self::USER_AGENT,
            'Accept-Language' => 'pt-BR,pt;q=0.9',
        ])->timeout(15)->get($url);

        $contentType = $response->header('Content-Type', 'text/html; charset=UTF-8');
        $body = $response->body();

        if ($this->shouldRewrite($contentType)) {
            $body = $this->rewriteContent($body, $contentType);
        }

        $headers = [
            'Content-Type' => $contentType,
        ];

        if ($response->header('Cache-Control')) {
            $headers['Cache-Control'] = $response->header('Cache-Control');
        }

        return response($body, $response->status(), $headers);
    }

    private function shouldRewrite(string $contentType): bool
    {
        return Str::contains($contentType, ['text/html', 'text/css', 'javascript', 'application/javascript']);
    }

    private function rewriteContent(string $body, string $contentType): string
    {
        $proxyPrefix = self::PROXY_PREFIX;
        $externalPath = '/externo';
        $body = str_replace(
            ['https://www.sp.senac.br/', 'http://www.sp.senac.br/', '//www.sp.senac.br/'],
            $proxyPrefix,
            $body
        );

        $body = preg_replace(
            '/(href|src|action|poster|data-src|data-href|data-background)=([\\\"\'])\\/(?!\\/|senac-proxy\\/)/i',
            '$1=$2' . $proxyPrefix,
            $body
        );

        $body = preg_replace_callback(
            '/(srcset|data-srcset)=([\\\"\'])([^\\\"\']+)/i',
            function ($matches) use ($proxyPrefix) {
                $attribute = $matches[1];
                $quote = $matches[2];
                $value = $matches[3];
                $entries = array_filter(array_map('trim', explode(',', $value)));

                $rewritten = [];
                foreach ($entries as $entry) {
                    $parts = preg_split('/\\s+/', $entry, 2);
                    $url = $parts[0] ?? '';
                    $descriptor = $parts[1] ?? '';

                    if (Str::startsWith($url, ['https://www.sp.senac.br/', 'http://www.sp.senac.br/'])) {
                        $parsed = parse_url($url);
                        $path = $parsed['path'] ?? '';
                        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
                        $fragment = isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '';
                        $url = $proxyPrefix . ltrim($path, '/') . $query . $fragment;
                    } elseif (Str::startsWith($url, '//www.sp.senac.br/')) {
                        $url = $proxyPrefix . ltrim(Str::after($url, '//www.sp.senac.br/'), '/');
                    } elseif (Str::startsWith($url, '/')) {
                        $url = $proxyPrefix . ltrim($url, '/');
                    }

                    $rewritten[] = trim($url . ' ' . $descriptor);
                }

                return $attribute . '=' . $quote . implode(', ', $rewritten) . $quote;
            },
            $body
        );

        $body = preg_replace('/url\\(\\s*\\/(?!\\/|senac-proxy\\/)/i', 'url(' . $proxyPrefix, $body);

        $body = preg_replace_callback(
            '/<a\\s[^>]*href=([\\\"\'])([^\\\"\']+)\\1[^>]*>/i',
            function ($matches) use ($externalPath) {
                $tag = $matches[0];
                $href = trim($matches[2]);

                if (Str::startsWith($href, ['#', 'javascript:'])) {
                    return $tag;
                }

                $absolute = null;
                if (Str::startsWith($href, ['http://', 'https://'])) {
                    $absolute = $href;
                } elseif (Str::startsWith($href, '//')) {
                    $absolute = 'https:' . $href;
                } elseif (Str::startsWith($href, ['mailto:', 'tel:'])) {
                    $absolute = $href;
                }

                if (! $absolute) {
                    return $tag;
                }

                $host = parse_url($absolute, PHP_URL_HOST);
                if ($host && Str::endsWith($host, 'sp.senac.br')) {
                    return $tag;
                }

                $replacement = $externalPath . '?url=' . rawurlencode($absolute);
                $tag = preg_replace('/href=([\\\"\'])([^\\\"\']*)\\1/i', 'href="' . $replacement . '"', $tag);
                $tag = preg_replace('/\\s*target=([\\\"\'])_blank\\1/i', '', $tag);

                return $tag;
            },
            $body
        );

        $body = preg_replace('/\\s+target=([\\\"\'])_blank\\1/i', '', $body);

        if (Str::contains($contentType, 'text/html') && ! Str::contains($body, '<base')) {
            $body = preg_replace('/<head(.*?)>/', '<head$1><base href="' . $proxyPrefix . '">', $body, 1);
        }

        return $body;
    }
}
