<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateElectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * ここは使わないので、trueにしておく
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
            // ワイルドカードが効かない？forで回すか？
             // name属性 => required:必須
             'title' => 'required|string|max:255',
             'subtitle' => 'string|nullable|max:255',
             'name0' => 'required|string|max:255',
             'name1' => 'string|nullable|max:255', // nullを許容しないと、空の時エラーが出る
             'name2' => 'string|nullable|max:255', // nullを許容するときは、nullableを入れる
             'name3' => 'string|nullable|max:255', // さらにDBの方もnull許容を設定しないといけない
             'name4' => 'string|nullable|max:255',
             'name5' => 'string|nullable|max:255',
             'name6' => 'string|nullable|max:255',
             'name7' => 'string|nullable|max:255',
             'name8' => 'string|nullable|max:255',
             'name9' => 'string|nullable|max:255',
             'com0' => 'required|string|max:255',
             'com1' => 'string|nullable|max:255', // nullを許容しないと、空の時エラーが出る
             'com2' => 'string|nullable|max:255', // nullを許容するときは、nullableを入れる
             'com3' => 'string|nullable|max:255', // さらにDBの方もnull許容を設定しないといけない
             'com4' => 'string|nullable|max:255',
             'com5' => 'string|nullable|max:255',
             'com6' => 'string|nullable|max:255',
             'com7' => 'string|nullable|max:255',
             'com8' => 'string|nullable|max:255',
             'com9' => 'string|nullable|max:255',
             'img0' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'img1' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
             'img2' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
             'img3' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
             'img4' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'img5' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'img6' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'img7' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'img8' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'img9' => 'file|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        
        ];

    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "email" => "メールアドレスの形式で入力してください。",
        "numeric" => "数値で入力してください。",
        "opinion.max" => "255文字以内で入力してください。"
        ];
      }
}
