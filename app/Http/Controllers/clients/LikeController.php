<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Like;
use App\Models\clients\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function isLikedByMe(Tour $tour ){
        $like=$tour->likes()->where('userId',Auth::id())->exists();
        return response()->json([
            'liked'=>$like
        ]);
    }
    public function toggleLike(Tour $tour){
        $like=Like::withTrashed()->where('tourId',$tour->tourId)
        ->where('userId',Auth::id())->first();
       if(!$like){
        $tour->likes()->create([
            'userId'=>Auth::id()
        ]);
        return response()->json([
            'message'=>'Liked'
        ]);
       }
       if($like->trashed()){
        $like->restore();
        return response()->json([
            'message'=>'Unliked'
        ]);
       }
       $like->delete();
       return response()->json([
        'message'=>'Unliked'
       ]);
    }
    public function totalLikes(Tour $tour){
        $count=$tour->likes()->count();
        return response()->json([
            'message'=>$count
        ]);
    }
}
