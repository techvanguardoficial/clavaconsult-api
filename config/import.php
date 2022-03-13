<?php

return [
    'api_url' => 'https://api.onmed.com.br/app/php/services/chamafuncoes.php',
    'api_origin' => 'https://app.onmed.com.br',
    'api_timezone' => 'America/Sao_Paulo',

    'api_account' => env('IMPORT_API_ACCOUNT'),
    'api_user_id' => intval(env('IMPORT_API_USER_ID')),
    'api_clinic_id' => intval(env('IMPORT_API_CLINIC_ID')),
    'api_session_id' => env('IMPORT_API_SESSION_ID'),

    'appointment_types' => [
        'Primeira Vez' => 'first',
        'Paciente' => 'default',
        'Pessoal' => 'default',
        'Profissional' => 'default',
        'Reconsulta' => 'return',
        'Cortesia' => 'free',
        'Bloqueado' => 'blocked'
    ],
    'appointment_status' => [
        '0' => 1, // Agendado
        '1' => 2, // Confirmado
        '2' => 8, // Faltou
        '3' => 3, // Em espera
        '4' => 5, // Em consulta
        '5' => 4, // Dilatação
        '6' => 6, // Atendido
        '9' => 9, // Não atendeu
        '10' => 10, // Desligado
        '11' => 11, // Não estava
        '7' => 7, // Desmarcado
    ],

    'start' => env('IMPORT_START'),
    'end' => env('IMPORT_END'),

    'doctors' => env('IMPORT_DOCTORS'),
    'patients' => env('IMPORT_PATIENTS')
];
