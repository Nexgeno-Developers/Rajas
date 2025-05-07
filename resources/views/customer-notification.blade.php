@extends('layouts.home',['title' => trans('Notification')])
@section('content')
    <div class="container py-4 min-vh-90 mt-lg-4">
    <div class="card overflow-hidden mb-3">
            <div class="card-header bg-light">
              <div class="row flex-between-center">
                <div class="col-sm-auto">
                  <h5 class="mb-1 mb-md-0">{{ __('Your Notifications') }}</h5>
                </div>
              </div>
            </div>
            <div class="card-body fs--1 p-0">
            @foreach($notifications as $notification)
            @if($notification->type == 'appointment' ||  $notification->type == 'Appointment')
              <a class="border-bottom-0 notification rounded-0 border-x-0 border-300" href="#!">
                <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                    <img class="rounded-circle" src="{{ asset('rbtheme/img/placeholder.png') }}" alt="" />
                  </div>
                </div>
                
                <div class="notification-body">
                <p class="mb-1">{{ $notification->message }}</p>
                  <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji"><span class="fa fa-calendar"></span></span>{{ Helper::notificationTime($notification->created_at) }}</span>
                </div>
              </a>
              @endif
              
              @if ($notification->type == 'Cancel')
              <a class="border-bottom-0  notification rounded-0 border-x-0 border-300" href="#!">
                <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                    <img class="rounded-circle" src="{{ asset('rbtheme/img/placeholder.png') }}" alt="" />
                  </div>
                </div>
                <div class="notification-body">
                  <p class="mb-1">{{ $notification->message }}</p>
                  <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji"><span class="fa fa-calendar"></span></span>{{ Helper::notificationTime($notification->created_at) }}</span>
                </div>
              </a>
              @endif
             
              @if ($notification->type == 'completed')
              <a class="border-bottom-0 notification rounded-0 border-x-0 border-300" href="#!">
                <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                    <img class="rounded-circle" src="{{ asset('rbtheme/img/placeholder.png') }}" alt="" />
                  </div>
                </div>
                <div class="notification-body">
                  <p class="mb-1">{{ $notification->message }}</p>
                  <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji"><span class="fa fa-calendar"></span></span>{{ Helper::notificationTime($notification->created_at) }}</span>
                </div>
              </a>
              @endif

              @if($notification->type == 'customer')
              <a class="border-bottom-0 notification rounded-0 border-x-0 border-300" href="#!">
                <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                    <img class="rounded-circle" src="{{ asset('rbtheme/img/placeholder.png') }}" alt="" />
                  </div>
                </div>
                <div class="notification-body">
                  <p class="mb-1">{{ $notification->message }}</p>
                  <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji"><span class="fa fa-calendar"></span></span>{{ Helper::notificationTime($notification->created_at) }}</span>
                </div>
              </a>
              @endif
              @endforeach
            </div>
          </div>
    </div>
@endsection