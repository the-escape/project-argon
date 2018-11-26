<?php

namespace App\Console\Commands;

use Escape\Argon\Media\Eloquent\MediaItemRepository;
use Illuminate\Console\Command;


class MediaLibraryFixThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medialib:fixthumbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix names of old thumbnails (change ID based names to slug based names).';

    protected $mediaRepository;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->mediaRepository = app()->make(MediaItemRepository::class);

        $this->info('Fixing thumbnails...');
        $results = $this->fixThumbs();

        $count = 0;

        foreach ($results as $result) {
            if ($result)
            {
                $count++;
            }
            $this->info(json_encode($result));
        }

        $msg = ($count === 1)
            ? "Changed {$count} thumbnail file name."
            : "Changed {$count} thumbnail file names.";

        $this->info($msg);
    }

    private function fixThumbs()
    {
        $mediaItems = $this->mediaRepository->findWhere([
            ['hasThumb','=', 1]
        ]);

        foreach ($mediaItems as $mediaItem)
        {
            $response = $mediaItem->fixThumb();

            yield [
                'action'      => 'fix-thumbnail',
                'entity_id'   => $mediaItem->id,
                'filename_changed' => $response,
            ];
        }


    }
}