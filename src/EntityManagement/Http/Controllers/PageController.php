<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Criterias\SearchCriteria;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityType;
use Escape\Argon\Table\Models\Table;
use Escape\Argon\Table\Models\TableRow;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    protected $entityRepository;
    protected $statuses;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;

        $this->statuses = [
            0 => view('argon.entity::partials.not-published'),
            1 => view('argon.entity::partials.published'),
        ];

        parent::__construct();
    }

    function setMiddleware()
    {
        return [
            'auth',
        ];
    }

    function setTabs()
    {
        return [
            new Tab('PAGES', action('\Escape\Argon\EntityManagement\Http\Controllers\PageController@index')),
        ];
    }

    public function index()
    {
        $entities = $this->entityRepository
            ->pages()
            ->keyBy('id');

        foreach ($entities as $entity) {
            if ($entity->parent_id) {
                $entities[$entity->parent_id]->addChild($entity);
            }
        }

        $entities = $entities->filter(function ($entity) {
            return $entity->parent_id == null;
        });

        $table = new Table();

        $table->setClassName('table--sitemap');
        $table->setRowView('argon.entity::partials.row');

        $table->addColumn('navigation', 'NAVIGATION', 50);
        $table->addColumn('status', 'STATUS', 20);

        foreach ($entities as $entity) {
            $this->addRow($table, $entity);
        }

        return view('argon::partials.table', [
            'name' => 'Sitemap',
            'table' => $table,
        ]);
    }

    private function addRow(Table $table, $entity, $level = 0, $parent = 0)
    {
        $row = new TableRow($entity->id, [
            'navigation' => $entity->name,
            'status' => $this->statuses[$entity->status],
        ]);

        $row->setLevel($level);
        $row->setParent($parent);

        $row->addAction(TableRow::TABLE_ACTION_CREATE);
        $row->addAction(TableRow::TABLE_ACTION_BUTTON, '#', 'EDIT');

        $table->addRow($row);

        if ($entity->hasChildren()) {
            $level++;
            $row->setHasChildren(true);
            foreach ($entity->getChildren() as $child) {
                $this->addRow($table, $child, $level, $entity->id);
            }
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

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
}
