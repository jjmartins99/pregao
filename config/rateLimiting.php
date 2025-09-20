<?php
// config/rateLimiting.php - CORRIGIDO
return [
    'limiters' => [
        'global' => [
            'max_attempts' => 100,
            'decay_minutes' => 1,
        ],
        
        'api' => [
            'max_attempts' => 30,
            'decay_minutes' => 1,
        ],
        
        'login' => [
            'max_attempts' => 5,
            'decay_minutes' => 15,
        ],
    ]
];