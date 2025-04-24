<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin email') }}</title>
</head>
<body>
    <div style="font-family:'Roboto,RobotoDraft,Helvetica,Arial,sans-serif',Arial,sans-serif;background:#e5e5e5;margin:0">
        <div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background:#e5e5e5;margin:0;padding:50px 15px">
            <table style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;max-width:700px;width:100%;margin:auto;border-top:4px solid #006161;border-spacing:0;background:#fff;     padding: 25px;">
                 <thead>
      <tr>
        @env('local')
          @if(empty($site->logo))
          <th style="text-align:left;"><img style="max-width: 150px;" src="{{asset('rbtheme/img/logo.png')}}" alt="{{ __('logo')}}"></th>
          @else
          <th style="text-align:left;"><img style="max-width: 150px;" src="{{asset('rbtheme/img/logo.png')}}" alt="{{ __('logo')}}"></th>
          @endif
        @else
          @if(empty($site->logo))
          <th style="text-align:left;"><img style="max-width: 150px;" src="{{asset('rbtheme/img/logo.png')}}" alt="{{ __('logo')}}"></th>
          @else
          <th style="text-align:left;"><img style="max-width: 150px;" src="{{asset('rbtheme/img/logo.png')}}" alt="{{ __('logo')}}"></th>
          @endif
        @endenv
        
      </tr>
    </thead>
    <tbody>

     <tr>
                        <td style="padding:15px 0px 0">
                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-weight:600;font-size:14px;line-height:18px;color:#1e2538;margin-bottom:15px">{{ __('Hi')}} {{ $admin->first_name.' '.$admin->last_name}},</p>
                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-weight:500;font-size:14px;line-height:18px;color:#73788b"> {{ $customer->first_name.' '.$customer->last_name}} {{ __('Appointment is') }} 
                            @if( $title == 'Appointment Cancellation')
                                <span style="color:#ff0303">{{ __('Canceled') }}</span>
                            @else
                                <span style="color:#60b158">{{ __('Approved')}}</span>
                            @endif
                            {{ __('for')}} {{date('d F Y', strtotime($appointment->date))}}.</p>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding:10px 0px 0 0px;background:#fff">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:5px 0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">{{ $title }}</h2>
                                        </td>
                                        <td>
                                            @if( $title == 'Appointment Cancellation')
                                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-weight:500;font-size:14px;line-height:18px;text-align:center;color:#fe0303;margin:0;background:#f1fff0;border:1px solid #fe0303;border-radius:3px;width:100px;padding:5px;margin-left:auto">{{ __('Canceled') }}</p>
                                            @else
                                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-weight:500;font-size:14px;line-height:18px;text-align:center;color:#60b158;margin:0;background:#f1fff0;border:1px solid #60b158;border-radius:3px;width:100px;padding:5px;margin-left:auto">{{ __('Approved') }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:7px; padding-top:10px;">
                                <tbody><tr>
                                    <td>
                                        <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">
                                            @if( $title == 'Appointment Cancellation')
                                                {{ __('Canceled') }}
                                            @else
                                                {{ __('Approved') }}
                                            @endif
                                         
                                        {{ __('by')}}: <u></u>{{ $admin->first_name.' '.$admin->last_name}}<u></u></h2>
                                    </td>
                                    <td style="text-align:right">
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:500;color:#73788b;line-height:16px;max-width:160px">{{ date('D, d m Y h:i A')}}</span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                   
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Employee Name') }}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $employee->first_name.' '.$employee->last_name}}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Customer Name') }}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $customer->first_name.' '.$customer->last_name}}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Goverment ID') }}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $customer->goverment_id}}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>  
                    
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Service')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{$appointment->category_id.' - '.$appointment->service_id}}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>                    


                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Appointment Date')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{date('d F Y', strtotime($appointment->date))}}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                           {{ __('Appointment Time')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ date('h:i:s A',strtotime($appointment->start_time)).' - '.date('h:i:s A',strtotime($appointment->finish_time))}}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                           {{ __('Number of Persons')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $appointment->no_of_person_allowed }}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>    
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                           {{ __('Allowed Weight')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $appointment->allowed_weight }} {{__('Kg')}}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>                                    
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Appointment Detail')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $appointment->comments }}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Appointment Status') }}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#73788b;line-height:20px">
                                        @if($appointment->status == 'pending')
                                            {{ __('Pending') }}
                                        @else
                                            @if($title == 'Appointment Cancellation')
                                                {{ __('Canceled') }}
                                            @else
                                                {{ __('Approved') }}
                                            @endif
                                        @endif
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    @if($title == 'Appointment Cancellation')
                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#ff0000;line-height:20px;margin-bottom:5px">
                                            {{ __('Cancel Reason')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#4162e8;line-height:20px">
                                            {{ $appointment->cancel_reason }}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td style="padding:0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:20px;margin-bottom:5px">
                                            {{ __('Payment Status')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            <b>{{ ucfirst($appointment->payment->status) }}</b>
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:center;padding:20px 20px 0 20px">
                            <a href="{{ route('appointments.show',$appointment->id) }}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;background:#006161;padding:12px 30px;color:#ffffff;font-size:14px;font-weight:700;letter-spacing:0.5px;line-height:16px;border-radius:3px;text-decoration:none;display:inline-block" target="_blank">{{ __('Go to Website') }}</a>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td style="padding:10px 0px 0 0px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:3px">
                                <tbody><tr>
                                    <td>
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:500;color:#73788b;line-height:16px;text-align:center">
                                            {{ __('if button is not working') }} <a href="{{ route('appointments.show',$appointment->id) }}" style="margin:0;color:#1e2538;font-size:14px;font-weight:500;line-height:16px;display:inline-block" target="_blank">{{ __('click here') }}</a>
                                        </p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr> -->
                    <tr>
                        <td style="padding:15px 20px 10px 20px">
                            <table style="width:100%;margin:auto;padding-bottom:3px">
                                <tbody>
                                <!-- <tr>
                                    <td style="padding:0;text-align:center">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-style:italic;font-weight:normal;font-size:14px;line-height:18px;color:#1e2538;margin:0">{{ __('Please do not reply to this email. You are receiving this email because') }}<br>{{ __('you have created an account at')}} <a href="{{ route('welcome') }}" style="margin:0;color:#1e2538;font-size:14px;font-weight:500;line-height:16px;display:inline-block;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif" target="_blank">{{ $site->site_title }}</a>.</p>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td style="padding:15px 0 0 0">
                                        <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:16px;text-align:center">{{ __('Copyright © 2022')}} <a href="{{ route('welcome') }}" style="font-family: inherit;text-decoration: none;font-size: 14px;color: #73788b;font-weight: 700;" target="_blank">{{ $site->company_name }}</a>. {{ __('All rights reserved') }}.</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="padding:15px 0 0 0">
                                        <table style="width:100%;margin:auto;max-width:250px">
                                        <!-- <tbody><tr>
                                                    <td style="padding:0">
                                                    <a style="display:block"><img alt="{{ __('google') }}" height="19px" width="auto" title="{{ __('google') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/google.png')}}" /></a>
                                                    </td>
                                                    <td style="padding:0">
                                                    <a style="display:block"><img alt="{{ __('gmail') }}"  height="23px" width="auto" title="{{ __('gmail') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/gmail.jpg')}}" /></a>
                                                    </td>
                                                    <td style="padding:0">
                                                    <a style="display:block"><img alt="{{ __('instagram') }}"  height="23px" width="auto" title="{{ __('instagram') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/instagram.jpg')}}" /></a>
                                                    </td>
                                                    <td style="padding:0">
                                                        <a style="display:block"><img alt="{{ __('linkedin') }}"  height="26px" width="auto" title="{{ __('linkedin') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/linkedIn.jpg')}}" /></a>
                                                    </td>
                                                    <td style="padding:0">
                                                    <a style="display:block"><img alt="{{ __('facebook') }}" height="24px" width="auto" title="{{ __('facebook') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/facebook.png')}}" /></a>
                                                    </td>
                                                    <td style="padding:0">
                                                    <a style="display:block"><img alt="{{ __('twitter') }}"  height="26px" width="auto" title="{{ __('twitter') }}" style="display:block;margin:auto" src="{{asset('rbtheme/img/twitter.jpg')}}" /></a>
                                                    </td>
                                                </tr>
                                            </tbody></table> -->
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--When customer book the email sent to admin whcih is in site config table-->
</body>
</html>