<?php
return [
    'general' =>  [
        'timezone' => 'America/Sao_Paulo',
        'language' => 'pt',
        'application' => 'ludsce',
        'title' => 'Ludes CE',
        'theme' => 'adminbs5_v8',
        'seed' => 'odfu6asnodf8as',
        'rest_key' => '',
        'multiunit' => '0',
        'public_view' => '0', // Habilita a visualização de páginas públicas. Quando ligado muda a imagem para o fundo geral
        'public_entry' => '',
        'debug' => '0',
        'strict_request' => '0',
        'multi_lang' => '1',
        'require_terms' => '0',
        'concurrent_sessions' => '1',
        'lang_options' => [
          'pt' => 'Português',
          'en' => 'English',
          'es' => 'Español',
          'fr' => 'Français',
          'de' => 'Deutsch',
          'it' => 'Italiano',
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
          'SystemConcurrentAccessView',
          'SystemInvalidAccessView'
        ],
        'admin_groups' => ['1'],
        /*'allowed_unit_groups' => ['3'],*/
        'user_register' => '1',
        'reset_password' => '1',
        'default_groups' => '2',
        'default_screen' => '30',
        'default_units' => '1',
        'user_deletion' => '1'
    ],
    'hooks' =>
    [
        'after_user_creation' => [],
        'after_unit_creation' => [],
        'after_login' => [],
        'before_logout' => []
    ]
    ,
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
    'template' => [
        'navbar' => [
            'has_program_search' => '1',
            'has_notifications' => '0',
            'has_messages' => '0',
            'has_docs' => '0',
            'has_contacts' => '0',
            'has_support_form' => '0',
            'has_wiki' => '0',
            'has_news' => '0',
            'has_menu_mode_switch' => '1',
            'has_main_mode_switch' => '1',
            'has_master_menu' => '0',  // 0 = menu lateral, 1 = menu icones
            'always_collapse' => '0',
            'allow_page_tabs' => '0',
            'only_top_menu' => '0', // Habilita o menu superior
            'header_display' => "visible",
            'footer_display' => "visible"
        ],
        'dialogs' => [
            'use_swal' => '1'
        ],
        'theme' => [
            /*'menu_dark_color' => 'rgb(29 45 83)',*/
            'login_mode'  => 'light',
            'menu_mode'  => 'dark',
            'main_mode'  => 'light',
            'box_layout' => '0'
        ]
    ],
    'system' =>  [
        'system_version' => '1.0.0',
        'system_name_sub'=> 'Fork do Adianti FrameWork',
        'adianti_min_version'=> '8.7.0.1',
        'formdin_min_version'=> '5.15.2',
    ]
];
