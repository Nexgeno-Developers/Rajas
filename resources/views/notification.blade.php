@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Notification')])
@endsection

@section('content')
    <div class="col-sm-12 col-mobile p-3">
        <div class="board-box main_section_bg">
            <div class="board-title">
                <h2>{{ __('Notifications') }}</h2>
            </div>

            <div class="table-style">
                <div class="table-responsive">
                    <table class="table table-hover data-table" id="notification-table">
                        <thead>
                        <tr>
                            <th>{{ __('SR No.') }}</th>
                            <th>{{ __('Customer Name') }}</th>
                            <th>{{ __('Message') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $result)
                            <tr>
                                <th>{{ $rowIndex++ }}</th>
                                <td>{{ ucfirst($result->first_name)}}</td>
                                <td>{{ ucfirst($result->message) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
