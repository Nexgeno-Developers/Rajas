@extends('layouts.home',['title' => trans('Customer Appointment')])
@section('content')
<section class=" overflow-hidden light" id="banner">
    <div class="bg-holder overlay">
    </div>
    <div class="container mt-lg-6">
        {{ csrf_field() }}
        <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card customer-card-appointment"></div>
            <div class="card-body position-relative">
                <h5>{{ __('Appointment Details') }}</h5>
                <p class="fs--1">{{ date($custom->date_format, strtotime($appointment->date)) }}</p>
                <div><strong class="me-2">{{ __('Status') }}: </strong>
                    @if($appointment->status == 'cancel')
                    <div class="badge rounded-pill badge-soft-danger fs--2">{{ ucfirst($appointment->status) }}<span
                            class="fas fa-check ms-1" data-fa-transform="shrink-2"></span></div>
                    @endif
                    @if($appointment->status == 'pending')
                    <div class="badge rounded-pill badge-soft-danger fs--2">{{ ucfirst($appointment->status) }}<span
                            class="fas fa-check ms-1" data-fa-transform="shrink-2"></span></div>
                    @endif
                    @if($appointment->status == 'approved')
                    <div class="badge rounded-pill badge-soft-success fs--2">{{ ucfirst($appointment->status) }}<span
                            class="fas fa-check ms-1" data-fa-transform="shrink-2"></span></div>
                    @endif
                    @if($appointment->status == 'completed')
                    <div class="badge rounded-pill badge-soft-success fs--2">{{ ucfirst($appointment->status) }}<span
                            class="fas fa-check ms-1" data-fa-transform="shrink-2"></span></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <h5 class="mb-3 fs-0">{{ __("Customer") }} Details</h5>
                        <h6 class="mb-2">
                            {{ ucfirst($appointment->user->first_name).' '.ucfirst($appointment->user->last_name) }}
                        </h6>
                        <p class="mb-0 fs--1"> <strong>{{ __('Email') }}: </strong>{{ $appointment->user->email }}</p>
                        <p class="mb-0 fs--1"> <strong>{{ __('Phone') }}: </strong>{{ $appointment->user->country_code.$appointment->user->phone }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <h5 class="mb-3 fs-0">{{ __('Employee') }} Details</h5>
                        <h6 class="mb-2">
                            {{ ucfirst($appointment->employee->first_name).' '.ucfirst($appointment->employee->last_name) }}
                        </h6>
                        <p class="mb-0 fs--1"> <strong>{{ __('Email') }}: </strong>{{ $appointment->employee->email }}</p>
                        <p class="mb-0 fs--1"> <strong>{{ __('Phone') }}: </strong>{{ $appointment->employee->country_code.$appointment->employee->phone }}</p>                        
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h5 class="mb-3 fs-0">{{ __('Payment Information') }}</h5>
                        <div class="flex-1">
                            <h6 class="mb-0">
                                <p class="mb-0 fs--1"><strong>{{ __('Method') }}: </strong> {{ isset($appointment->payment) ? ucfirst($appointment->payment->payment_method) : '-' }}</p>
                                <p class="mb-0 fs--1"><strong>{{ __('Payment ID') }}: </strong> {{ isset($appointment->payment) ? ucfirst($appointment->payment->payment_id) : '-' }}</p>
                                <p class="mb-0 fs--1"><strong>{{ __('Paid Amount') }}: </strong> {{ isset($appointment->payment) ? $custom->currency_icon.ucfirst($appointment->payment->amount) : '-' }}</p>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-8 mb-set">
            <div class="card-body">
                <div class="table-responsive fs--1">
                    <table class="table table-striped border-bottom">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="border-0">{{ __('Service') }}</th>
                                <th class="border-0">{{ __('Addional Information') }}</th>
                                <th class="border-0 text-center">{{ __('Start Time') }}</th>
                                <th class="border-0 text-end">{{ __('End Time') }}</th>
                                <th class="border-0 text-end">{{ __('Appointment Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-200">
                                <td class="align-middle">
                                    <h6 class="mb-0 text-nowrap">{{ ucfirst($appointment->service_id) }}</h6>

                                </td>
                                <td class="align-middle">
                                    <p class="mb-0 text-nowrap">Allowed Weight : {{ ucfirst($appointment->allowed_weight) }}</p>
                                    <p class="mb-0 text-nowrap">Allowed Persons : {{ ucfirst($appointment->no_of_person_allowed) }}</p>
                                </td>                                
                                <td class="align-middle text-center">
                                    {{ date('h:i a',strtotime($appointment->start_time)) }}</td>
                                <td class="align-middle text-end">
                                    {{ date('h:i a',strtotime($appointment->finish_time)) }}</td>
                                <td class="align-middle text-end">{{ date($custom->date_format, strtotime($appointment->date)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-center mt-5">
                    <div class="col-sm-12 text-center appCancelBtnBlock">
                        @if($appointment->status != 'completed')
                        @if($appointment->status != 'cancel')
                        <button type="button" class="btn btn-danger btn-design" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">{{ __('Cancel Appointment') }}</button>
                        @endif
                        <button type="button" class="btn btn-info back-btn-click">{{ __('Back') }}</button>
                        @endif
                    </div>
                </div>

                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{route('cancel',$appointment->id)}}" method="POST" id="cancel" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Cancel Appointment') }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">{{ __('Reason') }}:</label>
                                        <textarea class="form-control" id="message-text"
                                            name="cancel_reason"></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary" id="cancel">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
