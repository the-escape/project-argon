<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class BlockController extends BaseController
{
    protected $entityRepository;
    protected $entityGroupRepository;

    public function __construct(
        EntityRepository $entityRepository,
        EntityGroupRepository $entityGroupRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->entityGroupRepository = $entityGroupRepository;

        parent::__construct();
    }

    public function edit($entityId, $entityLocalisationId, $entityGroupId)
    {
        $this->addTabs([
            new Tab('ATTRIBUTES', route('cms:pages:attributes', [$entityId, $entityLocalisationId])),
            new Tab('PAGE CONTENT', route('cms:pages:content', [$entityId, $entityLocalisationId]), true),
            new Tab('SEO', route('cms:pages:seo', [$entityId, $entityLocalisationId])),
        ]);

        $entity = $this->entityRepository->find($entityId);

        $entityGroup = $this->entityGroupRepository->find($entityGroupId);

        return view('argon.entity::pages.block', [
            'entity' => $entity,
            'name' => $entity->name,
            'entityGroup' => $entityGroup,
        ]);
    }

    public function update()
    {

    }

    function setMiddleware()
    {
        return [];
    }
}
