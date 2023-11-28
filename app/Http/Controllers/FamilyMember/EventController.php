<?php

namespace App\Http\Controllers\FamilyMember;

use App\Constants\FamilyMemberPage;
use App\Constants\Paginate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function events()
    {
        $authUser = Auth::guard('family_member')->user();
        $agent = new Agent();
        $pageTitle = 'Tin tức & Sự kiện';
        $events = Event::select('id', 'title', 'date')
            ->where('family_tree_id', $authUser->family_tree_id)
            ->withCount(['eventsViewers' => function($q) use($authUser) {
                $q->where('user_id', $authUser->id);
            }])
            ->orderBy('events_viewers_count', 'asc')
            ->paginate(Paginate::EVENT);
        
        $returnData = [
            'events' => $events,
            'pageTitle' => $pageTitle,
            'agent' => $agent,
            'currentPage' => FamilyMemberPage::EVENT,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.events', $returnData);
        }

        return view('family_member.desktop.events', $returnData);
    }

    public function eventDetail($id)
    {
        $authUser = Auth::guard('family_member')->user();
        $agent = new Agent();
        $event = Event::where('family_tree_id', $authUser->family_tree_id)
            ->with(['eventsUsers', 'eventTimes'])
            ->whereId($id)
            ->firstOrFail();
        $event->eventsViewers()->sync($authUser->id);

        $returnData = [
            'event' => $event,
            'pageTitle' => $event->title,
            'agent' => $agent,
            'currentPage' => FamilyMemberPage::EVENT,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.event_detail', $returnData);
        }
        
        return view('family_member.desktop.event_detail', $returnData);
    }
}
