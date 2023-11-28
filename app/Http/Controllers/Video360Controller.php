<?php

namespace App\Http\Controllers;

use App\Constants\CurrentPage;
use App\Constants\Paginate;
use App\Http\Requests\CreatePrVideoRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Video360;
use App\Traits\FileTrait;

class Video360Controller extends Controller
{
    use FileTrait;

    public function index($user_id)
    {
        $videos = Video360::where('user_id', $user_id)->paginate(Paginate::VIDEO_360);

        return view('family_admin.video_360', [
            'user_id' => $user_id,
            'current_page' => CurrentPage::GENEALOGY,
            'videos' => $videos
        ]);
    }

    public function create(CreatePrVideoRequest $request, $user_id)
    {
        $videoNum = Video360::where('user_id', $user_id)->count();
        if ($videoNum >= env('MAX_REST_360_VIDEO')) {
            return redirect()->back();
        }
        $video360 = new Video360;
        // $file = $request->file('url');
        // $video360->url = $this->storeRestVideo360($file);
        $video360->url = $request->url;
        $video360->user_id = $user_id;
        $video360->save();

        return $this->responseJson($video360);
    }

    public function delete($video_id)
    {
        $video360 = Video360::findOrFail($video_id);
        $video360->delete();

        return redirect()->back();
    }
}
