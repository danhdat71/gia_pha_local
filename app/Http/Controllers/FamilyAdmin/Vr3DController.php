<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Constants\Paginate;
use App\Http\Requests\StoreVr3DRequest;
use App\Http\Requests\UpdateVr3DRequest;
use App\Models\Vr3DButton;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vr3D;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Vr3DController extends Controller
{
    use FileTrait;

    public function index($user_id)
    {
        $vr3Ds = Vr3D::where('user_id', $user_id)->paginate(Paginate::VR_3D);
        $sizeOfVr3Ds = Vr3D::where('user_id', $user_id)->count();

        return view('family_admin.vr_3d', [
            'user_id' => $user_id,
            'current_page' => CurrentPage::GENEALOGY,
            'vr3Ds' => $vr3Ds,
            'size_of_vr_3d' => $sizeOfVr3Ds,
        ]);
    }

    public function createVr3D($user_id)
    {
        $vr3ds = Vr3D::where('user_id', $user_id)->get();
        return view('family_admin.create_vr_3d', [
            'vr_3ds' => $vr3ds,
            'user_id' => $user_id,
            'current_page' => CurrentPage::GENEALOGY,
        ]);
    }

    public function storeVr3D(StoreVr3DRequest $request, $user_id)
    {
        $vr3DModel = new Vr3D;
        $title = $request->title;
        $file = $request->file('vr_3d_file');
        $buttons = $request->buttons;

        DB::beginTransaction();
        try {
            $vr3DModel->title = $title;
            $vr3DModel->url = $this->storeVr3DFile($file);
            $vr3DModel->user_id = $user_id;
            $vr3DModel->save();
            if ($buttons && sizeof($buttons) > 0) {
                $vr3DModel->vr3Dbuttons()->createMany($buttons);
            }
            DB::commit();
            return $this->successMessage('Thành công !');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('vr_3d')->error($th->getMessage());
            return $this->errorMessage('Có lỗi !');
        }
    }

    public function editVr3D($vr_3d_id)
    {
        $vr3D = Vr3D::with(['vr3Dbuttons'])->findOrFail($vr_3d_id);
        $vr3ds = Vr3D::where('user_id', $vr3D->user_id)->where('id', '<>', $vr3D->id)->get();

        return view('family_admin.edit_vr_3d', [
            'user_id' => $vr3D->user_id,
            'vr3D' => $vr3D,
            'vr_3ds' => $vr3ds,
            'current_page' => CurrentPage::GENEALOGY,
        ]);
    }

    public function updateVr3D(UpdateVr3DRequest $request, $vr_3d_id)
    {
        DB::beginTransaction();
        try {
            $vr3DModel = Vr3D::find($vr_3d_id);
            $title = $request->title;
            $buttons = $request->buttons;
            if ($request->file('vr_3d_file')) {
                $file = $request->file('vr_3d_file');
                $vr3DModel->url = $this->storeVr3DFile($file);
            }
            $vr3DModel->title = $title;
            $vr3DModel->save();

            $vr3DModel->vr3Dbuttons()->delete();
            if ($buttons && sizeof($buttons) > 0) {
                $vr3DModel->vr3Dbuttons()->createMany($buttons);
            }
            DB::commit();
            return $this->successMessage('Thành công !');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('vr_3d')->error($th->getMessage());
            return $this->errorMessage('Có lỗi !');
        }
    }

    public function deleteVr3D($vr_3d_id)
    {
        $vr3DModel = Vr3D::findOrFail($vr_3d_id);
        $vr3DModel->vr3Dbuttons()->delete();
        $vr3DModel->delete();
        return redirect()->back();
    }
}
