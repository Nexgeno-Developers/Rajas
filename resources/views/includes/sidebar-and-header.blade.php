<aside class="aside">
    <div class="aside-content">
        <div class="logo">
            <a href="/dashboard" class="">
            @if(!empty($site->logo))
            <img src="{{asset('img/logo/'.$site->logo)}}" alt="{{ __('Site Logo') }}" class="img-responsive">
            @else
            <img src="{{asset('rbtheme/img/logo.png')}}" alt="{{ __('Site Logo') }}" class="img-responsive">
            @endif
            </a>
        </div>

        <nav class="aside-menu">
    <ul>
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{ __('Dashboard') }}</a>
        </li>
    </ul>

    @can('customers', Auth::user())
    <ul>
        <li class="{{ request()->routeIs('customers*') ? 'active' : '' }}">
            <a href="{{ route('customers.index') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                <span>{{ __('Customers') }}</span>
            </a>
        </li>
    </ul>
    @endcan

    @can('appointments', Auth::user())
    <ul>
        <li class="{{ request()->routeIs('appointments*') ? 'active' : '' }}">
            <a href="{{ route('appointments.index') }}">
                <i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
                <span>{{ __('Appointments') }}</span>
            </a>
        </li>
    </ul>
    @endcan

    @can('employees', Auth::user())
    @if($custom->employees == 1)
    <ul>
        <li class="{{ request()->routeIs('employees*') ? 'active' : '' }}">
            <a href="{{ route('employees.index') }}">
                <i class="fa fa-user-circle" aria-hidden="true"></i>
                <span>{{ __('Employees') }}</span>
            </a>
        </li>
    </ul>
    @endif
    @endcan

    @can('payments', Auth::user())
    <ul>
        <li class="{{ request()->routeIs('paymentlist') ? 'active' : '' }}">
            <a href="{{ route('paymentlist') }}" @if(isset($custom) && $custom->currency_icon != "") class="currency-link" @endif>
                @if(isset($custom) && $custom->currency_icon != "")
                <span class="currency-icon">{{$custom->currency_icon}}</span>
                @else
                <i class="fa fa-inr" aria-hidden="true"></i>
                @endif
                <span>{{ __('Payments') }}</span>
            </a>
        </li>
    </ul>
    @endcan

    @can('employeepayment', Auth::user())
    <ul>
        <li class="{{ request()->routeIs('employee-paymentlist*') ? 'active' : '' }}">
            <a href="{{ route('employee-paymentlist') }}">
                <i class="fa fa-inr" aria-hidden="true"></i>
                <span>{{ __('Payments') }}</span>
            </a>
        </li>
    </ul>
    @endcan

    @can('categories', Auth::user())
    @if($custom->categories == 1)
    <ul>
        <li class="{{ request()->routeIs('categories*') ? 'active' : '' }}">
            <a href="{{ route('categories.index') }}">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
                <span>{{ __('Categories') }}</span>
            </a>
        </li>
    </ul>
    @endif
    @endcan

    @can('employees', Auth::user())
    <ul>
        <li class="{{ request()->routeIs('services*') ? 'active' : '' }}">
            <a href="{{ route('services.index') }}">
                <i class="fa fa-wrench" aria-hidden="true"></i>
                <span>{{ __('Services') }}</span>
            </a>
        </li>
    </ul>
    @endcan

    @can('settings', Auth::user())
    <ul>
        <li class="{{ request()->routeIs('setting.*') ? 'active' : '' }}">
            <a href="/site/setting">
                <i class="fa fa-cog" aria-hidden="true"></i>
                <span>{{ __('Settings') }}</span>
                <!-- <div class="icon"><i class="fa fa-arrow-left" aria-hidden="true"></i></div> -->
            </a>
            <!-- <ul class="nested-menu">
                <li class="{{ request()->routeIs('setting.site') ? 'active' : '' }}">
                    <a href="{{ route('setting.site') }}">{{ __('Site Setting') }}</a>
                </li>
            </ul> -->
        </li>
    </ul>
    @endcan
</nav>

    </div>
</aside>
<header class="header">
    <div class="header-top header-inverted">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <div class="bt-menu-trigger">
                        <span></span>
                    </div>
                </div>
                <div class="col-10">
                    <ul class="settings">
                        
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-bs-toggle="dropdown" id="langaugeDropDown" aria-expanded="false">
                                {{ Config::get('languages')[app()->getLocale()] }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="langaugeDropDown">
                                @foreach (Config::get('languages') as $key => $item)
                                    <li><a class="dropdown-item" href="{{ route('chang.locale', $key) }}">{{ __($item) }}</a></li>    
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown">
                                @php
                                    $notificationcount = DB::table('notification')->where('user_id',Auth::user()->id)->where('is_read','0')->count();
                                    $empnotification = DB::table('notification')->where('user_id',Auth::user()->id)->where('is_read','0')->count();
                                @endphp
                            <a href="{{ route('admin-notification') }}" class="notification">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                @if(Auth()->user()->role_id == 1)
                                    <span class="badge">{{ $notificationcount }}</span>
                                @else
                                    <span class="badge">{{ $empnotification }}</span>   
                                @endif
                            </a>
                           
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-bs-toggle="dropdown" id="profileDropdown" aria-expanded="false">
                                @if(!empty(Auth::user()->profile))
                                <img src="{{ asset('img/profile/'.Auth::user()->profile) }}" alt="{{ __('avatar') }}"
                                    class="img-circle img">
                                @else
                                <img src="{{ asset('rbtheme/img/image.png') }}" alt="{{ __('avatar') }}" class="img-circle img">
                                @endif
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}"><i class="fa fa-user-o"
                                            aria-hidden="true"></i>{{ __('User Profile') }}</a></li>
                                <li><a class="dropdown-item btn-logout-click" href="javascript: void(0);"><i class="fa fa-sign-out"
                                            aria-hidden="true"></i> {{ __('SignOut') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form id="logout-form" method="post" action="{{route('logout')}}">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

