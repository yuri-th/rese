<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ManagerRequest extends FormRequest
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
            'shop' => 'required',
            'email' => 'required|email',
            'postcode' => 'required|regex:/^[0-9]{3}-[0-9]{4}$/',
            'address' => 'required',
            'tel' => 'required|regex:/^[0-9]{1,11}$/',
            'birthdate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '氏名を入力してください',
            'area_id.required' => 'エリアを入力してください',
            'shop.required' => '店舗名を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは例の形式で入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => '郵便番号は例の形式で入力してください',
            'address.required' => '住所を入力してください',
            'tel.required' => '電話番号を入力してください',
            'tel.tel' => '電話番号は例の形式で１１文字以内で入力してください',
            'birthdate.required' => '誕生日を入力してください',
        ];
    }
}
