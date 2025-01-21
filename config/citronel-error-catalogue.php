<?php

$errorCatalogue = config('citronel-general-error-catalogue');

// Load the external error configurations
$externalErrorCatalogues = config('citronel-error-config.citronel_error_catalogue_external_catalogues', []);

foreach ($externalErrorCatalogues as $externalErrorCatalogue) {
    if (is_array($externalErrorCatalogue) && array_key_exists('process', $externalErrorCatalogue)) {
        $errorCatalogue['process'] = array_merge($errorCatalogue['process'], config($externalErrorCatalogue)['process']);
    }
}

return $errorCatalogue;
