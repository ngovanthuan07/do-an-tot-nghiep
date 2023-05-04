<div class="loading-indicator">
    <div
        style="
          display: flex;
          justify-content: center;
          align-items: center;
          background-color: white;
          position: fixed;
          top: 0px;
          left: 0px;
          z-index: 9999;
          width: 100%;
          height: 100%;
          opacity: 1;
        "
    >
        <div style="color: rgb(255, 200, 35)" class="la-ball-clip-rotate la-2x">
            <div></div>
        </div>
    </div>
</div>
@push('pushLink')
    <link rel="stylesheet" href="{{asset('css/load/loading.css')}}">
@endpush
@push('scripts')
    <script>
        // $('.loading-indicator').show();
        $(window).on('load', function() {
            setTimeout(() => {
                $('.loading-indicator').hide();
            }, 500)
        });
    </script>
@endpush
