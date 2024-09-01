@extends('admin.layout.teampage')

@section('title', __('message.home'))

@section('content')
    <style>
        .tt-menu.tt-open {
            box-shadow: rgb(0 0 0 / 48%) 8px 7px 15px 0px;
        }

        .radio label {
            cursor: pointer;
        }

        @media screen {
            #printSection {
                display: none;
            }


        }

        @media print {
            body * {
                visibility:hidden;
            }
            #printSection, #printSection * {
                visibility:visible;
            }
            #printSection {
                position:absolute;
                left:0;
                top:0;
            }
            #printThis button{
                display: none;
            }
            #printThis .modal-title {
                text-align: center;
                width: 100%;
                font-size: 35px;

            }
            .modal-content #logo,
            .modal-content .modal-header .modal-title{
                display: none;
            }
            .modal-content {
                width: 400px;
            }
            .modal-content .card-body.card-block img{
              width: 130px;
            }
            #print_qr{
                display: block !important;
            }
        }

    </style>

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                @if(session('warning'))
                    <div class="alert alert-{{session('warning')}}" role="alert">
                        {{session('message')}}
                        <button type="button" class="close " data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap justify-content-end">
                            <h2 class="title-1 d-none">Overview</h2>
                            <button class="btn btn-danger btn-sm m-1"  data-toggle="modal"
                                    data-target="#scrollmodal" ><i class="zmdi zmdi-plus"></i> {{ __('message.add_item') }}</button>
                            <button  data-toggle="modal"
                                     data-target="#modal_print_qr_code" id="submit-btn" type="button" class="btn btn-primary btn-sm m-1">  <i class="fa fa-qrcode"></i> {{ __('message.qr_code') }}</button>
                        </div>
                    </div>
                </div>
                {{--                    {{dd()}}--}}
                <div class="row m-t-25">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <form id="list_cnb">
                            <table class="table table-borderless table-striped table-earning" id="myTable">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th> <!-- คอลัมน์ checkbox -->
                                    <th class="text-center">{{ __('message.modify') }}</th>
                                    <th>{{ __('message.id_code') }}</th>
                                    <th style="width: 100px">{{ __('message.address_land') }}</th>
                                    <th>{{ __('message.trial_code') }}</th>
                                    <th class="">{{ __('message.varieties_used') }}</th>
                                    <th class="">{{ __('message.planting_date')}}</th>
                                    <!-- <th class="text-right">{{$name['status']}}</th> -->
                                    <!-- <th class="text-right">Updated At</th> -->

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $row = 1;
                                //                                dd($basicInformation);
                                ?>
                                {{-- TODO loopTable --}}
                                @foreach ($basicInformation as $index => $val)
                                    <?php
                                    $value = json_decode($basicInformation[$index]->value, true);
                                    ?>
                                    <tr>
                                        <td> <input type="checkbox" class="select-row" id="{{$val->id}}" data-planting-date="{{$value['planting_date']}}" data-varieties-used="{{$value['varieties_used']}}"></td>
                                        <td>
                                            <div class="table-data-feature justify-content-center">
                                                @if($value['note'] != '')
                                                    <button id-note="{{$val->id}}" onclick="updateNote('{{$val->id}}',$(this).attr('data-original-title'))" class="item note" data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="{{$value['note']}}" type="button"> <i class="fa fa-comment" aria-hidden="true"></i>
                                                    </button>
                                                @endif
                                                    <button class="item" type="button">
                                                        <a href="{{url('admin/event/'.$val->id)}}" target="_blank">
                                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                                        </a>
                                                    </button>

{{--                                                 <button class="item"--}}
{{--                                                        data-placement="top" title=""--}}
{{--                                                        data-original-title="{{$value['trial_code']}}" data-toggle="modal"--}}
{{--                                                        data-target="#modalQrCode" id="{{$val->id}}" type="button">--}}
{{--                                                    <i class="fa fa-qrcode"></i>--}}

{{--                                                </button>--}}
                                                <button onclick="checkBasicInformationById('{{$val->id}}')" class="item"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Edit" type="button">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                                <button onclick="del('{{$val->id}}','{{$value['experiment_name']}}')" class="item" data-toggle="tooltip"
                                                        data-placement="top" title=""
                                                        data-original-title="Delete" type="button">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>

                                            </div>
                                        </td>
                                        <td>{{$val->id}}</td>
                                        <td onclick="checkBasicInformationById({{$val->id}})" class="text-uppercase">{{$value['experiment_name']}}</td>
                                        <td onclick="checkBasicInformationById({{$val->id}})" >{{$value['trial_code']}}</td>
                                        <td class=""><a style="color: #808080"  target="_blank">{{$value['varieties_used']}}</a></td>
                                        <td class="">{{$value['planting_date']}}</td>
                                        <!-- <td class="text-right">{{$status[$val->display]}}</td> -->
                                        <!-- <td class="text-right">{{$val->updated_at}}</td> -->

                                    </tr>

                                    <?php
                                    $row++
                                    ?>
                                @endforeach
                                </tbody>
                            </table>
{{--                            <button type="button" id="submit-btn">Submit</button>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->

    <!-- Modal Qr-Code-->
    <div id="printThis">
        <div class="modal fade" id="modalQrCode" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
             aria-hidden="true"
             data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="card-body card-block">
                                <div class="col-12 text-center">
                                    <img id="logo" width="100px" src="{{url('images/icon/logo.png')}}"
                                         alt="Herbal Health Tourism Phuket"/>
                                </div>
                                <div class="col-12">
                                    <div class="col-12 text-center">
                                        <img name="gen-qr-code" src="">
                                    </div>
                                    <div class="col-12 text-center">
                                        <div>
                                            <p>Staff</p>
                                            <img name="gen-bar-code" src=''/>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button id="btnPrint" type="button" class="btn btn-primary btn-sm">Print</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- END Modal Qr-Code-->

    <div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
         aria-hidden="true"
         data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">{{ __('message.plant_information_form') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="card-body card-block">
                            <form action="{{url('admin/inset')}}" method="post" enctype="multipart/form-data"
                                  class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input"
                                               class=" form-control-label">{{ __('message.planting_date') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="date" name="input[{{$input['planting_date']}}]"
                                               placeholder="{{$name['planting_date']}}"
                                               class="form-control" value="{{date('Y-m-d')}}">
                                        <small class="form-text text-muted">This is a help </small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input"
                                               class=" form-control-label">{{ __('message.number_plants') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input required type="number" id="text-input" name="input[{{$input['number_plants']}}]"
                                               placeholder="1-999" class="form-control" value="1" min="1" max="999" maxlength="3" oninput="this.value=this.value.slice(0, this.maxLength)">
                                        <small class="form-text text-muted">This is a help </small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-Radioslabel">{{ __('message.varieties_used') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input required type="text" name="input[{{$input['varieties_used']}}]"
                                               placeholder="{{ __('message.varieties_used') }}"
                                               class="form-control">
                                        <small class="form-text text-muted">This is a help </small>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-Radioslabel">{{ __('message.warehouse') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="input[{{$input['experiment_name']}}]"  class="form-control text-uppercase">expert
                                            <option selected value="">{{ __('message.please_select') }}</option>
                                            @foreach ($building as $index => $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Ex : Testxxxxxxx</small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="select" class=" form-control-label">{{ __('message.expert') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="input[{{$input['expert']}}][]" class="form-control select2"  multiple="multiple" >
                                            @foreach ($head_project as $key => $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input"
                                               class=" form-control-label">{{ __('message.coworker') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="input[{{$input['coworker']}}][]" class="form-control select2"  multiple="multiple" id="head_project">
                                            @foreach ($staff as $key => $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">This is a help </small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input"
                                               class=" form-control-label">{{ __('message.trial_code') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="input[{{$input['trial_code']}}]"
                                               placeholder="{{ __('message.trial_code') }}" class="form-control">
                                        <small class="form-text text-muted">This is a help </small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input"
                                               class=" form-control-label">{{ __('message.objective') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="input[{{$input['objective']}}]"
                                               placeholder="{{ __('message.objective') }}" class="form-control">
                                        <small class="form-text text-muted">This is a help </small>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input"
                                               class=" form-control-label">{{ __('message.research_center') }}</label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="help-block form-text">{{ __('message.research_center') }}</small>
                                        <input type="text" name="input[{{$input['research_center']}}]"
                                               placeholder="{{ __('message.co_partner') }}" class="form-control">
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <small class="help-block form-text">{{ __('message.year') }}</small>
                                        <input type="text" name="input[{{$input['year']}}]"
                                               placeholder="{{ __('message.year') }}" class="form-control">
                                    </div>
                                </div>
 {{--                            พื้นที่
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input"
                                               class=" form-control-label">{{ __('message.address_land') }}</label>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <small class="form-text text-muted">{{$name['coordinates']}}</small>
                                        <input type="text" id="text-input" name="input[{{$input['coordinates']}}]"
                                               placeholder="{{ __('message.Lat_Long') }}" class="form-control" value="7.9039729,98.3793559">
                                    </div>

                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input"
                                               class=" form-control-label">{{$name['sloping_area']}}</label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="help-block form-text">ลาดเอียง</small>
                                        <div class="input-group">
                                            <input type="text" name="input[{{$input['sloping_area']}}]"
                                                   placeholder="Number" class="form-control">
                                            <div class="input-group-addon">
                                                <i class="fa fa-percent"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <small class="help-block form-text">ทิศทาง </small>
                                        <input type="text" name="input[{{$input['direction']}}]"
                                               placeholder="{{$name['direction']}}" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input"
                                               class=" form-control-label">{{$name['soil_preparation']}}</label>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="help-block form-text">ไถดะ</small>
                                        <input type="text" name="input[{{$input['soil_preparation']}}]"
                                               placeholder="ไถดะ" class="form-control">

                                    </div>
                                    <div class="col-12 col-md-5">
                                        <small class="help-block form-text">{{$name['plow']}}</small>
                                        <input type="text" name="input[{{$input['plow']}}]" placeholder="ไถแปร"
                                               class="form-control">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input"
                                               class=" form-control-label">{{$name['trial_plan']}}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="input[{{$input['trial_plan']}}]"
                                               placeholder="{{$name['trial_plan']}}" class="form-control">
                                        <small class="form-text text-muted">This is a help </small>
                                    </div>
                                </div>
--}}
                                <div class="row form-group">
                                    <div class="col-12 col-md-4">
                                        <small class="form-text text-muted">{{ __('message.germination_date') }}</small>
                                        <input type="date" name="input[{{$input['germination_date']}}]"
                                               placeholder="{{$name['germination_date']}}"
                                               class="form-control">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="form-text text-muted">{{ __('message.repair_day') }}</small>
                                        <input type="date" name="input[{{$input['repair_day']}}]"
                                               placeholder="{{$name['repair_day']}}"
                                               class="form-control">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="form-text text-muted">{{ __('message.harvest_day') }}</small>
                                        <input type="date" name="input[{{$input['harvest_day']}}]"
                                               placeholder="{{$name['harvest_day']}}"
                                               class="form-control">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="form-text text-muted">{{ __('message.how_to_plant') }}</small>
                                        <input type="text" name="input[{{$input['how_to_plant']}}]"
                                               placeholder="{{ __('message.how_to_plant') }}"
                                               class="form-control">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="form-text text-muted">{{ __('message.seed_preparation') }}</small>
                                        <input type="text" name="input[{{$input['seed_preparation']}}]"
                                               placeholder="{{ __('message.seed_preparation') }}"
                                               class="form-control">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <small class="form-text text-muted">{{ __('message.address_land') }}</small>
                                        <input type="text" name="input[{{$input['address_land']}}]"
                                               placeholder="HHT PHUKET" value="HHT PHUKET"
                                               class="form-control">
                                    </div>
{{--                                    <div class="col-12 col-md-4">--}}
{{--                                        <small class="form-text text-muted">{{$name['planting_rate']}}</small>--}}
{{--                                        <input type="text" name="input[{{$input['planting_rate']}}]"--}}
{{--                                               placeholder="{{$name['planting_rate']}}"--}}
{{--                                               class="form-control">--}}
{{--                                    </div>--}}
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input"
                                               class=" form-control-label">{{ __('message.type_soil') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="input[{{$input['soil_type']}}]" class="form-control">
                                            <option selected>{{ __('message.please_select') }}</option>
                                            @foreach(__('message.soil') as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="textarea-input" class=" form-control-label">{{ __('message.note') }}</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <textarea name="input[{{$input['note']}}]" id="textarea-input" rows="9"
                                                  placeholder="{{ __('message.note') }}" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> {{ __('message.submit') }}
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> {{ __('message.reset') }}
                                    </button>
                                </div>
                                {{ csrf_field() }}

                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="print_qr_code">
        <div class="modal fade" id="modal_print_qr_code" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
             aria-hidden="true"
             data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel"></h5>
                        <div class="text-right w-100">
                            <button class="btn btn-danger btn-sm m-1" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button id="btnPrintQr" type="button" class="btn btn-primary btn-sm m-1">Print</button>
                        </div>

                        <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body-qr-code"> </div>
                </div>
            </div>
        </div>

    </div>
    <div id="print_qr" class="print_qr" style="display: none">

    </div>
    <link rel="stylesheet" href="{{url('location.thailand/dist/jquery.Thailand.min.css')}}">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/js/uikit.min.js"></script>

    <!-- dependencies for zip mode -->
    <script type="text/javascript" src="{{url('location.thailand/dependencies/zip.js/zip.js')}}"></script>
    <!-- / dependencies for zip mode -->

    <script type="text/javascript" src="{{url('location.thailand/dependencies/JQL.min.js')}}"></script>
    <script type="text/javascript" src="{{url('location.thailand/dependencies/typeahead.bundle.js')}}"></script>

    <script type="text/javascript" src="{{url('location.thailand/dist/jquery.Thailand.min.js')}}"></script>

    <script type="text/javascript">
        /******************\
         *     DEMO 1     *
         \******************/
        // demo 1: load database from json. if your server is support gzip. we recommended to use this rather than zip.
        // for more info check README.md

        $.Thailand({
            database: '{{url("location.thailand/database/db.json")}}',

            $district: $('#get_location_thailand [name="district"]'),
            $amphoe: $('#get_location_thailand [name="amphoe"]'),
            $province: $('#get_location_thailand [name="province"]'),
            $zipcode: $('#get_location_thailand [name="zipcode"]'),

            onDataFill: function (data) {
                console.info('Data Filled', data);
            },

            onLoad: function () {
                console.info('Autocomplete is ready!');
                $('#loader, .demo').toggle();
            }
        });

        // watch on change

        $('#demo1 [name="district"]').change(function () {
            console.log('ตำบล', this.value);
        });
        $('#demo1 [name="amphoe"]').change(function () {
            console.log('อำเภอ', this.value);
        });
        $('#demo1 [name="province"]').change(function () {
            console.log('จังหวัด', this.value);
        });
        $('#demo1 [name="zipcode"]').change(function () {
            console.log('รหัสไปรษณีย์', this.value);
        });

        /******************\
         *     DEMO 2     *
         \******************/
        // demo 2: load database from zip. for those who doesn't have server that supported gzip.
        // for more info check README.md
        $.Thailand({
            database: '{{url('location.thailand/database/db.zip')}}',
            $search: $('#address .input-address'),

            onDataFill: function (data) {
                console.log(data)
                var html = '<b>ที่อยู่:</b> ตำบล' + data.district + ' อำเภอ' + data.amphoe + ' จังหวัด' + data.province + ' ' + data.zipcode;
                $('#address-output').prepend('<div class="uk-alert-warning" uk-alert><a class="uk-alert-close" uk-close></a>' + html + '</div>');
            }

        });

        function checkBasicInformationById(id) {
            var goTo = '{{url('admin/profile/')}}/' + id;
            $.ajax({
                type: 'GET',
                // url: 'admin/profile/ajax/' + id,
                url: '{{url('admin/profile/ajax')}}/' + id,
                success: function (response) {
                    var status = response.status;
                    if (status) {
                        windowLocation(goTo);

                    } else if (!status) {
                        sweetAlert('error', response.message)
                    }

                }

            });
        }

        function windowLocation(url) {
            return window.location.href = url;
        }

        function sweetAlert(status, message) {
            Swal.fire({
                icon: status,
                title: message,
                text: 'Something went wrong!'
            });
        }

        function del(id,key) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this! \n"+ key,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {if(result.isConfirmed){
                window.location.href = '{{url('admin/delete')}}/'+id;
            }
        })
        };
        function updateNote(id, note){
            Swal.fire({
                input: 'textarea',
                inputLabel: 'Message',
                inputPlaceholder: 'Type your message here...',
                inputValue : note,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                Swal.fire(
                    'Save!',
                     result.value,
                    'success'
                );
                $.ajax({
                    type: 'POST',
                    data: {
                        id:id,
                        note:result.value,
                        _token:'{{csrf_token()}}'
                    },
                    url: '{{url('admin/profile/update/note')}}/' + id,
                    success: function (response) {
                        // console.log(d);
                        var   setNewNote = '[id-note='+ id +']';
                        $(setNewNote).attr("data-original-title", result.value);
                    }

                })
            }
        })
        }
        $(document).ready( function () {

            $('.select2').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });

            $('[data-target="#modalQrCode"]').mouseover(function (e) {
                var id = $(this).attr("id");
                var size = '250x250';
                var trialCode = $(this).attr("data-original-title");
                var genUrlQrCode = 'https://api.qrserver.com/v1/create-qr-code/?size='+size+'&data=https://www.propertynext.work/demo/cnb/public/admin/profile/'+id+'&choe=UTF-8';
                var genBarCode = 'https://barcode.tec-it.com/barcode.ashx?data='+id+'&code=Code128&translate-esc=true&dmsize=Default';

                $('img[name="gen-qr-code"]').attr('src',genUrlQrCode);
                $('img[name="gen-bar-code"]').attr('src',genBarCode);
                $('#modalQrCode #staticModalLabel').text(trialCode +'['+id+']');
            });
             // กำหนดตัวแปร table
             var table = $('#myTable').DataTable({
                "pageLength": 100,
                "lengthMenu": [50, 100, 200, 500, -1],
                'columnDefs': [
                    {
                        'targets': 0, // คอลัมน์ checkbox
                        'orderable': false, // ปิดการเรียงลำดับ
                        'className': 'select-checkbox',
                        'checkboxes': {
                            'selectRow': true
                        }
                    }
                ],
                'select': {
                    'style': 'multi'
                },
                'order': [[2, 'DESC']]
            });

            // ทำให้ checkbox ในหัวตารางสามารถเลือก/ไม่เลือกแถวทั้งหมดได้
            $('#select-all').on('click', function(){
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // เมื่อปุ่ม submit ถูกกด
            $('#submit-btn').on('click', function() {
                var selectedData = [];

                // Loop ผ่าน checkbox ที่ถูกเลือก
                $('#myTable input.select-row:checked').each(function() {
                    var id = this.id;
                    var plantingDate = $(this).data('planting-date');
                    var varietiesUsed = $(this).data('varieties-used');

                    selectedData.push({
                        id: id,
                        plantingDate: plantingDate,
                        varietiesUsed: varietiesUsed
                    });
                });

                // แสดงผลลัพธ์ใน console
                console.log(selectedData);
                var css = '<style type="text/css">#print_qr_code .label-container,.print_qr .label-container {width:230px;border:1px solid #b9bebb;padding:10px;text-align:center;background-color:#fff;display:inline-block;height:350px;box-sizing:border-box;page-break-inside:avoid}#print_qr_code .header,.print_qr .header{background-color:lightgray;padding:10px 0;font-size:18px}#print_qr_code .item-number,.print_qr .item-number{font-size:24px;font-weight:700}#print_qr_code .item-name,.print_qr .item-name{font-size:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:inline-block;width:100%}#print_qr_code .qr-code img,.print_qr .qr-code img{width:55%}#print_qr_code .barcode img,.print_qr .barcode img{margin:5px 0 0 0;width:35%}#print_qr_code{width:100%;text-align:center;margin:10px;display:flex;flex-wrap:wrap}@media print{.label-container{}.main{text-align:left;page-break-after:always}@page{size:A4;margin:10mm}}</style>';
                // เพิ่ม div ลงใน #print
                $('#print_qr_code .modal-body').empty(); // ล้าง #print ก่อน
                $('.print_qr').empty(); // ล้าง #print ก่อน

                $('#print_qr_code .modal-body').append(css);
                $('.print_qr').append(css);
                selectedData.forEach(function(data) {
                        var html = '<div class="label-container">' +
                            '<div class="header">' +
                            '<span>HHT</span>' +
                            '</div>' +
                            '<div class="item-number">' +
                            '<span>' + data.id + '</span>' +
                            '</div>' +
                            '<div class="">' + data.plantingDate +
                            '</div>' +
                            '<div class="item-name" style="font-size: 12px" id="qr-' + data.id + '">' + data.varietiesUsed +
                            '</div>' +
                            '<div class="qr-code">' +
                            '<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://www.propertynext.work/demo/cnb/public/admin/profile/' + data.id + '&choe=UTF-8" alt="QR Code">' +
                            '</div>' +
                            '<div class="barcode">' +
                            '<img src="https://barcode.tec-it.com/barcode.ashx?data=' + data.id + '&code=Code128&translate-esc=true&dmsize=Default" alt="Barcode">' +
                            '</div>' +
                            '</div>';
                        $('#print_qr_code .modal-body').append(html);
                        $('.print_qr').append(html);
                    }
                    );

            });



        } );



        function adjustFontSize(id) {
            var item = document.getElementById('qr-' + id);
            var fontSizeNumber = parseFloat(window.getComputedStyle(item).fontSize);
            console.log(fontSizeNumber,item.offsetWidth);
            while (item.offsetWidth > 120) {
                console.log(1);
                fontSizeNumber -= 1;
                item.style.fontSize = fontSizeNumber + 'px';
            }
        }



        document.getElementById("btnPrint").onclick = function () {
            printElement(document.getElementById("printThis"));
        }
        function printElement(elem) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById("printSection");

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            var title = $('[data-target="#modalQrCode"]').attr('data-original-title');

            window.print();
        }


        document.getElementById("btnPrintQr").onclick = function () {
            printElement(document.getElementById("print_qr"));
        }
        function printElement(elem) {
            var domClone = elem.cloneNode(true);

            var $printSection = document.getElementById("printSection");

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            var title = $('[data-target="#modal_print_qr_code"]').attr('data-original-title');

            window.print();
        }
    </script>
    <link rel="stylesheet" type="text/css" href="{{url('css/jquery.dataTables.min.css?v=1')}}"/>

    <script type="text/javascript" src="{{url('js/datatables.js')}}"></script>


@endsection

