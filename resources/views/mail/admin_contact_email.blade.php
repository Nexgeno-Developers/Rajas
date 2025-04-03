<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin email')}}</title>
</head>
<body>
    <div style="font-family:'Roboto,RobotoDraft,Helvetica,Arial,sans-serif',Arial,sans-serif;background:#e5e5e5;margin:0">
        <div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background:#e5e5e5;margin:0;padding:50px 15px">
            <table style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;max-width:700px;width:100%;margin:auto;border-top:4px solid #ffa700;border-spacing:0;background:#fff">
                <tbody>
                    <tr>
                        <td style="padding:15px 20px 0 20px;background:#fff">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:15px">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:5px 0;font-size:16px;font-weight:bold;color:#1e2538;line-height:22px">{{ $title }}</h2>
                                        </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 20px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:10px">
                                <tbody><tr>
                                    <td>
                                        <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">
                                        {{ __('Customer Name') }}: <u></u>{{ $name }}<u></u></h2>
                                    </td>
                                    <td style="text-align:right">
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:500;color:#73788b;line-height:16px;max-width:160px">{{ date('D, d m Y h:i A')}}</span>
                                    </td>
                                   
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 20px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:10px">
                                <tbody><tr>
                                    <td>
                                        <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">
                                        {{ __('Customer Email') }}: <u></u>{{ $email }}<u></u></h2>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 20px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:10px">
                                <tbody><tr>
                                    <td>
                                        <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">
                                       {{ __('Customer Phone Number') }}: <u></u>{{ $phone }}<u></u></h2>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 20px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:10px">
                                <tbody><tr>
                                    <td>
                                        <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">
                                       {{ __('Customer message')}}: <u></u>{{ $customer_message }}<u></u></h2>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;padding:20px 20px 0 20px">
                            <a href="{{ route('welcome') }}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;background:#007aff;padding:12px 30px;color:#ffffff;font-size:14px;font-weight:700;letter-spacing:0.5px;line-height:16px;border-radius:3px;text-decoration:none;display:inline-block" target="_blank">{{ __('View Details') }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px 20px 0 20px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:15px">
                                <tbody><tr>
                                    <td>
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:500;color:#73788b;line-height:16px;text-align:center">
                                            {{ __('if button is not working click here') }} <a href="{{ route('welcome') }}" style="margin:0;color:#007aff;font-size:14px;font-weight:500;line-height:16px;display:inline-block" target="_blank">{{ __('Login here')}}</a>
                                        </p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px 20px 0 20px">
                            <table style="width:100%;margin:auto;padding-bottom:15px">
                                <tbody><tr>
                                    <td style="padding:0;text-align:center">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-style:italic;font-weight:normal;font-size:14px;line-height:18px;color:#1e2538;margin:0">{{ __('Please do not reply to this email. You are receiving this email because')}}<br>{{ __('you have created an account at') }} <a href="{{ route('welcome') }}" style="margin:0;color:#007aff;font-size:14px;font-weight:500;line-height:16px;display:inline-block;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif" target="_blank">{{ $site_name }}</a>.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 0 0 0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:16px;text-align:center">{{ __('Copyright © 2022')}} <a href="{{ route('welcome') }}" style="font-family: inherit;text-decoration: none;font-size: 14px;color: #73788b;font-weight: 700;" target="_blank">{{ $company_name }}</a>.{{ __('All rights reserved.')}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 0 0 0">
                                        <table style="width:100%;margin:auto;max-width:250px">
                                            <tbody><tr>
                                                <td style="padding:0">
                                                <a style="display:block"><img alt="{{ __('google')}}" height="20px" width="auto" title="{{ __('google')}}" style="display:block;margin:auto" src="{{asset('rbtheme/img/google.png')}}" /></a>
                                                </td>
                                                <td style="padding:0">
                                                <a style="display:block"><img alt="{{ __('gmail') }}" height="25px" width="auto" title="{{ __('gmail') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/gmail.jpg')}}" /></a>
                                                </td>
                                                <td style="padding:0">
                                                <a style="display:block"><img alt="{{ __('instagram') }}" height="25px" width="auto" title="{{ __('instagram') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/instgram.jpg')}}" /></a>
                                                </td>
                                                <td style="padding:0">
                                                    <a style="display:block"><img alt="{{ __('linkedin') }}" height="25px" width="auto" title="{{ __('linkedin') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/linkedin.jpg')}}" /></a>
                                                </td>
                                                <td style="padding:0">
                                                <a style="display:block"><img alt="{{ __('facebook') }}" height="25px" width="auto" title="{{ __('facebook') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/facebook.png')}}" /></a>
                                                </td>
                                                <td style="padding:0">
                                                <a style="display:block"><img alt="{{ __('twitter') }}" height="25px" width="auto" title="{{ __('twitter') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/twitter.jpg')}}" /></a>
                                                </td>
                                            </tr>
                                            
                                        </tbody></table>
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