<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Excel;
use \App\Imports\SiswaImportDapodik;

class ImportSiswaDapodik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dapodik';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data dapodik siswa pak mul';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $business_id = 13;
        $file_location = base_path('SDMUH2_DATA_LENGKAP_UPDATE_19-05-24.xlsx');
        if(file_exists($file_location) === false) {
            // $this->error('File not found: ' . $file_location);
            echo 'File not found: ' . $file_location;
            return;
        }
        echo "Starting import for business ID: $business_id\n";
        echo "Importing from file: $file_location\n";
        Excel::import(
            new SiswaImportDapodik([
                'business_id' => $business_id
            ]), 
            $file_location
        );

        echo "Import completed successfully.\n";
        return;
    }
}
