<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Group::class);
        return Group::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        DB::transaction(function () use ($request) {

            $group = new Group();
            $group->user_id        =     auth()->id();
            $group->name           =     $request->name;
            $group->slug           =     Str::slug($request->name, '-');
            $group->save();

            $group->users()->attach(auth()->id());
        });
        return ['message'   =>     'the user ' . auth()->user()->name . ' added a new  group successfuly'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGroupRequest  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
        $group->delete();

        return ['message'      =>     'the user ' . auth()->user()->name . ' has deleted successfuly group'];
    }
    /**
     * عرض المحموعات التي يملكها اليوزر
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function showUserGroups(User $user)
    {
        $groups = [];
        foreach ($user->groups as $group) {
            if ($group->user_id == $user->id) {
                $groups[] = $group;
            }
        }
        return $groups;
    }
}
