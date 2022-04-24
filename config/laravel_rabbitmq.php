<?php
return [
    'connections' => [
        'rabbitmq' => [
            "hostname" => "rabbitmq",
            "port" => "5672",
            "username" => "guest",
            "password" => "guest",
            "vhost" => "/",
        ],
    ],
    'queues' => [
        'urlQueue' => [
            'connection' => 'rabbitmq',
            'name' => 'RSS-URLS',
            'attributes' => [
                'durable' => true
            ]
        ],
        'feedQueue' => [
            'connection' => 'rabbitmq',
            'name' => 'RSS-Items',
            'attributes' => [
                'durable' => true
            ]
        ]
    ],
    'publishers' => [
        'urlPublisher' => 'urlQueue'
    ],
    'consumers' => [
        'rssConsumer' => [
            'queue' => 'feedQueue',
            'message_processor' => \App\Services\ConsumerProcessor::class
        ]
    ]
];

