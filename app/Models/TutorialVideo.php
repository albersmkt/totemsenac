<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TutorialVideo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'youtube_url',
        'youtube_video_id',
        'audience_role',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function completions(): HasMany
    {
        return $this->hasMany(TutorialCompletion::class);
    }

    public function embedUrl(): string
    {
        return 'https://www.youtube.com/embed/'.$this->youtube_video_id;
    }

    public function thumbnailUrl(): string
    {
        return 'https://img.youtube.com/vi/'.$this->youtube_video_id.'/hqdefault.jpg';
    }

    public function audienceLabel(): string
    {
        return $this->audience_role === 'operador' ? 'Operador' : 'Aluno';
    }

    public static function parseYoutubeVideoId(string $url): ?string
    {
        $parts = parse_url($url);
        if ($parts === false || empty($parts['host'])) {
            return null;
        }

        $host = strtolower($parts['host']);
        $path = trim($parts['path'] ?? '', '/');

        if (str_contains($host, 'youtu.be') && $path !== '') {
            return self::cleanVideoId(explode('/', $path)[0]);
        }

        if (str_contains($host, 'youtube.com')) {
            parse_str($parts['query'] ?? '', $query);
            if (! empty($query['v'])) {
                return self::cleanVideoId((string) $query['v']);
            }

            $segments = explode('/', $path);
            if (in_array($segments[0] ?? '', ['embed', 'shorts'], true) && ! empty($segments[1])) {
                return self::cleanVideoId($segments[1]);
            }
        }

        return null;
    }

    private static function cleanVideoId(string $value): ?string
    {
        return preg_match('/^[A-Za-z0-9_-]{6,32}$/', $value) ? $value : null;
    }
}
