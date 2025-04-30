 <div class="footer-top2">
    <div class="footer-bg-image"></div>
    <div class="container">
        <div class="row">
              <div class="col-lg-4">
             <a href="{{ route('welcome')}}" class="logo mr-md-auto">
            @if(!empty($site->logo) && $site->logo != 'default-logo.png')
            <img src="{{ asset('img/logo/'.$site->logo )}}" alt="logo" class="img-fluid footer_logo">
            @else
            <img src="{{asset('rbtheme/img/logo.png')}}" alt="" class="img-fluid footer_logo">
            @endif
        </a>
         </div>
         
         

          <div class="col-lg-8 col-md-8 footer-links">
                <!-- <h4>{{ __('Our Social Networks') }}</h4> -->
                <!-- <p>{{ __('Follow the social media to getting latest updates') }}</p> -->
                <div class="social-links-footer mt-5">
                      @if(isset($site) && !empty($site->instagram))
                    <a href="{{ $site->instagram }}" class="" target="_blank"><i class="bx bxl-instagram"></i> <span>airsafari_india</span></a>
                    @endif
                  
                    @if(isset($site) && !empty($site->facebook))
                    <a href="{{ $site->facebook }}" class="" target="_blank"><i class="bx bxl-facebook"></i> <span>Air Safari</span></a>
                    @endif
                  
                    @if(isset($site) && !empty($site->linkedin))
                    <a href="{{ $site->linkedin }}" class="" target="_blank"><i class="bx bxl-linkedin"></i> <span>Rajas Group of...</span></a>
                    @endif
                    @if(isset($site) && !empty($site->twitter))
                    <a href="{{ $site->twitter }}" class="" target="_blank"><i class="bx bxl-youtube"></i> <span>Air Safari India</span></a>
                    @endif
                </div>
            </div>
            </div>
            </div>
            </div>


            <div class="footer-top">
    <div class="container">
        <div class="row">


       
            <div class="col-lg-4 col-md-6 footer-contact">
                 <h4 class="text-white">{{ __('About Us') }}</h4>
               <p class="text-white pr-lg-5">Adventure is in Our Blood. As India’s first company to introduce aero tourism and hobby flying, Rajas Aerosports and Adventures is redefining the possibilities of exploration from above.</p>
               
            </div>

            <div class="col-lg-2 col-md-6 footer-links">
                <h4 class="text-white">{{ __('Useful Links') }}</h4>
                <ul>
                    <li><img class="footer_icons" src="{{asset('rbtheme/img/footer_arrow_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="{{route('welcome')}}">{{ __('Home') }}</a></li>
                    <li><img class="footer_icons" src="{{asset('rbtheme/img/footer_arrow_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="#features">{{ __('Features') }}</a></li>
                    @if(isset($services) && count($services) > 0)
                    <li><img class="footer_icons" src="{{asset('rbtheme/img/footer_arrow_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="#services">{{ __('Services') }}</a></li>
                    @endif
                    <li><img class="footer_icons" src="{{asset('rbtheme/img/footer_arrow_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="#about">{{ __('About us') }}</a></li>
                    <li><img class="footer_icons" src="{{asset('rbtheme/img/footer_arrow_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="#contact">{{ __('Contact') }}</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 footer-links">
                @if(isset($services) && count($services) > 0)
                <h4 class="text-white">{{ __('Our Services') }}</h4>
                <ul>
                    @if(isset($services) && !empty($services))
                    @foreach ($services as $key => $service)
                    @if($key < 5)
                    <li><img class="footer_icons" src="{{asset('rbtheme/img/footer_arrow_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="javascript:;">{{ucfirst($service->name)}}</a></li>
                    @endif
                    @endforeach
                    @endif
                </ul>
                @endif
            </div>

             <div class="col-lg-4 col-md-6 pl-lg-5 footer-links">
                <h4 class="text-white">{{ __('Contact Info') }}</h4>


                <p class="social_flex text-white"><img class="social_icons" src="{{asset('rbtheme/img/address_icon.svg')}}" alt="" class="img-fluid"> {{ (!empty($site->address)) ? ucfirst($site->address) : '-' }}<p>
                <p class="social_flex"><img class="social_icons" src="{{asset('rbtheme/img/call_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="{{ (!empty($site->phone)) ? 'tel:'.$site->phone : 'javascript:;' }}" class="text-black" target="_blank">{{ (!empty($site->phone)) ? $site->country_code.$site->phone : '-' }}</a></p>
                <p class="social_flex"><img class="social_icons" src="{{asset('rbtheme/img/email_icons.svg')}}" alt="" class="img-fluid"> <a class="text-white" href="{{ (!empty($site->email)) ? 'mailto:'.$site->email : 'javascript:;' }}" class="text-black" target="_blank">{{ (!empty($site->email)) ? $site->email : '-' }}</a></p>
               
            </div>

           

        </div>
    </div>
</div>