<?php

namespace Escape\Argon\Entity\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\Entity\Eloquent\EntityRepository;
use Escape\Argon\Entity\Eloquent\EntityRevisionGroupRepository;
use Escape\Argon\Entity\Eloquent\EntityRevisionRepository;

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

        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        $entityRevisionGroups = $entityRevision->entityRevisionGroups;

        $entityRevisionGroupIds = $entityRevisionGroups->pluck('entity_group_id');

        $entityGroups = $entity->type->groups()
            ->whereNotIn('id', $entityRevisionGroupIds)->get();

        return view('argon.entity::pages.content', [
            'entity' => $entity,
            'entityLocalisationId' => $entityLocalisationId,
            'name' => $entity->name,
            'entityGroups' => $entityGroups,
            'entityRevisionGroups' => $entityRevisionGroups,
            'entityRevisionGroupIds' => $entityRevisionGroupIds,
        ]);
    }

    public function update($entityLocalisationId)
    {
        $this->entityRevisionRepository->publishDraft($entityLocalisationId);

        return redirect()->back();
    }
}
