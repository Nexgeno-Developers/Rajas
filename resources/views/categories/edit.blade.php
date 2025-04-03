@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Edit Category')])
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
                </div>
                @endif
                <div class="panel panel-default panel-custom">
                    <div class="panel-heading panel-custom-heading">
                    <h3 class="panel-title">{{ __('Edit Category') }}: {{ $category->name }}</h3>
                    </div>
                    <div class="panel-body">
                        {!! Form::model($category, ['method' => 'PATCH','route' => ['categories.update', $category->id],'id'=>'category-form'] ) !!}
                        {{ csrf_field() }}
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{ ucfirst($custom->custom_field_category) }} {{ __('Name') }}: </label>
                                        <input type="text" name="name" placeholder="{{ucfirst($custom->custom_field_category)}} {{ __('name') }}" id="name" value="{{ $category->name }}" 
                                        class="form-control custom-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class=" error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    
                            <hr>

                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-default custom-btn btn-block">{{ __('Submit') }}</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                            <a href="{{ route('categories.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
