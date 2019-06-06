<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class PagesOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set order to existing pages';

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
        $this->info('Ordering pages...');
        $results = $this->processAll();

        $count = 0;

        foreach ($results as $result) {
            $count++;
            $this->info(json_encode($result));
        }

        $msg = ($count === 1)
            ? "Ordered {$count} page."
            : "Ordered {$count} pages.";

        $this->info($msg);
    }

    private function processAll()
    {
        $entityRepository = app()->make(EntityRepository::class);
        $entities = $entityRepository->pages()->sortBy('order');
        $groups = $entities->groupBy('parent_id');

        foreach ($groups as $parentId => $group)
        {
            if ($parentId === '' || count($group) <= 1)
            {
                continue;
            }

            foreach ($group as $index => $entity)
            {
                $entity->order = $index;
                $entity->save();

                yield [
                    'action'      => 'ordering',
                    'entity_id'   => $entity->id,
                    'entity_order' => $entity->order,
                ];
            }
        }
    }
}
