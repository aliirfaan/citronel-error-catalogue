<?php

namespace aliirfaan\CitronelErrorCatalogue\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use aliirfaan\CitronelErrorCatalogue\Services\CitronelErrorCatalogueService;

class CitronelErrorCatalogueServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CitronelErrorCatalogueService();
    }

    public function testGenerateCodeFromCatalogue()
    {
        // Mock the config values
        Config::set([
            'citronel-error-config.citronel_error_code_separator' => '-',
            'citronel_error_catalogue.process' => [
                'customer' => [
                    'code' => '101',
                    'sub_process' => [
                        'registration' => [
                            'code' => '1',
                            'events' => [
                                'otp_sent' => [
                                    'code' => '001',
                                    'code_status' => 'otp_sent'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $result = $this->service->generateCodeFromCatalogue('customer', 'registration', 'otp_sent');

        $this->assertEquals('101-1-001', $result['code']);
        $this->assertEquals('otp_sent', $result['status']);
    }

    public function testGenerateCodeFromCatalogueForInvalidProcess()
    {
        $result = $this->service->generateCodeFromCatalogue('invalid_key', 'invalid_key', 'invalid_key');

        $this->assertEquals(null, $result['code']);
        $this->assertEquals(null, $result['status']);
    }

    public function testGenerateCodeFromCatalogueForInvalidSubProcess()
    {
        // Mock the config values
        Config::set([
            'citronel-error-config.citronel_error_code_separator' => '-',
            'citronel_error_catalogue.process' => [
                'customer' => [
                    'code' => '101',
                    'sub_process' => [
                        'registration' => [
                            'code' => '1',
                            'events' => [
                                'otp_sent' => [
                                    'code' => '001',
                                    'code_status' => 'otp_sent'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $result = $this->service->generateCodeFromCatalogue('customer', 'invalid_key', 'invalid_key');

        $this->assertEquals('101', $result['code']);
        $this->assertEquals(null, $result['status']);
    }

    public function testGenerateCodeFromCatalogueForInvalidEvent()
    {
        // Mock the config values
        Config::set([
            'citronel-error-config.citronel_error_code_separator' => '-',
            'citronel_error_catalogue.process' => [
                'customer' => [
                    'code' => '101',
                    'sub_process' => [
                        'registration' => [
                            'code' => '1',
                            'events' => [
                                'otp_sent' => [
                                    'code' => '001',
                                    'code_status' => 'otp_sent'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $result = $this->service->generateCodeFromCatalogue('customer', 'registration', 'invalid_key');

        $this->assertEquals('101-1', $result['code']);
        $this->assertEquals(null, $result['status']);
    }

    public function testGenerateCodeFromCatalogueSeparator()
    {
        // Mock the config values
        Config::set([
            'citronel-error-config.citronel_error_code_separator' => '/',
            'citronel_error_catalogue.process' => [
                'customer' => [
                    'code' => '101',
                    'sub_process' => [
                        'registration' => [
                            'code' => '1',
                            'events' => [
                                'otp_sent' => [
                                    'code' => '001',
                                    'code_status' => 'otp_sent'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $result = $this->service->generateCodeFromCatalogue('customer', 'registration', 'otp_sent');

        $this->assertEquals('101/1/001', $result['code']);
        $this->assertEquals('otp_sent', $result['status']);
    }

    public function testGenerateCodeFromCatalogueExtraCode()
    {
        // Mock the config values
        Config::set([
            'citronel-error-config.citronel_error_code_separator' => '-',
            'citronel_error_catalogue.process' => [
                'customer' => [
                    'code' => '101',
                    'sub_process' => [
                        'registration' => [
                            'code' => '1',
                            'events' => [
                                'otp_sent' => [
                                    'code' => '001',
                                    'code_status' => 'otp_sent'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $extraCode = 'EXTRA109';
        $result = $this->service->generateCodeFromCatalogue('customer', 'registration', 'otp_sent', $extraCode);

        $this->assertEquals('101-1-001-EXTRA109', $result['code']);
        $this->assertEquals('otp_sent', $result['status']);
    }

    public function testErrorCatalogueMerging()
    {
        // Mock the config values
        Config::set([
            'citronel-error-config.citronel_error_code_separator' => '-',
            'citronel-general-error-catalogue.process' => [
                'customer' => [
                    'code' => '101',
                    'sub_process' => [
                        'registration' => [
                            'code' => '1',
                            'events' => [
                                'otp_sent' => [
                                    'code' => '001',
                                    'code_status' => 'otp_sent'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        // Set up the external error catalogues
        Config::set('citronel-error-config.citronel_error_catalogue_external_catalogues', [
            [
                'process' => [
                    'external_1' => [
                        'code' => '201',
                        'key' => 'external_1',
                        'sub_process' => [
                            'create' => [
                                'key' => 'create',
                                'name' => 'create',
                                'code' => '1',
                                'events' => [
                                    'invalid_product' => [
                                        'key' => 'invalid_product',
                                        'name' => 'invalid_product',
                                        'code' => '1',
                                        'code_status' => 'invalid_product',
                                    ],
                                ],
                            ],
                        ]
                    ],
                ],
            ],
            [
                'process' => [
                    'external_2' => [
                        'code' => '301',
                        'key' => 'external_2',
                        'sub_process' => [
                            'update' => [
                                'key' => 'update',
                                'name' => 'update',
                                'code' => '1',
                                'events' => [
                                    'invalid_product' => [
                                        'key' => 'invalid_product',
                                        'name' => 'invalid_product',
                                        'code' => '1',
                                        'code_status' => 'invalid_product',
                                    ],
                                ],
                            ],
                        ]
                    ],
                ],
            ],
        ]);

        // Load the merged error catalogue
        $errorCatalogue = $this->service->getMergedConfig();

        // Assert that the general error is present
        $this->assertArrayHasKey('customer', $errorCatalogue['process']);
        $this->assertEquals('101', $errorCatalogue['process']['customer']['code']);

        // Assert that the external errors are present
        $this->assertArrayHasKey('external_1', $errorCatalogue['process']);
        $this->assertEquals('external_1', $errorCatalogue['process']['external_1']['key']);

        $this->assertArrayHasKey('external_2', $errorCatalogue['process']);
        $this->assertEquals('external_2', $errorCatalogue['process']['external_2']['name']);

        $this->assertArrayHasKey('create', $errorCatalogue['process']['external_1']['sub_process']);
    }
}
