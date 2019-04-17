<?php

namespace App\Console\Commands;

use Escape\Argon\Media\Eloquent\MediaItemRepository;
use Illuminate\Console\Command;


class MediaLibraryRefreshThumbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medialib:refreshthumbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes thumbnails for media items.';

    protected $mediaRepository;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->mediaRepository = app()->make(MediaItemRepository::class);
        ini_set('memory_limit', '256m');
        $this->info('Fixing thumbnails...');
        $results = $this->refreshThumbs();

        $count = 0;

        foreach ($results as $result) {
            if ($result)
            {
                $count++;
            }
            $this->info(json_encode($result));
        }

        $msg = ($count === 1)
            ? "Changed {$count} thumbnail file."
            : "Changed {$count} thumbnail files.";

        $this->info($msg);
    }

    private function refreshThumbs()
    {
        $mediaItems = $this->mediaRepository->all();

        foreach ($mediaItems as $mediaItem)
        {
            $response = $mediaItem->recreateThumbnail();

            yield [
                'action'      => 'refresh-thumbnail',
                'entity_id'   => $mediaItem->id,
                'filename_changed' => $response,
            ];
        }


    }
}
