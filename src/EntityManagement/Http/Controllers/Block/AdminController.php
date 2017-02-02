<?php

namespace Escape\Argon\EntityManagement\Http\Controllers\Block;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    protected $entityRepository;
    protected $entityGroupRepository;
    protected $entityRevisionRepository;
    protected $entityRevisionGroupRepository;
    protected $fieldDataRepository;

    public function __construct(
        EntityRepository $entityRepository,
        EntityGroupRepository $entityGroupRepository,
        EntityRevisionRepository $entityRevisionRepository,
        EntityRevisionGroupRepository $entityRevisionGroupRepository,
        FieldDataRepository $fieldDataRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->entityGroupRepository = $entityGroupRepository;
        $this->entityRevisionRepository = $entityRevisionRepository;
        $this->entityRevisionGroupRepository = $entityRevisionGroupRepository;
        $this->fieldDataRepository = $fieldDataRepository;

        parent::__construct();
    }

    public function edit($entityLocalisationId, $entityRevisionGroupId)
    {
        $this->addTabs([
            new Tab('ATTRIBUTES', route('cms:pages:attributes', [1, $entityLocalisationId])),
            new Tab('PAGE CONTENT', route('cms:pages:content', [1, $entityLocalisationId]), true),
            new Tab('SEO', route('cms:pages:seo', [1, $entityLocalisationId])),
        ]);

        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        $entity = $entityRevision->localisation->entity;

        $entityRevisionGroup = $this->entityRevisionGroupRepository->find($entityRevisionGroupId);

        return view('argon.entity::pages.block', [
            'entity' => $entity,
            'name' => $entity->name,
            'entityRevisionGroup' => $entityRevisionGroup,
            'entityLocalisationId' => $entityLocalisationId,
            'entityRevision' => $entityRevision,
        ]);
    }

    public function update(Request $request, $entityId, $entityLocalisationId, $entityGroupId)
    {
        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        $entityRevisionGroup = $this->entityRevisionGroupRepository
            ->makeModel()
            ->where('entity_revision_id', $entityRevision->id)
            ->where('entity_group_id', $entityGroupId)
            ->first();

        $fields = $entityRevisionGroup->entityGroup->fields;

        $entityRevisionGroup->status = $request->input('status');
        $entityRevisionGroup->save();

        foreach ($fields as $field) {

            $value = $field->field_type === 'combo' ? 'combo.'.$field->id : 'fields.'.$field->id;

            $this->fieldDataRepository->updateOrCreate([
                'field_id' => $field->id,
                'entity_revision_id' => $entityRevision->id,
                'language' => $entityRevision->localisation->getLocale()->getLanguageCode(),
            ], [
                'field_id' => $field->id,
                'entity_revision_id' => $entityRevision->id,
                'language' => $entityRevision->localisation->getLocale()->getLanguageCode(),
                'value' => $request->input($value),
            ]);
        }

        return redirect()->route('cms:pages:content', [$entityId, $entityLocalisationId]);
    }

    function setMiddleware()
    {
        return [];
    }
}
