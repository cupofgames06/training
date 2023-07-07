<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Learner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PartialController extends Controller
{

    public function overview(Request $request)
    {
        $dateDebut = Carbon::parse($request->get('date_start'));
        $dateFin = Carbon::parse($request->get('date_end'));

        if($request->has('learner'))
        {
            $learner = Learner::find($request->get('learner'));
            $finish = $learner->countFinish($dateDebut,$dateFin);
            $next = $learner->countNext($dateDebut,$dateFin);
            $in_progress = $learner->countInProgress($dateDebut,$dateFin);
            $total = $learner->countTotal($dateDebut,$dateFin);
            return view('dashboard.partials._overview',['count'=> 1,'total' => $total,'finish' => $finish,'next' => $next,'in_progress' => $in_progress ]);
        }
        if($request->has('company'))
        {
            $company = Company::find($request->get('company'));
            $finish = $company->countFinish($dateDebut,$dateFin);
            $next = $company->countNext($dateDebut,$dateFin);
            $in_progress = $company->countInProgress($dateDebut,$dateFin);
            $total = $company->countTotal($dateDebut,$dateFin);
            return view('dashboard.partials._overview',['count'=>$company->learners->count(),'total' => $total,'finish' => $finish,'next' => $next,'in_progress' => $in_progress ]);
        }

        return null;

    }
    public function indicators(Request $request): View|Factory|Application|null
    {
        $dateDebut = Carbon::parse($request->get('date_start'));
        $dateFin = Carbon::parse($request->get('date_end'));

        if($request->has('learner'))
        {
            $learner = Learner::find($request->get('learner'));
            return view('dashboard.partials._indicators',['items'=>$learner->indicators_pourcent($dateDebut,$dateFin)]);
        }
        if($request->has('company'))
        {
            $company = Company::find($request->get('company'));
            return view('dashboard.partials._indicators',['items'=>$company->learners_indicators_pourcent($dateDebut,$dateFin)]);
        }

        return null;
    }
    public function ratings(Request $request): View|Factory|Application|null
    {
        $dateDebut = Carbon::parse($request->get('date_start'));
        $dateFin = Carbon::parse($request->get('date_end'));

        if($request->has('learner'))
        {
            $learner = Learner::find($request->get('learner'));
            return view('dashboard.partials._average-ratings', ['item' => $learner, 'from' => $dateDebut, 'to' => $dateFin]);
        }
        if($request->has('company'))
        {
            $company = Company::find($request->get('company'));
            return view('dashboard.partials._average-ratings', ['item' => $company, 'from' => $dateDebut, 'to' => $dateFin]);
        }

        return null;
    }
    public function monitoring_course_details($locale,$customer,$learner,$session,Request $request)
    {

        return view('dashboard.partials._monitoring-course-details', ['item' => null]);
    }
}
