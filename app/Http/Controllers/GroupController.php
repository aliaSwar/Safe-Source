<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        return view('groups.index', ['groups' => Group::with('users', 'files')->paginate(7)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {


        $group = new Group();
        $group->user_id        =     auth()->id();
        $group->name           =     $request->name;
        $group->slug           =     Str::slug($request->name, '-');
        $group->save();

        $group->users()->attach(auth()->id());

        return to_route('groups.show', ['group' => $group]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('groups.show', ['group' => $group]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
        $group->delete();

        return to_route('groups.index');
    }
    /**
     * عرض المحموعات التي يملكها اليوزر
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function showUserGroups()
    {
        $groups = [];
        foreach (auth()->user()->groups as $group) {
            if ($group->user_id == auth()->id()) {
                $groups[] = $group;
            }
        }
        return view('groups.show-user', $groups);
    }
}