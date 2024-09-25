@extends('admin.layout.teampage')

@section('title', __('message.weather') )

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>{{ __('message.weather') }}</strong>
                            </div>
                            <div class="container">

                                    <style>
                                        .weather-card {

                                        }
                                        .weather-icon {
                                            font-size: 2rem;
                                        }
                                        .day {

                                            font-weight: bold;
                                        }
                                        .temp {

                                            color: #333333;
                                        }
                                        .rain-chance {
                                            color: #007bff;
                                        }
                                        .wind-speed {
                                            color: #6c757d;
                                        }
                                        .temp .tc_max{
                                            font-weight: bold;

                                        }
                                        .temp p{
                                            display: contents;
                                        }

                                    </style>


                                <div class="container mt-5">
                                    <h2 class="mb-4">สภาพอากาศ 10 วัน</h2>
                                    <!-- ตัวอย่างหนึ่งวัน -->
                                    @foreach($weather as $val)
                                    <div class="weather-card row align-items-center">
                                            <div class="col-12 col-md-2 col-sm-12 text-center">
                                                <div class="day">{{$val['time']}}</div>
                                            </div>
                                            <div class="col-12 col-md-2 col-sm-12 text-center">
                                                <div class="temp"><p class="tc_max">33°</p>/<p class="tc_min">33°</p></div>
                                            </div>
                                            <div class="col-12 col-md-3 col-sm-12 text-center">
                                                <p class="weather-icon">🌤️</p>

                                            </div>
                                            <div class="col-12 col-md-2 col-sm-12 text-center">
                                                <div class="rain-chance">62%</div>
                                            </div>
                                            <div class="col-12 col-md-3 col-sm-12 text-center">
                                                <div class="wind-speed">ตะวันตกเฉียงเหนือ 18 กม./ชม.</div>
                                            </div>
                                    </div>
                                    <hr>
                                     @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
