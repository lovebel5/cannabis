
@extends('admin.layout.teampage')

@section('title', 'Building')

@section('content')
    <style>
        /*.select2-search.select2-search--inline{display: none}*/
        .lightbox-gallery{color:#000;overflow-x:hidden;width:100%}.lightbox-gallery p{color:#fff}.lightbox-gallery h2{font-weight:700;margin-bottom:40px;padding-top:40px;color:#fff}@media (max-width:767px){.lightbox-gallery h2{margin-bottom:25px;padding-top:25px;font-size:24px}}.lightbox-gallery .intro{font-size:16px;max-width:500px;margin:0 auto 40px}.lightbox-gallery .intro p{margin-bottom:0}.lightbox-gallery .photos{padding-bottom:20px}.lightbox-gallery .item{padding-bottom:30px;cursor:pointer}
    </style>
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @if(session('warning'))
                            <div class="alert alert-{{session('warning')}}" role="alert">
                                {{session('message')}}
                                <button type="button" class="close " data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header row">
                                <div class="col-6 col-md-6">
                                    <h2 class="title-1">{{ __('message.warehouse') }} : {{$id_building}}</h2>
                                </div>
                                <div class="col-6 col-md-6 text-right" name="add-item">

                                </div>

                            </div>
                            <div class="card-body card-block">
                                <form action="{{url('admin/building/insert')}}" id="building" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-lg-12 col-ms-12">
                                            <div class="card-body card-block">
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3">
                                                            <small class="form-text text-muted">{{ __('message.recording_date') }}</small>
                                                            <input type="date" value="{{date('Y-m-d')}}" name="form[date]"
                                                                  class="form-control" id="txtDate">
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <small class="form-text text-muted">{{ __('message.humidity') }}</small>
                                                            <input type="number" maxlength="2" value="{{($data) ? $data['moisture']:''}}" name="form[moisture]"
                                                                   placeholder="{{ __('message.humidity') }}" class="form-control" id="moisture" required>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <small class="form-text text-muted">{{ __('message.temperature') }}</small>
                                                            <input type="number" maxlength="3" value="{{($data) ? $data['temperature']:''}}" name="form[temperature]"
                                                                   placeholder="{{ __('message.temperature') }}" class="form-control" id="temperature" required>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <small class="form-text text-muted">{{ __('message.expert') }}</small>
                                                            <select name="form[expert][]" id="expert" class="form-control select2 " multiple autocomplete="on" required>
                                                                @if($data)
                                                                    @foreach($data['expert'] as $val)
                                                                        <option selected>{{$val}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <small class="form-text text-muted">{{ __('message.coworker') }}</small>
                                                            <select name="form[coworker][]" id="coworker" class="form-control select2" multiple autocomplete="on" required>
                                                                @if($data)
                                                                    @foreach($data['coworker'] as $val)
                                                                        <option selected>{{$val}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <small class="form-text text-muted">{{ __('message.watering') }}</small>
                                                            <input type="text" value="{{($data) ? $data['give_water']:''}}" name="form[give_water]"
                                                                   placeholder="{{ __('message.watering') }}" class="form-control" id="give_water" required>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <small class="form-text text-muted">{{ __('message.fertilizing') }}</small>
                                                            <input type="text" value="{{($data) ? $data['fertilize']:''}}" name="form[fertilize]"
                                                                   placeholder="{{ __('message.fertilizing') }}" class="form-control" id="fertilize" required>
                                                        </div>
                                                        <div class="col-12 col-md-3">

                                                            <small class="form-text text-muted">{{ __('message.soil_type') }}</small>
                                                            <select id="soil_type" name="form[soil_type]" class="form-control" required>
                                                                <option value="0" selected="">ดินร่วนปนทราย</option>
                                                                <option value="1">ดินร่วนเหนียว</option>
                                                                <option value="2">ดินร่วนเหนียวปนทราย</option>
                                                                <option value="3">ดินร่วน</option>
                                                                <option value="4">อื่นๆ</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-12">
                                                            <small  class="form-text text-muted">{{ __('message.note') }}</small>
                                                        </div>
                                                        <div class="col-12 col-md-12">
                                                            <textarea name="form[note]" id="textarea-input" rows="9"
                                                                      placeholder="{{ __('message.note') }}"
                                                                      class="form-control"></textarea>
                                                        </div>

                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-dot-circle-o"></i>{{ __('message.submit') }}
                                                        </button>
                                                        <button type="reset" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-ban"></i> {{ __('message.reset') }}
                                                        </button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ csrf_field() }}
                                    <input name="form[building]" value="{{$id_building}}" class="d-none">
                                </form>

                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <div class="table-responsive m-b-40">
                                            <table class="table table-borderless table-data3" id="myTable">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('message.date') }}</th>
                                                    <th>{{ __('message.humidity') }}</th>
                                                    <th>{{ __('message.temperature') }}</th>
                                                    <th>{{ __('message.watering') }}</th>
                                                    <th>{{ __('message.fertilizing') }}</th>
                                                    <th>{{ __('message.type_soil') }}</th>
                                                    <th>{{ __('message.expert') }}</th>
                                                    <th>#</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                $row_number  = 1;

                                                ?>
                                                @foreach ($row as $index => $val)
                                                    <?php
                                                        $value = json_decode($row[$index]->value, true)
                                                    ?>
                                                    <tr>
                                                        <td>{{$row_number}}</td>
                                                        <td>{{$row[$index]->date}}</td>
                                                        <td>{{$value['moisture']}}</td>
                                                        <td>{{$value['temperature']}}</td>
                                                        <td>{{$value['give_water']}}</td>
                                                        <td>{{$value['fertilize']}}</td>
                                                        <td>{{$value['soil_type']}}</td>
                                                        <td>
                                                            @foreach ($value['expert'] as $val)
                                                                {{$val.','}}
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <div class="table-data-feature">
                                                                <button onclick="getDataBuildingEachDay({{$row[$index]->id}})" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                </button>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $row_number++
                                                    ?>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        $(function(){
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;

            // or instead:
            // var maxDate = dtToday.toISOString().substr(0, 10);
            // $('#txtDate').attr('min', maxDate);
            $("form[name='building']").validate({
                // Specify validation rules
                rules: {
                    firstname: "required",
                    lastname: "required",
                    email: {
                        required: true,
                        // Specify that email should be validated
                        // by the built-in "email" rule
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 5
                    }
                },
                // Specify validation error messages
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    email: "Please enter a valid email address"
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
        //
          $(document).ready(function () {
            var table = $('#myTable').DataTable();
            $('.select2').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });

          function getDataBuildingEachDay(id) {
              $.ajax({
                  type: 'GET',
                  url: '{{url('admin/building/edit-building-each')}}/' + id,
                  success: function (response) {
                      var value = JSON.parse(response.date.value, true);
                        // console.log(value['note']);
                      $('#txtDate').val(response.date.date);
                      $('#moisture').val(value['moisture']);
                      $('#temperature').val(value['temperature']);
                      $('#give_water').val(value['give_water']);
                      $('#fertilize').val(value['fertilize']);
                      $("#soil_type").prop("selectedIndex", value['soil_type']).val();
                      $('#textarea-input').val(value['note']);
                      $("[name=submit]").html("<i class=\"fa fa-dot-circle-o\"></i> {{ __('message.update') }} ");
                      $('.title-1').html("{{ __('message.edit') }} : "+response.date.building+" ["+ response.date.date +"]");
                      $('[name=add-item]').html("<button type='button' onclick='window.location.reload()' class='btn btn-primary btn-sm'> <i class='fa fa-dot-circle-o'></i> New</button>");
                      $('#building').attr('action','{{url('admin/building/edit-building-each/update')}}/'+response.date.id);

                      var coworker = value['coworker'];
                      var expert = value['expert'];
                      var coworkerText = [];
                      var expertText = [];

                      $.each(coworker, function(index, value) {
                          coworkerText += "<option selected> " + value + " </option>\n";
                      });
                      $.each(expert, function(index, value) {
                          expertText += "<option selected> " + value + " </option>\n";
                      });

                      $('#coworker option').remove();
                      $('#coworker').append(coworkerText);

                      $('#expert option').remove();
                      $('#expert').append(expertText);

                  }

              })
          }


    </script>
    @if(session('id'))
        <script>
            setTimeout(getDataBuildingEachDay({{session('id')}}),1000)
        </script>
    @endif
    <link rel="stylesheet" type="text/css" href="{{url('css/jquery.dataTables.min.css?v=1')}}"/>

    <script type="text/javascript" src="{{url('js/datatables.js')}}"></script>
@endsection
