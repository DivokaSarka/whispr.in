<?php

return [
    'class' => 'rmrevin\yii\postman\Component',
    'driver' => 'smtp',
    'default_from' => ['noreply@whispr.in', 'Mailer'],
    'subject_prefix' => 'Whispr In / ',
    'subject_suffix' => null,
    'table' => '{{%postman_letter}}',
    'view_path' => '/email',
    'smtp_config' => [
        'host' => 'smtp.domain.cpom',
        'port' => 465,
        'auth' => true,
        'user' => 'email@domain.cpom',
        'password' => 'password',
        'secure' => 'ssl',
        'debug' => true,
    ]
];
