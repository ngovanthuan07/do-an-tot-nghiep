<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-body text-center"> <img src="{{\Illuminate\Support\Facades\Auth::guard('customer')->user()->image}}" height="100" width="100">
                <div class="comment-box text-center">
                    <h4>{{\Illuminate\Support\Facades\Auth::guard('customer')->user()->fullname}}</h4>
                    <div class="rating">
                        <input type="radio" name="rating" value="5" id="5">
                        <label for="5">☆</label>
                        <input type="radio" name="rating" value="4" id="4">
                        <label for="4">☆</label>
                        <input type="radio" name="rating" value="3" id="3">
                        <label for="3">☆</label>
                        <input type="radio" name="rating" value="2" id="2">
                        <label for="2">☆</label>
                        <input type="radio" name="rating" value="1" id="1">
                        <label for="1">☆</label>
                    </div>
                    <div class="comment-area">
                        <textarea id="commentText" name="commentText" class="form-control" placeholder="Viết bình luận..." rows="4"></textarea>
                    </div>

                    <div id="btnComment" class="text-center mt-4"> <button class="btn btn-success send px-5">Gửi bình luận</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push("styles")
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200&display=swap');
        .cross {
            padding: 10px;
            color: #ffcc33;
            cursor: pointer;
            font-size: 23px;
        }

        .cross i{

            margin-top: -5px;
            cursor: pointer;
        }







        .comment-box {
            padding: 5px
        }

        .comment-area textarea {
            resize: none;
            border: 1px solid #ffcc33
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #ffffff;
            outline: 0;
            box-shadow: 0 0 0 1px #ffcc33 !important
        }

        .send {
            color: #fff;
            background-color: #ffcc33;
            border-color: #ffcc33
        }

        .send:hover {
            color: #fff;
            background-color: #ffcc33;
            border-color: #ffcc33
        }

        .rating {
            display: inline-flex;
            margin-top: -10px;
            flex-direction: row-reverse;


        }

        .rating>input {
            display: none
        }

        .rating>label {
            position: relative;
            width: 28px;
            font-size: 35px;
            color: #ffcc33;
            cursor: pointer;
        }

        .rating>label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .rating>label:hover:before,
        .rating>label:hover~label:before {
            opacity: 1 !important
        }

        .rating>input:checked~label:before {
            opacity: 1
        }

        .rating:hover>input:checked~label:before {
            opacity: 0.4
        }
    </style>
@endpush

@push("scripts")
    <script>
        $('#btnComment').on('click', function (event) {
            event.preventDefault();
            let ratingValue = $('input[name=rating]:checked').val();
            let commentText = $('#commentText').val();
{{--            @if(!\App\Util\CheckCommentUtil::checkCommentUtil($salon->salon_id))--}}
{{--                Swal.fire({--}}
{{--                    icon: "error",--}}
{{--                    title: "Xin vui lòng đặt lịch và hoàn thành dịch vụ trước khi đánh giá",--}}
{{--                    text: "Đã bị lỗi!",--}}
{{--                    confirmButtonColor: "#3085d6",--}}
{{--                    confirmButtonText: "Đóng",--}}
{{--                    allowOutsideClick: false,--}}
{{--                })--}}
{{--                return;--}}
{{--            @endif--}}
            if(!(ratingValue && commentText)) {
                Swal.fire({
                    icon: "error",
                    title: "Bình luận bị thiếu",
                    text: "Đã bị lỗi vui lòng đăng nhập lại!",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Đóng",
                    allowOutsideClick: false,
                })
                return;
            }
            $.ajax({
                url: '/salon-comment/add',
                type:'POST',
                data: {
                    salon_id: $('#salon_id').val(),
                    star: ratingValue,
                    content: commentText
                },
                success: function (resp) {
                    Swal.fire({
                        icon: "success",
                        title: "Thành Công",
                        text: "Thêm Bình Luận Thành Công!",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Đóng",
                        allowOutsideClick: false,
                    })
                    window.location.reload();
                },
                error: function (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi Bình Luận",
                        text: "Đã bị lỗi!",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Đóng",
                        allowOutsideClick: false,
                    })
                }
            })
        })
    </script>
@endpush
