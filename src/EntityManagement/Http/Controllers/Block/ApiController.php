<?php

namespace Escape\Argon\EntityManagement\Http\Controllers\Block;

use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevision;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\Http\Controllers\BaseApiController;
use Escape\Argon\EntityManagement\Transformers\EntityGroupTransformer;
use Escape\Argon\EntityManagement\Transformers\EntityRevisionGroupTransformer;
use Escape\Argon\EntityManagement\Transformers\EntityRevisionTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;

class ApiController extends BaseApiController
{
    protected $entityGroupRepository;
    protected $entityRevisionRepository;
    protected $entityTypeRepository;
    protected $entityRevisionGroupRepository;

    public function __construct(
        EntityGroupRepository $entityGroupRepository,
        EntityRevisionRepository $entityRevisionRepository,
        EntityTypeRepository $entityTypeRepository,
        EntityRevisionGroupRepository $entityRevisionGroupRepository)
    {
        $this->entityGroupRepository = $entityGroupRepository;
        $this->entityRevisionRepository = $entityRevisionRepository;
        $this->entityTypeRepository = $entityTypeRepository;
        $this->entityRevisionGroupRepository = $entityRevisionGroupRepository;

        parent::__construct();
    }

    public function index($entityLocalisationId)
    {
        $entityRevision = $this->entityRevisionRepository->getLatestRevision($entityLocalisationId);

        $this->manager->parseIncludes([
            'entityGroups',
            'entityRevisionGroups',
        ]);

        $item = new Item($entityRevision, new EntityRevisionTransformer());

        $response = $this->manager->createData($item)->toArray();

        return response()->json($response);
    }

    public function store(Request $request, $entityLocalisationId)
    {
        $entityRevision = $this->entityRevisionRepository->getLatestRevision($entityLocalisationId);

        if (!$entityRevision->isStatus(EntityRevision::STATUS_DRAFT)) {
            $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);
        }

        $entityRevisionGroup = $this->entityRevisionGroupRepository->create([
            'entity_revision_id' => $entityRevision->id,
            'entity_group_id' => $request->input('id'),
        ]);

        $item = new Item($entityRevisionGroup, new EntityRevisionGroupTransformer());

        $response = $this->manager->createData($item)->toArray();

        return response()->json($response);
    }

    public function destroy($entityRevisionGroupId)
    {
        $entityRevisionGroup = $this->entityRevisionGroupRepository->find($entityRevisionGroupId);

        $entityGroup = $entityRevisionGroup->entityGroup;

        $entityRevisionGroup->delete();

        $item = new Item($entityGroup, new EntityGroupTransformer());

        $response = $this->manager->createData($item)->toArray();

        return response()->json($response);
    }
}
