<?php
return [
    'general' =>  [
        'timezone' => 'America/Sao_Paulo',
        'language' => 'pt',
        'application' => 'template',
        'title' => 'Adianti Fork Template 8.0',
        'theme' => 'adminbs5_v2',
        'seed' => 'odfu6asnodf8as',
        'rest_key' => '',
        'multiunit' => '1',
        'public_view' => '0',
        'public_entry' => '',
        'debug' => '1',
        'multi_lang' => '1',
        'require_terms' => '0',
        'concurrent_sessions' => '1',
        'lang_options' => [
          'pt' => 'Português',
          'en' => 'English',
          'es' => 'Español',
        ],
        'multi_database' => '0',
        'validate_strong_pass' => '1',
        'notification_login' => '0',
        'welcome_message' => 'Have a great jorney!',
        'request_log_service' => 'SystemRequestLogService',
        'request_log' => '0',
        'request_log_types' => 'cli,web,rest',
        /*'password_renewal_interval' => '',*/
    ],
    'recaptcha' => [
        'enabled' => '0',
        'key' => '...',
        'secret' => '...'
    ],
    'permission' =>  [
        'public_classes' => [
          'SystemRequestPasswordResetForm',
          'SystemPasswordResetForm',
          'SystemRegistrationForm',
          'SystemPasswordRenewalForm',
        ],
        'user_register' => '1',
        'reset_password' => '1',
        'default_groups' => '2',
        'default_screen' => '30',
        'default_units' => '1',
    ],
    'highlight' => [
        'comment' => '#808080',
        'default' => '#FFFFFF',
        'html' => '#C0C0C0',
        'keyword' => '#62d3ea',
        'string' => '#FFC472',
    ],
    'login' => [
        'logo' => 'app/images/icon.png',
        'background' => 'app/images/thumb-1920-698137.jpg'
    ],
    'system' => [
        'system_version' => '2.0.0'
    ],    
    'template' => [
        'navbar' => [
            'has_program_search' => '1',
            'has_notifications' => '1',
            'has_messages' => '1',
            'has_docs' => '1',
            'has_contacts' => '1',
            'has_support_form' => '1',
            'has_wiki' => '1',
            'has_news' => '1',
            'has_menu_mode_switch' => '1',
            'has_main_mode_switch' => '1'
        ],
        'dialogs' => [
            'use_swal' => '1'
        ],
        'theme' => [
            'menu_dark_color' => 'rgb(29 45 83)',
            'menu_mode'  => 'dark',
            'main_mode'  => 'light'
        ]
    ]
];
