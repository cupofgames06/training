<?php

namespace App\Http\Controllers;

use App\Core\DataTableAPI;
use App\Http\Resources\CompanyActiveLearnerMonitoringResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\OfMonitoringCustomerLearnerLeftResource;
use App\Http\Resources\OfMonitoringCustomerLearnerResource;
use App\Models\Company;
use App\Models\Course;
use App\Models\Of;
use Illuminate\Http\Request;

class DataTableController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('front.pages.home');

    }

    public function getCourses(Request $request)
    {
        $courses = Course::all();
        $dataTable = new DataTableAPI($courses,$request);

        $dataTable->search(array(
            'search' => 'reference',
        ));
        $dataTable->ordering(array(
            0 => 'reference',
            1 => 'name',
        ));

        return $dataTable->result(CourseResource::class);
    }

    public function getOfMonitoringCustomerLearnersActive($of, $company,Request $request)
    {
        $company = Company::find($company);
        $dataTable = new DataTableAPI($company->learners,$request);

        $dataTable->search(array(
            'search' => 'reference',
        ));
        $dataTable->ordering(array(
            0 => 'reference',
            1 => 'name',
        ));

        OfMonitoringCustomerLearnerResource::company($company);

        return $dataTable->result(OfMonitoringCustomerLearnerResource::class);
    }
    public function getOfMonitoringCustomerLearnersLeft($of, $company,Request $request)
    {
        $company = Company::find($company);
        $dataTable = new DataTableAPI($company->leftLearners,$request);

        $dataTable->search(array(
            'search' => 'reference',
        ));
        $dataTable->ordering(array(
            0 => 'reference',
            1 => 'name',
        ));

        OfMonitoringCustomerLearnerLeftResource::company($company);

        return $dataTable->result(OfMonitoringCustomerLearnerLeftResource::class);
    }
}
