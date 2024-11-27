<?php

namespace aliirfaan\CitronelErrorCatalogue\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DumpLangMessages
{
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
            $langPath = resource_path('lang');
            $dumped = [];

            $headers = ['scope', 'message_key', 'message'];

            foreach (File::allFiles($langPath) as $file) {
                $scope = $file->getRelativePath();
                $messages = require_once $file->getPathname();

                foreach ($messages as $key => $message) {
                    $dumped[] = [
                        $scope,
                        $key,
                        $message,
                    ];
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
