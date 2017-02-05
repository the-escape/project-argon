<?php

namespace Escape\Argon\Table\Models;

class TableRow
{
    const TABLE_ACTION_BUTTON = 1;
    const TABLE_ACTION_DELETE = 2;
    const TABLE_ACTION_CREATE = 3;
    const TABLE_ACTION_CLONE = 4;

    private $id;
    private $level;
    private $parent;
    private $hasChildren = false;
    private $data = [];
    private $actions = [];
    private $columns = [];

    public function __construct($id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setHasChildren($hasChildren)
    {
        $this->hasChildren = $hasChildren;
    }

    public function getHasChildren()
    {
        return $this->hasChildren;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData($key = null)
    {
        return is_null($key) ? $this->data : $this->data[$key];
    }

    public function addAction($type, $url = '#', $label = null)
    {
        $action = '';

        switch ($type) {
            case self::TABLE_ACTION_BUTTON:
                $action = view('argon.table::actions.button')->with(compact('url', 'label'));
                break;
            case self::TABLE_ACTION_DELETE:
                $action = view('argon.table::actions.delete')->with(compact('url'));
                break;
            case self::TABLE_ACTION_CREATE:
                $action = view('argon.table::actions.create')->with(compact('url'));
                break;
            case self::TABLE_ACTION_CLONE:
                $action = view('argon.table::actions.clone')->with(compact('url'));
                break;
        }

        if ($action !== '') {
            $this->actions[] = $action;
        }
    }

    public function renderActions()
    {
        $html = '';

        foreach ($this->actions as $action) {
            $html .= $action->render();
        }

        return $html;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function render($columns, $rowView = 'argon.table::partials.row', $viewData = [])
    {
        if ($this->actions) {
            $columns[] = new TableColumn('action', 'ACTION', 20);
            $data = $this->getData() + ['action' => $this->renderActions()];
            $this->setData($data);
        }

        $viewData = [
            'row' => $this,
            'columns' => $columns,
        ] + $viewData;

        return view($rowView)->with($viewData);
    }
}
