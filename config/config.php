<?php

define('STAGE_DEV', "dev");
define('STAGE_PROD', "prod");
define('REDBEAN_MODEL_PREFIX', '\\findus\\model\\' );

/**
 * global configuration of the application.
 */
$config = [
    'general' => [
        'maintenance' => false,
        'stage' => STAGE_DEV,
        'title' => 'Tierhilfe'
    ],
    "login" => [
        "enableRecaptcha" => false,
        "secret" => ""
    ],
    'uploads' => [
        
    ],
    'templating' => [
        'templateDir' => './templates',
        'compileDir' => './templates_c'
    ],
    'logging' => [
        'logfile' => './logs/main.log'
    ],
    'routing' => [
        'login' => 'Login', 
        'home' => 'Home'
    ],
    'database' => [
        'dsn' => 'later',
        'username' => 'your_mother',
        'password' => 'too_easy'
    ],
    'menu' => [
        "Home" => [
            "role" => 1,
            "module" => "menu\\Home",
            "menu" => []
            ],
        "Mitarbeiter" => [
            "role" => 3,
            "module" => "menu\\Employee",
            "menu" => [
                'Tiere suchen' => 'animal\\SearchAnimal',
                'Tier erfassen' => 'animal\\AddAnimal',
                'Tierarten und Rassen' => 'species\\ManageSpecies'
                ]
            ],
        "Vorstand" => [
            "role" => 7,
            "module" => "menu\\Management",
            "menu" => [
                "Eingangsarten" =>  "admission\\ManageAdmissionTypes",
                "Behandlungsarten" =>  "therapy\\ManageTherapyTypes",
                "Vereinsmitglieder" =>  "employee\\ManageEmployees",
                "Tierärzte" =>  "veterinarian\\ManageVeterinarians",
                "Eingänge je Zeitraum" =>  "AdditionsReport",
                "Behandlungen je Zeitraum" =>  "AdditionsReport",
                "Vermittlungsübersicht je Zeitraum" =>  "AdditionsReport",
                "Pflegefälle je Zeitraum" =>  "AdditionsReport"
                ]
            ],
        "Admin" => [
            "role" => 15,
            "module" => "menu\\Admin",
            "menu" => [
                    "Benutzer verwalten" => "user\\ManageUsers",
                    "Konfiguration verwalten" => "configuration\\ManageConfiguration"
                ]
            ],
        "Logout" => [
            "role" => 3,
            "module" => "user\\Logout",
            "menu" => []
            ],
        "Kontakt" => [
            "role" => 1,
            "module" => "menu\\Contact",
            "menu" => []
        ],
        "Login" => [
            "role" => 1,
            "module" => "user\\Login",
            "menu" => []
            ]
    ]
];