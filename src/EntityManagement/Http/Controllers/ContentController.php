<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
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
            new Tab('PAGE CONTENT', route('cms:pages:content', [$entityId, $entityLocalisationId])),
            new Tab('ATTRIBUTES', route('cms:pages:attributes', $entityId)),
            new Tab('SEO', route('cms:pages:seo', $entityId)),
        ]);

        $entity = $this->entityRepository->find($entityId);

        /** @var \Illuminate\Support\Collection $entityRevisionGroups **/
        $entityRevisionGroups = $entity->getPublishedRevision()
            ->entityRevisionGroups;

        $entityGroups = $entity->type->groups()
            ->whereNotIn('id', $entityRevisionGroups->pluck('entity_group_id'))->get();

        return view('argon.entity::pages.content', [
            'entity' => $entity,
            'entityLocalisationId' => $entityLocalisationId,
            'name' => $entity->name,
            'groups' => $entityGroups,
            'rendered' => $entityRevisionGroups,
        ]);
    }

    public function update(Request $request, $entityLocalisationId)
    {
        // Create a new draft revision.
        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        // Get the new entity group IDs.
        $entityGroupIds = json_decode($request->get('groups'));

        // If the entity group IDs exist, create instances and attach them to the revision.
        if (!is_null($entityGroupIds)) {
            $this->entityRevisionGroupRepository->createGroups($entityRevision->id, $entityGroupIds);
        }

        return redirect()->back();
    }
}
