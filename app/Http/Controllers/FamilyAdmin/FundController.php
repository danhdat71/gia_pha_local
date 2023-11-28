<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Constants\Paginate;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeFundStatus;
use App\Http\Requests\CreateFundRequest;
use App\Http\Requests\EditFundRequest;
use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use App\Constants\Fund as FundConstant;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;

class FundController extends Controller
{
    use FileTrait;

    public function getFunds(Request $request)
    {
        $user = Auth::guard('family_member')->user();
        $inputed = $request->only('keyword', 'from_date', 'to_date', 'user_id', 'event_id');
        $funds = Fund::when(!empty($request->from_date), function($q) use($request) {
                $q->whereDate('date', '>=', $request->from_date);
            })
            ->when(!empty($request->to_date), function($q) use($request) {
                $q->whereDate('date', '<=', $request->to_date);
            })
            ->when($request->user_id, function($q) use($request) {
                $q->when($request->user_id == -1, function($q) {
                    $q->where('user_id', '=', null);
                });
                $q->when($request->user_id != -1, function($q) use($request){
                    $q->where('user_id', $request->user_id);
                });
            })
            ->when($request->event_id, function($q) use($request) {
                $q->when($request->event_id == -1, function($q) {
                    $q->where('event_id', '=', null);
                });
                $q->when($request->event_id != -1, function($q) use($request) {
                    $q->where('event_id', $request->event_id);
                });
            })
            ->where('family_tree_id', $user->family_tree_id)
            ->paginate(Paginate::FUND);

        $users = User::select('id', 'full_name')->get();
        $events = Event::select('id', 'title')->get();

        return view('family_admin.funds', [
            'funds' => $funds,
            'events' => $events,
            'users' => $users,
            'current_page' => CurrentPage::FUND,
            'inputed' => $inputed,
        ]);
    }

    public function store(Request $request)
    {
        $validate = new CreateFundRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }
        $user = Auth::guard('family_member')->user();
        $fund = new Fund();
        $fund->description = $request->description;
        $fund->user_id = $request->user_id;
        $fund->event_id = $request->event_id;
        $fund->fund_type = $request->fund_type;
        $fund->date = $request->date;
        $fund->family_tree_id = $user->family_tree_id;
        $fund->status = FundConstant::FUND_OK;

        if ($request->hasFile('proof')) {
            $fund->proof = $this->storeProof($request->file('proof'));
        }

        $fund->save();

        return $this->successMessage('Thành công !');
    }

    public function delete(Request $request)
    {
        $fund = Fund::findOrFail($request->id);
        $fund->delete();
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $validate = new EditFundRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }
        $fund = Fund::findOrFail($request->id);
        $fund->description = $request->description;
        $fund->fund_type = $request->fund_type;
        $fund->event_id = $request->event_id;
        $fund->date = $request->date;

        // If del proof
        if ($request->is_del_proof == 1) {
            $fund->proof = null;
        }
        // If upload image
        if ($request->hasFile('proof')) {
            $fund->proof = $this->storeProof($request->file('proof'));
        }

        $fund->save();
        return $this->successMessage('Thành công !');
    }

    public function changeStatus(Request $request)
    {
        $validate = new ChangeFundStatus();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }

        $fund = Fund::findOrFail($request->id);
        $fund->status = $request->status;
        $fund->save();

        return $this->successMessage('Thành công !');
    }
}
