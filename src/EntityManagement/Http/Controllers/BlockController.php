<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class BlockController extends BaseController
{
    protected $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;

        parent::__construct();
    }

    public function edit($entityId, $groupId)
    {
        $this->addTabs([
            new Tab('PAGE CONTENT', route('cms:pages:content', $entityId), true),
            new Tab('ATTRIBUTES', route('cms:pages:attributes', $entityId)),
            new Tab('SEO', route('cms:pages:seo', $entityId)),
        ]);

        $entity = $this->entityRepository->find($entityId);



        return view('argon.entity::pages.block', [
            'entity' => $entity,
            'name' => $entity->name,
        ]);
    }

    function setMiddleware()
    {
        return [];
    }
}
