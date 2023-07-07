<?php

namespace App\Core;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DataTableAPI
{
    protected Collection $allItems;
    protected Collection $filteredItems;
    protected Request $request;
    protected int $draw;
    protected string|array|int|null $search;
    protected string|array|int|null $start;
    protected string|array|int|null $length;
    protected string|array|int|null $order;
    protected string|array|int|null $columns;
    protected int $recordsTotal;
    protected int $recordsTotalFiltered;

    public function __construct($items,$request)
    {
        $this->filteredItems = $this->allItems = $items;
        $this->request = $request;
        $this->recordsTotal = $this->recordsTotalFiltered = $items->count();
        $this->draw = $this->request->query('draw', 0);
        $this->search = $this->request->query('search', array('value' => '', 'regex' => false));
        $this->start = $this->request->query('start', 0);
        $this->length = $this->request->query('length', 25);
        $this->order = $this->request->query('order');
        $this->columns = $this->request->query('columns');
    }


    public function search($columns)
    {

        if (!empty($this->search['value'])) {


            $this->filteredItems = $this->allItems; // récupère la liste de base avant d'ajouter les filtres

            $searchElements = json_decode($this->search['value']);

            $this->filteredItems = $this->filteredItems->filter(function($item)use($columns,$searchElements){
                $ret = [];
                foreach ($searchElements as $key => $elements)
                {

                    $search = $columns[$key];

                    $value = $item;

                    $in_item = [];

                    // search sur plusieurs colonne
                    if(is_array($search))
                    {
                        foreach ($search as $prop)
                        {
                            $value = $item;
                            foreach (explode('.',$prop)as $property)
                            {

                                $value = $this->get_nested_property($property,$value); // item value en fonction de sa colonne

                            }

                            foreach ($elements as $element)
                            {
                                if($element != "")
                                {
                                    if(is_string($value))
                                    {
                                        $in_item[] = Str::contains(strtolower($value),strtolower($element));
                                    }
                                    else
                                    {
                                        if($value instanceof Carbon)
                                        {
                                            $in_item[] = Str::contains(strtolower($value->format('d/m/Y')),strtolower($element));
                                        }
                                        if(is_int($value))
                                        {
                                            $in_item[] = Str::contains(strtolower(strval($value)),strtolower($element));
                                        }

                                    }

                                }
                                else
                                {
                                    $in_item[] = true;
                                }
                            }
                        }
                    }
                    else
                    {
                        if(Str::contains($search,','))
                        {
                            foreach (explode(',',$search) as $prop)
                            {
                                $value = $item;
                                foreach (explode('.',$prop)as $property)
                                {

                                    $value = $this->get_nested_property($property,$value); // item value en fonction de sa colonne

                                }
                                foreach ($elements as $element)
                                {
                                    if($element != "")
                                    {
                                        if(is_string($value))
                                        {
                                            $in_item[] = Str::contains(strtolower($value),strtolower($element));
                                        }
                                        else
                                        {
                                            if($value instanceof Carbon)
                                            {
                                                $in_item[] = Str::contains(strtolower($value->format('d/m/Y')),strtolower($element));
                                            }
                                            if(is_int($value))
                                            {
                                                $in_item[] = Str::contains(strtolower(strval($value)),strtolower($element));
                                            }

                                        }

                                    }
                                    else
                                    {
                                        $in_item[] = true;
                                    }
                                }
                            }
                        }
                        else
                        {
                            foreach (explode('.',$search)as $property)
                            {
                                $value = $this->get_nested_property($property,$value); // item value en fonction de sa colonne
                            }
                            foreach ($elements as $element)
                            {
                                if($element != "")
                                {
                                    $in_item[] = Str::contains(strtolower($value),strtolower($element));
                                }
                                else
                                {
                                    $in_item[] = true;
                                }
                            }
                        }
                    }

                    if(count($in_item) > 0)
                    {
                        $ret[] = in_array(true, $in_item);
                    }
                }
                $ret = array_unique($ret);

                if((count($ret) == 1 && $ret[0]) || count($ret) == 0)
                {
                    return $item;
                }

                return null;

            });
        }

        $this->recordsTotalFiltered = $this->filteredItems->count();
    }
    private function get_nested_property($property, $object) {
        return $object->{$property};
    }

    public function ordering($columns): void
    {
        if(isset($this->order)) {
            $sortColumnName = $columns[$this->order[0]['column']];

            $this->filteredItems = $this->filteredItems->sortBy([
                [$sortColumnName, $this->order[0]['dir']]
            ]);
        }

        $this->recordsTotalFiltered = $this->filteredItems->count();
    }

    public function result(mixed $resource = null): array
    {
        return array(
            'draw' => $this->draw,
            'recordsTotal' => $this->recordsTotal,
            'recordsFiltered' => $this->recordsTotalFiltered,
            'data' => isset($resource)?$resource::collection($this->collection()):$this->collection(),
        );
    }

    public function collection(): LengthAwarePaginator
    {
        return PaginateCollection::paginate($this->filteredItems->slice($this->start, $this->length),$this->length);
    }
    public static function datatable(Collection $items,Request $request,array $sortColumns, $resource = null)
    {

        $recordsTotal = $items->count();
        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order');

        $filter = $search['value'];

        if (!empty($filter)) {

            $items = $items->filter(function($item)use($filter,$sortColumns){
                //todo?
                return Str::contains(strtolower($item->profile->full_name), [strtolower($filter)]);
            });
        }

        $recordsTotalFiltered = $items->count();

        if(isset($order)) {
            $sortColumnName = $sortColumns[$order[0]['column']];

            $items = $items->sortBy(function ($item,int $key){
                dd($item);
            });
            $items = $items->sortBy([
                [$sortColumnName, $order[0]['dir']]
            ]);
        }

        return array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotalFiltered,
            'data' => $resource::collection(PaginateCollection::paginate($items->forPage($start,$length),$length)),
        );
    }

}
