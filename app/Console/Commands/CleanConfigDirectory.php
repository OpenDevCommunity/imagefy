<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CleanConfigDirectory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:configdir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans Sharex Config Direcotry';

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
     * @return void
     */
    public function handle()
    {
        $file = new Filesystem;

        $file->cleanDirectory(public_path('/upload/json'));
    }
}
