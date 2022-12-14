<?php

namespace App\Http\Requests;

use App\Models\File;
use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class AddFileToGroupRequest extends FormRequest
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
            'group_id'       =>           'required|exists:groups,id'
        ];
    }

    /**
     * can add file to group just when user exits in group
     *
     * @return boolean
     */
    public function check(Group $group, File $file)
    {
        if (auth()->id() != $file->user_id) {
            return false;
        }
        foreach ($group->users as $user) {
            if ($file->user_id === $user->id) {
                return true;
            }
        }
        return false;
    }
}