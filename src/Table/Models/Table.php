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
        $this->rows[] = $row;
    }

    public function getRows()
    {

    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function render()
    {
        $rows = [];

        foreach ($this->rows as $row) {
            $rows[] = $row->render($this->columns, $this->rowView);
        }

        return view('argon.table::partials.table')->with([
            'className' => $this->className,
            'rows' => $rows,
            'columns' => $this->columns,
        ]);
    }
}
