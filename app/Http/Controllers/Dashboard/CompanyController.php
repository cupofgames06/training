<?php

namespace App\Http\Controllers\Dashboard;

use App\Core\DataTableAPI;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyBestCoursesResource;
use App\Models\Company;
use App\Models\Course;
use App\Models\Learner;
use App\View\Components\DataTable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use JetBrains\PhpStorm\NoReturn;

class CompanyController extends Controller
{
    public Company $company;

    #[NoReturn] public function __construct()
    {
        if (Cache::has('account')) {
            $this->company = Company::find(Cache::get('account')->id);
            View::share('company', $this->company);
        }

        parent::__construct();
    }

    public function index(Request $request): \Illuminate\Contracts\View\View|Factory|array|Application
    {
        if($request->ajax())
        {
            $dataTable = new DataTableAPI(Course::all()->take(10),$request);

            return $dataTable->result(CompanyBestCoursesResource::class);
        }

        $table = new DataTable();

        $table->title('Top 10 des formations suivies');

        $table->columns(array(
            array(
                'title' => 'Intitulé formation',
                'class' => ''
            ),
            array(
                'title' => 'nombre d\'apprenants',
                'class' => ''
            ),
            array(
                'title' => 'Moyenne des acquis',
                'class' => ''
            ),
            array(
                'title' => 'Moyenne évaluations',
                'class' => ''
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable'=> false,
                'class' => '',
            )
        ));

        //$table->ajax();

        $table->items(Course::all()->take(10)->map(function($item){
            return collect([
                $item->name,
                "10",
                "9",
                "8",
                view('components.datatable.action._body', ['route' => '#'])->render()
            ]);
        }));

        return view('dashboard.pages.company.index',['company'=>$this->company,'table'=> $table->render()->with($table->data()) ]);
    }
}
