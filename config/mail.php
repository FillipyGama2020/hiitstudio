<?php

return [
    'host' => env('MAIL_HOST'),
    'port' => (int) env('MAIL_PORT', 465),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'encryption' => env('MAIL_ENCRYPTION', 'smtps'),
    'from_name' => env('MAIL_FROM_NAME', 'Hiitstudio'),
];
