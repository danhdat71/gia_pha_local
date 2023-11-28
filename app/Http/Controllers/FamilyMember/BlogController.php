<?php

namespace App\Http\Controllers\FamilyMember;

use App\Constants\FamilyMemberPage;
use App\Constants\Paginate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use App\Models\Blog;

class BlogController extends Controller
{
    public function blogs()
    {
        $authUser = Auth::guard('family_member')->user();
        $agent = new Agent();
        $pageTitle = 'Tin tức & Sự kiện';
        $blogs = Blog::select('id', 'title', 'avatar', 'user_id')
            ->where('family_tree_id', $authUser->family_tree_id)
            ->where('is_visible', true)
            ->withCount(['blogsViewers'])
            ->orderBy('created_at', 'desc')
            ->paginate(Paginate::BLOG);

        $returnData = [
            'blogs' => $blogs,
            'pageTitle' => $pageTitle,
            'agent' => $agent,
            'currentPage' => FamilyMemberPage::EVENT,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.blogs', $returnData);
        }

        return view('family_member.desktop.blogs', $returnData);
    }

    public function blogDetail($id)
    {
        $authUser = Auth::guard('family_member')->user();
        $agent = new Agent();
        $blog = Blog::where('is_visible', true)
            ->where('family_tree_id', $authUser->family_tree_id)
            ->whereId($id)
            ->withCount(['blogsViewers'])
            ->firstOrFail();
        $blog->blogsViewers()->sync($authUser->id);

        $returnData = [
            'blog' => $blog,
            'pageTitle' => $blog->title,
            'agent' => $agent,
            'currentPage' => FamilyMemberPage::EVENT,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.blog_detail', $returnData);
        }

        return view('family_member.desktop.blog_detail', $returnData);
    }
}
