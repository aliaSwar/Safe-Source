<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReserveRequest;
use App\Models\File;
use App\Models\History;
use Illuminate\Support\Facades\DB;

class ReserverationController extends Controller
{
    /**
     * حجز ملف
     */
    public function checkIn(File $file)
    {
        if ($file->is_reserve) {
            return response('the file is already reserving ', 201);
        }
        $file->is_reserve      =       true;
        $file->reverse_id      =       auth()->id();
        $file->save();

        //store in history file
        History::create([
            'user_id' => auth()->id(),
            'file_id' => $file->id,
            'status'  => 'reserve',

        ]);
        return ['message'   =>     'the user is reservetion the  file successfuly'];
    }
    /**
     * الغاء الحجز
     */
    public function checkOut(File $file)
    {
        if (!$file->is_reserve) {
            return response('the file is not reserving ', 201);
        }
        DB::transaction(function () use ($file) {

            $file->is_reserve      =       false;
            $file->reverse_id      =       null;
            $file->save();
            //store in history file
            History::create([
                'user_id' => auth()->id(),
                'file_id' => $file->id,
                'status'  => 'cancle',

            ]);
        });
        return ['message'   =>     'the user cancle eservetion the file successfuly'];
    }
    /**
     * الغاء الحجز
     */
    public function BulkcheckIn(StoreReserveRequest $request)
    {

        foreach ($request->check() as $file) {

            $file->is_reserve      =       true;
            $file->reverse_id      =       auth()->id();
            $file->save();

            //store in history file
            History::create([
                'user_id' => auth()->id(),
                'file_id' => $file->id,
                'status'  => 'reserve',

            ]);
        }
        return [
            'message'   =>     'the user is  reservetion the files successfuly'
        ];
    }
}