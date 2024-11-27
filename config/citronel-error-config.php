<?php

return [
    /*
    | citronel_error_catalogue_name | String
    | The configuration file name from which to take errors.
    |
    | citronel_error_catalogue_lang_file | String
    | The language file name from which to take translations.
    |
    | citronel_error_code_separator | String
    | The separator to use when generating error codes.
    */

    'citronel_error_catalogue_name' => env('CITRONEL_ERROR_CATALOGUE_NAME', 'citronel-error-catalogue'),
    'citronel_error_catalogue_lang_file' => env('CITRONEL_ERROR_CATALOGUE_LANG_FILE', null),
    'citronel_error_code_separator' => env('CITRONEL_ERROR_CODE_SEPARATOR', '-'),
];
