<?php

namespace App\Http\Controllers\FamilyMember;

use App\Constants\FamilyMemberPage;
use App\Constants\Paginate;
use App\Http\Controllers\Controller;
use App\Http\Requests\FundRegisterRequest;
use App\Http\Requests\FundUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\Event;
use App\Constants\Fund as FundConstant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use App\Traits\FileTrait;

class FundController extends Controller
{
    use FileTrait;

    public function registerView()
    {
        $agent = new Agent();
        $authUser = Auth::guard('family_member')->user();
        $events = Event::where('family_tree_id', $authUser->family_tree_id)->select('title', 'id')->get();

        $returnData = [
            'currentPage' => FamilyMemberPage::PROFILE,
            'pageTitle' => 'Đăng ký quỹ',
            'events' => $events,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.fund_register', $returnData);
        }
        $returnData['currentPage'] = FamilyMemberPage::FUND_REGIST;
        return view('family_member.desktop.fund_register', $returnData);
    }

    public function register(Request $request)
    {
        $authUser = Auth::guard('family_member')->user();
        $validate = new FundRegisterRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }

        $fund = new Fund();
        $fund->fund_type = $request->fund_type;
        $fund->event_id = $request->event_id;
        $fund->date = $request->date;
        $fund->description = $request->description;
        $fund->user_id = $authUser->id;
        $fund->family_tree_id = $authUser->family_tree_id;
        $fund->status = FundConstant::FUND_CONFIRM;
        if ($request->hasFile('proof')) {
            $fund->proof = $this->storeProof($request->file('proof'));
        }
        $fund->save();

        return $this->successMessage('Đăng ký thành công !');
    }

    public function funds(Request $request)
    {
        $inputed = $request->only('date_from', 'date_to', 'event_id');
        $agent = new Agent();
        $authUser = Auth::guard('family_member')->user();
        $funds = Fund::where('user_id', $authUser->id)
            ->when($request->date_from != "", function($q) use($request) {
                $q->whereDate('date', '>=', $request->date_from);
            })
            ->when($request->date_to != "", function($q) use($request) {
                $q->whereDate('date', '<=', $request->date_to);
            })
            ->when($request->event_id, function($q) use($request) {
                $q->when($request->event_id == -1, function($q) {
                    $q->where('event_id', '=', null);
                });
                $q->when($request->event_id != -1, function($q) use($request) {
                    $q->where('event_id', $request->event_id);
                });
            })
            ->select('id', 'date', 'fund_type', 'status', 'description')
            ->paginate(Paginate::FUND);
        $events = Event::select('id', 'title')->where('family_tree_id', $authUser->family_tree_id)->get();

        $returnData = [
            'currentPage' => FamilyMemberPage::PROFILE,
            'pageTitle' => 'Quỹ thu chi',
            'funds' => $funds,
            'events' => $events,
            'inputed' => $inputed,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.funds', $returnData);
        }
        $returnData['currentPage'] = FamilyMemberPage::FUNDS;
        return view('family_member.desktop.funds', $returnData);
    }

    public function remove(Request $request)
    {
        $fund = Fund::where('id', $request->id)->where('status', FundConstant::FUND_CONFIRM)->firstOrFail();
        $fund->delete();

        return redirect()->route('family_member.funds');
    }

    public function edit($id)
    {
        $agent = new Agent();
        $authUser = Auth::guard('family_member')->user();
        $events = Event::where('family_tree_id', $authUser->family_tree_id)->select('title', 'id')->get();
        $fund = Fund::where('user_id', $authUser->id)
            ->where('id', $id)
            ->firstOrFail();

        $returnData = [
            'fund' => $fund,
            'currentPage' => FamilyMemberPage::PROFILE,
            'pageTitle' => 'Chi tiết quỹ',
            'events' => $events,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.fund_detail_edit', $returnData);
        }
        $returnData['currentPage'] = FamilyMemberPage::FUNDS;
        return view('family_member.desktop.fund_detail_edit', $returnData);
    }

    public function update(Request $request)
    {
        $authUser = Auth::guard('family_member')->user();
        $validate = new FundUpdateRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }

        $fund = Fund::where('user_id', $authUser->id)
            ->where('id', $request->id)
            ->where('status', FundConstant::FUND_CONFIRM)
            ->firstOrFail();

        // If del proof
        if ($request->is_del_proof == 1) {
            $fund->proof = null;
        }
        // If upload image
        if ($request->hasFile('proof')) {
            $fund->proof = $this->storeProof($request->file('proof'));
        }

        $fund->fund_type = $request->fund_type;
        $fund->event_id = $request->event_id;
        $fund->date = $request->date;
        $fund->description = $request->description;
        $fund->save();

        return $this->successMessage('Cập nhật thành công !');
    }
}
