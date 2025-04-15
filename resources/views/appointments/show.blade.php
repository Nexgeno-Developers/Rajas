@extends('layouts.app')
@section('head')
@include('includes.head',['title'=> trans('View Appointment')])
@endsection
@section('css')
<link href="{{ asset('rbtheme/css/loader.css') }}" rel="stylesheet" id="style-default">
@endsection
@section('content')

<section class="py-0 overflow-hidden light page-padding" id="banner">
    <div class="bg-holder overlay">
    </div>
    <form action="{{route('approval',$appointment->id)}}" method="POST" autocomplete="off">
        {{ csrf_field() }}
        <div class="appointment-detail-design">
            <div class="card mb-2">
                <div class="bg-holder d-none d-lg-block bg-card opacity-7"></div>
                {{--/.bg-holder--}}
                <div class="card-body position-relative">
                    <h2>{{ __('Appointment Details') }}</h2>
                    <p class="fs--1">{{ date($custom->date_format,strtotime($appointment->date)) }}</p>
                    <div><strong class="me-2">{{ __('Status') }}: </strong>
                        @if($appointment->status == 'cancel')
                        <div class="badge bg-danger fs--2"><span class="fa fa-close ms-1"
                                data-fa-transform="shrink-2"></span> {{ ucfirst($appointment->status) }}</div>
                        @endif
                        @if($appointment->status == 'pending')
                        <div class="badge bg-warning fs--2"><span class="fa fa-check ms-1"
                                data-fa-transform="shrink-2"></span> {{ ucfirst($appointment->status) }}</div>
                        @endif
                        @if($appointment->status == 'approved')
                        <div class="badge bg-success fs--2"><span class="fa fa-check ms-1"
                                data-fa-transform="shrink-2"></span> {{ ucfirst($appointment->status) }}</div>
                        @endif
                        @if($appointment->status == 'completed')
                        <div class="badge bg-info fs--2"><span class="fa fa-check ms-1"
                                data-fa-transform="shrink-2"></span> {{ ucfirst($appointment->status) }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                            <h4 class="mb-3 fs-0">{{ __('Customer') }} Details</h4>
                            <div class="mb-2">
                                {{ !empty($appointment->user) ? ucfirst($appointment->user->first_name).' '.ucfirst($appointment->user->last_name) : 'User Not Available' }}
                            </div>
                            <div class="mb-0 fs--1">
                                <strong>{{ __('Email') }}:</strong> <span
                                    class="">{{ $appointment->user->email }}</span>
                            </div>
                            <div class="mb-0 fs--1">
                                <strong>{{ __('Phone') }}: </strong> <span
                                    class="">{{ $appointment->user->country_code.$appointment->user->phone }}</span>
                            </div>
                        </div>

                        @if($custom->employees == 1)
                            @if(Auth::user()->role_id == 1)
                            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                                <h4 class="mb-3 fs-0">{{ __('Employee') }} Details</h4>
                                <div class="mb-2">
                                    {{ !empty($appointment->employee) ? ucfirst($appointment->employee->first_name).' '.ucfirst($appointment->employee->last_name) : 'Employee Not Available' }}
                                </div>
                            </div>
                            @endif
                        @endif
                        
                        <div class="col-md-6 col-lg-4">
                            <h4 class="mb-3 fs-0">{{ __('Payment Information') }}</h4>
                            <div class="flex-1">
                            <div class="mb-0">
                                <p class="mb-0 fs--1"><strong>{{ __('Method') }}: </strong> {{ isset($appointment->payment) ? ucfirst($appointment->payment->payment_method) : '-' }}</p>
                                <p class="mb-0 fs--1"><strong>{{ __('Payment ID') }}: </strong> {{ isset($appointment->payment) ? ucfirst($appointment->payment->payment_id) : '-' }}</p>
                                <p class="mb-0 fs--1"><strong>{{ __('Amount') }}: </strong> {{ isset($appointment->payment) ? $custom->currency_icon.ucfirst($appointment->payment->amount) : '-' }}</p>
                                <p class="mb-0 fs--1"><strong>{{ __('Payment Status') }}: </strong> {{ isset($appointment->payment) ? ucfirst($appointment->payment->status) : '-' }}</span></p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-8">
                <div class="card-body">
                    <div class="table-responsive fs--1">
                        <table class="table table-striped border-bottom">
                            <thead class="bg-200 text-900">
                                <tr>
                                    <th class="border-0">{{ __('Category') }}</th>
                                    <th class="border-0">{{ __('Service') }}</th>
                                    <th class="border-0">{{ __('Addional Information') }}</th>
                                    <th class="border-0 text-center">{{ __('Booking Created Date') }}</th>
                                    <th class="border-0 text-center">{{ __('Appointment Date') }}</th>
                                    <th class="border-0 text-center">{{ __('Start Time') }}</th>
                                    <th class="border-0 text-center">{{ __('End Time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-200">
                                    <td class="align-middle">
                                        <p class="mb-0 text-nowrap previous-serviceid" data-previous-serviceid="{{ old('employee_id') }}">{{ ucfirst($appointment->category_id) }}</p>
                                    </td>                                    
                                    <td class="align-middle">
                                        <p class="mb-0 text-nowrap previous-serviceid" data-previous-serviceid="{{ old('employee_id') }}">{{ ucfirst($appointment->service_id) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="mb-0 text-nowrap">Allowed Weight : {{ ucfirst($appointment->allowed_weight) }}</p>
                                        <p class="mb-0 text-nowrap">Allowed Persons : {{ ucfirst($appointment->no_of_person_allowed) }}</p>
                                    </td>                                     
                                    <td class="align-middle">
                                        <p class="text-center">{{ date($custom->date_format,strtotime($appointment->created_at)) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-center">{{ date($custom->date_format,strtotime($appointment->date)) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-center">{{ date('h:i a',strtotime($appointment->start_time)) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-center">{{ date('h:i a',strtotime($appointment->finish_time)) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-6 col-md-8 col-sm-12 text-center">
                            @if($appointment->status != 'completed')
                            @if($appointment->status != 'approved' && Auth::user()->role_id != 2 && $appointment->status
                            != 'cancel')
                            <button type="submit" id="approved" class="btn btn-success btn-design">{{ __('Approve Appointment') }}</button>
                            @endif

                            @if($appointment->status != 'cancel')
                            <button type="button" class="btn btn-danger btn-design" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter">{{ __('Cancel Appointment') }}</button>
                            @endif

                            @if($appointment->status == 'cancel')
                            <button type="button" class="btn btn-info btn-design back-btn-click">{{ __('Back') }}</button>
                            @endif
                            @endif

                            @if($appointment->status == 'approved' && isset($appointment->payment->status) &&
                            $appointment->payment->status == 'success')
                            <button type="button" class="btn btn-primary btn-design" id="complete" data-bs-toggle="modal"
                                data-bs-target="#exampleModalComplete">{{ __('Complete Appointment') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="exampleModalCenter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <form action="{{route('cancel',$appointment->id)}}" class="w-100" method="POST" id="cancel" autocomplete="off">
                    {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Cancel Appointment') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ __('Reason') }}:</label>
                            <textarea class="form-control" id="message-text" name="cancel_reason"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary" id="cancel">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="exampleModalComplete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{route('complete',$appointment->id)}}" class="w-100" method="POST" id="complete" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Complete Appointment') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ __('Note') }}:</label>
                            <textarea class="form-control" id="message-text" name="note"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{asset('backend/js/appointment.js')}}"></script>
@endsection