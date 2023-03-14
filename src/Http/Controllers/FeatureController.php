<?php

namespace Tithe\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Tithe\Contracts\CreatesFeatures;
use Tithe\Contracts\UpdatesFeatures;
use Tithe\Tithe;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $features = Tithe::featureModel()::paginate();

        return view('tithe::feature.index', [
            'user' => $request->user('tithe'),
            'features' => $features,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        Gate::forUser(request()->user('tithe'))->authorize('create', Tithe::newFeatureModel());

        return view('tithe::feature.create', [
            'user' => request()->user('tithe'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesFeatures $creator, Request $request)
    {
        $feature = $creator->create($request->user('tithe'), $request->all());

        return redirect()->route('features.show', $feature->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $featureId
     * @return \Illuminate\View\View
     */
    public function show($featureId)
    {
        $feature = Tithe::featureModel()::withCount(['plans'])
            ->with(['plans'])
            ->findOrFail($featureId);

        Gate::forUser(request()->user('tithe'))->authorize('view', $feature);

        return view('tithe::feature.show', [
            'user' => request()->user('tithe'),
            'feature' => $feature,
            'permissions' => [
                'canUpdate' => Gate::check('update', $feature),
                'canDelete' => Gate::check('delete', $feature),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $featureId
     * @return \Illuminate\View\View
     */
    public function edit($featureId)
    {
        $feature = Tithe::featureModel()::findOrFail($featureId);

        Gate::forUser(request()->user('tithe'))->authorize('update', $feature);

        return view('tithe::feature.edit', [
            'user' => request()->user('tithe'),
            'feature' => $feature,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $featureId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatesFeatures $editor, $featureId)
    {
        $feature = Tithe::featureModel()::findOrFail($featureId);

        $editor->update(request()->user('tithe'), $feature, request()->all());

        return redirect()->route('features.show', $featureId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $featureId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($featureId)
    {
        $feature = Tithe::featureModel()::findOrFail($featureId);

        Gate::forUser(request()->user('tithe'))->authorize('delete', $feature);

        $feature->delete();

        return redirect()->route('features.index');
    }
}
