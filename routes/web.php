<?php

use App\Http\Controllers\Auth\FamilyMemberAuthController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\FamilyAdmin\BlogController;
use App\Http\Controllers\FamilyAdmin\ContactInfoController;
use App\Http\Controllers\FamilyAdmin\DashboardController;
use App\Http\Controllers\FamilyAdmin\EventController;
use App\Http\Controllers\FamilyAdmin\Vr3DController;
use App\Http\Controllers\FamilyMember\EventController as MemberEventController;
use App\Http\Controllers\FamilyMember\BlogController as MemberBlogController;
use App\Http\Controllers\FamilyAdmin\FamilyAdminAuthController;
use App\Http\Controllers\FamilyAdmin\FamilyGenealogyController;
use App\Http\Controllers\FamilyAdmin\FundController;
use App\Http\Controllers\FamilyAdmin\RoleController;
use App\Http\Controllers\FamilyMember\AboutController;
use App\Http\Controllers\FamilyMember\GenealogyController;
use App\Http\Controllers\FamilyMember\MenuController;
use App\Http\Controllers\FamilyMember\ProfileController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FamilyMember\FundController as MemberFundController;
use App\Http\Controllers\FamilyMember\ContactController;
use App\Http\Controllers\RootAdmin\RootAdminAuthController;
use App\Http\Controllers\RootAdmin\RootAdminDashBoardController;
use App\Http\Controllers\RootAdmin\RootAdminUserController;
use App\Http\Controllers\FamilyAdmin\VRController;
use App\Http\Controllers\Video360Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomePageController::class, 'index'])->name('home_page');
Route::post('family-member/login', [FamilyMemberAuthController::class, 'login'])->name('family_member.login');
Route::get('family-member/login', [FamilyMemberAuthController::class, 'loginView'])
    ->name('family_admin.login_view')
    ->middleware('auth-family-domain');
Route::post('user-register', [HomePageController::class, 'register'])->name('user_register');
#Route::post('family-admin/login', [FamilyAdminAuthController::class, 'login'])->name('family_admin.login');

Route::group(['prefix' => '', 'middleware' => [
    'auth-family-admin',
    'check-trial-expired',
    'auth-family-domain',
]], function() {
    Route::get('family-admin/dashboard', [DashboardController::class, 'index'])->name('family_admin.dashboard');

    Route::get('family-admin/genealogy', [FamilyGenealogyController::class, 'genealogy'])->name('family_admin.genealogy');
    Route::get('family-admin/add-user/{from_member}', [FamilyGenealogyController::class, 'addUserView'])->name('family_admin.add_user_view');
    Route::post('family-admin/add-user', [FamilyGenealogyController::class, 'addUser'])->name('family_admin.add_user');
    Route::get('family-admin/edit-user/{id}', [FamilyGenealogyController::class, 'editUserView'])->name('family_admin.edit_user_view');
    Route::post('family-admin/edit-user', [FamilyGenealogyController::class, 'editUser'])->name('family_admin.edit_user');
    Route::get('family-admin/user/{id}', [FamilyGenealogyController::class, 'detailUser'])->name('family_admin.detail_user');
    Route::post('family-admin/delete-user/{id}', [FamilyGenealogyController::class, 'deleteUser'])->name('family_admin.delete_user');

    Route::get('family-admin/events', [EventController::class, 'getEvents'])->name('family_admin.events');
    Route::get('family-admin/create-event', [EventController::class, 'create'])->name('family_admin.create_event_view');
    Route::post('family-admin/create-event', [EventController::class, 'store'])->name('family_admin.create_event');
    Route::get('family-admin/edit-event/{id}', [EventController::class, 'edit'])->name('family_admin.edit_event_view');
    Route::post('family-admin/edit-event', [EventController::class, 'update'])->name('family_admin.edit_event');
    Route::post('family-admin/delete-event', [EventController::class, 'delete'])->name('family_admin.delete_event');

    Route::get('family-admin/blogs', [BlogController::class, 'getBlogs'])->name('family_admin.blogs');
    Route::get('family-admin/create-blog', [BlogController::class, 'create'])->name('family_admin.create_blog_view');
    Route::post('family-admin/create-blog', [BlogController::class, 'store'])->name('family_admin.create_blog');
    Route::get('family-admin/edit-blog/{id}', [BlogController::class, 'edit'])->name('family_admin.edit_blog_view');
    Route::post('family-admin/edit-blog', [BlogController::class, 'update'])->name('family_admin.edit_blog');
    Route::post('family-admin/delete-blog', [BlogController::class, 'delete'])->name('family_admin.delete_blog');

    Route::get('family-admin/funds', [FundController::class, 'getFunds'])->name('family_admin.funds');
    Route::post('family-admin/create-fund', [FundController::class, 'store'])->name('family_admin.create_fund');
    Route::post('family-admin/edit-fund', [FundController::class, 'update'])->name('family_admin.edit_fund');
    Route::post('family-admin/delete-fund', [FundController::class, 'delete'])->name('family_admin.delete_fund');
    Route::post('family-admin/fund-status', [FundController::class, 'changeStatus'])->name('family_admin.fund_status');

    Route::get('family-admin/contact-info', [ContactInfoController::class, 'index'])->name('family_admin.contact_info');
    Route::post('family-admin/contact-info-update', [ContactInfoController::class, 'updateContactInfo'])->name('family_admin.contact_info_update');
    Route::post('family-admin/family-tree-info-update', [ContactInfoController::class, 'updateFamilyTreeInfo'])->name('family_admin.family_tree_info_update');

    Route::get('family-admin/roles', [RoleController::class, 'index'])->name('family_admin.roles');
    Route::post('family-admin/add-role', [RoleController::class, 'addRole'])->name('family_admin.add_role');
    Route::post('family-admin/remove-role', [RoleController::class, 'removeRole'])->name('family_admin.remove_role');

    Route::get('family-admin/mypage', [FamilyAdminAuthController::class, 'mypageView'])->name('family_admin.my_page');
    Route::post('family-admin/update-password', [FamilyAdminAuthController::class, 'changePassword'])->name('family_admin.update_password');

    Route::post('family-admin/logout', [FamilyAdminAuthController::class, 'logout'])->name('family_admin.logout');

    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');
    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('ckfinder_browser');

    Route::get('family-admin/{user_id}/user-vr', [VRController::class, 'index'])->name('family_admin.user_vr_manager');
    Route::get('family-admin/{user_id}/user-vr/video-360', [Video360Controller::class, 'index'])->name('family_admin.index_video_360');
    Route::post('family-admin/{user_id}/user-vr/video-360/create', [Video360Controller::class, 'create'])->name('family_admin.create_video_360');
    Route::post('family-admin/user-vr/video-360/{video_id}/delete', [Video360Controller::class, 'delete'])->name('family_admin.delete_video_360');

    Route::get('family-admin/{user_id}/user-vr/vr-3d', [Vr3DController::class, 'index'])->name('family_admin.index_vr_3d');
    Route::get('family-admin/{user_id}/user-vr/vr-3d/create', [Vr3DController::class, 'createVr3D'])->name('family_admin.create_vr_3d');
    Route::post('family-admin/{user_id}/user-vr/vr-3d/store', [Vr3DController::class, 'storeVr3D'])->name('family_admin.store_vr_3d');
    Route::get('family-admin/vr-3d/{vr_3d_id}/edit', [Vr3DController::class, 'editVr3D'])->name('family_admin.edit_vr_3d');
    Route::post('family-admin/vr-3d/{vr_3d_id}/update', [Vr3DController::class, 'updateVr3D'])->name('family_admin.update_vr_3d');
    Route::post('family-admin/vr-3d/{vr_3d_id}/delete', [Vr3DController::class, 'deleteVr3D'])->name('family_admin.delete_vr_3d');
});

Route::group(['prefix' => '', 'middleware' => [
    'auth-family-member',
    'auth-audio-background',
    'check-trial-expired',
    'auth-family-domain',
]], function() {
    Route::get('family-member/about', [AboutController::class, 'index'])->name('family_member.about');
    Route::get('family-member/user/{id}/panorama', [AboutController::class, 'panoramaView'])->name('family_member.detail_user_panorama');
    Route::get('family-member/genealogy', [GenealogyController::class, 'genealogy'])->name('family_member.genealogy');
    Route::post('family-member/load-more-genealogy', [GenealogyController::class, 'loadMore'])->name('family_member.genealogy_loadmore');
    Route::get('family-member/user', [GenealogyController::class, 'detailUser'])->name('family_member.detail_user');
    Route::get('family-member/events', [MemberEventController::class, 'events'])->name('family_member.events');
    Route::get('family-member/event/{id}', [MemberEventController::class, 'eventDetail'])->name('family_member.event_detail');
    Route::get('family-member/blogs', [MemberBlogController::class, 'blogs'])->name('family_member.blogs');
    Route::get('family-member/blog/{id}', [MemberBlogController::class, 'blogDetail'])->name('family_member.blog_detail');
    Route::get('family-member/profile', [ProfileController::class, 'index'])->name('family_member.profile_index');
    Route::get('family-member/profile/mypage', [ProfileController::class, 'mypage'])->name('family_member.mypage');
    Route::post('family-member/profile/remove-cert-image', [ProfileController::class, 'removeCertImage'])->name('family_member.remove_cert_image');
    Route::post('family-member/profile/add-cert-image', [ProfileController::class, 'addCertImage'])->name('family_member.add_cert_image');
    Route::post('family-member/profile/remove-rest-image', [ProfileController::class, 'removeRestImage'])->name('family_member.remove_rest_image');
    Route::post('family-member/profile/remove-cccd-image', [ProfileController::class, 'removeCCCDImage'])->name('family_member.remove_cccd_image');
    Route::post('family-member/profile/add-rest-image', [ProfileController::class, 'addRestImage'])->name('family_member.add_rest_image');
    Route::post('family-member/profile/update', [ProfileController::class, 'userUpdateProfile'])->name('family_member.update_profile');
    Route::get('family-member/fund/register', [MemberFundController::class, 'registerView'])->name('family_member.fund_register_view');
    Route::post('family-member/fund/register', [MemberFundController::class, 'register'])->name('family_member.fund_register');
    Route::get('family-member/funds', [MemberFundController::class, 'funds'])->name('family_member.funds');
    Route::get('family-member/fund/{id}', [MemberFundController::class, 'edit'])->name('family_member.fund_detail');
    Route::post('family-member/fund/update', [MemberFundController::class, 'update'])->name('family_member.fund_update');
    Route::post('family-member/fund/remove', [MemberFundController::class, 'remove'])->name('family_member.fund_delete');
    Route::get('family-member/contact', [ContactController::class, 'contactInfo'])->name('family_member.contact_info');
    Route::get('family-member/logout', [FamilyMemberAuthController::class, 'logout'])->name('family_member.logout');
    Route::post('family-member/store-device-token', [FamilyAdminAuthController::class, 'storeDeviceToken'])->name('family_member.store_device_token');
});

Route::get('get-cccd/{image_name}', [FileController::class, 'getCCCDImage'])->name('get_cccd_image');
Route::get('get-avatar/{image_name}', [FileController::class, 'getAvatarImage'])->name('get_avatar_image');
Route::get('get-rest-image/{image_name}', [FileController::class, 'getRestImage'])->name('get_rest_image');
Route::get('get-cert-image/{image_name}', [FileController::class, 'getCertImage'])->name('get_cert_image');
Route::get('get-blog-avatar/{image_name}', [FileController::class, 'getBlogImage'])->name('get_blog_avatar_image');
Route::get('get-360-video/{video_name}', [FileController::class, 'get360video'])->name('get_360_video');
Route::get('get-vr-3d/{file_name}', [FileController::class, 'getVr3D'])->name('get_vr_3d');
Route::get('get-proof/{image_name}', [FileController::class, 'getProofImage'])->name('get_proof');

Route::get('root-admin', [RootAdminAuthController::class, 'loginView'])->name('root_admin.login_view');
Route::post('root-admin/login', [RootAdminAuthController::class, 'login'])->name('root_admin.login');
Route::group(['middleware' => 'auth-root-admin'], function() {
    Route::get('root-admin/dashboard', [RootAdminDashBoardController::class, 'index'])->name('root_admin.dashboard');
    Route::get('root-admin/user-register', [RootAdminUserController::class, 'registerView'])->name('root_admin.user_register_view');
    Route::post('root-admin/user-register', [RootAdminUserController::class, 'registerUser'])->name('root_admin.user_register');
    Route::get('root-admin/users', [RootAdminUserController::class, 'users'])->name('root_admin.users');
    Route::get('root-admin/user/{id}', [RootAdminUserController::class, 'editUser'])->name('root_admin.edit_user');
    Route::post('root-admin/user/update', [RootAdminUserController::class, 'updateUser'])->name('root_admin.update_user');
    Route::get('root-admin/mypage', [RootAdminAuthController::class, 'mypageView'])->name('root_admin.my_page');
    Route::post('root-admin/update-password', [RootAdminAuthController::class, 'changePassword'])->name('root_admin.update_password');
    Route::get('root-admin/list-user-register', [RootAdminUserController::class, 'listRegister'])->name('root_admin.list_register');
    Route::get('root-admin/{family_tree_id}/approve-trial', [RootAdminUserController::class, 'approveTrialView'])->name('root_admin.approve_trial_view');
    Route::post('root-admin/{family_tree_id}/approve-trial', [RootAdminUserController::class, 'approveTrial'])->name('root_admin.approve_trial');
    Route::post('root-admin/logout', [RootAdminAuthController::class, 'logout'])->name('root_admin.logout');
});

Route::get('reset-password', [FamilyMemberAuthController::class, 'resetPasswordRequestView'])->name('reset_password_request_view');
Route::post('reset-password', [FamilyMemberAuthController::class, 'sendResetPassword'])->name('reset_password_request');
Route::get('reset-password/{token}', [FamilyMemberAuthController::class, 'resetPasswordView'])->name('reset_password_view');
Route::post('reset-password-confirm', [FamilyMemberAuthController::class, 'confirmResetPassword'])->name('reset_password');

Route::post('common/add-month', [CommonController::class, 'addMonth'])->name('common.add_month');

Route::get('test', [FamilyMemberAuthController::class, 'test']);