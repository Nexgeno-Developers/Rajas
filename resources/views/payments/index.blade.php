@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Payments')])
@endsection
@section('css')
    <link href="{{ asset('rbtheme/css/flatpickr.min.css') }}" rel="stylesheet" id="style-default">
@endsection
@section('content')
    @include('includes.message-block')
    <div class="row p-2">
        <div class="col-sm-12 col-mobile">
            <div class="board-box">
            <div class="board-title">
                    <h2>{{ __('List of all Payments')}}</h2>
                <form method="post" id="filter-form" action="{{ route('payment-filter') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2 payments-filter">  
                        <div class="mb-3">
                            <label for="date" class="form-label"> {{ __('Appointment Start Date') }}: </label>
                            <input type="text" class="form-control custom-control date custom-format" id="startdate" min="{{date($custom->date_format)}}" autocomplete="off" 
                            value="{{ isset($data) ? $data['startdate'] : '' }}" name="startdate" data-date-format="{{ $custom->date_format }}" data-wizard-validate-date="true" placeholder="{{ __('Please Select Date') }}">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2 payments-filter">
                        <div class="mb-3">
                            <label for="date" class="form-label">{{ __('Appointment End Date') }}: </label>
                            <input type="text" class="form-control custom-control date custom-format" id="enddate" max="{{date($custom->date_format)}}" autocomplete="off" 
                            value="{{ isset($data) ? $data['enddate'] : '' }}" name="enddate" data-date-format="{{ $custom->date_format }}" data-wizard-validate-date="true" placeholder="{{ __('Please Select Date')}}">
                            <span class=" error-message" id="err-date"></span>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2 payments-filter">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">{{ __('Payment Method') }}: </label>
                            <select name="payment_method" id="payment_method" class="form-control custom-control">
                            <option value="">{{ __('Select Payment Method')}}</option>
                            <option value="stripe" {{ ( isset($data) && 'stripe' == $data['payment_method']) ? 'selected' : '' }}>{{ __('Stripe') }}</option>
                            <option value="paypal" {{ ( isset($data) && 'paypal' == $data['payment_method']) ? 'selected' : '' }}>{{ __('Paypal') }}</option>
                            <option value="razorpay" {{ ( isset($data) && 'razorpay' == $data['payment_method']) ? 'selected' : '' }} >{{ __('Razorpay')}}</option>
                            <option value="offline" {{ ( isset($data) && 'offline' == $data['payment_method']) ? 'selected' : '' }}>{{ __('COD') }}</option>
                            </select>
                        </div>
                    </div>  
                    
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2 payments-filter">
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Payment Status') }}: </label>
                            <select name="status" id="status" class="form-control custom-control">
                            <option value="">{{ __('Select Status')}}</option>
                            <option value="succeeded" {{ ( isset($data) && 'succeeded' == $data['status']) ? 'selected' : '' }}>{{ __('Succeeded')}}</option>
                            <option value="pending" {{ ( isset($data) && 'pending' == $data['status']) ? 'selected' : '' }}>{{ __('Pending')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2 payments-filter mt-1">
                        <input type="submit" class="btn btn-primary filter" name="filter" value="{{ __('Apply Filter') }}" id="filter"></button>
                        <input type="button" class="btn btn-primary filter" name="reset" value="{{ __('Reset') }}" id="reset"></button>
                    </div>
                </div>
    
                </form>
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="payment-table">
                            <thead>
                                <tr>
                                    <th>{{ __('SR No') }}.</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Appointment Date') }}</th>
                                    <th>{{ __('Payment Method') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Appointment Status')}}</th>
                                    <th>{{ __('Payment Status')}}</th>
                                    <th class="t-right">{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($payment_history as $payment)
                           
                                <tr>
                                    <th>{{ $rowIndex++ }}</th>
                                    <td>{{ ucfirst($payment->user->first_name).' '.ucfirst($payment->user->last_name) }}</td>
                                    <td>{{ date($custom->date_format, strtotime($payment->date)) }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td>{{ $custom->currency_icon}}{{ $payment->amount }} </td>
                                    
                                    <td><span class="bg-{{ (in_array($payment->status,['approved','completed'])) ? (in_array($payment->status,['completed'])) ? 'info' : 'success' : 'danger'}} badge">{{ ucfirst($payment->status) }}</span></td>
                                    @if($payment->pstatus == 'success' || $payment->pstatus == 'succeeded')
                                    <td><span class="bg-success badge">{{ __('Succeeded')}}</span></td>
                                    @endif
                                    @if($payment->pstatus == 'pending')
                                    <td><span class="bg-danger badge">{{ ucfirst($payment->pstatus) }}</span></td>
                                    @endif
                                    <td class="t-right">
                                        @if($payment->payment_method == 'offline' && $payment->pstatus == 'pending' && $payment->status == 'approved')
                                            <a class="btn btn-success" href="{{ route('pay',$payment->id) }}">{{ __('Add Payment')}}</a>
                                        @endif
                                        
                                        <a class="btn btn-default btn-lg" href="{{ route('paymentview',$payment->id) }}">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </a>
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

@endsection
