@extends('layouts.home',['title' => trans('Home'), 'pagename' => trans('landing')])

@section('content')
<section class="zluck-container" id="banner">
    <div class="container justify-content-center mt-5" data-layout="container">
        <div class="row min-vh-70 py-6 text-center justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-10 col-xxl-6">
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <div>
                            <i class="fa fa-check check-round" aria-hidden="true"></i>
                        </div>
                        <div class="fw-black lh-1 text-800 fs-error thank-size mt-3">{{ __('Thank you!') }}</div>
                        @if(Session::has('success'))
                        <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold">{{Session::get('success')}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection