<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Reset Password') }}</title>
</head>
<body>
    <div style="font-family:'Roboto,RobotoDraft,Helvetica,Arial,sans-serif',Arial,sans-serif;background:#e5e5e5;margin:0">
        <div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background:#e5e5e5;margin:0;padding:50px 15px">
            <table style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;max-width:700px;width:100%;margin:auto;border-top:4px solid #006161;border-spacing:0;background:#fff; padding:25px;">
                <thead>
      <tr>
        @env('local')
          @if(empty($site->logo))
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/Fkn5XXqp/logo.png" alt="{{ __('logo')}}"></th>
          @else
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/Fkn5XXqp/logo.png" alt="{{ __('logo')}}"></th>
          @endif
        @else
          @if(empty($site->logo))
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/Fkn5XXqp/logo.png" alt="{{ __('logo')}}"></th>
          @else
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/Fkn5XXqp/logo.png" alt="{{ __('logo')}}"></th>
          @endif
        @endenv
        
      </tr>
    </thead>
    
    <tbody>
                    <tr>
                        <td style="padding:15px 0px 0 0px;background:#fff">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:15px">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:5px 0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">{{ $title }}</h2>
                                        </td>   
                                        <!-- <td style="text-align:right;padding-right:20px;margin-bottom:10px;">
                                            <img src="{{ $logo }}" alt="logo" style="width:30px;">
                                        {{-- <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:5px 0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">{{ $logo }}</h2> --}}
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px 0px 0 0px">  
                            <table style="width:100%;margin:auto;border-bottom:0px solid #ebecf2;padding-bottom:15px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#006161;line-height:20px;margin-bottom:5px">
                                            {{ __('Hi') }},
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#006161;line-height:20px;margin-bottom:5px">
                                          {{ $name }}
                                        </span></p>
                                        <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;">{{ __('Please click the button and reset your password')}}.</div>

                                        <div style="padding:20px 0px 20px 0px;">
                                            <a href="{{ $url }}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;background:#006161;padding:12px 30px;color:#ffffff;font-size:14px;font-weight:700;letter-spacing:0.5px;line-height:16px;border-radius:3px;text-decoration:none;display:inline-block" target="_blank">{{ __('Click to reset password') }}</a>
                                        </div>

                                        <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;margin-bottom:20px;">{{ __('If you did not request a password reset, no further action is required') }}.</div>
                                        {{-- <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;">Regards,</div>
                                        <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;">ReadyBook</div> --}}

                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                   
                   
                              
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>