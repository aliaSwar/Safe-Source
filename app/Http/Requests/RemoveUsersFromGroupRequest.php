<?php

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class RemoveUsersFromGroupRequest extends FormRequest
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

            'user_id'      =>           'exists:users,id',
        ];
    }
    public function check($group)
    {
        return auth()->id() == $group->user_id and $group->files()->each(function ($file) {
            if ($file->is_reserve and $file->reverse_id == $this->user_id) {
                return false;
            }
            
        });
    }
}