@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Categories')])
@endsection
@section('content')
    @include('includes.message-block')
    <div class="row p-md-4 p-2">
        <div class="col-sm-12 col-mobile">
            <div class="board-box main_section_bg">
                <div class="board-title">
                   
                        <div class="row">
	<div class="col-md-6"><h2>{{ __('List of all Categories') }} </h2></div>
	<div class="col-md-6"><a href="{{ route('categories.create') }}" class="add-new-employee btn btn-secondary pull-c-right"> <span class="fa fa-plus"></span> Create Locations</a></div>
</div>


                    </div>
                
    
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="cat-table">
                            <thead>
                            <tr>
                                <th>{{ __('SR No.') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th class="t-right">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <th>{{ $rowIndex++ }}</th>
                                    <td>{{ ucfirst($category->name) }}</td>
                                    <td class="t-right">
                                        <a class="btn btn-default btn-lg eye_class" href="{{ route('categories.show',$category->id) }}">
                                        <img class="eyes_img" src="{{asset('rbtheme/img/eyes_img.svg')}}" alt="" class="img-fluid"></a>
                                        <a class="btn btn-default btn-lg edit_class" href="{{ route('categories.edit',$category->id) }}">
                                        <img class="edit_img" src="{{asset('rbtheme/img/edit_img.svg')}}" alt="" class="img-fluid"></a>
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
    </div>

@endsection
