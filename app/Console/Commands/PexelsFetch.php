<?php

namespace App\Console\Commands;

use App\Jobs\FetchImagesJob;
use Illuminate\Console\Command;

class PexelsFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pexels:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data of images from Pexels.';

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
     * @return int
     */
    public function handle()
    {
        FetchImagesJob::dispatch();
        return 0;
    }
}
