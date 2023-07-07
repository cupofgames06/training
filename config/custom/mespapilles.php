<?php

return [
    'supported_locales' => [
        'fr', 'en'
    ],
    'date_format' => 'd/m/Y', //format de date utilisé pour les affichages et les calendar
    'datepicker-format' => 'dd/mm/yyyy',
    'auto-translation' => false,
    'auto-quiz' => false,
    'meelk-api' => ['key' => '3|dPfdFB5jUqVB0k6vIJy4hzIvLcwC8ek8Lnx4WXYt'],
    'course-type' => [
        'virtual' => ['name'=>'Classe virtuelle'],
        'physical' => ['name'=>'Session présentielle'],
        'elearning' => ['name'=>'Module E-learning'],
    ],
    'price-level' => [
        'Standard'
    ],
    'pack-type' => [
        'pack' => ['name'=>'Pack E-Learning'],
        'blended' => ['name'=>'Parcours'],
    ],
    'indicators' => [
        //rouge
        [
            'objective' => 100,
            'name' => ['fr' => 'rouge', 'en' => 'red'],
            'unit' => ['fr' => 'points', 'en' => 'points']
        ],
        //blanc
        [
            'objective' => 100,
            'name' => ['fr' => 'blanc', 'en' => 'white'],
            'unit' => ['fr' => 'points', 'en' => 'points']
        ],
        //rosé
        [
            'objective' => 100,
            'name' => ['fr' => 'rosé', 'en' => 'rosé'],
            'unit' => ['fr' => 'points', 'en' => 'points']
        ],
        //bulles
        [
            'objective' => 100,
            'name' => ['fr' => 'bulles', 'en' => 'bubbles'],
            'unit' => ['fr' => 'points', 'en' => 'points']
        ]
    ],
    'tags' => [
        'learner' =>
            [
                'function' => [
                    ['fr' => 'fonction fr 1', 'en' => 'fonction en 1'],
                    ['fr' => 'fonction fr 2', 'en' => 'fonction en 2'],
                ],
                'service' => [
                    ['fr' => 'service fr 1',
                        'en' => 'service en 1']
                ],
            ],
        'course' =>
            [
                'theme' => [
                    ['fr' => 'theme fr 1', 'en' => 'theme en 1'],
                    ['fr' => 'theme fr 2', 'en' => 'theme en 2'],
                ]
            ],
    ],
    'charge' => '5',
    'vat_rates' => [
        '20' => '20%',
        '5' => '5%'
    ]
];
