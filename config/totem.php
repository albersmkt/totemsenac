<?php

return [
    'courses_url' => env('SENAC_COURSES_URL', 'https://www.sp.senac.br/senac-registro/cursos-livres'),
    'courses_source' => [
        'label' => 'Senac Registro - Cursos Livres',
        'url' => 'https://www.sp.senac.br/senac-registro/cursos-livres',
    ],
    'courses_cache_ttl' => env('SENAC_COURSES_CACHE_TTL', 21600),
    'courses_proxy_path' => env('SENAC_COURSES_PROXY_PATH', 'senac-registro/cursos-livres'),
];
