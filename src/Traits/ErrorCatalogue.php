<?php

namespace aliirfaan\CitronelErrorCatalogue\Traits;

use aliirfaan\CitronelErrorCatalogue\Services\CitronelErrorCatalogueService;

trait ErrorCatalogue
{
    /**
     * Get the error catalogue.
     *
     * @return array
     */
    public function getErrorCatalogue()
    {
        $service = new CitronelErrorCatalogueService();
        return $service->getMergedConfig();
    }
    
    /**
     * Method catalogueLanguageFile
     *
     * @return string
     */
    public function catalogueLanguageFile()
    {
        return !is_null(config('citronel-error-config.citronel_error_catalogue_lang_file')) ? config('citronel-error-config.citronel_error_catalogue_lang_file') . '/' : 'citronel-error-catalogue::';
    }
    
    /**
     * Method validationErrorCatalogue
     *
     * @return array
     */
    public function validationErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['validation_error'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.invalid_data_provided';

        return $details;
    }
    
    /**
     * Method databaseErrorCatalogue
     *
     * @return array
     */
    public function databaseErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['database_error'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.database_error';

        return $details;
    }
    
    /**
     * Method unknownErrorCatalogue
     *
     * @return array
     */
    public function unknownErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['unknown_error'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.unknown_error';

        return $details;
    }
    
    /**
     * Method processingErrorCatalogue
     *
     * @return array
     */
    public function processingErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['processing_error'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.processing_error';

        return $details;
    }
    
    /**
     * Method recordNotFoundErrorCatalogue
     *
     * @return array
     */
    public function recordNotFoundErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['record_not_found'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.record_not_found';

        return $details;
    }
    
    /**
     * Method authorizationErrorCatalogue
     *
     * @return array
     */
    public function authorizationErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['authorization_error'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.authorization_error';

        return $details;
    }

    /**
     * Method authenticationErrorCatalogue
     *
     * @return array
     */
    public function authenticationErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['authentication_error'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.authentication_error';

        return $details;
    }
    
    /**
     * Method externalConnectionIssueErrorCatalogue
     *
     * @return array
     */
    public function externalConnectionIssueErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['external_connection_issue'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.external_connection_issue';

        return $details;
    }
    
    /**
     * Method externalTechnicalIssueErrorCatalogue
     *
     * @return array
     */
    public function externalTechnicalIssueErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['external_technical_issue'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.external_technical_issue';

        return $details;
    }
    
    /**
     * Method externalServerErrorErrorCatalogue
     *
     * @return array
     */
    public function externalServerErrorErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['external_server_error'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.external_server_error';

        return $details;
    }
    
    /**
     * Method externalTooManyRedirectsErrorCatalogue
     *
     * @return array
     */
    public function externalTooManyRedirectsErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['external_too_many_redirects'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.external_too_many_redirects';

        return $details;
    }
    
    /**
     * Method externalEmptyResponseErrorCatalogue
     *
     * @return array
     */
    public function externalEmptyResponseErrorCatalogue()
    {
        $details = $this->getErrorCatalogue()['external_empty_response'];
        $details['lang'] = $this->catalogueLanguageFile() . 'messages.external_empty_response';

        return $details;
    }
}
