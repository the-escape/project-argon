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
            ->whereNotIn('status', [RevisionStatus::PREVIEW])
            ->update(['status' => RevisionStatus::PREVIOUSLY_PUBLISHED]);
    }

    /**
     * Equivalent to Escape\Argon\EntityManagement\Eloquent\Localisation@archivedRevisions
     * @return collection of EntityRevisions
     */
    public function archivedRevisions($localisationId)
    {
        return $this->makeModel()
            ->orderBy('created_at', 'desc')
            ->with(['user' => function ($query) {
                $query->withTrashed();
            }])
            ->where('entity_localisation_id', $localisationId)
            ->where('status', RevisionStatus::PREVIOUSLY_PUBLISHED)
            ->get();
    }

    public function deletePreviews($exceptIds = [])
    {
        // TODO: Enforce foreign key constraint cascade.
        $revisions = $this->makeModel()
            ->where('status', RevisionStatus::PREVIEW)
            ->whereNotIn('id', $exceptIds);

        $models = $revisions->get();

        // Delete all fields associated with this revision.
        foreach ($models as $revision) {
            $revision->fields()->forceDelete();
        }

        // Force delete the revisions.
        $revisions->forceDelete();
    }
}
