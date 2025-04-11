@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Services')])
@endsection
@section('content')
    @include('includes.message-block')
    <div class="row p-2">
        <div class="col-sm-12 col-mobile">
            <div class="board-box">
                <div class="board-title">
                    <h2>{{ __('List of all services') }} <a href="{{ route('services.create') }}" class="add-new-employee"><span
                                    class="fa fa-plus pull-c-right"></span></a></h2>  
                </div>
    
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="service-table">
                            <thead>
                            <tr>
                                <th>{{ __('SR No.') }}</th>
                                <th>{{ucfirst($custom->custom_field_service)}} {{ __('Name') }}</th>
                                @if($custom->categories == 1)
                                <th>{{ucfirst($custom->custom_field_category)}}</th>
                                @endif
                                <th>{{ucfirst($custom->custom_field_service)}} {{ __('Fee') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Cancel Before') }}</th>
                                <th>{{ __('Service Image') }}</th>
                                <th class="t-right">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <th>{{  $rowIndex++ }}</th>
                                    <td>{{ ucfirst($service->name) }}</td>
                                    @if($custom->categories == 1)
                                    <td>{{ (ucfirst(isset($service->categories))) ? ucfirst($service->categories->name) : '-'}}</td>
                                    @endif
                                    <td>{{ $custom->currency_icon }}{{ $service->price }}</td>
                                    <td>{!! $service->description !!}</td>
                                    <td>{{ Helper::timeformat($service->duration) }}</td>
                                    <td>{{ Helper::timeformat($service->cancel_before) }}</td>
                                    @if(!empty($service->image))
                                    <td>
                                        <a href="javascript:;" class="btn btn-default btn-lg open-service-image" data-original="{{ asset('img/services/'.$service->image) }}" title="{{ __('Service Image') }}">
                                            <span class="glyphicon glyphicon-picture"></span>
                                        </a>
                                    </td>
                                    @else
                                    <td>
                                        <a href="javascript:;" class="btn btn-default btn-lg open-service-image" data-original="{{asset('rbtheme/img/placeholder.jpeg')}}" title="{{ __('Service Image') }}">
                                            <span class="glyphicon glyphicon-picture"></span>
                                        </a>
                                    </td>
                                    @endif
    
                                    <td class="t-right">
                                        <a class="btn btn-default btn-lg" href="{{ route('services.show',$service->id) }}">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </a>
                                        <a class="btn btn-default btn-lg" href="{{ route('services.edit',$service->id) }}">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a class="btn btn-default btn-lg" title="{{ __('employee') }}" href="{{route('service.employee',$service->id)}}">
                                            <span class="glyphicon glyphicon-user"></span>
                                        </a> 
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
    <div class="modal fade" id="serviceImageModal" tabindex="-1" aria-labelledby="serviceImageLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceImageLabel">{{__('Service Image')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" alt="" id="serviceImagePopup" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="serviceImageModal" tabindex="-1" aria-labelledby="serviceImageLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceImageLabel">{{__('Service Image')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" alt="" id="serviceImagePopup" class="img-fluid lazyload" loading="lazy">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('backend/js/jquery.lazyload.min.js')}}"></script>
<script>
    $("img").lazyload({
        effect : "fadeIn"
    });
</script>
@endsection