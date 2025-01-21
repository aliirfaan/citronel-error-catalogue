<?php

/*
| Main processes are under process key.
| A main process may have many sub processes.
| A sub process may have many events.
| Format: [main-process code]-[sub-process code]-[event code]
| Example: 101-3-1
|
| General errors may also be used: [main-process code]-[sub-process code]-[general-error code]
| Example: 101-3-VAE

|--------------------------------------------------------------------------
| Format
|--------------------------------------------------------------------------
'customer' => [
    'code' => '101',
    'key' => 'customer',
    'sub_process' => [
        'register' => [
            'key' => 'register',
            'name' => 'register',
            'code' => '1',
            'events' => [
                'otp_sent' => [
                    'key' => 'otp_sent',
                    'name' => 'register.otp_sent',
                    'code' => '1',
                    'code_status' => 'register.otp_sent'
                ],
                'customer_already_exists' => [
                    'key' => 'customer_already_exists',
                    'name' => 'customer_already_exists',
                    'code' => '2',
                    'code_status' => 'customer_already_exists'
                ],
            ]
        ],
    ]
],
*/

return [
        // general errors
        'validation_error' => [
            'key' => 'VALIDATION_ERROR',
            'code' => 'VAE'
        ],
        'database_error' => [
            'key' => 'DATABASE_ERROR',
            'code' => 'DBE'
        ],
        'unknown_error' => [
            'key' => 'UNKNOWN_ERROR',
            'code' => 'UNE'
        ],
        'authentication_error' => [
            'key' => 'AUTHENTICATION_ERROR',
            'code' => 'AUE'
        ],
        'authorization_error' => [
            'key' => 'AUTHORIZATION_ERROR',
            'code' => 'AZE'
        ],
        'processing_error' => [
            'key' => 'PROCESSING_ERROR',
            'code' => 'PRE'
        ],
        'record_not_found' => [
            'key' => 'RECORD_NOT_FOUND',
            'message' => 'The record was not found',
            'code' => 'NFE'
        ],
        'external_connection_issue' => [
            'key' => 'EXTERNAL_CONNECTION_ISSUE',
            'message' => 'Connection issue',
            'code' => 'CON'
        ],
        'external_technical_issue' => [
            'key' => 'EXTERNAL_TECHNICAL_ISSUE',
            'message' => 'Technical issue',
            'code' => 'TCH'
        ],
        'external_server_error' => [
            'key' => 'EXTERNAL_SERVER_ERROR',
            'message' => 'Server error',
            'code' => 'SRV'
        ],
        'external_too_many_redirects' => [
            'key' => 'EXTERNAL_TOO_MANY_REDIRECTS',
            'message' => 'Too many redirects',
            'code' => 'TMR'
        ],
        'external_empty_response' => [
            'key' => 'EXTERNAL_EMPTY_RESPONSE',
            'message' => 'Empty response',
            'code' => 'EMR'
        ],
        // process errors
        'process' => [
            'back_office' => [
                'key' => 'back_office',
                'code' => 'BKO',
                'sub_process' => [
                    'verify_key' => [
                        'key' => 'verify_key',
                        'name' => 'back_office.verify_key',
                        'code' => '1',
                        'events' => [
                            'invalid_key' => [
                                'key' => 'invalid_key',
                                'name' => 'verify_key.invalid_key',
                                'code' => '1',
                                'code_status' => null
                            ],
                        ],
                    ],
                ]
            ],
            'customer' => [
                'key' => 'customer',
                'code' => '101',
                'sub_process' => [
                    'register' => [
                        'key' => 'register',
                        'name' => 'customer.register',
                        'code' => '1',
                        'events' => [
                            'otp_sent' => [
                                'key' => 'otp_sent',
                                'name' => 'register.otp_sent',
                                'code' => '1',
                                'code_status' => null
                            ],
                            'customer_already_exists' => [
                                'key' => 'customer_already_exists',
                                'name' => 'customer_already_exists',
                                'code' => '2',
                                'code_status' => null
                            ],
                            'otp_not_sent' => [
                                'key' => 'otp_not_sent',
                                'name' => 'otp_not_sent',
                                'code' => '3',
                                'code_status' => null
                            ],
                            'otp_attempt_exceeded' => [
                                'key' => 'otp_attempt_exceeded',
                                'name' => 'otp_attempt_exceeded',
                                'code' => '4',
                                'code_status' => null
                            ]
                        ],
                    ],
                    'otp_validate' => [
                        'key' => 'otp_validate',
                        'name' => 'otp_validate',
                        'code' => '2',
                        'events' => [
                            'otp_valid' => [
                                'key' => 'otp_valid',
                                'name' => 'otp_valid',
                                'code' => '1',
                                'code_status' => null
                            ],
                            'otp_invalid' => [
                                'key' => 'otp_invalid',
                                'name' => 'otp_invalid',
                                'code' => '2',
                                'code_status' => null
                            ],
                            'otp_invalid_not_match' => [
                                'key' => 'otp_invalid_not_match',
                                'name' => 'otp_invalid_not_match',
                                'code' => '3',
                                'code_status' => null
                            ],
                            'otp_invalid_expired' => [
                                'key' => 'otp_invalid_expired',
                                'name' => 'otp_invalid_expired',
                                'code' => '4',
                                'code_status' => null
                            ],
                        ],
                    ],
                    'is_active_check' => [
                        'key' => 'is_active_check',
                        'name' => 'is_active_check',
                        'code' => '7',
                        'events' => [
                            'is_not_active' => [
                                'key' => 'is_not_active',
                                'name' => 'is_not_active',
                                'code' => '1',
                                'code_status' => null
                            ],
                        ],
                    ],
                    'is_verified_check' => [
                        'key' => 'is_verified_check',
                        'name' => 'is_verified_check',
                        'code' => '8',
                        'events' => [
                            'is_not_verified' => [
                                'key' => 'is_not_verified',
                                'name' => 'is_not_verified',
                                'code' => '1',
                                'code_status' => null
                            ],
                        ],
                    ],
                ]
            ],
        ]
];
