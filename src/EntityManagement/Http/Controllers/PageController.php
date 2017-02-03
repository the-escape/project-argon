<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Criterias\SearchCriteria;
use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevision;
use Escape\Argon\Table\Models\Table;
use Escape\Argon\Table\Models\TableRow;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends BaseController
{
    protected $entityRepository;
    protected $table;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;

        $this->table = new Table();

        $this->table->setClassName('table--sitemap');
        $this->table->setRowView('argon.entity::partials.row');

        $this->table->addColumn('navigation', 'NAVIGATION', 50);
        $this->table->addColumn('status', 'STATUS', 20);

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
            new Tab('PAGES', action('\Escape\Argon\EntityManagement\Http\Controllers\PageController@index')),
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
            action('\Escape\Argon\EntityManagement\Http\Controllers\ContentController@edit', [$entity->id, $entity->getDefaultLocalisation()]),
            'EDIT');

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
        $entity = $this->entityRepository->find(1);

        $entity->id = 1000;

        $row = $this->addTableRow($entity, $request->get('level'), $request->get('parent'), true);

        return $row->render($this->table->getColumns(), 'argon.entity::partials.row');
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
