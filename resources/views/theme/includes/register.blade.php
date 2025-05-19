<div  class="modal fade" id="registerModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content border-0">

        <div class="modal-header position-relative modal-shape-header bg-shape">
            <h5 class="modal-title" id="staticBackdropLabel">{{ __('Register') }}</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">

          <form action="{{ route('register') }}" method="post" id="sign-up-form" autocomplete="off" data-recaptcha>

            {{ csrf_field() }}

            <div class="row gx-2 d-none">

                <div class="mb-3 col-sm-12">

                  <div class="form-check form-check-inline">

                    <input type="radio" name="role_id" class="form-check-input" value="2" id="customer_role" checked>

                    <label for="customer_role" class="form-check-label">{{ __('Customer') }}</label>

                  </div>

                  {{--<div class="form-check form-check-inline">

                    <input type="radio" name="role_id" class="form-check-input" value="3" id="employee_role">

                    <label for="employee_role" class="form-check-label">{{ __('Employee') }}</label>

                  </div>--}}

                </div>

            </div>

            <div class="row gx-2">

                <div class="mb-3 col-sm-6"><input class="form-control" type="text" name="first_name" autocomplete="off" placeholder="{{ __('First Name') }}" value="{{ session('google_name') ?? '' }}" /></div>
 
                <div class="mb-3 col-sm-6"><input class="form-control" type="text" name="last_name" autocomplete="off" placeholder="{{ __('Last Name') }}" /></div>

            </div>  
            <input type="hidden" name="country_name" id="iso2R" class="country-name" value="">
            <input type="hidden" name="country_code" class="country_code" id="dialcodeR" value="" data-country="" data-number="">
            <div class="row gx-2">

                <div class="mb-3 col-sm-6"><input class="form-control" type="email" name="email" autocomplete="off" placeholder="{{ __('Email Address') }}" value="{{ session('google_email') ?? '' }}" /></div>
 
                <div class="mb-3 col-sm-6">
                  <input class="form-control mobile reg country-phone-validation" type="tel" name="mobile" autocomplete="off" placeholder="{{ __('Phone Number') }}" id="bootstrap-wizard-phone" data-wizard-validate-phone="true" data-name="{{ Auth::user()->country_name ?? $site->country_name }}"/>
                 
                  <label id="valid-msg" style="color: green;" class="d-none phone-valid-msg">✓ {{__('Phone Number Valid')}}</label>
                  <label id="error-msg" style="color: #bd5252;" class="d-none phone-error-msg"></label>
                </div>
            </div>

            <div class="row gx-2">

              <div class="mb-3 col-sm-12">

                <span toggle="password" class="toggle-password open"><i class="fa fa-eye-slash"></i></span>

                <span toggle="password" class="toggle-password close d-none"><i class="fa fa-eye"></i></span>

                <input class="form-control" type="password" name="password" id="password" autocomplete="off" placeholder="{{ __('Password') }}"/>

              </div>

              <div class="mb-3 col-sm-12">

                <span toggle="password_confirmation" class="toggle-password open"><i class="fa fa-eye-slash"></i></span>

                <span toggle="password_confirmation" class="toggle-password close d-none"><i class="fa fa-eye"></i></span>

                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" autocomplete="off" placeholder="{{ __('Confirm Password') }}" />

              </div>

            </div>

            <p class="fs--1 text-600 mb-0">{{ __('Have an account?') }} <a href="#!" data-bs-toggle="modal" data-bs-target="#loginModel">{{ __('Login') }}</a></p>

            <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ __('Register') }}</button></div>

          </form>

          <a href="{{ route('auth.google') }}">
              <button class="google_btn">
                  Login with
                  <img src="/assets/images/google.svg" alt="google icon" class="google_icon" />
              </button>
          </a>  

        </div>

      </div>

    </div>

  </div>

@section('script')
<script src="{{ asset('backend/js/phone.js') }}"></script>
@endsection