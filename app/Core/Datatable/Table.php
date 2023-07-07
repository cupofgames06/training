<?php

namespace App\Core\Datatable;

class Table
{
    public string $id ;
    public array $columns = array();
    public array $filters;
    public mixed $items = array();
    public string $route = ''; // cas api datatable
    public bool $ajax = false;
    public string $title;
    public bool $search = false;
    public object $action;

    public function __construct()
    {
        $this->id = 'table_'.uniqid();
    }
    public function columns(array $columns)
    {
        $this->columns = $columns;
    }
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function filters($items): void
    {
        $filters = [];
        foreach ($items as $item)
        {
            $filters[] = new Filter($item);
        }
        $this->filters = $filters;
    }
    public function title($title)
    {
        $this->title = $title;
    }

    public function route(string $route)
    {
        $this->ajax = true;
        $this->route = $route;
    }

    public function items(mixed $items)
    {
        $this->items = $items;
    }
    public function ajax()
    {
        $this->ajax = true;
    }

    public function action($item)
    {
        $this->action = (object)$item;
    }
    public function search($value)
    {
        $this->search = $value;
    }
    protected function getQuery(): mixed
    {
        return $this->items; // Exemple de requête de base pour récupérer les utilisateurs
    }
    public function toolbar()
    {

    }
}
