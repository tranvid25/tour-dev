<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
     public function index(){
        $reason=Reason::all();
        return response()->json([
            'message'=>'Hiển thị thành công',
            'reason'=>$reason
        ]);
    }
    public function show(string $id){
        $reason=Reason::findOrFail($id);
        return response()->json([
            'message'=>'Chi tiết reason',
            'reason'=>$reason
        ]);
    }
    public function store(Request $request){
        $data=$request->all();
        $reason=Reason::create($data);
        return response()->json([
            'message'=>"Tạo thành công",
            'reason'=>$reason
        ]);
    }
    public function update(Request $request,string $id){
        $reason=Reason::findOrFail($id);
        $data=$request->all();
        $reason->update($data);
        return response()->json([
            'message'=>'Cập nhật thành công',
            'reason'=>$reason
        ]);
    }
    public function destroy(string $id){
        $reason=Reason::findOrFail($id);
        $reason->delete();
        return response()->json([
            'message'=>'Xóa cầu thủ thành công'
        ]);
    }
}
