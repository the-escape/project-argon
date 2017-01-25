<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\RevisionStatus;
use Prettus\Repository\Eloquent\BaseRepository;

class EntityRevisionRepository extends BaseRepository
{
    public function model()
    {
        return EntityRevision::class;
    }

    /**
     * Creates a new draft revision and deletes the previous.
     *
     * @param int $entityLocalisationId
     * @return EntityRevision
     */
    public function createDraft($entityLocalisationId)
    {
        // Create the new draft revision.
        $entityRevisionDraft = $this->create([
            'entity_localisation_id' => $entityLocalisationId,
            'status' => RevisionStatus::DRAFT,
            'created_by' => 1,
        ]);

        // Find all draft revisions (except for the latest one).
        $entityRevisions = $this->findWhere([
            ['entity_localisation_id', '=', $entityLocalisationId],
            ['status', '=', RevisionStatus::DRAFT],
            ['id', '<>', $entityRevisionDraft->id],
        ]);

        // Loop through all of the previous draft revisions and delete them.
        foreach ($entityRevisions as $entityRevision) {
            $this->delete($entityRevision->id);
        }

        return $entityRevisionDraft;
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
