<?php

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

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
            'users'        =>           'required|array',
            'users.*'      =>           'exists:users,id',
        ];
    }
    /**
     *
     */
    public function check(Group $group)
    {

        foreach ($this->users as $userID) {
            $users[] = $group->files()->each(function ($file) use ($userID) {

                if (!is_null($file->reverse_id) and $file->reverse_id == $userID) {
                    return $userID;
                }
            });
        }
        return $users;
    }
}