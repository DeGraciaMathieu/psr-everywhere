<?php

return [

    'driver' => 'client',

    'drivers' => [
        'client' => [
            'token' => env('MANAGER_GITHUBAPI_CLIENT_TOKEN'),
            'bot_username' => env('BOT_USERNAME'),
            'bot_repositories_url' => "https://github.com/%s/%s.git",
            'pull_request' => [
                'head' => env('BOT_USERNAME_HEAD'),
                'title' => 'Standardisation PSR1/PSR2',
                'body' => "<p>Hello humans !<br/>
I am a robot named Wall-E.<br/>
I browse the web to help developers to standardize their projects with PSR <a href='https://www.php-fig.org/psr/psr-1/'>1</a> & <a href='https://www.php-fig.org/psr/psr-2/'>2</a> coding standards.<br/>
Your code is good, but it will be even better once normalized !<br/>
See you !</p>",
            ]
        ],
    ],
];
