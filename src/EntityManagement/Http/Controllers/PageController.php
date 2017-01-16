<?php

namespace Escape\Argon\EntityManagement\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Core\Models\Tab;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\Table\Models\Table;
use Escape\Argon\Table\Models\TableRow;

class PageController extends BaseController
{
    protected $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;

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
        $statuses = [
            0 => view('argon.entity::partials.not-published'),
            1 => view('argon.entity::partials.published'),
        ];

        $entities = $this->entityRepository->all();

        $table = new Table();

        $table->addColumn('navigation', 'NAVIGATION', 50);
        $table->addColumn('status', 'STATUS', 20);

        foreach ($entities as $entity) {



            $row = new TableRow([
                'navigation' => $entity->name,
                'status' => $statuses[$entity->status],
            ]);

            $table->addRow($row);
        }

        return view('argon::partials.table', [
            'name' => 'Sitemap',
            'table' => $table,
        ]);
    }

    public function create($parentId, $typeId)
    {


        return view('argon.entity::pages.create', [
            'name' => 'New Page'
        ]);
    }
}
