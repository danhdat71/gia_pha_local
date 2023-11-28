<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Constants\Paginate;
use App\Constants\Status;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function getEvents(Request $request)
    {
        $user = Auth::guard('family_member')->user();
        $inputed = $request->only('keyword', 'from_date', 'to_date');
        $events = Event::select('id', 'title', 'date')
            ->when(!empty($request->keyword), function($q) use($request) {
                $q->where('title', 'like', "%".$request['keyword']."%");
            })
            ->when(!empty($request->from_date), function($q) use($request) {
                $q->whereDate('date', '>=', $request->from_date);
            })
            ->when(!empty($request->to_date), function($q) use($request) {
                $q->whereDate('date', '<=', $request->to_date);
            })
            ->where('family_tree_id', $user->family_tree_id)
            ->paginate(Paginate::EVENT);

        return view('family_admin.events', [
            'events' => $events,
            'current_page' => CurrentPage::EVENT,
            'inputed' => $inputed,
        ]);
    }

    public function create()
    {
        $user = Auth::guard('family_member')->user();
        $members = User::where('family_tree_id', $user->family_tree_id)->get();

        return view('family_admin.create_event', [
            'members' => $members,
            'current_page' => CurrentPage::EVENT,
        ]);
    }

    public function store(CreateEventRequest $request)
    {
        $authUser = Auth::guard('family_member')->user();
        $now = Carbon::now();
        $event = new Event;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->detail = $request->detail;
        $event->is_year_loop = $request->is_year_loop;
        $event->user_id = $authUser->id;
        $event->family_tree_id = $authUser->family_tree_id;

        // Noti at
        if ($request->is_year_loop == Status::VALUE_TRUE) {
            $notiAtTime = $request->noti_time_before;
            $notiAtDay = Carbon::parse($request->date)->subDays($request->noti_day_before)->format('1000-m-d');
            $event->noti_before_at = "$notiAtDay $notiAtTime";
            $event->noti_before = "$request->noti_day_before|$request->noti_time_before"; //Ex: 90|16:52
        } else {
            $event->noti_before_at = null;
            $event->noti_before = null;
        }

        $event->save();

        // Sync event and members
        $joinMembers = explode(',', $request->join_members);
        $event->eventsUsers()->sync($joinMembers);
        $event->eventsUsers()->updateExistingPivot($joinMembers, [
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Sync event and event times
        $event->eventTimes()->createMany($request->event_times);

        return redirect()->route('family_admin.events');
    }

    public function edit($id)
    {
        $user = Auth::guard('family_member')->user();
        $event = Event::findOrFail($id);
        $members = User::where('family_tree_id', $user->family_tree_id)->get();

        return view('family_admin.edit_event', [
            'event' => $event,
            'members' => $members,
            'current_page' => CurrentPage::EVENT,
        ]);
    }

    public function update(UpdateEventRequest $request)
    {
        $now = Carbon::now();
        $event = Event::findOrFail($request->id);
        $event->title = $request->title;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->detail = $request->detail;
        $event->is_year_loop = $request->is_year_loop;
        
        // Noti at
        if ($request->is_year_loop == Status::VALUE_TRUE) {
            $notiAtTime = $request->noti_time_before;
            $notiAtDay = Carbon::parse($request->date)->subDays($request->noti_day_before)->format('1000-m-d');
            $event->noti_before_at = "$notiAtDay $notiAtTime";
            $event->noti_before = "$request->noti_day_before|$request->noti_time_before"; //Ex: 90|16:52
        } else {
            $event->noti_before_at = null;
            $event->noti_before = null;
        }

        $event->save();

        // Sync event and members
        $joinMembers = explode(',', $request->join_members);
        $event->eventsUsers()->sync($joinMembers);
        $event->eventsUsers()->updateExistingPivot($joinMembers, [
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Sync event and event times
        $event->eventTimes()->delete();
        $event->eventTimes()->createMany($request->event_times);
        return redirect()->back()->with('message', 'Cập nhật thành công !');
    }

    public function delete(Request $request)
    {
        $event = Event::findOrFail($request->id);
        $event->eventTimes()->delete();
        $event->eventsUsers()->detach();
        $event->delete();

        return redirect()->back()->with('message', 'Đã xoá event ' . $event->title);
    }
}
