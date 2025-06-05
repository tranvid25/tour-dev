<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Comment;
use App\Models\clients\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'tourId' => $request->tourId,
            'userId' => Auth::id(),
            'comment' => $request->comment,
            'parent_id' => $request->parent_id ?: null,
            'level' => 0,
            'avatar_user' => Auth::user()->avatar ?? 'images/default-avatar.png',
            'name_user' => Auth::user()->userName,
            'time' => now(),
        ];
        //tính level nếu là reply
        if (!is_null($data['parent_id'])) {
            $parent = Comment::findOrFail($data['parent_id']);
            $data['level'] = $parent->level + 1;
        }
        $comment = Comment::create($data);
        return response()->json([
            'success' => 'Thêm bình luận thành công',
            'comment' => $comment
        ]);
    }
    public function loadComments($tourId)
    {
        $comment = Comment::where('tourId', $tourId)
            ->orderBy('time', 'asc')
            ->get();
        $tour = Tour::findOrFail($tourId);
        return response()->json([
            'success' => true,
            'data' => $comment
        ]);
    }
    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->userId !== Auth::id()) {
            return response()->json(['error' => 'Bạn không có quyền'], 403);
        }
        $comment->comment = $request->comment;
        $comment->time = now();
        $comment->save();
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật bình luận thành công',
            'data' => $comment
        ]);
    }
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->userId !== Auth::id()) {
            return response()->json(['error' => 'Bạn không có quyền'], 403);
        }
        Comment::where('parent_id', $id)->delete();
        $comment->delete();
        return response()->json([
            'success' => true,
            'message' => 'xóa thành công'
        ]);
    }
}
