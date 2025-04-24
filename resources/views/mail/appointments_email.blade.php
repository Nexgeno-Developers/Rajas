<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Appointment') }}</title>
</head>
<body>
    <div style="font-family:'Roboto,RobotoDraft,Helvetica,Arial,sans-serif',Arial,sans-serif;background:#e5e5e5;margin:0">
        <div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background:#e5e5e5;margin:0;padding:50px 15px">
            <table style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;max-width:700px;width:100%;margin:auto;border-top:4px solid #006161;border-spacing:0;background:#fff; padding:25px;">
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
                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-weight:600;font-size:14px;line-height:18px;color:#1e2538;margin-bottom:15px">
                            {{ __('Hi')}} {{ $name }},</p>

                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-weight:500;font-size:14px;line-height:18px;color:#73788b">
                            @if(isset($cancel_text) && $title == 'Appointment Cancellation' )
                                {{ $cancel_text }}
                            @elseif($appointment->status == 'pending')
                                @if($customer->email == $to)
                                    {{ __('You have a new appointment request. The appointment details are as below:')}} 
                                @elseif(isset($admin) && $admin->email == $to)
                                    {{ __("There is a new appointment request has been placed on $company_name. The appointment details are as below:") }}
                                @elseif($employee->email == $to)
                                    {{ __('Your appointment has been generated successfully. The appointment details are as below:') }}
                                @endif
                            @else 
                                {{ isset($approved_text) ? $approved_text : __('Your appointment has been approved.') }}
                            @endif
                            </p>

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
                                        @if($appointment->status == 'pending')
                                        <td>
                                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-weight:500;font-size:14px;line-height:18px;text-align:center;color:#60b158;margin:0;background:#f1fff0;border:1px solid #60b158;border-radius:3px;width:100px;padding:5px;margin-left:auto">{{ __('Created') }}</p>
                                        </td>
                                        @else
                                        <td>
                                            @if( $title == 'Appointment Cancellation')
                                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-weight:500;font-size:14px;line-height:18px;text-align:center;color:#fe0303;margin:0;background:#f1fff0;border:1px solid #fe0303;border-radius:3px;width:100px;padding:5px;margin-left:auto">{{ __('Canceled')}}</p>
                                            @else
                                            <p style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-weight:500;font-size:14px;line-height:18px;text-align:center;color:#60b158;margin:0;background:#f1fff0;border:1px solid #60b158;border-radius:3px;width:100px;padding:5px;margin-left:auto">{{ __('Approved')}}</p>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:10px">
                            <table style="width:100%;margin:auto;border-bottom:1px solid #ebecf2;padding-bottom:10px">
                                <tbody><tr>
                                    <td>
                                        <h2 style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:bold;color:#1e2538;line-height:22px">
                                            
                                            @if($title == 'Appointment Created')
                                            {{ __('Created') }}
                                            @elseif($title == 'Appointment Cancellation' )
                                            {{ __('Canceled') }}
                                            @else
                                            {{ __('Approved') }}
                                            @endif
                                            
                                            
                                        {{ __('by') }}: <u></u>{{ auth()->user()->first_name.' '.auth()->user()->last_name}}<u></u></h2>
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
                                            {{ __('Customer Email')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $customer->email }}
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
                                            {{ __('Employee Email')}}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $employee->email }}
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
                                            {{ __('Appointment Date') }}:
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
                                            {{ __('Appointment Time') }}:
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
                                            {{ __('Allowed Persons') }}:
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
                                            {{ __('Allowed Weight') }}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#73788b;line-height:20px">
                                            {{ $appointment->allowed_weight }} {{__("Kg")}}
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
                                            {{ __('Appointment Detail') }}:
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
                                            {{ __('Cancel Reason') }}:
                                        <span style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;font-size:14px;font-weight:normal;color:#4162e8;line-height:20px">
                                            {{ $appointment->cancel_reason }}
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    @endif
                    @include('mail.social_media')
                </tbody>
            </table>
        </div>
    </div>
    <!-- This Email is common for  custome & Employee during pay later feature-->
</body>
</html>