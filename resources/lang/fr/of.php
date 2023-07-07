<?php

return [
    'back_edit' => 'Retour à l\'édition',
    'quiz' => [
        'first_page' => 'Première page',
        'delete_version' => 'Supprimer cette version',
        'add_version' => 'Ajouter',
        'copy_version' => 'Dupliquer',
    ],
    'index' => [
        'title' => 'Synthèse',
        'sub_title' => ''
    ],
    'profile' => [
        'edit' => [
            'title' => 'Profil OF',
            'sub_title' => 'Gérez ci-dessous les informations relatives à votre organisme de formation.',
            'btn' => 'Mettre à jour le profil',
        ],
    ],
    'intra_trainings' => [
        'title' => 'Gestion Intras',
    ],
    'supports' => [
        'title' => 'Supports de formation',
        'sub_title' => "Téléchargez le document et saisissez son nom, tel qu'il apparaitra au sein de l'espace apprenant.",
        'btn' => 'Ajouter le support',
        'name' => 'Nom du fichier',
        'upload_document' => ['text' => 'Types de documents : PDF<br>Poids Max : 10 Mo.'],
    ],
    'courses' => [
        'tab_nav' => [
            'info' => 'Informations',
            'prerequisite-quiz' => 'Quiz pré-requis',
            'evaluation-quiz' => 'Quiz évaluation',
            'module-quiz' => 'Gestion module'
        ],
        'index' => [
            'title' => 'Liste formations',
            'sub_title' => "Retrouvez ci-dessous l'ensemble de vos formations."
        ],
        'create' => [
            'title' => 'Ajouter une formation',
            'sub_title' => 'Saisissez les informations nécessaires à la création de votre formation.',
            'btn' => 'Créer la formation'
        ],
        'edit' => [
            'title' => 'Editer une formation',
            'sub_title' => '',
            'btn' => 'Mettre à jour la formation'
        ],
        'main' => [
            'title' => 'Informations principales',
            'sub_title' => ''
        ],
        'internal_comment' => [
            'title' => 'Commentaire interne',
            'sub_title' => "Si besoin saisissez ci-dessous votre commentaire interne (qui n'apparaitra qu'au sein de cette page)."
        ],
        'indicators' => [
            'title' => 'Affectations spécifiques',
            'sub_title' => 'Pour permettre le suivi d\'indicateurs dédiés le cas échéant.'
        ],
        'resources' => [
            'title' => 'Illustration et vidéo',
            'sub_title' => 'Pour illustrer votre formation sur le site.',
            'text' => 'Format : PNG ou JPG (max. 1920x1080px).<br>Cette image s\'affichera sur la page de vente et au sein de l\'espace apprenant.'
        ],
        'promo_message' => [
            'title' => 'Message personnalisé',
            'sub_title' => "Ce message sera mis en avant sur la page de vente de votre formation.<br>
Il peut s'agir par exemple d'un message promotionnel, ou d'une date de disponibilité."
        ],
        'learner_message' => [
            'title' => 'Message pour les apprenants',
            'sub_title' => "Informations pratiques pour les apprenants,<br> visibles sur la page Détail formation et dans l'e-mail de convocation."
        ],
        'access_rules' => [
            'title' => 'Règles d\'accès',
            'sub_title' => 'A l\'aide du formulaire ci-dessous, ajoutez une règle d\'accès à remplir par l\'apprenant<br> pour autoriser son inscription à cette formation.',
            'required_courses' => 'Formations obligatoires',
            'indicators_sub_title' => '',
            'indicators_min' => '',
            'btn' => 'Ajouter cette règle à la formation'
        ],
        'content' => [
            'title' => 'Description & contenu',
        ]
    ],
    'session_trainers' => [
        'title' => 'Formateurs',
        'sub_title' => 'Associez un formateur à cette session, à l\'aide du formulaire ci-dessous.',
        'btn' => 'Ajouter'
    ],
    'classrooms' => [
        'name' => 'Nom de la salle',
        'max_learners' => 'Max. apprenants',
        'pmr' => 'Accessibilité PMR',
        'index' => [
            'title' => 'Liste des salles de formation',
            'sub_title' => 'Retrouvez ci-dessous l\'ensemble de vos salles  de formation.',
        ],
        'create' => [
            'title' => 'Ajouter une salle de formation',
            'sub_title' => 'Saisissez les informations nécessaires à la création de votre salle de formation.',
            'btn' => 'Ajouter la salle'
        ],
        'edit' => [
            'title' => 'Editer une salle de formation',
            'sub_title' => '',
            'btn' => 'Mettre à jour la salle'
        ],
        'main' => [
            'title' => 'Informations principales',
            'sub_title' => ''
        ],
        'address' => [
            'title' => 'Adresse',
        ],
    ],
    'promotions' => [
        'name' => 'Nom de la promotion',
        'index' => [
            'title' => 'Liste des promotions',
            'sub_title' => 'Retrouvez ci-dessous l\'ensemble de vos promotions.',
        ],
        'create' => [
            'title' => 'Ajouter une  promotion',
            'sub_title' => 'Saisissez les informations nécessaires à la création de votre promotion.',
            'btn' => 'Ajouter la promotion'
        ],
        'edit' => [
            'title' => 'Editer une promotion',
            'sub_title' => '',
            'btn' => 'Mettre à jour la promotion'
        ],
        'main' => [
            'title' => 'Informations principales',
            'sub_title' => ''
        ],
        'amount' => 'Montant remise',
        'percent' => 'Remise %',
        'date_start' => 'Date début de validité (optionnelle)',
        'date_end' => 'Date fin de validité (optionnelle)',
        'code' => 'Code promo à saisir (optionnel)',
        'companies_title' => 'Sociétés associées (Si exclusivité)',
        'companies' => 'Sociétés associées à cette promotion',
    ],
    'trainers' => [
        'description_title' => 'Description / CV',
        'info_title' => 'Informations professionnelles',
        'cv' => 'Saisissez ci-dessous le CV du formateur',
        'city' => 'Ville de résidence',
        'type' => 'Raison sociale',
        'type_person' => 'Personne physique',
        'type_company' => 'Personne morale',
        'index' => [
            'title' => 'Liste formateurs',
            'sub_title' => 'Retrouvez ci-dessous l\'ensemble de vos formateurs.',
        ],
        'create' => [
            'title' => 'Ajouter un formateur',
            'sub_title' => 'Saisissez les informations nécessaires à la création de votre formateur.',
            'btn' => 'Ajouter le formateur'
        ],
        'edit' => [
            'title' => 'Editer un formateur',
            'sub_title' => '',
            'btn' => 'Mettre à jour le formateur'
        ],
        'main' => [
            'title' => 'Informations principales',
            'sub_title' => ''
        ],
        'internal_comment' => [
            'title' => 'Commentaire interne',
            'sub_title' => "Si besoin saisissez ci-dessous votre commentaire interne (qui n'apparaitra qu'au sein de cette page)."
        ],
        'learner_message' => [
            'title' => 'Message pour les apprenants',
            'sub_title' => "Informations pratiques pour les apprenants visibles sur la page Détail formation et dans l'e-mail de convocation."
        ]
    ],
    'sessions' => [
        'tab_nav' => [
            'info' => 'Informations',
            'prerequisite-quiz' => 'Quiz pré-requis',
            'evaluation-quiz' => 'Quiz évaluation',
            'module-quiz' => 'Gestion module'
        ],
        'index' => [
            'title' => 'Liste sessions',
            'sub_title' => 'Retrouvez ci-dessous l\'ensemble de vos sessions.',
        ],
        'create' => [
            'title' => 'Ajouter une session',
            'sub_title' => 'Saisissez les informations nécessaires à la création de votre session.',
            'btn' => 'Créer la session'
        ],
        'edit' => [
            'title' => 'Editer une session',
            'sub_title' => '',
            'btn' => 'Mettre à jour la session'
        ],
        'main' => [
            'title' => 'Informations principales',
            'sub_title' => ''
        ],
        'internal_comment' => [
            'title' => 'Commentaire interne',
            'sub_title' => "Si besoin saisissez ci-dessous votre commentaire interne (qui n'apparaitra qu'au sein de cette page)."
        ],
        'learner_message' => [
            'title' => 'Message pour les apprenants',
            'sub_title' => "Informations pratiques pour les apprenants visibles sur la page Détail formation et dans l'e-mail de convocation."
        ],
        'psh_accessibility' => [
            'title' => 'Accessibilité PSH',
            'sub_title' => "Ce message sera mis en avant sur la page de vente de votre formation.<br>
Il peut s'agir par exemple d'un message promotionnel, ou d'une date de disponibilité.",
        ],
        'promo_message' => [
            'title' => 'Message personnalisé',
            'sub_title' => "Ce message sera mis en avant sur la page de vente de votre formation.<br>
Il peut s'agir par exemple d'un message promotionnel, ou d'une date de disponibilité."
        ],
    ],
    'session_days' => [
        'title' => 'Jours & horaires',
        'sub_title' => 'Ajouter une journée à votre session à l\'aide du formulaire ci-dessous.',
        'btn' => 'Ajouter',
        'date' => 'Date',
        'description' => 'Description supplémentaire',
        'am_start' => 'Début matinée',
        'am_end' => 'Fin matinée',
        'pm_start' => 'Début après-midi',
        'pm_end' => 'Fin après-midi',
    ],
    'packs' => [
        'index' => [
            'title' => 'Packs e-learning',
            'sub_title' => 'Retrouvez ci-dessous l\'ensemble de vos packs e-learning.',
        ],
        'create' => [
            'title' => 'Ajouter un pack',
            'sub_title' => 'Saisissez les informations nécessaires à la création de votre pack.',
            'btn' => 'Créer le pack'
        ],
        'edit' => [
            'title' => 'Editer un pack',
            'sub_title' => '',
            'btn' => 'Mettre à jour le pack'
        ],
        'main' => [
            'title' => 'Informations principales',
            'sub_title' => ''
        ],
        'packables' => [
            'title' => 'Contenu du pack',
            'sub_title' => 'Choisissez ci-dessous les formations à intégrer à ce pack',
            'btn' => 'Ajouter au pack',
            'elearnings' => 'Modules E-elearning',
            'sessions' => 'Sessions',
        ],
    ],
    'blendeds' => [
        'index' => [
            'title' => 'Parcours',
            'sub_title' => 'Retrouvez ci-dessous l\'ensemble de vos parcours.',
        ],
        'create' => [
            'title' => 'Ajouter un parcours',
            'sub_title' => 'Saisissez les informations nécessaires à la création de votre parcours.',
            'btn' => 'Créer le parcours'
        ],
        'edit' => [
            'title' => 'Editer un parcours',
            'sub_title' => '',
            'btn' => 'Mettre à jour le parcours'
        ],
        'main' => [
            'title' => 'Informations principales',
            'sub_title' => ''
        ],
        'packables' => [
            'title' => 'Contenu du parcours',
            'sub_title' => 'Choisissez ci-dessous les formations à intégrer à ce parcours',
            'btn' => 'Ajouter au parcours',
            'elearnings' => 'Modules E-elearning',
            'sessions' => 'Sessions',
        ],
    ],
    'learners' => [
        'index' => ['title' => 'Liste des apprenants',
            'sub_title' => '',
            'tab_nav' => [
                'in' => 'Apprenants en poste',
                'left' => 'Apprenants sortis'
            ]
        ],
        'create' => [
            'title' => 'Création apprenant',
            'sub_title' => 'Créez un apprenant à l\'aide du formulaire ci-dessous.',
            'infos_perso_title' => 'Informations personnelles',
            'infos_pro_title' => 'Informations professionnelles',
            'infos_connexion_title' => 'Informations connexion',
        ],
        'edit' => [
            'title' => 'Détails apprenant',
            'sub_title' => 'Gérez les informations de cet apprenant ici.',
            'public_info_title' => 'Informations personnelles',
            'pro_info_title' => 'Informations professionnelles',
            'user_info_title' => 'Informations de connexion',
        ]
    ],
    'monitoring' => [
        'sessions' => [
            'title' => 'Suivi sessions',
            'type' => [
                'virtual' => 'Classe virtuelle',
                'physical' => 'Séance de formation en salle'
            ],
            'edit' => [
                'title' => 'Détails session'
            ]
        ],
        'elearnings' => [
            'title' => 'Suivi e-learning',
            'type' => [
                'virtual' => 'Classe virtuelle',
                'physical' => 'Séance de formation en salle'
            ],
        ],
        'elearning' => [
            'edit' => [
                'title' => 'Détails e-learning'
            ]
        ],
        'customers' => [
            'title' => 'Suivi clients',


        ],
        'customer' => [
            'details' => [
                'tab_nav' => [
                    'in' => 'Apprenants en poste',
                    'left' => 'Apprenants sortis'
                ]
            ]
        ]
    ]
];
