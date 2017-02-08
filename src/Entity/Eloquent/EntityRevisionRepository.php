<?php

namespace Escape\Argon\Entity\Eloquent;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;

class EntityRevisionRepository extends BaseRepository
{
    public function model()
    {
        return EntityRevision::class;
    }

    /**
     * Get the latest entity revision fot a given entity localisation.
     *
     * @param $entityLocalisationId
     * @return EntityRevision
     */
    public function getLatestRevision($entityLocalisationId)
    {
        return $this->findWhere([
            ['entity_localisation_id', '=', $entityLocalisationId],
        ])->sortByDesc('created_at')->first();
    }

    public function createDraft($entityLocalisationId, $timestamps = false)
    {
        $entityRevision = $this->getLatestRevision($entityLocalisationId);

        if ($entityRevision->isStatus(EntityRevision::STATUS_DRAFT)) {
            return $entityRevision;
        }

        // Create the new draft revision.
        $entityRevisionDraft = $this->makeModel()->fill([
            'entity_localisation_id' => $entityLocalisationId,
            'status' => EntityRevision::STATUS_DRAFT,
            'created_by' => 1,
        ]);

        if ($timestamps) {
            $entityRevisionDraft->setCreatedAt($entityRevision->created_at);
            $entityRevisionDraft->setUpdatedAt($entityRevision->updated_at);
            $entityRevisionDraft->save();
        }

        foreach ($entityRevision->fieldData as $fieldData) {
            $fieldData->fill(['id' => null, 'entity_revision_id' => $entityRevisionDraft->id])->save();
        }

        foreach ($entityRevision->entityRevisionGroups as $entityRevisionGroup) {
            $entityRevisionGroup->fill(['id' => null, 'entity_revision_id' => $entityRevisionDraft->id])->save();
        }

        return $entityRevisionDraft;
    }

    /**
     * Turn a draft revision in to a published revision.
     *
     * @param int $entityLocalisationId
     */
    public function publishDraft($entityLocalisationId)
    {
        //  Get the draft.
        $entityRevisionDraft = $this->findWhere([
            ['entity_localisation_id', '=', $entityLocalisationId],
            ['status', '=', EntityRevision::STATUS_DRAFT],
        ])->first();

        // Set the draft to published.
        $entityRevisionDraft->update([
            'status' => EntityRevision::STATUS_PUBLISHED,
        ]);

        // Get all published revisions except for the new one.
        $entityRevisionPublished = $this->findWhere([
            ['entity_localisation_id', '=', $entityLocalisationId],
            ['status', '=', EntityRevision::STATUS_PUBLISHED],
            ['id', '<>', $entityRevisionDraft->id],
        ])->first();

        // Set all published revisions to previous published.
        if ($entityRevisionPublished) {
            $entityRevisionPublished->update([
                'status' => EntityRevision::STATUS_PREVIOUSLY_PUBLISHED,
            ]);
        }
    }

    public function archiveRevisions($localisationId, $except)
    {
        $this->makeModel()
            ->where('entity_localisation_id', $localisationId)
            ->where('id', '<>', $except)
            ->update(['status' => EntityRevision::STATUS_PREVIOUSLY_PUBLISHED]);
    }

    public function deletePreviews($exceptIds = [])
    {
        // TODO: Enforce foreign key constraint cascade.
        $revisions = $this->makeModel()
            ->where('status', EntityRevision::STATUS_PREVIEW)
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
