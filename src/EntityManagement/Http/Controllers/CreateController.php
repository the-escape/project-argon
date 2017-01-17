<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;

class CreateController extends BaseController
{
    private $entityGroupRepository;

    public function __construct(EntityGroupRepository $entityGroupRepository)
    {
        $this->entityGroupRepository = $entityGroupRepository;

        parent::__construct();
    }

    function setMiddleware()
    {
        return [
            'auth'
        ];
    }

    function setTabs()
    {
        return [
            new Tab('PAGE CONTENT', '/admin/pages/create'),
            new Tab('ATTRIBUTES', ''),
            new Tab('SEO', ''),
            new Tab('REVISIONS', ''),
        ];
    }

    public function page($parentId, $typeId)
    {
        $groups = $this->entityGroupRepository
            ->findByField('entity_type_id', $typeId);

        return view('argon.entity::pages.create', [
            'name' => 'New Page',
            'groups' => $groups,
        ]);
    }
}
