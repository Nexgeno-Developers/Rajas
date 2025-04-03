@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Employee Payments')])
@endsection
<!-- monitor -->
@section('content')
@include('includes.message-block')
<div class="row p-2">
    <div class="col-sm-12 col-mobile">
            <a href="{{ \Illuminate\Support\Facades\URL::previous() }}"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
            <div class="board-box">
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="employee-payment-table">
                            <thead>
                                <tr>
                                    <th>{{ __('SR No.') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Appointment Date') }}</th>
                                    <th>{{ __('Payment Method') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="t-right">{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            @php $index = 0; @endphp
                            <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                    <th>{{++$index}}</th>
                                    <td>{{ ucfirst($appointment->user->first_name).' '.ucfirst($appointment->user->last_name) }}</td>
                                    <td>{{ date($custom->date_format, strtotime($appointment->date)) }}</td>
                                    @empty(!$appointment->payment)
                                        <td>{{ ucfirst($appointment->payment->payment_method) }}</td>
                                    @else
                                        <td>{{ __('Offline')}}</td>
                                    @endempty
                                    <td>{{$custom->currency_icon}}{{$appointment->amount}}</td>
                                    @empty(!$appointment->payment)
                                        @if($appointment->pstatus == 'success' || $appointment->pstatus == 'succeeded')
                                            <td><span class="bg-success badge">{{ ucfirst($appointment->pstatus) }}</span></td>
                                        @endif
                                        @if($appointment->pstatus == 'pending')
                                            <td><span class="bg-danger badge">{{ ucfirst($appointment->pstatus) }}</span></td>
                                        @endif
                                    @else
                                        <td>-</td>
                                    @endempty
                                    <td class="t-right">
                                    @empty(!$appointment->payment)
                                        @if($appointment->payment->payment_method == 'offline' && $appointment->pstatus == 'pending' && $appointment->status == 'approved')
                                            <a class="btn btn-success" href="{{ route('pay',$appointment->payment_id) }}">{{ __('Add Payment')}}</a>
                                        @endif
                                    @endempty
                                        <a class="btn btn-default btn-lg" href="{{ route('paymentview',$appointment->id) }}">
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