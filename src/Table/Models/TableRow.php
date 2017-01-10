<?php

namespace Escape\Argon\Table\Models;

class TableRow
{
    const TABLE_ACTION_DELETE = 1;
    const TABLE_ACTION_BUTTON = 2;

    private $data = [];
    private $actions = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData($key = null)
    {
        return is_null($key) ? $this->data : $this->data[$key];
    }

    public function addAction($type, $url, $label = null)
    {
        $action = '';

        switch ($type) {
            case self::TABLE_ACTION_DELETE:
                $action = view('argon.table::actions.delete')->with(compact('url'));
                break;
            case self::TABLE_ACTION_BUTTON:
                $action = view('argon.table::actions.button')->with(compact('url', 'label'));
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
}
