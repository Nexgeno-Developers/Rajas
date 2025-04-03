<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Employee email') }}</title>
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
                        <td style="padding:15px 20px 0 20px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:15px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:16px;font-weight:bold;color:#007aff;line-height:20px;margin-bottom:5px">
                                            {{ __('Hi') }},
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:16px;font-weight:bold;color:#007aff;line-height:20px;margin-bottom:5px">
                                           {{ $employee->first_name.' '.$employee->last_name }}
                                        </span></p>
                                        <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:center">{{ __('google_link_mail_message', ['sitename' => $site_name])}}</div>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                   
                    <tr>
                        <td style="text-align:center;padding:20px 20px 20px 20px;">
                            <a href="{{ $googlecalendar }}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;background:#007aff;padding:12px 30px;color:#ffffff;font-size:14px;font-weight:700;letter-spacing:0.5px;line-height:16px;border-radius:3px;text-decoration:none;display:inline-block" target="_blank">{{ __('Verify') }}</a>
                        </td>
                    </tr>
                              
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>