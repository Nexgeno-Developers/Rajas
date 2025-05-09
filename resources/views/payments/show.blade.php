@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Invoice')])
@endsection
@section('css')
<link rel="stylesheet" href="{{ url('backend/css/invoice.css')}}">
@endsection
@section('content')
<div class="mt p-2">
   <div class="col-md-12">
      <div class="invoice">
         <div class="invoice-company text-inverse f-w-600">
            <span class="pull-right hidden-print">
               <button class="btn btn-sm btn-white btn-print-click m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> {{ __('Print') }}</button>
            </span>
         <div class="t-center">{{ __('Payments Details') }} </div>
         </div>
         <div class="invoice-header">
            <div class="invoice-from">
               <small>{{ __('Customer Detail') }}</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse">{{ (ucfirst($payment_detail->appointments->user->first_name)).' '.(ucfirst($payment_detail->appointments->user->last_name)) }}</strong><br>
                  {{ __('Email')}}: {{ $payment_detail->appointments->user->email }}<br>
                  {{ __('Phone')}}: {{ $payment_detail->appointments->user->country_code.$payment_detail->appointments->user->phone }}<br>
               </address>
            </div>
           
            <div class="invoice-to">
               <small>{{ __('Employee Detail') }}</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse">{{ (ucfirst($payment_detail->appointments->employee->first_name)).' '.(ucfirst($payment_detail->appointments->employee->last_name)) }}</strong><br>
                  {{ __('Email') }}: {{ $payment_detail->appointments->employee->email }}<br>
                  {{ __ ('Phone') }}: {{ $payment_detail->appointments->employee->country_code.$payment_detail->appointments->employee->phone }}<br>
               </address>
            </div>
            
            <div class="invoice-date">
               <small>{{ __('Payment Date')}}</small>
               @if($payment_detail->status == 'success' || $payment_detail->status =='succeeded')
                  @if(!empty($payment_detail->payment_date))
                  <div class="date text-inverse m-t-5">{{ date('M d Y', strtotime($payment_detail->payment_date)) }}</div>
                  @else
                  <div class="date text-inverse m-t-5">{{ date('M d Y', strtotime($payment_detail->created_at)) }}</div>
                  @endif
               @else
                  <div class="date text-inverse m-t-5"> {{ __('Not Paid')}} </div>
               @endif
               <div class="invoice-detail">
               </div>
            </div>
         </div>
         <div class="invoice-content">
            <div class="table-responsive">
               <table class="table table-invoice">
                  <thead>
                     <tr>
                        <th class="text-center" width="10%">{{ __('Service')}}</th>
                        <th class="text-center" width="10%">{{ __('Start Time')}}</th>
                        <th class="text-center" width="10%">{{ __('End Time')}}</th>
                        <th class="text-center" width="10%">{{ __('Appointment Date')}}</th> 
                        <th class="text-center" width="10%">{{ __('Amount')}}</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td class="text-center">
                           <span class="text-inverse">{{ (ucfirst($payment_detail->appointments->service_id)) }}</span><br>
                        </td>
                        <td class="text-center">{{ date('H:i a',strtotime(trim($payment_detail->appointments->start_time))) }}</td>
                        <td class="text-center">{{ date('H:i a',strtotime(trim($payment_detail->appointments->finish_time))) }}</td>
                        <td class="text-center">{{ date($custom->date_format, strtotime($payment_detail->appointments->date)) }}</td>
                        <td class="text-center">{{ $custom->currency_icon}}{{ $payment_detail->amount }}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="invoice-price">
               <div class="invoice-price-left">
               </div>
               <div class="invoice-price-right">
                  <div class="invoice-subtotal">
                  {{ __('Subtotal') }}: {{$custom->currency_icon}}{{ $payment_detail->amount }}<br>
                  </div>
               </div>
            </div>
            <div class="invoice-price">
               <div class="invoice-price-left">
                  <div class="invoice-price-row">
                    
                  </div>
                
               </div> 
              
               <div class="invoice-price-right">
               {{ __('Total') }}: {{$custom->currency_icon}}{{ $payment_detail->amount }}<br>
                 
               </div>
            </div>
         </div>
         <div class="invoice-note">
            <label>{{ __('Comments') }}</label><br>
            *  <span class="text-center">{{ $payment_detail->appointments->comments }}</span> <br>
          
         </div>
         @if(Auth::user()->role_id == 1)
            <a href="{{ route('paymentlist') }}" class="back-button"><h4 class="invoice-back"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
         @endif
         @if(Auth::user()->role_id == 3)
            <a href="{{ route('employee-paymentlist') }}" class="back-button"><h4 class="invoice-back"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
         @endif
      </div>
   </div>
</div>
@endsection
