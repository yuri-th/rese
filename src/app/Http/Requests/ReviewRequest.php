<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'stars' => 'required|integer|between:1,5',
            'comment' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'stars.required' => '評価を選択してください',
            'stars.between' => '評価は1から5の範囲内で指定してください',
            'comment.required' => 'コメントを入力してください',
        ];
    }
}
