@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Employees')])
@endsection

@section('content')
    <a href="{{ \Illuminate\Support\Facades\URL::previous() }}"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back')}}</h4></a>
    @include('includes.message-block')
    <div class="row p-2">
        <div class="col-sm-12 col-mobile">
            <div class="board-box">
                <div class="board-title">
                    <h2>{{ $service->name}} {{ __('Service Of Employee') }} <a href="{{ route('employees.create') }}" class="add-new-employee"><span
                                    class="fa fa-plus pull-c-right"></span></a></h2>
                </div>
    
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table">
                            <thead>
                            <tr>
                                <th>{{ __('SR No.') }}</th>
                                <th>{{ __('First Name') }}</th>
                                <th>{{ __('Last Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                               @if($custom->categories == 1)
                                    <th>{{ __('Category') }}</th>
                               @endif
                                <th>{{ __('Status') }}</th>
                                <th class="custom-column"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($employees) > 0)
                                @php $rowIndex = 1; @endphp
                                @foreach ($employees as $row)
                                <tr>
                                    <td>{{ $rowIndex++ }}</td>
                                    <td>{{ $row->employee->first_name}}</td>
                                    <td>{{ $row->employee->last_name }}</td>
                                    <td>{{ $row->employee->email }}</td>
                                    <td>{{ $row->employee->phone }}</td>
                                    @if($custom->categories == 1)
                                        <td>{{ !empty($row->category) ? $row->category->name : '-' }}</td>
                                    @endif
                                    <td>
                                        @php
                                        $text = ($row->employee->status) ? 'Actvie' : 'Inactive';
                                        $btnClass = ($row->employee->status) ? 'success' : 'danger';
                                        @endphp
                                        <span class="bg-{{$btnClass}} badge">{{ $text }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-default btn-lg mt-0" href="{{ route('employees.show',$row->employee->id) }}">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
    
                    <nav aria-label="Page navigation" class="my-pagination">
                        {{ str_replace('/?', '?', $employees->render()) }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
