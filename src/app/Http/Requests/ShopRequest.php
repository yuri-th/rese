<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'name' => 'required',
            'area_id' => 'required',
            'genre_id' => 'required',
            'image_url' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください',
            'area_id.required' => 'エリアを入力してください',
            'genre_id.required' => 'ジャンルを入力してください',
            'image_url.required' => '画像URLを入力してください',
            'description.required' => '詳細を入力してください',
        ];
    }
}
