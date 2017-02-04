<?php

namespace Escape\Argon\Entity\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\Entity\Eloquent\EntityRepository;

class AttributeController extends BaseController
{
    protected $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;

        parent::__construct();
    }

    public function edit($entityId, $entityLocalisationId)
    {
        $this->addTabs([
            new Tab('ATTRIBUTES', route('cms:pages:attributes', [$entityId, $entityLocalisationId])),
            new Tab('PAGE CONTENT', route('cms:pages:content', [$entityId, $entityLocalisationId])),
            new Tab('SEO', route('cms:pages:seo', [$entityId, $entityLocalisationId])),
        ]);

        $entity = $this->entityRepository->find($entityId);

        return view('argon.entity::pages.attributes', [
            'entity' => $entity,
            'name' => $entity->name,
        ]);
    }

    function setMiddleware()
    {
        return [];
    }
}
