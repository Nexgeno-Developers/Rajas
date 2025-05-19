<!-- Modal -->
<div class="modal fade" id="loginModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Login') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('login') }}" method="post" id="login" autocomplete="off" data-recaptcha> 

                    {{ csrf_field() }}

                    <div class="row gx-2">

                        <div class="mb-3 col-sm-12">

                            <input class="form-control login-email" type="email" name="email" value=""
                                placeholder="{{ __('Email address') }}" autocomplete="off" />

                        </div>

                    </div>

                    <div class="row gx-2">

                        <div class="mb-3 col-sm-12">

                            <span toggle="loginPassword" class="toggle-password open"><i
                                    class="fa fa-eye-slash"></i></span>

                            <span toggle="loginPassword" class="toggle-password close d-none"><i
                                    class="fa fa-eye"></i></span>

                            <input class="form-control" type="password" name="password" value=""
                                placeholder="{{ __('Password') }}" autocomplete="off" id="loginPassword" />

                        </div>

                    </div>

                    <div class="row flex-between-center">

                        <div class="col-md-6">
                            <p class="fs--1 text-600 mb-0">{{ __("Don't have account?") }} <a href="#!" data-bs-toggle="modal"
                                    data-bs-target="#registerModel">{{ __('Register') }}</a></p>
                        </div>
                        <div class="col-md-6 float-right">
                            <p class="fs--1 text-600 mb-0 float-right"><a href="{{ route('password.forgot.mail') }}" data-bs-toggle="modal" data-bs-target="#forgotPasswordModel">{{ __('Forgot Password ?') }}</a></p>
                        </div>

                    </div>

                    <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit"
                            name="submit">{{ __('Login') }}</button></div>
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