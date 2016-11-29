<?php

return [

    'available'      => [

        'bronze' => [
            'key'  => 'bronze',
            'title' => 'Bronze | Entry level plan',
            'description' => 'This is the description for the bronze plan.',
            'price' => '300',
            'limits' => [
                'entries' => 5,
            ]
        ],

        'silver' => [
            'key'  => 'silver',
            'title' => 'Silver | Medium level plan',
            'description' => 'This is the description for the silver plan.',
            'price' => '500',
            'limits' => [
                'entries' => 10,
            ]
        ],

        'golden' => [
            'key'  => 'golden',
            'title' => 'Golden | High level plan',
            'description' => 'This is the description for the golden plan.',
            'price' => '1000',
            'limits' => [
                'entries' => 20,
            ]
        ],
    ]
];
