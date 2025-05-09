@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Categories')])
@endsection
@section('content')
    @include('includes.message-block')
    <div class="row p-2">
        <div class="col-sm-12 col-mobile">
            <div class="board-box">
                <div class="board-title">
                    <h2>{{ __('List of all Categories') }}<a href="{{ route('categories.create') }}" class="add-new-category">    
                        <span class="fa fa-plus pull-c-right"></span></a></h2>
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
                                        <a class="btn btn-default btn-lg" href="{{ route('categories.show',$category->id) }}">
                                        <span class="glyphicon glyphicon-eye-open"></span></a>
                                        <a class="btn btn-default btn-lg" href="{{ route('categories.edit',$category->id) }}">
                                        <span class="glyphicon glyphicon-edit"></span></a>
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
