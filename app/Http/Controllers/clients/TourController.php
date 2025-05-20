<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\clients\Booking;
use App\Models\clients\Tour;
use App\Models\clients\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
class TourController extends Controller
{
    public function index(){
        $tours=Tour::all();
        return response()->json([
            'tours'=>$tours,
            'message'=>'Hiển thị thành công'
        ]);
    }
    public function show(string $id){
        $tours=Tour::findOrFail($id);
        return response()->json([
            'tours'=>$tours,
            'message'=>'Xem chi tiết tour'
        ]);
    }
    public function store(Request $request){
        $imagesName=[];
        if($request->hasFile('images')){
            $images=$request->file('images');
            if(count($images)>3){
                return response()->json([
                    'message'=>'Số lượng ảnh vượt quá mưc cho phép'
                ],402);
            }
            foreach($images as $image){
                if(!$image->isValid() || $image->getSize() > 1024*1024){
                    continue;
                }
                $name=time() . '_' .uniqid(). '.'. $image->getClientOriginalExtension();
                $basePath=public_path('uploads/tour/');
                Image::make($image)->save($basePath.$name);
                Image::make($image)->resize(85,84)->save($basePath.'hinh50_'.$name);
                Image::make($image)->resize(329,380)->save($basePath.'hinh200_'.$name);
                $imagesName[]=$name;
            }
        }
         Tour::create([
            'availability'=>$request->availability,
            'description'=>$request->description,
            'destination'=>$request->destination,
            'duration'=>$request->duration,
            'images'=>json_encode($imagesName),
            'itinerary'=>$request->itinerary,
            'priceChild'=>$request->priceChild,
            'priceAdult'=>$request->priceAdult,
            'quantity'=>$request->quantity,
            'reviews'=>$request->reviews,
            'title'=>$request->title
        ]);
        return response()->json([
            'message'=>'Thêm tour thành công'
        ]);

    }
    public function update(Request $request,string $id){
       $tours=Tour::findOrFail($id);
       $hinhcu=json_decode($tours->images,true);//hình cũ [1,2,3]
       $hinhxoa=$request->input('hinhanhxoa',[]);
       foreach($hinhxoa as $hinh){
        if(in_array($hinh,$hinhcu)){
            $index=array_search($hinh,$hinhcu);
            if($index !== false){
                unset($hinhcu[$index]);
                 $basePath = public_path('uploads/tour/');
                 @unlink($basePath . $hinh);
                 @unlink($basePath . 'hinh50_' . $hinh);
                 @unlink($basePath . 'hinh200_' . $hinh);
            }
        }
       }
       $hinhconlai=array_values($hinhcu);
       $hinhanhmoi=[];
       if($request->hasFile('hinhanhmoi')){
        foreach($request->file('hinhanhmoi') as $file){
            if(!$file->isValid() || $file->getSize()>1024*1024){
                continue;
            }
            $name=time(). '_' . uniqid() . '.' .$file->getClientOriginalExtension();
            $basePath=public_path('uploads/tour/');
            Image::make($file)->save($basePath.$name);
            Image::make($file)->resize(85,84)->save($basePath . 'hinh50_' .$name);
            Image::make($file)->resize(329,380)->save($basePath . 'hinh200_' .$name);
            $hinhanhmoi[]=$name;

        }
       }
       if(count($hinhanhmoi)+count($hinhconlai)>3){
        return response()->json([
            'error'=>'upload quá mức cho phép'
        ],402);
       }
       $hinhtong=array_merge($hinhconlai,$hinhanhmoi);
       $tours->update([
          'availability'=>$request->availability,
            'description'=>$request->description,
            'destination'=>$request->destination,
            'duration'=>$request->duration,
            'images'=>json_encode($hinhtong),
            'itinerary'=>$request->itinerary,
            'priceChild'=>$request->priceChild,
            'priceAdult'=>$request->priceAdult,
            'quantity'=>$request->quantity,
            'reviews'=>$request->reviews,
            'title'=>$request->title
       ]);
       return response()->json([
        "message"=>"Cập nhật Tour thành công",
        'tours'=>$tours
       ]);
    }
    public function destroy(string $id){
        $tours=Tour::findOrFail($id);
        $tours->delete();
        return response()->json([
            'message'=>'Xóa Tour thành công '
        ]);
    }
}
