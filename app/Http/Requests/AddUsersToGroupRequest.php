<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AddUsersToGroupRequest extends FormRequest
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
            'users'       =>           'array|required',
            'users.*'     =>           'exists:users,id',
        ];
    }

    /**
     * Get the check request that apply to add uder to group.
     *
     * @return array<string, mixed>
     */
    public function check(Group $group)
    {

        if (auth()->id() != $group->user_id)
            return false;
        return true;
    }
}