<?php

namespace aliirfaan\CitronelErrorCatalogue\Console\Commands;

use Illuminate\Console\Command;
use aliirfaan\CitronelErrorCatalogue\Services\DumpErrorCatalogue as DumpErrorCatalogueService;

class DumpErrorCatalogue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'citronel:error-catalogue:dump {filename=error-catalogue.csv} {folder=error-catalogue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump error catalogue to a CSV file';

    /**
     * Execute the console command.
     */
    public function handle(DumpErrorCatalogueService $dumpErrorCatalogueService)
    {
        $filename = $this->argument('filename');
        $folder = $this->argument('folder');

        $dumpErrorCatalogueService->dumpCSV($filename, $folder);
    }
}
