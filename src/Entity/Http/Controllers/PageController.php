<?php

namespace Escape\Argon\Entity\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\Entity\Criterias\SearchCriteria;
use Escape\Argon\Entity\Eloquent\Entity;
use Escape\Argon\Entity\Eloquent\EntityRepository;
use Escape\Argon\Entity\Eloquent\EntityRevision;
use Escape\Argon\Entity\Eloquent\EntityRevisionRepository;
use Escape\Argon\Entity\Eloquent\EntityTypeRepository;
use Escape\Argon\Table\Models\Table;
use Escape\Argon\Table\Models\TableRow;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends BaseController
{
    protected $table;
    protected $entityRepository;
    protected $entityTypeRepository;
    protected $entityRevisionRepository;

    public function __construct(
        EntityRepository $entityRepository,
        EntityTypeRepository $entityTypeRepository,
        EntityRevisionRepository $entityRevisionRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->entityTypeRepository = $entityTypeRepository;
        $this->entityRevisionRepository = $entityRevisionRepository;

        $this->table = new Table();

        $this->table->setClassName('table--sitemap');
        $this->table->setRowView('argon.entity::partials.row', [
            'entityTypes' => $this->entityTypeRepository->page(),
        ]);

        $this->table->addColumn('navigation', 'NAVIGATION', 50);
        $this->table->addColumn('status', 'STATUS', 30);

        parent::__construct();
    }

    /**
     * Create and render the site-map table page.
     *
     * @return View
     */
    public function index()
    {
        $this->addTabs([
            new Tab('PAGES', action('\Escape\Argon\Entity\Http\Controllers\PageController@index')),
        ]);

        //  Get all pages and key by ID.
        $entities = $this->entityRepository
            ->pages()
            ->keyBy('id');

        // Loop through a add children to the parent entities.
        foreach ($entities as $entity) {
            if ($entity->parent_id) {
                $entities[$entity->parent_id]->addChild($entity);
            }
        }

        // Unset all the entities that have parent IDs.
        foreach ($entities as $key => $entity) {
            if (!is_null($entity->parent_id)) {
                unset($entities[$key]);
                continue;
            }

            // Add the remaining rows to the table
            $this->addTableRow($entity);
        }

        return view('argon::partials.table', [
            'name' => 'Sitemap',
            'table' => $this->table,
        ]);
    }

    /**
     * Adds a table row to the main table.
     *
     * @param Entity $entity
     * @param int $level
     * @param int $parent
     * @param bool $return
     * @return TableRow
     */
    protected function addTableRow(Entity $entity, $level = 0, $parent = 0, $return = false)
    {
        $row = new TableRow($entity->id, [
            'navigation' => $entity->name,
            'status' => EntityRevision::getStatusView($entity),
        ]);

        $row->setLevel($level);
        $row->setParent($parent);

        $row->addAction(TableRow::TABLE_ACTION_CREATE);
        $row->addAction(TableRow::TABLE_ACTION_BUTTON,
            action('\Escape\Argon\Entity\Http\Controllers\ContentController@edit', [$entity->id, $entity->getDefaultLocalisation()]),
            'EDIT PAGE');

        if ($return) {
            return $row;
        }

        $this->table->addRow($row);

        if ($entity->hasChildren()) {
            $level++;
            $row->setHasChildren(true);
            foreach ($entity->getChildren() as $childEntity) {
                $this->addTableRow($childEntity, $level, $entity->id);
            }
        }
    }

    public function store(Request $request)
    {
        $entity = $this->entityRepository->createPage([
            'name' => $request->input('name'),
            'entity_type_id' => $request->input('entity_type_id'),
            'owner_id' => 1,
            'parent_id' => $request->input('parent_id'),
            'slug' => $request->input('slug'),
            'status' => 0,
        ]);

        $row = $this->addTableRow($entity, $request->input('level'), $entity->parent_id, true);

        $viewData = [
            'entityTypes' => $this->entityTypeRepository->page(),
        ];

        return $row->render($this->table->getColumns(), 'argon.entity::partials.row', $viewData);
    }

    public function revert($entityId, $entityLocalisationId)
    {
        $latestEntityRevision = $this->entityRevisionRepository->getLatestRevision($entityLocalisationId);

        if ($latestEntityRevision->isStatus(EntityRevision::STATUS_DRAFT)) {
            $this->entityRevisionRepository->delete($latestEntityRevision->id);
        }

        $this->entityRevisionRepository->createDraft($entityLocalisationId, true);

        return redirect()->back();
    }

    /**
     * Table search functionality.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Get the search param.
        $search = $request->get('search');

        // Find all page entities using the search param.
        $entities = $this->entityRepository
            ->pushCriteria(new SearchCriteria($search))
            ->pages();

        $html = '';

        foreach ($entities as $entity) {
            $html .= view('argon.entity::partials.search-result', [
                'entity' => $entity,
            ]);
        }

        if ($entities->count() == 0) {
            $html = view('argon.entity::partials.search-result-empty');
        }

        return response()->make($html, 200);
    }

    /**
     * Set the controllers middleware.
     *
     * @return array
     */
    function setMiddleware()
    {
        return [];
    }
}
