<div  class="modal fade" id="ResetPassword"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Reset Password') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
            <div class="modal-body py-4 px-5">
                <form action="{{ route('password.reset.form') }}" method="post" id="reset-password-form" autocomplete="off">

                    {{ csrf_field() }}
                    <div class="row gx-2">

                        <div class="mb-3 col-sm-12">
                              
                                <input class="form-control" type="text" name="email" id="emailAddress" value="{{ isset($email) ? $email : '' }}"
                                autocomplete="off" placeholder="{{ __('Enter Email') }}" readonly/>

                        </div>

                        <div class="mb-3 col-sm-12">

                                <span toggle="new-passwords" class="toggle-password open"><i
                                        class="fa fa-eye-slash"></i></span>

                                <span toggle="new-passwords" class="toggle-password close d-none"><i
                                        class="fa fa-eye"></i></span>

                                <input class="form-control" type="password" name="password" id="new-passwords"
                                    autocomplete="off" placeholder="{{ __('Enter Password') }}" />

                        </div>

                        <div class="mb-3 col-sm-12">

                            <span toggle="confirm-passwords" class="toggle-password open"><i
                                    class="fa fa-eye-slash"></i></span>

                            <span toggle="confirm-passwords" class="toggle-password close d-none"><i
                                    class="fa fa-eye"></i></span>

                            <input class="form-control" type="password" name="password_confirmation"
                                id="confirm-passwords" autocomplete="off"
                                placeholder="{{ __('Enter Confirm Password') }}" />

                        </div>

                    </div>
                    <div class="row justify-content-center">

                        <div class="col-md-12">      
                        <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit"
                            name="submit">{{ __('Submit') }}</button></div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('backend/js/custom.js') }}"></script>
@endsection
