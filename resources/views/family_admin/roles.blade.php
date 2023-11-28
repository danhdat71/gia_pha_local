@extends('family_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Vai trò',
        ])
        <style>
            @media screen and (max-width: 576px) {
                .col-member-count {
                    display: none;
                }

                .col-event-id {
                    display: none;
                }

                .col-event-date {
                    display: none;
                }
            }

            .wrap-avatar-img {
                width: 100px;
                height: 100px;
                overflow: hidden;
            }

            .wrap-avatar-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .table td {
                vertical-align: middle;
            }

            .select2-container .select2-selection--single {
                height: 38px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
            }

            .tableFixHead {
                overflow: auto;
                height: 400px;
                margin-top: 20px;
            }

            .tableFixHead thead th {
                position: sticky;
                top: 0;
                z-index: 1;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                padding: 8px 16px;
                border: 1px solid rgba(0, 0, 0, 0.112);
            }

            th {
                background: #eee;
            }

            .w-70 {
                width: 70%;
            }

            .w-30 {
                width: 30%;
            }
        </style>
        <section class="content">
            <div class="container-fluid">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <label for="">Trưởng gia đình</label>
                                <div class="row">
                                    <div class="col-md-7 col-lg-8">
                                        <select name="" id="" class="select-2 w-100">
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 col-lg-4">
                                        <button
                                            data-user_type="{{App\Constants\UserType::FAMILY_ADMIN}}"
                                            class="btn button-color-template w-100 add"
                                            @if(count($users) < 1)
                                            disabled
                                            @endif
                                        >+ Thêm</button>
                                    </div>
                                </div>
                                <div class="tableFixHead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="w-70">Họ tên</th>
                                                <th class="w-30">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($familyAdmins) < 1)
                                            <tr><td colspan="2">Chưa có</td></tr>
                                            @endif
                                            @foreach ($familyAdmins as $familyAdmin)
                                            <tr>
                                                <td>{{$familyAdmin->full_name}}</td>
                                                <td>
                                                    @if (sizeof($familyAdmins) > 1)
                                                    <button
                                                        data-full_name="{{$familyAdmin->full_name}}"
                                                        data-type="{{$familyAdmin->type}}"
                                                        data-id="{{$familyAdmin->id}}"
                                                        class="btn btn-sm btn-danger remove"
                                                    >Gỡ vai trò</button>
                                                    @else
                                                    <button
                                                        disabled
                                                        class="btn btn-sm btn-secondary"
                                                    >Gỡ vai trò</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <label for="">Phó gia đình</label>
                                <div class="row">
                                    <div class="col-md-7 col-lg-8">
                                        <select name="" id="" class="select-2 w-100">
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 col-lg-4">
                                        <button
                                            data-user_type="{{App\Constants\UserType::FAMILY_SUB_ADMIN}}"
                                            class="btn button-color-template w-100 add"
                                            @if(count($users) < 1)
                                            disabled
                                            @endif
                                        >+ Thêm</button>
                                    </div>
                                </div>
                                <div class="tableFixHead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="w-70">Họ tên</th>
                                                <th class="w-30">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($subFamilyAdmins) < 1)
                                            <tr><td colspan="2">Chưa có</td></tr>
                                            @endif
                                            @foreach ($subFamilyAdmins as $subFamilyAdmin)
                                            <tr>
                                                <td>{{$subFamilyAdmin->full_name}}</td>
                                                <td>
                                                    <button
                                                        data-full_name="{{$subFamilyAdmin->full_name}}"
                                                        data-type="{{$subFamilyAdmin->type}}"
                                                        data-id="{{$subFamilyAdmin->id}}"
                                                        class="btn btn-sm btn-danger remove"
                                                    >Gỡ vai trò</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <label for="">Thư ký</label>
                                <div class="row">
                                    <div class="col-md-7 col-lg-8">
                                        <select name="" id="" class="select-2 w-100">
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 col-lg-4">
                                        <button
                                            data-user_type="{{App\Constants\UserType::SECRETARY}}"
                                            class="btn button-color-template w-100 add"
                                            @if(count($users) < 1)
                                            disabled
                                            @endif
                                        >+ Thêm</button>
                                    </div>
                                </div>
                                <div class="tableFixHead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="w-70">Họ tên</th>
                                                <th class="w-30">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($secretaryAdmins) < 1)
                                            <tr><td colspan="2">Chưa có</td></tr>
                                            @endif
                                            @foreach ($secretaryAdmins as $secretaryAdmin)
                                            <tr>
                                                <td>{{$secretaryAdmin->full_name}}</td>
                                                <td>
                                                    <button
                                                        data-full_name="{{$secretaryAdmin->full_name}}"
                                                        data-type="{{$secretaryAdmin->type}}"
                                                        data-id="{{$secretaryAdmin->id}}"
                                                        class="btn btn-sm btn-danger remove"
                                                    >Gỡ vai trò</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- Modal add user type --}}
    <div class="modal fade" id="add-user-type-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <button class="btn btn-sm btn-secondary w-100" data-dismiss="modal">Không</button>
                        </div>
                        <div class="col-6 text-center">
                            <form action="{{route('family_admin.add_role')}}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" id="user-id">
                                <input type="hidden" name="type" id="type">
                                <button class="btn btn-sm button-color-template w-100">Đồng ý</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal remove user type --}}
    <div class="modal fade" id="remove-user-type-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <button class="btn btn-sm btn-secondary w-100" data-dismiss="modal">Không</button>
                        </div>
                        <div class="col-6 text-center">
                            <form action="{{route('family_admin.remove_role')}}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" id="user-id-remove">
                                <button class="btn btn-sm button-color-template w-100">Đồng ý</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.add').click(function(){
            let userType = $(this).attr('data-user_type');
            let userId = $(this).closest('.row').find('.select-2').val();
            let userFullName = $(this).closest('.row').find('.select-2').find(':selected').text();
            let roleName = '';
            $('#user-id').val(userId);
            $('#type').val(userType);
            switch (userType) {
                case '{{App\Constants\UserType::FAMILY_ADMIN}}':
                    roleName = 'Trưởng Gia Đình';
                    break;
                case '{{App\Constants\UserType::FAMILY_SUB_ADMIN}}':
                    roleName = 'Phó Gia Đình';
                    break;
                case '{{App\Constants\UserType::SECRETARY}}':
                    roleName = 'Thư Ký';
                    break;
            }
            let ask = `Bạn có chắc muốn thêm ${userFullName} làm ${roleName}`;
            $('#add-user-type-modal').find('.modal-title').text(ask);
            $('#add-user-type-modal').modal('show');
        });

        $('.remove').click(function(){
            let userType = $(this).attr('data-type');
            let userId = $(this).attr('data-id');
            let userFullName = $(this).attr('data-full_name');
            let roleName = '';
            $('#user-id-remove').val(userId);
            switch (userType) {
                case '{{App\Constants\UserType::FAMILY_ADMIN}}':
                    roleName = 'Trưởng Gia Đình';
                    break;
                case '{{App\Constants\UserType::FAMILY_SUB_ADMIN}}':
                    roleName = 'Phó Gia Đình';
                    break;
                case '{{App\Constants\UserType::SECRETARY}}':
                    roleName = 'Thư Ký';
                    break;
            }
            let ask = `Bạn có chắc muốn gỡ ${userFullName} khỏi ${roleName}`;
            $('#remove-user-type-modal').find('.modal-title').text(ask);
            $('#remove-user-type-modal').modal('show');
        });
    </script>
@endsection
