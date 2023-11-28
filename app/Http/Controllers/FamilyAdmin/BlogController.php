<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Constants\Paginate;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\EditBlogRequest;
use App\Jobs\SendNotiCreatedPost;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BlogController extends Controller
{
    use FileTrait;

    public function getBlogs(Request $request)
    {
        $user = Auth::guard('family_member')->user();
        $inputed = $request->only('keyword', 'from_date', 'to_date');
        $blogs = Blog::when(!empty($request->keyword), function($q) use($request) {
                $q->where('title', 'like', "%".$request['keyword']."%");
            })
            ->when(!empty($request->from_date), function($q) use($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when(!empty($request->to_date), function($q) use($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->where('family_tree_id', $user->family_tree_id)
            ->orderBy('id', 'desc')
            ->paginate(Paginate::BLOG);

        return view('family_admin.blogs', [
            'blogs' => $blogs,
            'current_page' => CurrentPage::BLOG,
            'inputed' => $inputed,
        ]);
    }

    public function create()
    {
        return view('family_admin.create_blog', [
            'current_page' => CurrentPage::BLOG,
        ]);
    }

    public function store(Request $request)
    {
        $validate = new CreateBlogRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }

        $authUser = Auth::guard('family_member')->user();
        if ($request->has('avatar')) {
            $avatar = $this->storeBlogAvatar($request->file('avatar'));
        }

        $dataBlog = [
            'title' => $request->title,
            'avatar' => $avatar,
            'is_visible' => $request->is_visible,
            'content' => $request->content,
            'user_id' => $authUser->id,
            'family_tree_id' => $authUser->family_tree_id,
        ];
        $createdBlog = Blog::create($dataBlog);

        // Send notification
        if ($createdBlog->is_visible) {
            $notification = [
                'title' => $request->title,
                'body' => "$authUser->full_name vừa tạo bài viết mới.",
                'link' => route('family_member.blog_detail', $createdBlog->id),
            ];
            dispatch(new SendNotiCreatedPost($authUser->family_tree_id, $notification))->delay(5);
        }

        return $this->successMessage('Tạo thành công !');
    }

    public function edit(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        return view('family_admin.edit_blog', [
            'blog' => $blog,
            'current_page' => CurrentPage::BLOG,
        ]);
    }

    public function update(Request $request)
    {
        $validate = new EditBlogRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }

        $blog = Blog::findOrFail($request->id);
        if ($request->has('avatar')) {
            $blog->avatar = $this->storeBlogAvatar($request->file('avatar'));
        }

        $blog->title = $request->title;
        $blog->is_visible = $request->is_visible;
        $blog->content = $request->content;
        $blog->save();

        return $this->successMessage('Cập nhật công !');
    }

    public function delete(Request $request)
    {
        $blog = Blog::findOrFail($request->id);
        $blog->delete();
        return redirect()->back();
    }
}
