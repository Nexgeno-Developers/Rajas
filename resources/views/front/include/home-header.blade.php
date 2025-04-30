<div class="top_bar bg-white">
  <div class="container">
    <div class="row">
       <div class="col-md-6">
           <div class="social-links">
                      @if(isset($site) && !empty($site->instagram))
                    <a href="{{ $site->instagram }}" class="instagram" target="_blank"><i class="font-size-20 bx bxl-instagram"></i></a>
                    @endif
                  
                    @if(isset($site) && !empty($site->facebook))
                    <a href="{{ $site->facebook }}" class="facebook" target="_blank"><i class="font-size-20 bx bxl-facebook"></i></a>
                    @endif
                  
                    @if(isset($site) && !empty($site->linkedin))
                    <a href="{{ $site->linkedin }}" class="linkedin" target="_blank"><i class="font-size-20 bx bxl-linkedin"></i></a>
                    @endif
                    @if(isset($site) && !empty($site->twitter))
                    <a href="{{ $site->twitter }}" class="youtube" target="_blank"><i class="font-size-20 bx bxl-youtube"></i></a>
                    @endif
                </div>
       </div>
       <div class="col-md-6">
         <div class="">
          <ul class="list_top">
            <li class=""><a href="{{ (!empty($site->phone)) ? 'tel:'.$site->phone : 'javascript:;' }}" class="text-black" target="_blank"><i class="bx bx-phone"></i> {{ (!empty($site->phone)) ? $site->country_code.$site->phone : '-' }}</a></li>
            <li class=""><a href="{{ (!empty($site->email)) ? 'mailto:'.$site->email : 'javascript:;' }}" class="text-black" target="_blank"><i class="bx bx-envelope"></i> {{ (!empty($site->email)) ? $site->email : '-' }}</a></li>
          </ul>
           
         </div>
       </div>
    </div>
  </div>
</div>

<header id="header" class="header-scrolled">
    <div class="container d-flex align-items-center">
        <a href="{{ route('welcome')}}" class="logo mr-md-auto">
            @if(!empty($site->logo) && $site->logo != 'default-logo.png')
            <img src="{{ asset('img/logo/'.$site->logo )}}" alt="logo" class="img-fluid">
            @else
            <img src="{{asset('rbtheme/img/logo.png')}}" alt="" class="img-fluid">
            @endif
        </a>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="@if(Request::segment(2) == '' && Request::segment(1) == '') active @endif"><a href="{{ route('welcome')}}">{{ __('Home') }}</a></li>
                <li class=""><a href="{{ route('welcome')}}">{{ __('Air Safari Services') }}</a></li>
                <li class=""><a href="{{ route('welcome')}}">{{ __('Adi Kailash') }}</a></li>
                <li class=""><a href="{{ route('welcome')}}">{{ __('About') }}</a></li>
                <li class=""><a href="{{ route('welcome')}}">{{ __('Contact us') }}</a></li>
                <!-- <li class=""><a @if(!empty(request()->route()) && request()->route()->getName() != 'welcome') 
                  href="{{ route('welcome')}}#features" 
                  @elseif(empty(request()->route())) href="{{ route('welcome')}}#features" 
                  @else href="#features" @endif>{{ __('Feature') }}</a></li>
                @if(isset($services) && count($services) > 0)
                <li class=""><a @if(request()->route()->getName() != 'welcome') 
                  href="{{ route('welcome')}}#services" 
                  @elseif(empty(request()->route())) href="{{ route('welcome')}}#services" 
                  @else href="#services" @endif>{{ __('Service') }}</a></li>@endif
                <li class=""><a @if(!empty(request()->route()) && request()->route()->getName() != 'welcome') 
                  href="{{ route('welcome')}}#employees" 
                  @elseif(empty(request()->route())) href="{{ route('welcome')}}#employees" 
                  @else href="#employees" @endif>{{ __('Service Providers') }}</a></li>
                <li class=""><a @if(!empty(request()->route()) && request()->route()->getName() != 'welcome') 
                  href="{{ route('welcome')}}#about" 
                  @elseif(empty(request()->route())) href="{{ route('welcome')}}#about" 
                  @else href="#about" @endif>{{ __('About') }}</a></li>
                <li class=""><a @if(!empty(request()->route()) && request()->route()->getName() != 'welcome') 
                  href="{{ route('welcome')}}#contact" 
                  @elseif(empty(request()->route())) href="{{ route('welcome')}}#contact" 
                  @else href="#contact" @endif>{{ __('Contact') }}</a></li> -->
                <li class="@if(Request::segment(2) == 'book') active @endif"><a href="{{ route('appointment.book')}}">{{ __('Book Now') }}</a></li>
                <!-- <li class="drop-down">
                  <a href="javascript:;">{{ Config::get('languages')[app()->getLocale()] }}</a>
                  <ul>
                    @foreach (Config::get('languages') as $key => $item)
                    <li class="@if(app()->getLocale() == $key) active @endif"><a href="{{ route('chang.locale', $key) }}">{{ __($item) }}</a></li>
                    @endforeach
                  </ul>
                </li> -->
                @auth
                @php
                    $notificationcount = DB::table('notification')->where('is_read',0)->where('user_id',Auth::user()->id)->count();
                @endphp
                <li class="drop-down @if($notificationcount > 0) notification-indicator @endif notification-indicator-primary fa-icon-wait">
                    <div class="desktop-view @if(Request::segment(2) == 'notification') active @endif">
                        <a href="javascript:;" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="fas fa-bell font-c-25" data-fa-transform="shrink-5"></span></a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification" aria-labelledby="navbarDropdownNotification">
                            <div class="card card-notification shadow-none">
    
                                <div class="card-header">
              
                                  <div class="row justify-content-between align-items-center">
              
                                    <div class="col-auto">
              
                                      <h6 class="card-header-title mb-0">{{ __('Notifications') }}</h6>
              
                                    </div>
              
                                    
                                    @if($notificationcount > 0)
                                    <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="javascript:;" id="mark">{{ __('Mark all as read') }}</a></div>
                                    @endif
                                  </div>
              
                                </div>
              
                                <div class="scrollbar-overlay max-h-25">
              
                                  <div class="list-group list-group-flush fw-normal fs--1">
              
                                    <div class="list-group-title border-bottom">{{ __('NEW') }}</div>
              
                                    <div class="list-group-item">
              
                                      @php
              
                                        $latestNotifications = DB::table('notification')->where('user_id',Auth::user()->id)->where('is_read', 0)->limit(3)->orderBy('id','desc')->get();
              
                                      @endphp
              
              
                                      @foreach ($latestNotifications as $latestNotification) 
              
                                      <a class="notification notification-flush" href="{{ route('notification',$latestNotification->id) }}">
              
                                        <div class="notification-avatar">
              
                                          <div class="avatar avatar-2xl me-4">
                                            
                                            
                                            <img class="rounded-circle" src="{{ asset('rbtheme/img/placeholder.png') }}" alt="" />
              
                                          </div>
              
                                        </div>
              
                                        <div class="notification-body">
              
                                          <p class="mb-1 wrap">{{ $latestNotification->message }}</p>
                                          <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji"><i class="icofont icofont-chat"></i></span>{{ Helper::notificationTime($latestNotification->created_at) }}</span>
              
                                        </div>
              
                                      </a>
              
                                      @endforeach
              
                                    </div>
              
                                  </div>
              
                                </div>
              
                                <div class="card-footer text-center border-top"><a class="card-link d-block" href="{{ route('notification') }}">{{ __('View all') }}</a></div>
              
                              </div>
                        </div>
                    </div>
                    <div class="mobile-view @if(Request::segment(2) == 'notification') active @endif">
                        <a href="{{ route('notification') }}"><span data-fa-transform="shrink-5">{{ __('Notifications') }}</span></a>
                    </div>
                </li>
                <li class="drop-down">
                    @if(!empty(Auth::user()->profile))
                    <a href="javascript:;"><img src="{{ asset('img/profile/'.Auth::user()->profile) }}" alt="customer-logo" class="rounded" width="25" height="25"></a>
                    @else
                    <a href="javascript:;"><img src="{{ asset('rbtheme/img/image.png')}}" alt="default-logo" class="rounded" width="18" height="18"></a>
                    @endif
                    <ul @if(Request::segment(2) == 'profile' || Request::segment(1) == 'dashboard') class="d-block" @endif>
                        <li class="@if(Request::segment(1) == 'dashboard') active @endif">
                            @if(!empty(Auth::user()->role_id != 2))
                            <a href="{{ route('dashboard')}}">{{ __('Dashboard') }}</a>
                            @endif
                            @if(!empty(Auth::user()->role_id == 2))
                            <a href="{{ route('dashboard')}}">{{ __('My Bookings') }}</a>
                            @endif
                        </li>
                        <li class="@if(Request::segment(2) == 'profile') active @endif"><a href="{{ route('customer-profile',Auth::user()->id) }}">{{ __('Profile') }}</a></li>
                        <li><a href="javascript:;" class="btn-logout-click">{{ __('Logout') }}</a></li>
                    </ul>
                </li>
                @endauth
            </ul>
        </nav>
        @auth
            <a href="javascript:;" class="get-started-btn scrollto btn-logout-click">{{ __('Logout') }}</a>
        @else
            <a href="javascript:;" class="get-started-btn scrollto" data-bs-toggle="modal" data-bs-target="#loginModel">{{ __('Login / Register') }}</a>
        @endauth
    </div>
</header>
<form id="logout-form" method="post" action="{{route('logout')}}">
  {{ csrf_field() }}
</form>
@include('theme.includes.login')

@include('theme.includes.register')

@include('theme.includes.forgot-password')

@include('theme.includes.reset-password')