@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Create Categories')])
@endsection
@section('content')
<div class="mb-3 padding-space">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-lg-3 offset-md-3 col-md-6">
                @if(Session::has('message'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                {{Session::get('message')}}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="panel panel-default panel-custom">
                    <div class="panel-heading panel-custom-heading">
                        <h3 class="panel-title">{{ __('Create New Categories') }}</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('categories.store') }}" method="post" id="category-form" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="container-fluid">
    
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ ucfirst($custom->custom_field_category) }} {{ __('Name') }}: </label>
                                            <input type="text" name="name" placeholder="{{ucfirst($custom->custom_field_category)}} {{ __('name') }}" value="{{old('name')}}" 
                                            class="form-control custom-control @error('name') is-invalid @enderror">
                                            @error('name')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
       
                                <hr>
    
                                <div class="row">
                                    <div class="offset-sm-4 col-sm-4 col-xs-offset-2 col-xs-8">
                                        <button type="submit" id="submit" class="btn btn-default custom-btn btn-block">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                                <a href="{{ route('categories.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
