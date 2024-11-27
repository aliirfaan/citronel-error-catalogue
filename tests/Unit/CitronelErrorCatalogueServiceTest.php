<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;
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
            'citronel-error-config.citronel_error_catalogue_name' => 'citronel_error_catalogue',
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
            'citronel-error-config.citronel_error_catalogue_name' => 'citronel_error_catalogue',
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
            'citronel-error-config.citronel_error_catalogue_name' => 'citronel_error_catalogue',
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
            'citronel-error-config.citronel_error_catalogue_name' => 'citronel_error_catalogue',
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
            'citronel-error-config.citronel_error_catalogue_name' => 'citronel_error_catalogue',
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
}
