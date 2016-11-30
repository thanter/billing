<?php

return [

    'available'      => [

        'bronze' => [
            'key'  => 'bronze',
            'title' => 'Bronze | Entry level plan',
            'description' => 'This is the description for the bronze plan.',
            'charge_modes' => [
                'month' => [
                    'price' => 300
                ],
                'year' => [
                    'price' => 3000
                ]
            ],
            'limits' => [
                'entries' => 5,
            ]
        ],

        'silver' => [
            'key'  => 'silver',
            'title' => 'Silver | Medium level plan',
            'description' => 'This is the description for the silver plan.',
            'charge_modes' => [
                'month' => [
                    'price' => 500
                ],
                'year' => [
                    'price' => 5000
                ]
            ],
            'limits' => [
                'entries' => 10,
            ]
        ],

        'golden' => [
            'key'  => 'golden',
            'title' => 'Golden | High level plan',
            'description' => 'This is the description for the golden plan.',
            'charge_modes' => [
                'month' => [
                    'price' => 1000
                ],
                'year' => [
                    'price' => 10000
                ]
            ],
            'limits' => [
                'entries' => 20,
            ]
        ],
    ]
];
