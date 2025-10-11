protected $middlewareGroups = [
    'web' => [
        // ... outros middlewares
        \Illuminate\Routing\Middleware\ThrottleRequests::class . ':global',
    ],
    
    'api' => [
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];

protected $routeMiddleware = [
    // ... outros middlewares
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
];