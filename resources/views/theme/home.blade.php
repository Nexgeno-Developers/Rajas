@extends('layouts.home',['title' => trans('Home'), 'pagename' => trans('landing')])
@section('slider')
<!-- ======= Hero Section ======= -->


<div class="banner_section">
    <video autoplay="" loop="" muted="" playsinline="" class="w-100">
            <source src="{{asset('rbtheme/img/banner_video.mp4')}}" type="video/mp4">
    </video>
    <div class="banner_content">
        <h3>Soar Above the City with Rajas Helicopter Rides! </h3>
        <p>Unmatched adventure, stunning views—book your helicopter ride today!</p>
        <div class="button_design">
            <a href="">Book Your Ride Now <i class="bx bx-right-arrow-alt"></i></a>
        </div>
    </div>
</div>
<section id="hero" class=" align-items-center d-none">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
            data-aos="fade-up" data-aos-delay="200">
            <h1>{{ __('Choose') }} <span class="typed-text fw-bold" data-typed-text='["{{ __('Category') }}","{{ __('Service')}}", "@if($custom->employees == 1){{ __('Employee')}}@endif","{{ __('Time')}}"]'></span><br> {{ __('For Your Booking') }}</h1>
            <h2>{{ __("your_appointment") }}</h2>
            <div class="d-lg-flex">
                <a href="{{ route('appointment.book')}}" class="btn-get-started scrollto">{{ __('Click to Book Appointment') }}</a>
            </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
            <img src="{{asset('rbtheme/img/hero-img.png')}}" class="img-fluid animated" alt="">
        </div>
    </div>
</div>

</section><!-- End Hero -->
@endsection
    
@section('content')
    <!-- ======= Features Section ======= -->
    <section id="features" class="services section-bg d-none">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>{{ __('Features') }}</h2>
                <p>{{ __('Features_detail') }}</p>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bxl-dribbble"></i></div>
                        <h4><a>{{ __('Easy to Book Appointment') }}</a></h4>
                        <p>{{ __("Easy_Appointment") }}</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
                    data-aos-delay="200">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-file"></i></div>
                        <h4><a>{{ __('Available Time Slots') }}</a></h4>
                        <p>{{ __("Time_slot") }}</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
                    data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-tachometer"></i></div>
                        <h4><a>{{ __('Multiple Payment Options') }}</a></h4>
                        <p>{{ __("Multiple_Payment") }}</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
                    data-aos-delay="400">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-layer"></i></div>
                        <h4><a>{{ __('Email Reminder') }}</a></h4>
                        <p>{{ __("Email_Reminder_content") }}</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Features Section -->

    <!-- ======= Skills Section ======= -->
    <section id="features" class="skills d-none">
        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
                    <img src="{{ asset('rbtheme/img/skills.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
                    <h3>{{ __("Why your booking with us?") }}</h3>
                    <p class="font-italic">
                        {{ __("Appointment_Us") }} 
                    </p>

                    <div class="skills-content">

                        <div class="progress">
                            <span class="skill">{{ __('Customers') }} <i class="val">100%</i></span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        @if($custom->employees == 1)
                        <div class="progress">
                            <span class="skill">{{ __('Service Providers') }} <i class="val">90%</i></span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        @endif

                        <div class="progress">
                            <span class="skill">{{ __('Services') }} <i class="val">75%</i></span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="progress">
                            <span class="skill">{{ __('Categories') }} <i class="val">55%</i></span>
                            <div class="progress-bar-wrap">
                                <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section><!-- End Skills Section -->

    <!-- ======= Cta Section ======= -->
    <section id="features" class="cta d-none">
        <div class="container" data-aos="zoom-in">

            <div class="row">
                <div class="col-lg-9 text-center text-lg-left">
                    <h3>{{ __('Book Appointment') }}</h3>
                    <p>{{ __("Book_appointment_steps") }}</p>
                </div>
                <div class="col-lg-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="{{ route('appointment.book')}}">{{ __('Book Appointment') }}</a>
                </div>
            </div>

        </div>
    </section><!-- End Cta Section -->
    @if(isset($services) && count($services) > 0)
    <!-- ======= Service Section ======= -->
    <section id="services" class="portfolio d-none">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>{{ __('Services') }}</h2>
                <p>{{ __("We've multiple services with qualified service providers.") }}</p>
            </div>

            <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">{{ __('All') }}</li>
                @if(isset($categories) && !empty($categories))
                @foreach ($categories as $category)
                @if(count($category->services)> 0)
                <li data-filter=".filter-{{str_replace(' ','-',$category->name)}}">{{ ucfirst($category->name) }}</li>
                @endif
                @endforeach
                @endif
            </ul>

            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                @if(isset($services) && !empty($services))
                @foreach ($services as $service)
                <div class="col-lg-4 col-md-6 portfolio-item filter-{{!empty($service->categories) ? str_replace(' ','-',$service->categories->name) : '*'}}">
                    <div class="portfolio-img"><img src="{{(isset($service->image) && !empty($service->image)) ? asset('/img/services/'.$service->image) : asset('rbtheme/img/placeholder.jpeg')}}" class="img-fluid"
                            alt=""></div>
                    <div class="portfolio-info">
                        <h4>{{$service->name}}</h4>
                        <p>{{!empty($service->categories) ? $service->categories->name : 'General'}}</p>
                        <a href="{{(isset($service->image) && !empty($service->image)) ? asset('/img/services/'.$service->image) : asset('rbtheme/img/placeholder.jpeg')}}" data-gall="portfolioGallery"
                            class="venobox preview-link" title="{{$service->name}}"><i class="fa fa-eye"></i></a>
                    </div>
                </div>
                    
                @endforeach
                @endif
            </div>

        </div>
    </section><!-- End Service Section -->
    @endif

    <!-- ======= Employee Section ======= -->
    @if($custom->employees == 1)
    <section id="employees" class="team section-bg d-none">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>{{ __('Service Providers') }}</h2>
                <p>{{ __("Schedule your booking with us, We'll serve you better. We've a experienced staff for various services.") }}</p>
            </div>

            <div class="row">
                @if(!empty($employees))
                @foreach ($employees as $key => $employee)
                    <div class="col-lg-6 @if($key != 0) mt-4 mt-lg-0 @endif">
                        <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="100">
                            <div class="pic"><img src="{{ !empty($employee->profile) ? asset('/img/profile/'.$employee->profile) : asset('rbtheme/img/image.png')}}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>{{$employee->first_name.' '.$employee->last_name}}</h4>
                                @if(isset($employee->position) && !empty($employee->position))
                                <span>{{$employee->position}}</span>
                                @else
                                <span>{{ __('Employee') }}</span>
                                @endif
                                <p>{{$employee->first_name.' '.$employee->last_name}} {{ __('is Specialist. more info to:') }} {{$employee->email}}</p>
                                <div class="social">
                                    @if(isset($employee->twitter) && !empty($employee->twitter))
                                    <a href="{{$employee->twitter}}" target="_blank"><i class="ri-twitter-fill"></i></a>
                                    @else
                                    <a href="{{$site->twitter}}" target="_blank"><i class="ri-twitter-fill"></i></a>
                                    @endif
                                    @if(isset($employee->facebook) && !empty($employee->facebook))
                                    <a href="{{$employee->facebook}}" target="_blank"><i class="ri-facebook-fill"></i></a>
                                    @else
                                    <a href="{{$site->facebook}}" target="_blank"><i class="ri-facebook-fill"></i></a>
                                    @endif
                                    @if(isset($employee->instagram) && !empty($employee->instagram))
                                    <a href="{{$employee->instagram}}" target="_blank"><i class="ri-instagram-fill"></i></a>
                                    @else
                                    <a href="{{$site->instagram}}" target="_blank"><i class="ri-instagram-fill"></i></a>
                                    @endif
                                    @if(isset($employee->linkedin) && !empty($employee->linkedin))
                                    <a href="{{$employee->linkedin}}" target="_blank"> <i class="ri-linkedin-box-fill"></i> </a>
                                    @else
                                    <a href="{{$site->linkedin}}" target="_blank"> <i class="ri-linkedin-box-fill"></i> </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                @php $employee = \App\Entities\Employee::where('role_id', 1)->where('status', 1)->first(); @endphp
                <div class="col-lg-6">
                    <div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="100">
                        <div class="pic"><img src="{{ !empty($employee->profile) ? asset('/img/profile/'.$employee->profile) : asset('img/image.png')}}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>{{$employee->first_name.' '.$employee->last_name}}</h4>
                            @if(isset($employee->position) && !empty($employee->position))
                            <span>{{$employee->position}}</span>
                            @endif
                            <p>{{$employee->first_name.' '.$employee->last_name}} {{ __('is Specialist. more info to:') }} {{$employee->email}}</p>
                            <div class="social">
                                @if(isset($employee->twitter) && !empty($employee->twitter))
                                <a href="{{$employee->twitter}}" target="_blank"><i class="ri-twitter-fill"></i></a>
                                @endif
                                @if(isset($employee->facebook) && !empty($employee->facebook))
                                <a href="{{$employee->facebook}}" target="_blank"><i class="ri-facebook-fill"></i></a>
                                @endif
                                @if(isset($employee->instagram) && !empty($employee->instagram))
                                <a href="{{$employee->instagram}}" target="_blank"><i class="ri-instagram-fill"></i></a>
                                @endif
                                @if(isset($employee->linkedin) && !empty($employee->linkedin))
                                <a href="{{$employee->linkedin}}" target="_blank"> <i class="ri-linkedin-box-fill"></i> </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </section><!-- End Employee Section -->
    @endif

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about d-none">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>{{ __('About Us') }}</h2>
            </div>

            <div class="row content">
                <div class="col-lg-6">
                    <p>
                        {{ __('about', ['sitename' => $site->site_title]) }}
                    </p>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0">
                    <ul>
                        <li><i class="ri-check-double-line"></i> {{ __('Unlimited Categories') }}</li>
                        <li><i class="ri-check-double-line"></i> {{ __('Unlimited Services') }}</li>
                        <li><i class="ri-check-double-line"></i> {{ __('Unlimited Book Appointments') }}</li>
                    </ul>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg d-none">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>{{ __('Contact') }}</h2>
                <p>{{ __('Get connect with us.') }}</p>
            </div>

            <div class="row">

                <div class="col-lg-5 d-flex align-items-stretch">
                    <div class="info">
                        <div class="address">
                            <i class="icofont-google-map"></i>
                            <h4>{{ __('Location') }}:</h4>
                            <p>{{ (!empty($site->address)) ? ucfirst($site->address) : '-' }}</p>
                        </div>

                        <div class="email">
                            <i class="icofont-envelope"></i>
                            <h4>{{ __('Email') }}:</h4>
                            <p><a class="contact-email" href="{{(!empty($site->email)) ? 'mailto:'.$site->email : 'javascript:;'}}">{{ (!empty($site->email)) ? $site->email : '-' }}</a></p>
                        </div>

                        <div class="phone">
                            <i class="icofont-phone"></i>
                            <h4>{{ __('Call') }}:</h4>
                            <p><a class="contact-phone" href="{{(!empty($site->phone)) ? 'tel:'.$site->phone : 'javascript:;' }}">{{(!empty($site->phone)) ? $site->country_code.$site->phone : '-' }}</a></p>
                        </div>
                        <div class="map">
                            @if(isset($site->location) && !empty($site->location) && strpos($site->location, 'iframe') !== false)
                                {!!html_entity_decode($site->location) !!}
                            @elseif(isset($site->location) && !empty($site->location))
                                <iframe class="map location" style="min-width:100%" src="{!! html_entity_decode($site->location) !!}"></iframe>
                            @else
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119066.41264374652!2d72.75225623680046!3d21.15934583219656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e59411d1563%3A0xfe4558290938b042!2sSurat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1670587319456!5m2!1sen!2sin" width="800" height="600" frameborder="0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form action="{{ route('contact.email')}}" method="post" role="form" id="contact-form" class="php-email-form" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Full Name') }}</label>
                            <input type="text" name="contact_name" class="form-control" id="name" data-rule="minlen:4"
                                data-msg="{{ __('Please enter at least 4 characters') }}" />
                            <div class="validate"></div>
                        </div>

                        <input type="hidden" name="country_code" class="country_code" id="dialcode" value="{{ old('country_code') }} }}"  data-number="{{ old('phone') }}">
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('Phone') }}</label>
                                <input class="form-control mobile country-phone-validation" type="tel" name="contact_phone" autocomplete="off" placeholder="{{ __('Phone Number') }}" value=""  
                                data-name="{{ $site->country_name}}"/>
                                <div class="validate"></div>
                                <label id="valid-msg" style="color: green;" class="d-none phone-valid-msg">✓ {{ __('Phone Number Valid') }}</label>
                                <label id="error-msg" style="color: #bd5252;" class="d-none phone-error-msg"></label>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('Email') }}</label>
                                <input type="email" class="form-control" name="contact_email" id="email" data-rule="email"
                                    data-msg="{{ __('Please enter valid email') }}" />
                                <div class="validate"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('Message') }}</label>
                            <textarea class="form-control" name="customer_message" rows="10" data-rule="required"
                                data-msg="{{ __('Please enter comments') }}"></textarea>
                            <div class="validate"></div>
                        </div>
                        <div class="mb-3">
                            <div class="loading">{{ __('Loading') }}</div>
                            <div class="error-message"></div>
                            <div class="sent-message">{{ __('Your message has been sent. Thank you!') }}</div>
                        </div>
                        <div class="text-center"><button type="submit" class="btn-valid">{{ __('Send Message') }}</button></div>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->
@endsection

@section('footer-top')
    @include('theme.includes.footer-top')
@endsection

@section('script')
<script src="{{asset('backend/js/phone.js')}}"></script>

<script>
        $(document).ready(function () {
            var url_str = window.location.href;
            var url = new URL(url_str);
            var search_params = url.searchParams;
            if(search_params.get('token') != '' && search_params.get('token') != null) {
                $('#ResetPassword').modal('show');
            }
        });
</script>

@endsection