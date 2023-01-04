<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function PushComment(Request $req, $id)
    {
        $content = $req->input('content');
        Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $id,
            'content' => $content,
            'votes' => '0'
        ]);
        return back();
    }

    public function LikeComment($commentId)
    {
        $comment = Comment::find($commentId);
        ++$comment->votes;
        $comment->save();
        return back();
    }

    public function EditViewPost($postId)
    {
        $post = Post::find($postId);
        if (Gate::allows('update-post', $post)) {
            return view('edit_post', ['post' => $post, 'user' => Auth::user()]);
        }
        return back();
    }

    public function UpdatePost($postId, Request $req)
    {
        $post = Post::find($postId);
        if (Gate::allows('update-post', $post)) {
            $post->title = $req->input('title');
            $post->desc = $req->input('desc');
            $post->content = $req->input('content');
            $post->save();
            return redirect()->route('/profile')->with('message', 'Публикация обновлена!!');
        }
        return back();
    }

    public function DeletePost($id)
    {
        $post = Post::find($id);
        if (Gate::allows('update-post', $post)) {
            Post::destroy($id);
            return back()->with('message', 'Публикация удалена!');
        }
        return back();
    }

    public function AddPost(Request $req)
    {
        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $req->input('title'),
            'desc' => $req->input('desc'),
            'content' => $req->input('content'),
            'votes' => '0'
        ]);
        return redirect()->route('/profile')->with('message', 'Опубликовано!');
    }
}
