@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('View Category')])
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
                                    <h3 class="panel-title">{{ __('View Category') }}: {{ $category->name }}</h3>
    
                                    {{  Form::open(['method' => 'DELETE','id' => 'deleteItem','route' => ['categories.destroy', $category->id]])  }}
                                    <button type="button" class="btn btn-default btn-delete btn-lg btn-padding btn-color">
                                    <span class="glyphicon glyphicon-trash btn-delete-color"></span>
                                    {{  Form::close()  }} 
                                </div>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('categories.store') }}" method="post" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">{{ ucfirst($custom->custom_field_category) }} {{ __('Name') }}: </label>
                                                <input type="text" class="form-control custom-control" id="name" value="{{ $category->name }}" name="name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
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
