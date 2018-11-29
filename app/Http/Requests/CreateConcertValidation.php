<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConcertValidation extends FormRequest
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
            'concert_name' => 'required|max:255',
            'band_name' => 'required',
            'band_member' => 'required',
            'concert_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'concert_money' => 'required',
            'music_type' => 'required',
            'place_name' => 'required',
            'pref' => 'required',
            'line' => 'required',
            'station' => 'required',
//            'place_url' => 'required',
            'place_address' => 'required',
            'concert_img' => 'required|image|max:1000',
            'concert_introduction' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'concert_name.required' => 'ライブタイトルは必須です',
            'band_name.required' => 'バンド名は必須です',
            'band_member.required' => 'バンドメンバーは必須です',
            'concert_date.required' => 'ライブ日付は必須です',
            'start_time.required' => '開始時間は必須です',
            'end_time.required' => '終了時間は必須です',
            'concert_money.required' => 'チャージ料金は必須です',
            'music_type.required' => '音楽ジャンルは必須です',
            'place_name.required' => '会場名は必須です',
            'pref.required' => '都道府県は必須です',
            'line.required' => '路線は必須です',
            'station.required' => '最寄駅は必須です',
            'place_address.required' => '会場住所は必須です',
            'concert_img.required' => 'ライブ紹介画像は必須です',
            'concert_img.image' => '画像ファイルを選択してください',
            'concert_img.max' => '画像ファイルは最大1MBです',
            'concert_introduction.required' => 'ライブ説明は必須です',
        ];
    }
}
