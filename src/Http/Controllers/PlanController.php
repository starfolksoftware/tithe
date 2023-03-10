<?php

namespace Tithe\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Tithe\Contracts\CreatesPlans;
use Tithe\Contracts\UpdatesPlans;
use Tithe\Tithe;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $plans = QueryBuilder::for(Tithe::planModel(), $request)
            ->allowedFilters([
                'name',
                'display_name',
                'description',
                AllowedFilter::exact('interval', 'periodicity_type'),
                AllowedFilter::exact('currency'),
            ])
            ->allowedSorts('amount')
            ->paginate();

        return view('tithe::plan.index', [
            'user' => $request->user('tithe'),
            'plans' => $plans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        Gate::forUser(request()->user('tithe'))->authorize('create', Tithe::newPlanModel());

        return view('tithe::plan.create', [
            'user' => request()->user('tithe'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatesPlans $creator, Request $request)
    {
        $plan = $creator->create($request->user('tithe'), $request->all());

        return redirect()->route('plans.show', $plan->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $planId
     * @return \Illuminate\Http\Response
     */
    public function show($planId)
    {
        $plan = Tithe::planModel()::withCount(['features'])
            ->with(['features'])
            ->firstOrFail($planId);

        Gate::forUser(request()->user('tithe'))->authorize('view', $plan);

        return view('tithe::plan.show', [
            'user' => request()->user('tithe'),
            'plan' => $plan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $planId
     * @return \Illuminate\Http\Response
     */
    public function edit($planId)
    {
        $plan = Tithe::planModel()::findOrFail($planId);

        Gate::forUser(request()->user('tithe'))->authorize('update', $plan);

        return view('tithe::plan.edit', [
            'user' => request()->user('tithe'),
            'plan' => $plan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $planId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesPlans $editor, $planId)
    {
        $plan = Tithe::planModel()::findOrFail($planId);

        $editor->update(request()->user('tithe'), $plan, request()->all());

        return redirect()->route('plans.show', $plan->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $planId
     * @return \Illuminate\Http\Response
     */
    public function destroy($planId)
    {
        $plan = Tithe::planModel()::findOrFail($planId);

        Gate::forUser(request()->user('tithe'))->authorize('delete', $plan);

        $plan->delete();

        return redirect()->route('plan.index');
    }
}
