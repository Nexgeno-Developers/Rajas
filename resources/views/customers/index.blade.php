@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Customers')])
@endsection
@section('content')
    <div class="row p-md-4 p-2">
        @include('includes.message-block')
        <div class="col-sm-12 col-mobile">
            <div class="board-box main_section_bg">
                <div class="board-title">
                    <h2>{{ __('List of all customers') }}</h2>
                </div>
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="customer-table">
                            <thead>
                                <tr>
                                    <th>{{ __('SR No.') }}</th>
                                    <th>{{ __('First Name') }}</th>
                                    <th>{{ __('Last Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="t-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <th>{{ $rowIndex++ }}</th>
                                        <td>{{ ucfirst($customer->first_name) }}</td>
                                        <td>{{ ucfirst($customer->last_name) }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->country_code.$customer->phone }}</td>
                                        <td><input type="checkbox" name="status" class="status" value="1" @if($customer->status == 1) {{ 'checked' }} @endif data-toggle="toggle" data-style="slow"
                                            data-onstyle="success" data-offstyle="danger" data-off="{{ __('Inactive') }}" data-employee_id="{{$customer->id}}" data-on="{{ __('Active') }}">
                                        </td>
                                        <td  class="t-right">
                                            <a class="btn btn-default btn-lg eye_class" href="{{ route('customers.show',$customer->id) }}">
                                                <img class="eyes_img" src="{{asset('rbtheme/img/eyes_img.svg')}}" alt="" class="img-fluid"></a>
                                            <a class="btn btn-default btn-lg edit_class" href="{{ route('customers.edit',$customer->id) }}">
                                                <img class="edit_img" src="{{asset('rbtheme/img/edit_img.svg')}}" alt="" class="img-fluid"></a>
                                            <a class="btn btn-default btn-lg calendar_class" title="{{ __('appointment')}}" href="{{ route('customers.appointment',$customer->id) }}">
                                                    <img class="calnder_img" src="{{asset('rbtheme/img/calendar_img.svg')}}" alt="" class="img-fluid"></a>
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
@section('scripts')
<script src="{{asset('backend/js/customer.js')}}"></script>
@endsection
