
@if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
    @include("widgets.modal.comment-modal")
@endif
<div class="container card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="comment-container mb-2">
                <h4 class="card-title">Bình luận</h4>
                <div class="totalStar">
{{--                    <h1 class="text-warning">{{number_format($stars, 1)}}</h1>--}}
                    <div class="total-star-salon-container">
                        <div class="total-star-icons-salon" style="width:{{($stars/5) * 100}}%!important;">
                            <div class="total-star-box-salon">
                                <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #ffd43b; font-size: 25px;"></i>
                            </div>
                        </div>
                        <div class="total-star-icons-salon-overflow">
                            <div class="total-star-box-salon">
                                <i class="fa-solid fa-star" style="color: #d1d1d1; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #dbdbdb; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #cccccc; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #e0e0e0; font-size: 25px;"></i>
                                <i class="fa-solid fa-star" style="color: #dddddd; font-size: 25px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btnShowModalComment">
                <button type="button" class="btn btn-warning text-white " data-toggle="modal" data-target="#commentModal"><i class="fa-solid fa-pen"></i> Viết đánh giá </button>
            </div>
        </div>
        <div class="comment-widgets m-b-20">
           @forelse($comments as $comment)
                <div class="d-flex flex-row comment-row">
                    <div class="p-2"><span class="round"><img src="{{$comment['customer']->image}}" alt="user" width="50"></span></div>
                    <div class="comment-text w-100">
                        <h5>{{$comment['customer']->fullname}}</h5>
                        <div class="comment-footer">
                            <span class="date">{{\App\Helpers\HandleDateTimePickerHelper::formatDD_MM_YY_Display($comment->date)}}</span>
                            @for($i = 0; $i < $comment->star; $i++)
                                <i class="fa-solid fa-star" style="color: #ffd43b;"></i>
                            @endfor
                        </div>
                        <p class="m-b-5 m-t-10">
                            {{$comment->content}}
                        </p>
                    </div>
                </div>
            @empty
                <div class="d-flex flex-row comment-row justify-content-center">
                    ☹ Không có bình luận nào gần đây
                </div>
            @endforelse
        </div>
    </div>

</div>

@push("styles")
    <style>
        .total-star-salon-container {
            width: 157px;
            height: 50px;
            position: relative;
        }

        .total-star-icons-salon {
            background: #fff;
            width: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        .total-star-box-salon {
            width: 200px;
        }


        .total-star-icons-salon-overflow {
            position: absolute;
            top: 0;
        }

        .total-star-box-salon {
            width: 200px;
        }
    </style>
@endpush
