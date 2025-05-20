<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
{
    protected $supportedLangs=['vi','en'];

    public function update(Request $request){
        $lang=$request->input('lang');
        if(!in_array($lang,$this->supportedLangs)){
            return response()->json([
                'message'=>'ngôn ngữ không hỗ trợ'
            ],422);
        }
        $request->session()->put('lang',$lang);
        return response()->json([
            'message'=>'Ngôn ngữ đã được cập nhật.',
            'lang'=>$lang
        ]);
    }
}
