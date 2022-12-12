<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddFileToGroupRequest;
use App\Http\Requests\AddUsersToGroupRequest;
use App\Http\Requests\RemoveFileFromGroupRequest;
use App\Http\Requests\RemoveUsersFromGroupRequest;
use App\Models\File;
use App\Models\Group;
use Illuminate\Support\Facades\DB;

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

        $group->users()->attach($request->users);

        return [
            'message'   =>  'successfuly added users to group'
        ];
    }
    /**
     * remove users from group
     */
    public function removeUsersFromGroup(RemoveUsersFromGroupRequest $request, Group $group)
    {
        // return $request->check($group);
        if (!$request->check($group)) {
            return [
                "message"      =>         "the found error"
            ];
        }
        $group->users()->detach($request->user_id);

        return [
            'message'   =>  'successfuly remove user from group'
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
    /***
     * remove file from group
     */
    public function removeFileFromGroup(RemoveFileFromGroupRequest $request)
    {

        //can remove file from group just when user has a file
        $file = File::findOrFail($request->file_id);

        if (!$request->check($file)) {
            return response('the found error', 201);
        }
        $file->group_id = null;
        $file->save();
        return [
            'message'   =>     'the file removed from group successfuly'
        ];
    }
}