<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use App\Http\Resources\HistoryResource;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', File::class);
        return File::with('group', 'user')->paginate('5');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        //store path file
        if ($request->has('path')) {
            $fileRequest = $request->path;
            $path = $fileRequest->store('files-store', 'public');
        }

        DB::transaction(function () use ($request, $path) {

            $file = File::create([
                'user_id'        =>     auth()->id(),
                'name'           =>     $request->name,
                'slug'           =>     Str::slug($request->name, '-'),
                'path'           =>     $path,
            ]);
            //store in history file
            History::create([
                'user_id' => auth()->id(),
                'file_id' => $file->id,
                'status'  => 'create',

            ]);
        });
        return ['message'   =>     'the user added file successfuly'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        $this->authorize('view', $file);
        return new FileResource($file);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileRequest  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        $this->authorize('update', $file);
        //store path file
        if ($request->has('path')) {
            $fileRequest = $request->path;
            $path = $fileRequest->store('files-store', 'public');
        }

        DB::transaction(function () use ($file, $path) {

            $file->update([
                'path'           =>     $path,
            ]);
            //store in history file
            History::create([
                'user_id' => $file->reverse_id,
                'file_id' => $file->id,
                'status'  => 'edit',

            ]);
        });
        return ['message'   =>     'the user updated file successfuly'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $this->authorize('delete', $file);
        $file->delete();

        return ['message'    =>     'the file is deleted successfuly'];
    }
    /**
     * ?????? ???????????????? ???????? ???????????? ????????????
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function showUserFiles(User $user)
    {
        $files = File::where('user_id', $user->id)->get();
        return $files;
    }
    /**
     * ?????? ???????????????? ???????? ???????????? ????????????
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function showHistoryFile(File $file)
    {
        $history = DB::table('histories')
            ->where('file_id', $file->id)
            ->join('users', 'users.id', '=', 'histories.user_id')
            ->select('histories.id', 'histories.status', 'histories.created_at', 'users.name')
            ->orderByDesc('created_at')->get();

        return $history;
    }
}