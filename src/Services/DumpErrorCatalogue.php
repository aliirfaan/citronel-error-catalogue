<?php

namespace aliirfaan\CitronelErrorCatalogue\Services;

use Illuminate\Support\Facades\Storage;
use aliirfaan\CitronelErrorCatalogue\Services\CitronelErrorCatalogueService;

class DumpErrorCatalogue
{
    protected $citronelErrorCatalogueService;

    public function __construct(CitronelErrorCatalogueService $citronelErrorCatalogueService)
    {
        $this->citronelErrorCatalogueService = $citronelErrorCatalogueService;
    }

    /**
     * Method dump
     *
     * @param string $filename dump filename
     * @param string $folder folder name in storage folder
     *
     * @return void
     */
    public function dumpCSV ($filename, $folder)
    {
        try {
            $config = $this->citronelErrorCatalogueService->getMergedConfig();
            $dumped = [];
            $mainProcessArr = $config['process'];
            $headers = ['process_key', 'process_code', 'sub_process_key', 'sub_process_code', 'event_key', 'event_code', 'event_name', 'event_id'];

            foreach ($mainProcessArr as $aMainProcessKey => $aMainProcess) {
                foreach ($aMainProcess['sub_process'] as $aSubProcessKey => $aSubProcess) {
                    foreach ($aSubProcess['events'] as $aEventKey => $aEvent) {
                        $dumped[] = [
                            $aMainProcessKey,
                            $aMainProcess['code'],
                            $aSubProcessKey,
                            $aSubProcess['code'],
                            $aEventKey,
                            $aEvent['code'],
                            $aEvent['name'],
                            $aMainProcess['code'] . '-' . $aSubProcess['code'] . '-' . $aEvent['code'],
                        ];
                    }
                }
            }

            $tempFile = tmpfile();
            $tempFilePath = stream_get_meta_data($tempFile)['uri'];

            fputcsv($tempFile, $headers);
            foreach ($dumped as $row) {
                fputcsv($tempFile, $row);
            }

            // Ensure the folder exists
            Storage::makeDirectory($folder);

            Storage::put($folder . '/' . $filename, file_get_contents($tempFilePath));

            fclose($tempFile);
        } catch (Exception $e) {
            report($e);
        }
    }
}
