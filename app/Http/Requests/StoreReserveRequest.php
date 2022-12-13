<?php

namespace App\Http\Requests;

use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'filesId'       =>           'array|required',
            'filesId.*'     =>           'exists:files,id',
        ];
    }
    /**
     *
     */
    public function check()
    {

        return File::whereIn('id',  $this->filesId)
            ->where('is_reserve', false)
            ->get();
    }
}