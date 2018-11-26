<?php

namespace App\Console\Commands;

use Escape\Argon\Media\Eloquent\MediaItemRepository;
use Illuminate\Console\Command;


class MediaLibraryOptimizeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medialib:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize all unoptimized images';

    protected $mediaRepository;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->mediaRepository = app()->make(MediaItemRepository::class);

        if (!imageOptim()->isEnabled()) {
            $this->warn("Image optimization feature is not enabled in the argon configuration file. \nTo enable it refer to readme.md on how to enable Image Optimization.");
            return;
        }

        $this->info('Optimizing images...');
        $results = $this->optimizeAssets();

        $count = 0;

        foreach ($results as $result) {
            $count++;
            $this->info(json_encode($result));
        }

        $msg = ($count === 1)
            ? "Optimized {$count} image."
            : "Optimized {$count} images.";

        $this->info($msg);
    }

    private function optimizeAssets()
    {
        $mediaItems = $this->mediaRepository->findWhere([
            ['optimized','=', 0],
            ['mimetype','like',"image%"]
        ]);

        foreach ($mediaItems as $mediaItem)
        {
            $response = $mediaItem->optimize();

            yield [
                'action'      => 'optimize-image',
                'entity_id'   => $mediaItem->id,
                'optimized' => $response,
            ];
        }


    }
}