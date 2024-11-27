<?php

namespace aliirfaan\CitronelErrorCatalogue\Console\Commands;

use Illuminate\Console\Command;
use aliirfaan\CitronelErrorCatalogue\Services\DumpLangMessages as DumpLangMessagesService;

class DumpLangMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'citronel:messages:dump {filename=messages.csv} {folder=messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump lang messages to a CSV file';

    /**
     * Execute the console command.
     */
    public function handle(DumpLangMessagesService $dumpLangMessagesService)
    {
        $filename = $this->argument('filename');
        $folder = $this->argument('folder');

        $dumpLangMessagesService->dumpCSV($filename, $folder);
    }
}
