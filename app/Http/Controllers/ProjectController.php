<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $project = $user->projects()->create($request->only(['en_description', 'ar_description']));

        if ($request->get('before_exists')) {
            $project->addMediaFromRequest('before')->toMediaCollection('before');
        }
        $project->addMediaFromRequest('after')->toMediaCollection('after');

        return response($project->loadMissing(['before', 'after']));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response($project->loadMissing(['before', 'after']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request->only(['en_description', 'ar_description']));

            if ($request->get('update_before')) {
                $project->clearMediaCollection('before');
                $project->addMediaFromRequest('before')->toMediaCollection('before');
            }

            if ($request->get('update_after')) {
                $project->clearMediaCollection('after');
                $project->addMediaFromRequest('after')->toMediaCollection('after');
            }

        return response($project->loadMissing(['before', 'after']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        return response($project->delete());
    }
}
