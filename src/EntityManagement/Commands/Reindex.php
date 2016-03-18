<?php

namespace Serco\DotCom\Console\Commands;

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
    protected $description = 'Re-index entire content.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Content reindexing...');
        $solr = new Solr();
        $results = $solr->reindex();

        foreach ($results as $result) {
            $this->info(json_encode($result));
        }

        $count = count($results);

        $msg = ($count === 1)
            ? "Reindexed {$count} entity."
            : "Reindexed {$count} entities.";

        $this->info($msg);
    }
}