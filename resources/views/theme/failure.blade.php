@extends('layouts.home',['title' => trans('Home'), 'pagename' => trans('landing')])

@section('content')
<style>
.check-round {
    font-size: 100px;
    color: #dc3545;
    border: none;
    border-radius: 50%;
    padding: 10px;
}
</style>
<section class="zluck-container" id="banner">
    <div class="container justify-content-center mt-5" data-layout="container">
        <div class="row min-vh-70 py-6 text-center justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-10 col-xxl-6">
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <div>
                            <i class="fa fa-times check-round" aria-hidden="true"></i>
                        </div>
                        <h1 class="fw-black lh-1 text-800 fs-error1 thank-size1 mt-3 text-danger">{{ __('Booking Failed!') }}</h1>
                        @if(Session::has('error'))
                            <p class="mt-1 text-800 font-sans-serif fw-semi-bold">Thank you for your attempt. Your payment is currently being verified. If the transaction was successful, your booking will be confirmed shortly. Please check your email or contact our support if you don’t see an update within a few minutes.</p>
                            <p class="mt-0 mb-0"><b>Transaction ID:</b> {{ $request->txnid }}</p>
                            <p class="mt-0 mb-0"><b>Payment Status:</b> {{ $request->status }}</p>
                            <p class="mt-0 mb-0"><b>Failure Reason:</b> {{ $request->error_Message }}</p>                            
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection