<div  class="modal fade" id="forgotPasswordModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgetpasswordLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0">

            <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Forgot Password') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-4 px-5">
                <form action="{{ route('password.forgot.mail') }}" method="post" id="forgot-password-form" autocomplete="off">

                    {{ csrf_field() }}
                    <div class="row gx-2">

                        <div class="mb-3 col-sm-12">
                                <input class="form-control" type="text" name="email" id="forgot-email"
                                autocomplete="off" placeholder="{{ __('Enter Email') }}"/>
                        </div>

                    </div>

                    <div class="row justify-content-center">

                        <div class="col-md-12">      
                        <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit"
                            name="submit">{{ __('Submit') }}</button></div>
                        </div>

                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                        <a href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#loginModel"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>