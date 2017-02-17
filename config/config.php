<?php

define("STAGE_DEV", "dev");
define("STAGE_PROD", "prod");

/**
 * Globale Konfiguration der Anwendung.
 */
$config = [
    "general" => [
        "maintenance" => false,
        "stage" => STAGE_DEV
    ],
    "templating" => [
        "templateDir" => "./templates",
        "compileDir" => "./templates_c"
    ],
    "logging" => [
        "logfile" => "./logs/main.log"
    ],
    "routing" => [
        "login" => "Login", 
        "home" => "Home"
    ],
    $menu => [
        "Home" => [
            "role" => 1,
            "module" => "Home"
            ],
        "Vorstand" => [
            "role" => 1,
            "module" => "Management"
            ],
        "Admin" => [
            "role" => 1,
            "module" => "Admin"
            ],
        "Logout" => [
            "role" => 1,
            "module" => "Logout"
            ],
        "Login" => [
            "role" => 1,
            "module" => "Login"
            ]
    ]
];