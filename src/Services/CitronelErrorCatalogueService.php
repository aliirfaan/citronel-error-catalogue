<?php

namespace aliirfaan\CitronelErrorCatalogue\Services;

class CitronelErrorCatalogueService
{
    /**
     * Generates a code and status based on an error catalogue
     *
     * @param string $mainProcessKey
     * @param string $subProcessKey
     * @param string $eventKey
     * @param string $extraCode extra code to be added to the code
     *
     * @return array code example: 101-1-001 where main proces is 101, sub process is 1 and event is 001
     * status example: user_not_found
     */
    public function generateCodeFromCatalogue($mainProcessKey, $subProcessKey, $eventKey = null, $extraCode = null)
    {
        $processCode = [
            'code' => null,
            'status' => null
        ];

        $configKey = config('citronel-error-config.citronel_error_catalogue_name');

        $separator = config('citronel-error-config.citronel_error_code_separator');

        $mainProcess = null;
        $subProcess = null;
        $code = null;

        $configArray = config($configKey . '.process');
        if (is_array($configArray) && array_key_exists($mainProcessKey, $configArray)) {
            $mainProcess = $configArray[$mainProcessKey];
            $code = array_key_exists('code', $mainProcess) ? $mainProcess['code']: null;

            if (array_key_exists($subProcessKey, $mainProcess['sub_process'])) {
                $subProcess = $mainProcess['sub_process'][$subProcessKey];
                $code .= $separator .  $subProcess['code'];
                
                if (!is_null($eventKey) && array_key_exists($eventKey, $subProcess['events'])) {
                    $event = $subProcess['events'][$eventKey];
                    $code .= $separator .  $event['code'];
        
                    $codeStatus = $event['code_status'];
                    $processCode['status'] = $codeStatus;
                }
            }
        }

        if (!is_null($extraCode)) {
            $code .= $separator . $extraCode;
        }

        $processCode['code'] = $code;

        return $processCode;
    }
}
