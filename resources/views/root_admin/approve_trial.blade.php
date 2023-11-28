@extends('root_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Xác nhận chính thức',
        ])
        <section class="content">
            <div class="card">
                <div class="card-header">Xác nhận chính thức</div>
                <div class="card-body">
                    @if ($family_tree->is_approve_trial == App\Constants\Trial::APPROVED)
                    <div class="pb-2 alert alert-info">
                        <div>Gia phả này đã được approve.</div>
                    </div>
                    @else
                    <div class="pb-2 alert alert-warning">
                        <div>Xác nhận gia phả chính thức được sử dụng không giới hạn.</div>
                        <div>Sau khi xác nhận chính thức, chế độ dùng thử sẽ được dở bỏ.</div>
                    </div>
                    @endif
                    
                    <button
                        class="btn btn-info btn-lg"
                        data-toggle="modal"
                        data-target="#approve_trial_modal"
                        @if ($family_tree->is_approve_trial == App\Constants\Trial::APPROVED)
                        disabled
                        @endif
                    >Xác nhận chính thức</button>
                    <hr>
                    <a href="{{route('root_admin.users')}}" class="btn btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
                </div>
            </div>
        </section>
        <div class="modal fade" id="approve_trial_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn dở bỏ dùng thử ?</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Không</button>
                            </div>
                            <div class="col-6">
                                <form action="{{route('root_admin.approve_trial', $family_tree->id)}}" method="post">
                                    @csrf
                                    <button class="btn btn-info w-100">Có</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
    </div>
@endsection
