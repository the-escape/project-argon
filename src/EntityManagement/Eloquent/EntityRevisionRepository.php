<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\RevisionStatus;
use Prettus\Repository\Eloquent\BaseRepository;

class EntityRevisionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EntityRevision::class;
    }

    public function archiveRevisions($localisationId, $except)
    {
        $this->makeModel()
            ->where('entity_localisation_id', $localisationId)
            ->where('id', '<>', $except)
            ->update(['status' => RevisionStatus::PREVIOUSLY_PUBLISHED]);
    }

    public function deletePreviews($exceptIds = [])
    {
        // TODO: Enforce foreign key constraint cascade.
        $this->makeModel()
            ->where('status', RevisionStatus::PREVIEW)
            ->whereNotIn('id', $exceptIds)
            ->forceDelete();
    }
}
