<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Define os endpoints da aplicação Laravel que aceitam requisições CORS.
    | Inclui as rotas de API e do Sanctum, necessárias para login/register SPA.
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'register',
        'user',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | Permite todos os métodos HTTP usados pela tua SPA (GET, POST, PUT, DELETE).
    |
    */

    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Define as origens que podem fazer pedidos à API.
    | Aqui estão incluídos o Vite (5173) e o backend Laravel (8080).
    |
    */

    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        'http://127.0.0.1:8080',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins Patterns
    |--------------------------------------------------------------------------
    |
    | Mantém vazio a menos que precises de usar expressões regulares.
    |
    */

    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Permite todos os cabeçalhos necessários, incluindo X-Requested-With,
    | Authorization e X-CSRF-TOKEN.
    |
    */

    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Define cabeçalhos visíveis à tua SPA nas respostas HTTP.
    |
    */

    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | Tempo (em segundos) que o navegador pode armazenar a resposta de CORS.
    |
    */

    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | ESSENCIAL: deve estar como TRUE para que o Sanctum envie/receba cookies.
    |
    */

    'supports_credentials' => true,

];
