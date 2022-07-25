<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Escape\Argon\Helpers\Solr;


class Reindex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solr:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-index entire site content.';

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

        $this->info('Content reindexing...');
        $results = $solr->reindex();

        $count = 0;

        foreach ($results as $result) {
            $count++;
            $this->info(json_encode($result));
        }

        $msg = ($count === 1)
            ? "Reindexed {$count} entity."
            : "Reindexed {$count} entities.";

        $this->info($msg);
    }
}