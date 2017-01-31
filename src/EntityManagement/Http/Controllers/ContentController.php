<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevision;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\RevisionStatus;
use Illuminate\Http\Request;

class ContentController extends BaseController
{
    private $entityRepository;
    private $entityRevisionRepository;
    private $entityRevisionGroupRepository;

    public function __construct(
        EntityRepository $entityRepository,
        EntityRevisionRepository $entityRevisionRepository,
        EntityRevisionGroupRepository $entityRevisionGroupRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->entityRevisionRepository = $entityRevisionRepository;
        $this->entityRevisionGroupRepository = $entityRevisionGroupRepository;

        parent::__construct();
    }

    function setMiddleware()
    {
        return [
            'auth',
            'perm:cms:login',
        ];
    }

    public function edit($entityId, $entityLocalisationId)
    {
        $this->addTabs([
            new Tab('ATTRIBUTES', route('cms:pages:attributes', [$entityId, $entityLocalisationId])),
            new Tab('PAGE CONTENT', route('cms:pages:content', [$entityId, $entityLocalisationId])),
            new Tab('SEO', route('cms:pages:seo', [$entityId, $entityLocalisationId])),
        ]);

        $entity = $this->entityRepository->find($entityId);

        /** @var \Illuminate\Support\Collection $entityRevisionGroups **/
        $entityRevisionGroups = $entity->getPublishedRevision()
            ->entityRevisionGroups;

        $entityRevisionGroupIds = $entityRevisionGroups->pluck('entity_group_id');

        $entityGroups = $entity->type->groups()
            ->whereNotIn('id', $entityRevisionGroupIds)->get();

        $entityRevisionStatus = $this->entityRevisionRepository
            ->getLatestRevision($entityLocalisationId);

        $status = [
            EntityRevision::STATUS_DRAFT => 'DRAFT',
            EntityRevision::STATUS_PUBLISHED => 'PUBLISHED',
        ];

        return view('argon.entity::pages.content', [
            'entity' => $entity,
            'entityLocalisationId' => $entityLocalisationId,
            'name' => $entity->name.' '.$status[$entityRevisionStatus->status],
            'entityGroups' => $entityGroups,
            'entityRevisionGroups' => $entityRevisionGroups,
            'entityRevisionGroupIds' => $entityRevisionGroupIds,
        ]);
    }

    public function update(Request $request, $entityLocalisationId)
    {
        // Create a new draft revision.
        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        // Get the new entity group IDs.
        $entityGroupIds = json_decode($request->get('groups'));

        $entityRevisionGroups = [];

        // If the entity group IDs exist, create instances and attach them to the revision.
        if (!is_null($entityGroupIds)) {
            $entityRevisionGroups = $this->entityRevisionGroupRepository
                ->createGroups($entityRevision->id, $entityGroupIds);
        }

        if ($request->exists('publish')) {
            $this->publish($entityLocalisationId);
            return redirect()->back();
        }
    }

    public function publish($entityLocalisationId)
    {
        $this->entityRevisionRepository->publishDraft($entityLocalisationId);
    }
}
