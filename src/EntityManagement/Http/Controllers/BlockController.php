<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use App\Http\Requests\Request;
use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Escape\Argon\EntityManagement\Helpers\Fields;

class BlockController extends BaseController
{
    protected $entityRepository;
    protected $entityGroupRepository;
    protected $entityRevisionRepository;
    protected $fieldDataRepository;

    public function __construct(
        EntityRepository $entityRepository,
        EntityGroupRepository $entityGroupRepository,
        EntityRevisionRepository $entityRevisionRepository,
        FieldDataRepository $fieldDataRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->entityGroupRepository = $entityGroupRepository;
        $this->entityRevisionRepository = $entityRevisionRepository;
        $this->fieldDataRepository = $fieldDataRepository;

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

    public function update(Request $request, $entityId, $entityLocalisationId, $entityGroupId)
    {
        $entityRevision = $this->entityRevisionRepository->createDraft($entityLocalisationId);

        Fields::saveFields($request, $entityRevision->entity->type->fields, $entityRevision, $this->fieldDataRepository, $entityRevision->localisation);

        foreach ($entityRevision->entity->type->fields as $field) {

            $niceName = $field->field_type === 'combo' ? 'combo.'.$field->id : 'fields.'.$field->id;

            $this->fieldDataRepository->create([
                'field_id' => $field->id,
                'entity_revision_id' => $entityRevision->id,
                'language' => $entityRevision->localisation->getLocale()->getLanguageCode(),
                'value' => $request->get($niceName),
            ]);
        }

        return redirect()->route('cms:pages:content', [$entityId, $entityLocalisationId]);
    }

    function setMiddleware()
    {
        return [];
    }
}
