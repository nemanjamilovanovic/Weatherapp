<?php

return[
    'database' => [
        'name' => 'milovanovicmojte_weather',
        'username' => 'milovanovicmojte_nemanja',
        'password' => 'nemanja1234',
        'connection' => 'mysql:host=localhost:3306',
        'options' => [
        ]
    ],
    'dark_sky_api' =>[
        'key' => '5ad3fb5e0a2254159087a7353d0517c3',
        'baseUrl' => 'https://api.darksky.net/forecast/'
    ]
];
