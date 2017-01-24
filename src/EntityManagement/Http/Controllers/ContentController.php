<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;

class ContentController extends BaseController
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

    public function edit($entityId)
    {
        $this->addTabs([
            new Tab('PAGE CONTENT', route('cms:pages:content', $entityId)),
            new Tab('ATTRIBUTES', route('cms:pages:attributes', $entityId)),
            new Tab('SEO', route('cms:pages:seo', $entityId)),
        ]);

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

        return view('argon.entity::pages.content', [
            'entity' => $entity,
            'name' => $entity->name,
            'groups' => $groups,
            'rendered' => $rendered,
        ]);
    }

    public function update(Request $request, $entityId)
    {
        $currentLocale = 1;

        // Get the current entity.
        $entity = $this->entityRepository->find($entityId);

        $groups = ($entity->group_render instanceof  \stdClass) ? $entity->group_render : new \stdClass();
        $groups->{$currentLocale} = json_decode($request->get('selected'));

        $request->merge(['group_render' => $groups]);

        $entity->fill($request->all());
        $entity->save();

        return redirect()->back();
    }
}
