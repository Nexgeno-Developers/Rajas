<tr>
    <td style="text-align:center;padding:20px 20px 0 20px">
        <a href="{{ route('appointments.show',$appointment->id) }}"
            style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;background:#006161;padding:12px 30px;color:#ffffff;font-size:14px;font-weight:700;letter-spacing:0.5px;line-height:16px;border-radius:3px;text-decoration:none;display:inline-block"
            target="_blank"
            data-saferedirecturl="https://www.google.com/url?q=https://hrms.ubsapp.com/L4mqbi0wHu/leave/view/624e707388889f627463d7a6/62fc8fd3cc91ba267575e861&amp;source=gmail&amp;ust=1661063257263000&amp;usg=AOvVaw135T0_ceGFD3IWv9TPZQim">{{ __('Go to Website')}}</a>
    </td>
</tr>
<!-- <tr>
    <td style="padding:15px 20px 0 20px">
        <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:15px">
            <tbody>
                <tr>
                    <td>
                        <p
                            style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:500;color:#73788b;line-height:16px;text-align:center">
                            {{ __('if button is not working') }} <a
                                href="{{ route('appointments.show',$appointment->id) }}"
                                style="margin:0;color:#007aff;font-size:14px;font-weight:500;line-height:16px;display:inline-block"
                                target="_blank">{{ __('click here') }}</a>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr> -->
<tr>
    <td style="padding:15px 20px 10px 20px">
        <table style="width:100%;margin:auto;padding-bottom:15px">
            <tbody>
                <!-- <tr>
                    <td style="padding:0;text-align:center">
                        <p
                            style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-style:italic;font-weight:normal;font-size:14px;line-height:18px;color:#1e2538;margin:0">
                            {{ __('Please do not reply to this email. You are receiving this email because')}}<br>{{ __('you have created an account at')}}
                            <a href="{{ route('welcome') }}"
                                style="margin:0;color:#007aff;font-size:14px;font-weight:500;line-height:16px;display:inline-block;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif"
                                target="_blank">{{ $site_name }}</a>.</p>
                    </td>
                </tr> -->
                <tr>
                    <td style="padding:15px 0 0 0">
                        <p
                            style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:16px;text-align:center">
                            {{ __('Copyright © 2022')}} <a href="{{ route('welcome') }}"
                                style="font-family: inherit;text-decoration: none;font-size: 14px;color: #73788b;font-weight: 700;"
                                target="_blank">{{ $company_name }}</a>.{{ __(' All rights reserved')}}.</p>
                    </td>
                </tr>
                <!-- <tr>
                    <td style="padding:15px 0 0 0">
                        <table style="width:100%;margin:auto;max-width:250px">
                            <tbody>
                                <tr>
                                    <td style="padding:0">
                                        <a style="display:block"><img alt="{{ __('google') }}" height="19px"
                                                width="auto" title="{{ __('google') }}"
                                                style="display:block;margin:auto"
                                                src="{{asset('rbtheme/img/google.png')}}" /></a>
                                    </td>
                                    <td style="padding:0">
                                        <a style="display:block"><img alt="{{ __('gmail') }}" height="23px" width="auto"
                                                title="{{ __('gmail') }}" style="display:block;margin:auto"
                                                src="{{asset('rbtheme/img/gmail.jpg')}}" /></a>
                                    </td>
                                    <td style="padding:0">
                                        <a style="display:block"><img alt="{{ __('instagram') }}" height="23px"
                                                width="auto" title="{{ __('instagram') }}"
                                                style="display:block;margin:auto"
                                                src="{{asset('rbtheme/img/instagram.jpg')}}" /></a>
                                    </td>
                                    <td style="padding:0">
                                        <a style="display:block"><img alt="{{ __('linkedin') }}" height="26px"
                                                width="auto" title="{{ __('linkedin') }}"
                                                style="display:block;margin:auto"
                                                src="{{asset('rbtheme/img/linkedIn.jpg')}}" /></a>
                                    </td>
                                    <td style="padding:0">
                                        <a style="display:block"><img alt="{{ __('facebook') }}" height="24px"
                                                width="auto" title="{{ __('facebook') }}"
                                                style="display:block;margin:auto"
                                                src="{{asset('rbtheme/img/facebook.png')}}" /></a>
                                    </td>
                                    <td style="padding:0">
                                        <a style="display:block"><img alt="{{ __('twitter') }}" height="26px"
                                                width="auto" title="{{ __('twitter') }}"
                                                style="display:block;margin:auto"
                                                src="{{asset('rbtheme/img/twitter.jpg')}}" /></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr> -->
            </tbody>
        </table>
    </td>

</tr>