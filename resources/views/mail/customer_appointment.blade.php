<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('customer email') }}</title>
</head>
<body>
  <div style="font-family:'Roboto,RobotoDraft,Helvetica,Arial,sans-serif',Arial,sans-serif;background:#e5e5e5;margin:0">
  <div style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background:#e5e5e5;margin:0;padding:50px 15px">
  <table style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;max-width:700px;width:100%;margin:auto;border-top:4px solid #006161;border-spacing:0;background:#fff; padding:25px;">
    <thead>
      <tr>
        @env('local')
          @if(empty($site->logo))
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/6R6f0Gc9/logo.png" alt="{{ __('logo')}}"></th>
          @else
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/6R6f0Gc9/logo.png" alt="{{ __('logo')}}"></th>
          @endif
        @else
          @if(empty($site->logo))
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/6R6f0Gc9/logo.png" alt="{{ __('logo')}}"></th>
          @else
          <th style="text-align:left;"><img style="max-width: 150px;" src="https://i.ibb.co/6R6f0Gc9/logo.png" alt="{{ __('logo')}}"></th>
          @endif
        @endenv
        
      
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:10px;"></td>
      </tr>

      <tr>
        <td colspan="2" style="width:100%;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:14px;">{{ __('Dear') }}, {{ $customer->first_name.' '.$customer->last_name}}</span></p>
        </td>
      </tr>


      <tr>
        @if($appointment->status == 'Pending')
        <td >
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:block;min-width:150px">{{ __('Appointment status')}}</span>
          <b style="color:red;font-weight:normal;margin:0">{{ __('Pending')}}</b></p>
        </td>
        @else
        <td>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:block;min-width:150px">{{ __('Appointment status')}}</span>
          @if( $title == 'Appointment Cancellation')
          <b style="color:green;font-weight:normal;margin:0">{{ __('Canceled')}}</b></p>
          @else
          <b style="color:green;font-weight:normal;margin:0">{{ __('Approved')}}</b></p>
          @endif
        </td>
        @endif

         @if($appointment->payment->status == 'succeeded')
        <td>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:block;min-width:150px">{{ __('Payment status')}}</span>
          <b style="color:green;font-weight:normal;margin:0">{{ __('Paid')}}</b></p>
        </td>
        @else
        <td>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:block;min-width:150px">{{ __('Payment status')}}</span>
          <b style="color:red;font-weight:normal;margin:0">{{ __('Pending')}}</b></p>
        </td>
        @endif
      </tr>

      <tr>
        <td style="height:10px;"></td>
      </tr>
      
      <tr>
        <td style="width:50%;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">{{ __('Employee Name') }}</span>{{ $employee->first_name.' '.$employee->last_name}}</p>
        </td>
        <td style="width:50%;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">{{ __('Service Name') }}</span><b>{{ $appointment->category_id}}</b> - {{ $appointment->service_id}}</p>
        </td>
      </tr>
      <tr>
        <td style="width:50%;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">{{ __('Number of Persons')}}</span>  {{ $appointment->no_of_person_allowed }}</p>
        </td>
        <td style="width:50%;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">{{ __('Allowed Weight') }}</span> {{ $appointment->allowed_weight }} {{__('Kg')}} </p>
        </td>  
      </tr>      
      <tr>
        <td style="width:50%;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">{{ __('Appointment Date') }}</span>  {{date('d F Y', strtotime($appointment->date))}}</p>
        </td>
        <td style="width:50%;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">{{ __('Appointment Time') }}</span> {{ date('h:i:s A',strtotime($appointment->start_time)).' - '.date('h:i:s A',strtotime($appointment->finish_time))}} </p>
        </td>  
      </tr> 
      <tr>
        <td colspan="2" style="width:100%;vertical-align:top">
        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">{{ __('Appointment Details') }}</span> {{ $appointment->comments }}</p>
          @if($title == 'Appointment Cancellation')
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">{{ __('Cancel Reason') }}</span> {{ $appointment->cancel_reason }}</p>
          @endif
        </td>
      </tr>
      
    </tbody>
   
    <tfooter>
      <tr><td colspan="2"><hr></td></tr>
      <tr>
        <td colspan="2" style="font-size:14px;padding:10px 0px 0 0px;">
          <strong style="display:block;margin:0 0 10px 0;">{{ __('Regards') }}</strong> <b>{{ __('Address')}}:</b> {{ $site->address }}<br>
          <!-- <strong style="display:block;margin:0 0 10px 0;">{{ __('Regards') }}</strong> {{ $site->company_name }}<br><br> -->
          <b>{{ __('Phone')}}:</b> {{$site->phone}}<br>
        </td>
      </tr>
      <tr>
          <td style="padding:15px 0 0 0;">
                <!-- <table style="width:100%;margin:auto;max-width:250px;margin-left: 140px;">
                <tbody><tr>
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
              </tbody>
              </table> -->
          </td>
      </tr>
    </tfooter>
  </table>
</div>
</div>
  <!-- Sent to customer During Appointmnet book via payment gateway by customer -->
</body>
</html>