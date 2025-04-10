<!DOCTYPE html>
<html lang="en" class="fullscreen">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="{{ __('Appointment') }}, {{ __('Booking') }}, System, {{ __('Service') }}, {{ __('Categorie') }}, {{ __('Client') }}, {{ __('Customer') }}, {{ __('Employee') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<head>
    @routes()
    @yield('head')
    @yield('css')
</head>
<body class="page dashboard-page fullscreen relative">
<div class="loader">
    <div class="spinner">
        <div class="spinner-area spinner-forth"></div>
    </div>
</div>
<main class="dashboard-content relative">
@include('includes.sidebar-and-header')
@yield('content')
</main>
<script src="{{ asset('backend/js/popper.min.js')}}"></script>
<script src="{{ asset('backend/js/jquery.min.js')}}"></script>
<script src="{{ asset('backend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/main.js') }}"></script>
<script src="{{ asset('backend/js/sweetalert2.all.min.js')}}"></script>
<script src="{{ asset('rbtheme/js/lang/'.app()->getLocale().'.js') }}"></script>
<script src="{{ asset('backend/js/index.js') }}"></script>
<script src="{{ asset('rbtheme/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('backend/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('rbtheme/js/flatpickr.js') }}"></script>
<script src="{{ asset('rbtheme/js/bootstrap-toggle.min.js') }} "></script>
<script src="{{ asset('backend/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('backend/js/intlTelInput-jquery.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script src="{{ asset('rbtheme/js/nexgeno.js') }}"></script>
<script type="text/javascript">
    "use strict";
    var _token = "{{ csrf_token() }}";
    let SITEURL = "{{ route('welcome') }}";
    $(document).ready(function(){
        $("input, select").on("keyup, chnage", function(){
            $(".error").remove();
        });
    });
</script>
<script src="{{ asset('backend/js/custom.js')}}" type="text/javascript"></script>
@yield('scripts')
<script class="iti-load-utils" async src="{{ asset('backend/js/utils.js') }}"></script>
</body>
</html>

<!-- Modal -->
<div class="modal fade demo-popup" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLabel">Alert!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="text-danger fw-bold">You are not allowed to update this info. for the demo version. It'll be accessible on the production version.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>