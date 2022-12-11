<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddFileToGroupRequest;
use App\Http\Requests\AddUsersToGroupRequest;
use App\Http\Requests\RemoveUsersFromGroupRequest;
use App\Models\File;
use App\Models\Group;


class OperationController extends Controller
{
    /**
     * add users to group
     */
    public function addUsersToGroup(AddUsersToGroupRequest $request, Group $group)
    {
        //return $request->check($group);
        if (!$request->check($group)) {
            return [
                "message"      =>         "the found error"
            ];
        }

        $group->users()->sync($request->users);

        return [
            'message'   =>  'successfuly added users to group'
        ];
    }
    /**
     * remove users from group
     */
    public function removeUsersFromGroup(RemoveUsersFromGroupRequest $request, Group $group)
    {
        //return $request->check($group);
        if (!$request->check($group)) {
            return [
                "message"      =>         "the found error"
            ];
        }

        $group->users()->sync($request->users);

        return [
            'message'   =>  'successfuly added users to group'
        ];
    }
    /***
     * add file To group
     */
    public function addFileToGroup(AddFileToGroupRequest $request, File $file)
    {
        $group = Group::findOrFail($request->group_id);
        //can add file to group just when user exits in group

        if (!$request->check($group, $file)) {
            return [
                "message"      =>         "the found error"
            ];
        }
        $file->group_id = $group->id;
        $file->save();
        return [
            'message'   =>     'the file added to group successfuly'
        ];
    }
}