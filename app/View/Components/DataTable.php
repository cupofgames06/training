<?php

namespace App\View\Components;

use App\Core\Datatable\Table;
use Illuminate\View\Component;

class DataTable extends Component
{
    public Table $table;

    public function __construct()
    {
        $this->table = new Table();
    }
    public function title($title)
    {
        $this->table->title($title);
    }
    public function columns($columns)
    {
        $this->table->columns($columns);
    }

    public function filters($filters)
    {
        $this->table->filters($filters);
    }

    public function route($route)
    {
        $this->table->ajax();
        $this->table->route($route);
    }

    public function items($items)
    {
        $this->table->items($items);
    }
    public function ajax()
    {
        $this->table->ajax();
    }
    public function action($item)
    {
        $this->table->action($item);
    }
    public function search($value)
    {
        $this->table->search($value);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.datatable._table');
    }
}
