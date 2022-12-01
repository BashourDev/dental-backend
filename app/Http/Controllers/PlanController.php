<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $plans = Plan::query();

        switch ($request->get('type')) {
            case 1:
                $plans->where('type', '=', 1);
                break;
            case 2:
                $plans->where('type', '=', 2);
                break;
        }

        return response($plans->with(['features'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = Plan::query()->create($request->only(['en_name', 'ar_name', 'type', 'quarter_price', 'semi_annual_price', 'annual_price']));
        $plan->features()->createMany($request->get('features'));
        return response($plan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return response($plan->loadMissing(['features']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $plan->update($request->only(['en_name', 'ar_name', 'type', 'quarter_price', 'semi_annual_price', 'annual_price']));

        $plan->features()->delete();
        $plan->features()->createMany($request->get('features'));

        return response('ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Plan::query()->whereIn('id', $request->get('ids'))->delete();
        return response('ok');
    }

    public function users(Plan $plan)
    {
        return response($plan->users);
    }

    public function dentists()
    {
        return response(Plan::query()->where('type', '=', Plan::PLAN_TYPE_DOCTOR)->get());
    }

    public function companies()
    {
        return response(Plan::query()->where('type', '=', Plan::PLAN_TYPE_COMPANY)->get());
    }
}
