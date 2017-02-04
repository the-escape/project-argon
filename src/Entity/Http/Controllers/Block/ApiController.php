<?php

namespace Escape\Argon\Entity\Http\Controllers\Block;

use Escape\Argon\Entity\Eloquent\EntityGroupRepository;
use Escape\Argon\Entity\Eloquent\EntityRevisionGroupRepository;
use Escape\Argon\Entity\Eloquent\EntityRevisionRepository;
use Escape\Argon\Entity\Eloquent\EntityTypeRepository;
use Escape\Argon\Entity\Http\Controllers\BaseApiController;
use Escape\Argon\Entity\Transformers\EntityGroupTransformer;
use Escape\Argon\Entity\Transformers\EntityRevisionGroupTransformer;
use Escape\Argon\Entity\Transformers\EntityRevisionTransformer;
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
        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        $entityRevisionGroup = $this->entityRevisionGroupRepository->create([
            'entity_revision_id' => $entityRevision->id,
            'entity_group_id' => $request->input('id'),
        ]);

        $item = new Item($entityRevisionGroup, new EntityRevisionGroupTransformer());

        $response = $this->manager->createData($item)->toArray();

        return response()->json($response);
    }

    public function destroy($entityLocalisationId, $entityGroupId)
    {
        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        // @TODO: Figure out a way to use entity revision group ID on the new draft...
        $entityRevisionGroup = $this->entityRevisionGroupRepository
            ->makeModel()
            ->where('entity_revision_id', '=', $entityRevision->id)
            ->where('entity_group_id', '=', $entityGroupId)
            ->first();

        $entityGroup = $entityRevisionGroup->entityGroup;

        $entityRevisionGroup->delete();

        $item = new Item($entityGroup, new EntityGroupTransformer());

        $response = $this->manager->createData($item)->toArray();

        return response()->json($response);
    }
}
