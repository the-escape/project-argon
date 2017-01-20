<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class CreateController extends BaseController
{
    private $entityRepository;
    private $entityGroupRepository;

    public function __construct(EntityRepository $entityRepository, EntityGroupRepository $entityGroupRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->entityGroupRepository = $entityGroupRepository;

        parent::__construct();
    }

    function setMiddleware()
    {
        return [
            'auth',
            'perm:cms:login',
        ];
    }

    function setTabs()
    {
        return [
            new Tab('PAGE CONTENT', '/admin/pages/edit'),
            new Tab('ATTRIBUTES', ''),
            new Tab('SEO', ''),
            new Tab('REVISIONS', ''),
        ];
    }

    public function edit($entityId)
    {
        $entity = $this->entityRepository->find($entityId);

        $groups = $this->entityGroupRepository
            ->findByField('entity_type_id', $entity->entity_type_id);

        return view('argon.entity::pages.create', [
            'name' => $entity->name,
            'groups' => $groups,
        ]);
    }
}
