<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Constants\Gender;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $authUser = Auth::guard('family_member')->user();
        $totalMember = User::where('family_tree_id', $authUser->family_tree_id)->count();
        $totalWoman = User::where('family_tree_id', $authUser->family_tree_id)->where('gender', Gender::FEMALE)->count();
        $totalMan = User::where('family_tree_id', $authUser->family_tree_id)->where('gender', Gender::MALE)->count();
        $events = Event::where('family_tree_id', $authUser->family_tree_id)->whereDate('date', '>', Carbon::now()->format('Y-m-d'))->limit(10)->get();

        $familyMembers = collect();
        $parent = $this->getParent($authUser);
        $spouses = $this->getSpouses($authUser);
        $childs = $this->getChilds($authUser);
        $familyMembers = $familyMembers->merge($parent);
        $familyMembers = $familyMembers->merge($spouses);
        $familyMembers = $familyMembers->merge($childs);


        return view('family_admin.dashboard', [
            'totalMember' => $totalMember,
            'totalWoman' => $totalWoman,
            'totalMan' => $totalMan,
            'events' => $events,
            'familyMembers' => $familyMembers,
            'current_page' => CurrentPage::DASHBOARD,
        ]);
    }

    public function getSpouses($authUser)
    {
        $spouses = collect();
        if ($authUser->is_main) {
            $marriages = $authUser->marriages;
            foreach ($marriages as $marriage) {
                $spouse = $marriage->spouse;
                $spouses->push($spouse);
            }
        } else {
            $spouses->push($authUser->mainSpouse);
        }


        $result = $spouses->map(function ($item) {
            if ($item->gender == Gender::MALE) {
                $item->{'f_relationship'} = 'Chồng';
            } else {
                $item->{'f_relationship'} = 'Vợ';
            }
            return $item;
        });

        return $result;
    }

    public function getChilds($authUser)
    {
        $childs = collect();
        if ($authUser->is_main) {
            $marriages = $authUser->marriages;
            foreach ($marriages as $marriage) {
                $childs = User::where('parent_marriage_id', $marriage->id)->get();
            }
        } else {
            $childs = $authUser->spouseMarriage->marriageChildrens;
        }

        if (sizeof ($childs) != 0) {
            $childs = $childs->map(function ($item) {
                if ($item->gender == Gender::MALE) {
                    $item->{'f_relationship'} = 'Con trai';
                } else {
                    $item->{'f_relationship'} = 'Con gái';
                }
                return $item;
            });
        }

        return $childs;
    }

    public function getParent($authUser)
    {
        $result = collect([]);
        if ($authUser->is_main == true) {
            $parentMarriage = $authUser->parentMarriage;
            if ($parentMarriage) {
                $mainParent = $result->push($parentMarriage->mainPerson);
                $result = $mainParent->map(function ($item) {
                    if ($item->gender == Gender::MALE) {
                        $item->{'f_relationship'} = 'Cha';
                    } else {
                        $item->{'f_relationship'} = 'Mẹ';
                    }
                    return $item;
                });
            }
        }

        return $result;
    }
}
