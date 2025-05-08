@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Customer Appointment')])
@endsection
@section('content')
<a href="{{ \Illuminate\Support\Facades\URL::previous() }}"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
    <div class="row p-md-4 p-2">
        <div class="col-sm-12 col-mobile">
            <div class="board-box main_section_bg">
                <div class="board-title">
                    <h2>{{ __('List of Appointment') }}</h2>
                </div>
                <form action="{{ route('customers.appointment', $customer_id)}}" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label">{{ucfirst($custom->custom_field_service)}}:</label>
                            <select name="service_id" id="service_id" class="form-control custom-control">
                                <option value="">{{ __('Select')}} {{ucfirst($custom->custom_field_service)}}</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->name }}" {{ ($service->name == $service_id) ? 'selected' : '' }}>{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if($custom->employees == 1)
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label">{{ucfirst($custom->custom_field_text)}}:</label>
                            <select name="employee_id" id="employee" class="form-control custom-control">
                                <option value="">{{ __('Select')}} {{ucfirst($custom->custom_field_text)}}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ ($employee->id == $employee_id) ? 'selected' : '' }}>{{ ucfirst($employee->first_name).' '.ucfirst($employee->last_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="date" class="form-label">{{ __('Start Date') }}: </label>
                            <input type="text" class="form-control custom-control" id="date" min="{{ date($custom->date_format)}}" autocomplete="off" 
                            value="{{ $start_date }}" data-date-format="{{ $custom->date_format }}" name="start_date" data-wizard-validate-date="true" placeholder="{{ __('Please Select Date') }}">
                            <span class=" error-message" id="err-date"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="date" class="form-label">{{ __('End Date') }}: </label>
                            <input type="text" class="form-control custom-control date" id="date" min="{{ date($custom->date_format) }}" autocomplete="off" 
                            value="{{ $end_date }}" data-date-format="{{ $custom->date_format }}" name="end_date" data-wizard-validate-date="true" placeholder="{{ __('Please Select Date') }}">
                            <span class=" error-message" id="err-date"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="status" class="form-label">{{ __('Status') }}: </label>
                            <select name="status" id="status" class="form-control custom-control">
                            <option value="">{{ __('Select Status') }}</option>
                            <option value="approved" {{ ($status == 'approved') ? 'selected' : '' }}>{{ __('Approved') }}</option>
                            <option value="cancel" {{ ($status == 'cancel') ? 'selected' : '' }}>{{ __('Cancel') }}</option>
                            <option value="pending" {{ ($status == 'pending') ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 mt-sm-1">
                        <div class="form-group">
                            <input class="btn btn-primary filter truncate" type="submit" title="{{ __('Apply Filter') }}" value="{{ __('Apply Filter') }}" />
                            <a class="btn btn-primary filter" href="{{route('customers.appointment', $customer_id)}}">{{ __('Reset') }}</a>
                        </div>
                    </div>
                </div>
                </form>
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="customer-appointment-table">
                            <thead>
                                <tr>
                                    <th>{{ __('SR No.') }}</th>
                                    <th>{{ __('Service') }}</th>
                                    @if($custom->employees == 1)
                                    <th>{{ __('Employee') }}</th>
                                    @endif
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Start time') }}</th>
                                    <th>{{ __('Finish time') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('Comment') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($appointment as $row)
                                <tr>
                                    <th>{{ $rowIndex++ }}</th>
                                    <td>{{ $row->service_id }}</td>
                                    @if($custom->employees == 1)
                                    <td>{{ $row->employee->first_name.' '.$row->employee->last_name }}</td>
                                    @endif
                                    <td>{{ !empty($row->user) ?$row->user->first_name.' '.$row->user->last_name : __('User Not Avaible') }}</td>
                                    <td>{{ date($custom->date_format, strtotime($row->date)) }}</td>
                                    <td>{{ $row->start_time }}</td>
                                    <td>{{ $row->finish_time }}</td>
                                    @if($row->status == 'approved')
                                        <td><span class="btn btn-success">{{ ucfirst($row->status) }}</span></td>
                                    @endif
                                    @if($row->status == 'pending')
                                        <td><span class="btn btn-warning">{{ ucfirst($row->status) }}</span></td>
                                    @endif
                                    @if($row->status == 'cancel')
                                        <td><span class="btn btn-danger">{{ ucfirst($row->status) }}</span></td>
                                    @endif
                                    @if($row->status == 'completed')
                                        <td><span class="btn btn-info">{{ ucfirst($row->status) }}</span></td>
                                    @endif
                                    <td>{{ $row->comments }}</td>
                                    <td><a class="btn btn-default btn-lg eye_class" href="{{ route('appointments.show',$row->id) }}">
                                            <img class="eyes_img" src="{{asset('rbtheme/img/eyes_img.svg')}}" alt="" class="img-fluid"></a> 
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
