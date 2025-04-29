<div class="footer-top">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-md-6 footer-contact">
                <a href="{{ route('welcome')}}" class="logo mr-md-auto">
            @if(!empty($site->logo) && $site->logo != 'default-logo.png')
            <img src="{{ asset('img/logo/'.$site->logo )}}" alt="logo" class="img-fluid" style="max-height: 45px;">
            @else
            <img src="{{asset('rbtheme/img/logo.png')}}" alt="" class="img-fluid" style="max-height: 45px;">
            @endif
        </a>
                <p>
                    {{ (!empty($site->address)) ? ucfirst($site->address) : '-' }} <br><br>
                    <strong>{{ __('Phone') }}:</strong> <a href="{{ (!empty($site->phone)) ? 'tel:'.$site->phone : 'javascript:;' }}" class="text-black" target="_blank">{{ (!empty($site->phone)) ? $site->country_code.$site->phone : '-' }}</a><br>
                    <strong>{{ __('Email') }}:</strong> <a href="{{ (!empty($site->email)) ? 'mailto:'.$site->email : 'javascript:;' }}" class="text-black" target="_blank">{{ (!empty($site->email)) ? $site->email : '-' }}</a><br>
                </p>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
                <h4>{{ __('Useful Links') }}</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="{{route('welcome')}}">{{ __('Home') }}</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#features">{{ __('Features') }}</a></li>
                    @if(isset($services) && count($services) > 0)
                    <li><i class="bx bx-chevron-right"></i> <a href="#services">{{ __('Services') }}</a></li>
                    @endif
                    <li><i class="bx bx-chevron-right"></i> <a href="#about">{{ __('About us') }}</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#contact">{{ __('Contact') }}</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
                @if(isset($services) && count($services) > 0)
                <h4>{{ __('Our Services') }}</h4>
                <ul>
                    @if(isset($services) && !empty($services))
                    @foreach ($services as $key => $service)
                    @if($key < 5)
                    <li><i class="bx bx-chevron-right"></i> <a href="javascript:;">{{ucfirst($service->name)}}</a></li>
                    @endif
                    @endforeach
                    @endif
                </ul>
                @endif
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
                <h4>{{ __('Our Social Networks') }}</h4>
                <p>{{ __('Follow the social media to getting latest updates') }}</p>
                <div class="social-links mt-3">
                      @if(isset($site) && !empty($site->instagram))
                    <a href="{{ $site->instagram }}" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
                    @endif
                  
                    @if(isset($site) && !empty($site->facebook))
                    <a href="{{ $site->facebook }}" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
                    @endif
                  
                    @if(isset($site) && !empty($site->linkedin))
                    <a href="{{ $site->linkedin }}" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
                    @endif
                    @if(isset($site) && !empty($site->twitter))
                    <a href="{{ $site->twitter }}" class="youtube" target="_blank"><i class="bx bxl-youtube"></i></a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>