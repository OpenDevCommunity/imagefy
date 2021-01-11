<?php

namespace App\Console\Commands;

use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiriedShortUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shorturls:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for expired short URLS';

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
        ShortUrl::where('expiries_at', '<', Carbon::now())
            ->update(['expiried' => true]);

        $this->info('Checked for expiried short URLS!');
    }
}
