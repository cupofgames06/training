<?php

namespace App\Http\Controllers\Dashboard\Trainer;

use App\Core\DataTableAPI;
use App\Http\Controllers\Dashboard\TrainerController;
use App\Http\Resources\TrainerSessionResource;
use App\View\Components\DataTable;
use Illuminate\Http\Request;


class TrainerSessionController extends TrainerController
{
    public function index(Request $request)
    {
        if(!empty($request) && $request->ajax())
        {
            $dataTable = new DataTableAPI($this->trainer->sessions, $request);

            $dataTable->search(array(
                'search' => 'course.description.name',
            ));

            $dataTable->ordering(array(
                0 => 'date_start',
                1 => 'course.description.reference',
                2 => 'course.description.name',
                3 => 'place',
                4 => 'status',
            ));

            return $dataTable->result(TrainerSessionResource::class);
        }

        $table = new DataTable();
        $table->columns(array(
            array(
                'title' => 'Début formation',
                'class' => '',
            ),
            array(
                'title' => 'Référence',
                'class' => '',
            ),
            array(
                'title' => 'Intitulé',
                'class' => '',
            ),
            array(
                'title' => 'Ville',
                'class' => '',
            ),
            array(
                'title' => 'Status',
                'class' => '',
            ),
            array(
                'title' => 'Inscrits / Places',
                'class' => '',
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable'=> false,
                'class' => 'dt-right'
            )
        ));

        $table->ajax();
        $table->search(true);

        return view('dashboard.pages.trainer.sessions',['table'=> $table->render()->with($table->data()) ]);
    }


}
