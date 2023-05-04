<?php

$bitrix = require __DIR__ . '/bitrix_params.php';

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'bsVersion' => '5.x',
    'bitrix' => $bitrix,
    'payKeeper' => [
        'login' => 'admin',
        'password' => '126f2bb086db',
        'host' => 'https://vashotdel-v.server.paykeeper.ru',
    ],
    'telegramBots' => [
        'ВашОтдел' => '5954754283:AAEojbJMVAgi2p1n6Gj8llvPUVQY776apRc',
    ],
];
