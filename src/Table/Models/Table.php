<?php

namespace Escape\Argon\Table\Models;

class Table
{
    private $className;
    private $rowView = 'argon.table::partials.row';
    private $actions = false;
    private $rows = [];
    private $columns = [];

    public function setClassName($className)
    {
        $this->className = $className;
    }

    public function setRowView($rowView)
    {
        $this->rowView = $rowView;
    }

    public function addColumn($name, $label, $width)
    {
        $this->columns[] = new TableColumn($name, $label, $width);
    }

    public function addRow(TableRow $row)
    {
        if (!$this->actions && count($row->getActions()) > 0) {
            $this->actions = true;
            $this->columns[] = new TableColumn('action', 'ACTION', 30);
        }

        $this->rows[] = $row;
    }

    public function render()
    {
        $rows = [];

        foreach ($this->rows as $row) {
            if ($this->actions) {
                $data = $row->getData() + ['action' => $row->renderActions()];
                $row->setData($data);
            }

            $rows[] = view($this->rowView)->with([
                'row' => $row,
                'columns' => $this->columns,
            ])->render();
        }

        return view('argon.table::partials.table')->with([
            'className' => $this->className,
            'rows' => $rows,
            'columns' => $this->columns,
        ]);
    }
}
