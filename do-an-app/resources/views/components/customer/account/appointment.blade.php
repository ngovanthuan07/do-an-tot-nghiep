@extends('layouts.customer')
@section('title', 'Cuộc hẹn')
@push('pushLink')
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/load/a-ball-pulse-sync.css')}}">
    <link rel="stylesheet" href="{{asset('css/customer/salon-detail/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/customer/salon-detail/styles-resp.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/time-picker/custom-theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/customer/appointment/styles.css')}}">
@endpush
@section('content')
    <x-loading-indicator/>
    <header class="searchHeader mb-3"></header>

    <div class="wrapper container mb-3">
        <div class="row">
            <div class="col-3 ">
                @include('components.customer.account.menu')
            </div>
            <div id="content" class="col-9 content card">
               @include('components.customer.account.content-appointment')
            </div>
        </div>
    </div>
    @include('widgets.modal.create-service-choose-modal')
@endsection
@push('styles')
    <style>
        #content .form-group {
            margin-bottom: 1rem;
        }

        #content .form-check-label {
            margin-left: 0.5rem;
        }

        #content .btn {
            margin-top: 1rem;
        }

        #btnUpdate{
            background-color:#FFCC33 !important;
            border: none;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{asset('lib/OwlCarousel2-2.3.4/dist/owl.carousel.min.js')}}"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/carousel.js')}}"></script>
    <script type="module" src="{{asset('js/customer/salon-detail/handleLoadHTML.js')}}"></script>
    <script type="module">
        import {getByProvince, getByDistrict} from '/js/common/vn-public-api.js'
        import {logFormData, serializeFormToFormData} from '/js/helper/form-helper.js'
        import {modalDispatch, handleConfirmModal} from '/js/helper/modal-helper.js'

        let formData;

        $("#btnUpdate").on("click", function(event) {
            event.preventDefault();
            formData = serializeFormToFormData('myForm')
            logFormData(formData);

            $.ajax({
                type: "POST",
                url: "{{route('customer.profile.update')}}",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('input').removeClass('is-invalid')
                    $('.message-error').text('')
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Cập nhật thành công',
                            'Click vào đây để đóng lại!',
                            'success'
                        )
                    }
                },
                error: function (error) {
                    console.log(error)
                    let arrayErrors = [];
                    $.each(error.responseJSON.errors, function (prefix, val) {
                        if(prefix == 'gender') {
                            $('#gender-message').text(val);
                        } else {
                            $('#' + prefix).closest('.form-group').find('.message-error').text(val);
                        }
                        arrayErrors.push(prefix);
                    })
                    $('#' + arrayErrors[0]).focus();
                }
            });
        })
    </script>
@endpush
