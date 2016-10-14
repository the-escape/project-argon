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
            return;
        }

        $this->info('Content unindexing...');
        $results = $solr->unindex();

        foreach ($results as $result) {
            $this->info(json_encode($result));
        }

        $results['solr_status'] = count($results);

        $msg = ( $results['solr_status'] == "OK")
            ? "Unindexing failed. Please review."
            : "Unindexed all entities.";

        $this->info($msg);
    }
}