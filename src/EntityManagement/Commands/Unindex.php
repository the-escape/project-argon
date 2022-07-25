<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Escape\Argon\Helpers\Solr;


class Unindex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solr:unindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Un-index entire site content.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $solr = new Solr();

        if (!$solr->isEnabled()) {
            $this->warn('Solr not enabled! Review configuration and try again.');
            return 0;
        }

        $this->info('Content unindexing...');
        $results = $solr->unindex();

        $this->info(json_encode($results));

        $msg = ($results['solr_status'] == "OK")
            ? "Unindexed all entities."
            : "Unindexing failed. Please review.";

        $this->info($msg);
    }
}