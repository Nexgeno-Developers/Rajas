@extends('layouts.home', ['title' => trans('Dashboard')])
@section('css')
    <link rel="stylesheet" href="{{ asset('rbtheme/css/jquery.qtip.min.css') }}">
    <link rel="stylesheet" href="{{ asset('rbtheme/css/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('rbtheme/css/appointment-calender.css') }}">
@endsection
@section('content')
    <section class="py-0 overflow-hidden light" id="banner">
        <div class="bg-holder overlay">
        </div>

        <div class="container bg-light card mt-5 mb-0 p-3">
            <div class="card-body">
                <div class="table-responsive fs--1">
                    <table class="table table-striped border-bottom">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="border-0">{{ __('Category') }}</th>
                                <th class="border-0">{{ __('Service') }}</th>
                                <th class="border-0">{{ __('Addional Information') }}</th>
                                <th class="border-0 text-center">{{ __('Start Time') }}</th>
                                <th class="border-0 text-end">{{ __('End Time') }}</th>
                                <th class="border-0 text-end">{{ __('Appointment Date') }}</th>
                                <th class="border-0 text-end">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="border-200">
                                    <td class="align-middle">
                                        <p class="mb-0 text-nowrap">{{ ucfirst($appointment->category_id) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        @php 
                                            $service_img =  DB::table('services')->where('name',$appointment->service_id)->value('image') ?? null; 
                                        @endphp
                                        @if ($service_img)
                                            <img src="{{ asset('img/services/' . $service_img) }}" class=" mb-2 width140">
                                        @endif
                                        <p class="mb-0 text-nowrap">{{ ucfirst($appointment->service_id) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="mb-0 text-nowrap">Allowed Weight :
                                            {{ ucfirst($appointment->allowed_weight) }}</p>
                                        <p class="mb-0 text-nowrap">Allowed Persons :
                                            {{ ucfirst($appointment->no_of_person_allowed) }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ date('h:i a', strtotime($appointment->start_time)) }}</td>
                                    <td class="align-middle text-end">
                                        {{ date('h:i a', strtotime($appointment->finish_time)) }}</td>
                                    <td class="align-middle text-end">
                                        {{ date($custom->date_format, strtotime($appointment->date)) }}
                                    </td>
                                    <td>
                                        <a class="fc-daygrid-event ..." href="{{ route('customer-appointment', $appointment->id) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container bg-light card mt-lg-3 mb-5 p-3">
            <div id='appointment-calendar' class="card-body"></div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('rbtheme/js/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rbtheme/js/jquery.qtip.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/customer-appointment.js') }}"></script>

    {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.href.includes('dashboard')) {
            setTimeout(() => {
                const btn = document.querySelector('.fc-listWeek-button');
                if (btn) {
                    btn.click();
                } else {
                    setTimeout(() => {
                        const retryBtn = document.querySelector('.fc-listWeek-button');
                        if (retryBtn) {
                            retryBtn.click();
                        } else {
                            console.log('Second attempt also failed.');
                        }
                    }, 1000);
                }
            }, 1000); 
        }
    });
</script> --}}
@endsection
