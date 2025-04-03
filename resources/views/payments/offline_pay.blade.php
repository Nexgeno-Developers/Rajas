@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Make Payment')])
@endsection
@section('content')
<div class="mb-3 p-2">
    <div class="light-style flex-grow-1">
        @include('includes.message-block')
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden p-5">
                <h4 class="font-weight-bold">{{ __('Payment')}}</h4>
                    <div class="row no-gutters row-bordered row-border-light">
                      
                            <div class="col-md-3 p-1">
                                <hr class="border-light m-0">
                                <ul class="nav nav-tabs list-group list-group-flush account-settings-links hover-pointer" role="tablist">
                                    <li class="nav-item  list-group-item-action">
                                        <a class="nav-link list-group-item @if(session('frm') == 'detail') active @elseif(!in_array(session('frm'),['detail','upi','cash'])) active @endif" data-bs-toggle="tab" data-bs-target="#account-cheque" aria-current="page">{{ __('Cheque Details') }}</a>
                                    </li>
                                    <li class="nav-item list-group-item-action" id="change-upi" >
                                        <a class="nav-link list-group-item @if(session('frm') == 'upi') active @endif" data-bs-toggle="tab" data-bs-target="#account-upi">{{ __('UPI') }}</a>
                                    </li>
                                    <li class="nav-item list-group-item-action" id="change-cash">
                                        <a class="nav-link list-group-item @if(session('frm') == 'cash') active @endif" data-bs-toggle="tab" data-bs-target="#account-cash">{{ __('Cash') }}</a>
                                    </li>
                                </ul>
                            </div>
    
                            <div class="col-md-8">
                                <div class="tab-content">
                                    <div class="tab-pane fade  @if(session('frm') == 'detail') show active @elseif(!in_array(session('frm'),['detail','upi','cash'])) show active @endif" id="account-cheque">
                                        
                                        <form method="POST" action="{{ route('pay',$payment->id.'?frm=detail') }}" id="account-info" autocomplete="off">
                                            @csrf
                                            <hr class="border-light m-0">
                                            <div class="card-body p-0">
                                                <h2 class="font-weight-bold mt-0">
                                                {{ __('Account Info') }}
                                                </h2>
                                                <input type="hidden" name="payment_type" value="cheque">
    
                                                <div class="mb-3"> 
                                                    <label for="account_no" class="form-label">{{ __('Bank Account No') }}:</label>
                                                    <input type="text" class="form-control" name="account_no"  value="" id="account" placeholder="{{ __('Enter Bank Account No') }}" autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cheque" class="form-label">{{ __('Cheque No') }}:</label>
                                                    <input type="text" class="form-control" name="cheque_no"  value="" id="cheque" placeholder="{{ __('Enter Cheque No') }}" autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="account_no" class="form-label">{{ __('Account Holder Name')}}:</label>
                                                    <input type="text" class="form-control" name="account_holder_name"  value="" id="account_holder_name" placeholder="{{ __('Enter Account Holder Name') }}" autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bank_name" class="form-label">{{ __('Bank Name') }}:</label>
                                                    <input type="text" class="form-control" name="bank_name"  value="" id="bank" placeholder="{{ __('Enter Bank Name') }}" autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ifsc" class="form-label">{{ __('IFSC Code') }}:</label>
                                                    <input type="text" class="form-control" name="ifsc_code"  value="" id="ifsc" placeholder="{{ __('Enter IFSC Code') }}" autocomplete="off">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">{{ __('Date') }}:</label>
                                                    <input type="text" class="form-control custom-control custom-format flicker bg-transparent" name="payment_date"  value="{{ $payment->date }}" autocomplete="off" 
                                                    data-wizard-validate-date="true"  data-date-format="{{ $custom->date_format }}" placeholder="{{ __('Please Select Date')}}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">{{ __('Amount') }}:</label>
                                                    <div class='input-group'>
                                                        <span class="input-group-text">
                                                            {{ $custom->currency_icon }}
                                                        </span>
                                                
                                                    <input type="text" class="form-control bg-transparent" name="amount"  value="{{ $payment->amount }}" id="amount" placeholder="{{ __('Enter Amount') }}"  autocomplete="off" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right save">
                                                    <button type="submit" class="btn btn-primary">{{ __('Paid Account')}} </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
    
                                    <div class="tab-pane fade @if(session('frm') == 'upi') show active @endif" id="account-upi">
                                        <form method="POST" action="{{ route('pay',$payment->id.'?frm=upi') }}" id="upi-frm" autocomplete="off">
                                            @csrf
                                            <div class="card-body p-0 mt-0">
                                                <h2 class="font-weight-bold mt-0">
                                                {{ __('UPI Details') }}
                                                </h2>
                                                <hr class="border-light m-0">
                                                <input type="hidden" name="payment_type" value="upi">
                                                <div class="mb-3">
                                                    <label for="upi" class="form-label">{{ __('UPI ID') }}:</label>
                                                    <input type="text" class="form-control" value="{{ $payment->upi_id }}" name="upi_id" placeholder="{{ __('Enter UPI ID')}}"  autocomplete="off"> 
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">{{ __('Date') }}:</label>
                                                    <input type="text" class="form-control custom-control custom-format flicker bg-transparent" name="payment_date"  value="{{ $payment->date }}" autocomplete="off" 
                                                    data-wizard-validate-date="true"  data-date-format="{{ $custom->date_format }}" placeholder="{{ __('Please Select Date')}}" >
                                                </div>
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">{{ __('Amount') }}:</label>
                                                    <div class='input-group'>
                                                        <span class="input-group-text">
                                                            {{ $custom->currency_icon }}
                                                        </span>
                                                    <input type="text" class="form-control bg-transparent" name="amount"  value="{{ $payment->amount }}" id="amount" placeholder="{{ __('Enter Amount')}}" autocomplete="off" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right mt-5 mb-5">
                                                    <button type="submit" class="btn btn-primary">{{ __('Paid Amount')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade  @if(session('frm') == 'cash') show active @endif" id="account-cash">
                                        <form method="POST" action="{{ route('pay',$payment->id.'?frm=cash') }}" id="cash-frm" autocomplete="off">
                                            @csrf
                                            <div class="card-body pb-2 mt-0 p-0">
                                                <h2 class="font-weight-bold mt-0">
                                               {{ __(' Cash Details') }}
                                                </h2>
                                                <hr class="border-light m-0">
                                                <input type="hidden" name="payment_type" value="cash">
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">{{ __('Date') }}:</label>
                                                    <input type="text" class="form-control custom-control flicker bg-transparent custom-format border-right-0 border-left-0" name="payment_date"  value="{{ $payment->date }}" autocomplete="off" 
                                                    data-wizard-validate-date="true"  data-date-format="{{ $custom->date_format }}" placeholder="{{ __('Please Select Date') }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">{{ __('Amount') }}:</label>
                                                    <div class='input-group'>
                                                        <span class="input-group-text">
                                                            {{ $custom->currency_icon }}
                                                        </span>
                                                    <input type="text" class="form-control bg-transparent" name="amount"  value="{{ $payment->amount }}" id="amount" placeholder="{{ __('Enter Amount') }}" autocomplete="off" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right mt-5 mb-5">
                                                    <button type="submit" class="btn btn-primary">{{ __('Paid Amount')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="text-right mt-5 mb-5">
                                    @if(Auth::user()->role_id == 1)
                                    <a href="{{ route('paymentlist') }}"><span class="back"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back')}}</h4></span></a>
                                    @endif
                                    @if(Auth::user()->role_id == 3)
                                    <a href="{{ route('employee-paymentlist') }}"><span class="back"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back')}}</h4></span></a>
                                    @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

