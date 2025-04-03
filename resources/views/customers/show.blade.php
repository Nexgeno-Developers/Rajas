@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('View Customer')])
@endsection
@section('content')
<div class="mb-3 padding-space">
    <div class="container-fluid">
        @include('includes.message-block')
        <div class="row">
            <div class="offset-lg-3 offset-md-3 col-md-6">
                <div class="panel panel-default panel-custom">
                    <div class="panel-heading panel-custom-heading">
                        <div class="btn-position">
                            <h3 class="panel-title">{{ __('View Customer') }} : {{ $customers->first_name }}</h3>
                            {{  Form::open(['method' => 'DELETE','id' => 'deleteItem','route' => ['customers.destroy', $customers->id]])  }}
                                <button type="button" class="btn btn-default btn-delete btn-lg btn-padding btn-color">
                                <span class="glyphicon glyphicon-trash btn-delete-color"></span>
                            {{  Form::close() }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">  
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">{{ __('First Name') }}: </label>
                                                <input type="text" class="form-control custom-control" id="first_name" value="{{$customers->first_name}}" name="first_name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">{{ __('Last Name') }}: </label>
                                                <input type="text" class="form-control custom-control" id="last_name" value="{{$customers->last_name}}" name="last_name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">{{ __('Email') }}: </label>
                                                <input type="email" class="form-control custom-control" id="email" value="{{$customers->email}}" name="email" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">{{ __('Phone') }}: </label>
                                                <input type="tel" class="form-control custom-control intlTelInput" id="phone" value="{{$customers->phone}}" name="phone" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            <hr>
                            <a href="{{ route('customers.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection
