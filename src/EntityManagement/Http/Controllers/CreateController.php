<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Illuminate\Support\Collection;

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
            new Tab('PAGE CONTENT', action('\Escape\Argon\EntityManagement\Http\Controllers\CreateController@edit', 1)),
            new Tab('ATTRIBUTES', ''),
            new Tab('SEO', ''),
            new Tab('REVISIONS', ''),
        ];
    }

    public function edit($entityId)
    {
        // Get the current entity.
        $entity = $this->entityRepository->find($entityId);

        // TODO: Change to the active Locale.
        $rendered = $entity->getRenderedGroups(1);

        // Get all entity type groups minus the already rendered ones.
        $groups = $this->entityGroupRepository
            ->makeModel()
            ->where('entity_type_id', $entity->entity_type_id)
            ->whereNotIn('id', $rendered->keys())
            ->get();

        return view('argon.entity::pages.create', [
            'name' => $entity->name,
            'groups' => $groups,
            'rendered' => $rendered,
        ]);
    }
}
