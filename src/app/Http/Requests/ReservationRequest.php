<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'reservation_date' => 'required|date|after_or_equal:tomorrow',
            'time' => 'required', 
            'number' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'reservation_date.required' => '予約日を入力してください',
            'reservation_date.after_or_equal' => '予約日は翌日以降の日付をご入力ください',
            'time.required' => '時間を入力してください',
            'number.required' => '人数を入力してください'      
        ];
    }
}
