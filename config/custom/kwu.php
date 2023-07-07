<?php

return [
    'supported_locales' => [
        'fr', 'en'
    ],
    'date_format' => 'd/m/Y', //format de date utilisé pour les affichages et les calendar
    'datepicker-format' => 'dd/mm/yyyy',
    'auto-translation' => false,
    'auto-quiz' => false,
    'auto-image' => false,
    'meelk-api' => ['key' => '3|dPfdFB5jUqVB0k6vIJy4hzIvLcwC8ek8Lnx4WXYt'],
    'course-type' => [
        'virtual' => ['name' => 'Classe virtuelle'],
        'physical' => ['name' => 'Présentiel'],
        'elearning' => ['name' => 'E-learning'],
    ],
    'course-code' => [
        'BOLD',
        'EVENTS',
        'FORMATION',
    ],
    'price-levels' => [
        'KWU' => ['fr' => 'Tarif KWU', 'en' => 'Tarif KWU'],
        'Externe' => ['fr' => 'Tarif externe', 'en' => 'Tarif externe'],
        'FNAIM' => ['fr' => 'Tarif FNAIM', 'en' => 'Tarif FNAIM']
    ],
    'payment-options'=> [
        '2' => '2 fois sans frais',
        '3' => '3 fois sans frais',
        '4' => '4 fois sans frais',
        '5' => '5 fois sans frais'
    ],
    'pack-type' => [
        'pack' => ['name' => 'Pack E-Learning'],
        'blended' => ['name' => 'Parcours'],
    ],
    'indicators' => [
        [
            'objective' => 120,
            'name' => ['fr' => 'déontologie', 'en' => 'déontology'],
            'unit' => ['fr' => 'minutes', 'en' => 'minutes']
        ],
        [
            'objective' => 120,
            'name' => ['fr' => 'TRACFIN', 'en' => 'TRACFIN'],
            'unit' => ['fr' => 'minutes', 'en' => 'minutes']
        ],
        [
            'objective' => 120,
            'name' => ['fr' => 'Non-discrmination', 'en' => 'Non-discrimination'],
            'unit' => ['fr' => 'minutes', 'en' => 'minutes']
        ],
        [
            'objective' => 100,
            'name' => ['fr' => 'ALUR', 'en' => 'ALUR'],
            'unit' => ['fr' => 'minutes', 'en' => 'minutes']
        ],
        [
            'objective' => 100,
            'name' => ['fr' => 'Ignite', 'en' => 'Ignite'],
            'unit' => ['fr' => '%', 'en' => '%']
        ],
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
