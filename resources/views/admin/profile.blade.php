@extends('admin.layout.teampage')

@section('title', $data->value['experiment_name'])

@section('content')
<style>
    /*.select2-search.select2-search--inline{display: none}*/
    .lightbox-gallery{color: #000;overflow-x: hidden;width: 100%}.lightbox-gallery p{color:#fff}.lightbox-gallery h2{font-weight:bold;margin-bottom:40px;padding-top:40px;color:#fff}@media (max-width:767px){.lightbox-gallery h2{margin-bottom:25px;padding-top:25px;font-size:24px}}.lightbox-gallery .intro{font-size:16px;max-width:500px;margin:0 auto 40px}.lightbox-gallery .intro p{margin-bottom:0}.lightbox-gallery .photos{padding-bottom:20px}.lightbox-gallery .item{padding-bottom:30px;cursor: pointer;}
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
                            <div class="card-header">
                                <strong>Basic Form</strong> Elements
                            </div>
                            <div class="card-body card-block">
                                <div class="col-12 text-left">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://www.propertynext.work/demo/cnb/public/admin/profile/{{$data->id}}&chs=100x100&choe=UTF-8">
                                    <img style="width: auto;height: 70px" src="https://barcode.tec-it.com/barcode.ashx?data={{$data->id}}&code=Code128&translate-esc=true&dmsize=Default">
                                </div>
                                <form action="{{url('admin/profile/update/'.$data->id)}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                                
                                    <div class="row form-group">
                                    <div class="col-12 col-md-3">
                                           <!-- วันที่ปลูก -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['planting_date']}}</small>
                                            <input type="date"
                                                   value="{{$data->value['planting_date']}}"
    {{--                                                   value="{{date('d-m-Y')}}"--}}
                                                   name="input[{{$var['input']['planting_date']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
{{--                                        {{dd($data,$building)}}--}}
                                        <div class="col-12 col-md-3">
                                            <small
                                                class="form-text text-muted">{{$var['name']['experiment_name']}}</small>
                                            <select name="input[{{$var['input']['experiment_name']}}]" class="form-control text-uppercase">
                                                    @foreach ($building as $value)
                                                        <option  value="{{$value}}" {{($data->value['experiment_name'] == $value) ? 'selected':''}}>{{$value}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                
                                        <div class="col-12 col-md-3">
                                                <!-- รหัสการทดลอง -->
                                            <small class="form-text text-muted">{{$var['name']['trial_code']}}</small>
                                            <input type="text" value="{{$data->value['trial_code']}}"
                                                   name="input[{{$var['input']['trial_code']}}]" placeholder="Text"
                                                   class="form-control">
                                        </div>
                                  
                                        <div class="col-12 col-md-3">
                                            <small class="form-text text-muted">{{$var['name']['objective']}}</small>
                                            <input type="text" value="{{$data->value['objective']}}"
                                                   name="input[{{$var['input']['objective']}}]" placeholder="Text"
                                                   class="form-control">
                                        </div>
                                        <!-- หัวหน้าโรงเรือน -->
                                        <div class="col-12 col-md-3">
{{--                                            {{dd($data->value)}}--}}
                                            <small class="form-text text-muted">{{$var['name']['expert']}}</small>
                                            <select name="input[expert][]" class="form-control select2" multiple="multiple">
                                                @if(isset($data->value['expert']))
                                                @foreach ($data->value['expert'] as $value)
                                                    <option value="{{$value}}" selected>{{$value}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <!-- เจ้าหน้าที่ประจำโรงเรื่อน -->
                                        <div class="col-12 col-md-3">
                                            <small
                                                class="form-text text-muted">{{$var['name']['coworker']}}</small>
                                            <select name="input[coworker][]" class="form-control select2" multiple="multiple">
                                                @if(isset($data->value['coworker']))
                                                    @foreach ($data->value['coworker'] as $value)
                                                        <option value="{{$value}}" selected>{{$value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                       
                                        <div class="col-12 col-md-3">
                                            <!-- po-partner -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['research_center']}}</small>
                                            <input type="text"
                                                   value="{{$data->value['research_center']}}"
                                                   name="input[{{$var['input']['research_center']}}]" placeholder="Text"
                                                   class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- ฤดี-ปี -->
                                            <small class="form-text text-muted">{{$var['name']['year']}}</small>
                                            <input type="text" value="{{$data->value['year']}}"
                                                   name="input[{{$var['input']['year']}}]" placeholder="Text"
                                                   class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- สถานที่ -->
                                            <small class="form-text text-muted">{{$var['name']['address_land']}}</small>
                                            <input type="text" value="{{$data->value['address_land']}}"
                                                   name="input[{{$var['input']['address_land']}}]" placeholder="Text"
                                                   class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- พิกัด -->
                                            <small class="form-text text-muted">{{$var['name']['coordinates']}}</small>
                                            <input type="text" value="{{$data->value['coordinates']}}"
                                                   name="input[{{$var['input']['coordinates']}}]" placeholder="Text"
                                                   class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- พื้นที่ -->
                                            <small class="form-text text-muted">{{$var['name']['sloping_area']}}</small>
                                            <div class="input-group">
                                            <input type="text" value="{{$data->value['sloping_area']}}"
                                                   name="input[{{$var['input']['sloping_area']}}]" placeholder="Text"
                                                   class="form-control">
                                            <div class="input-group-addon">
                                                <i class="fa fa-percent"></i>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- ทิศทาง -->
                                            <small class="form-text text-muted">{{$var['name']['direction']}}</small>
                                            <input type="text" value="{{$data->value['direction']}}"
                                                   name="input[{{$var['input']['direction']}}]" placeholder="Text"
                                                   class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- ไถแปร -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['plow']}}</small>
                                            <input type="text"
                                                   value="{{$data->value['plow']}}"
                                                   name="input[{{$var['input']['plow']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- แผนการทอดลอง -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['trial_plan']}}</small>
                                            <input type="text"
                                                   value="{{$data->value['trial_plan']}}"
                                                   name="input[{{$var['input']['trial_plan']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- วิธีการปลูก -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['how_to_plant']}}</small>
                                            <input type="text"
                                                   value="{{$data->value['how_to_plant']}}"
                                                   name="input[{{$var['input']['how_to_plant']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                    
                                        <div class="col-12 col-md-3">
                                            <!-- วันที่งอก -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['germination_date']}}</small>
                                            <input type="date"
                                                   value="{{$data->value['germination_date']}}"
                                                   name="input[{{$var['input']['germination_date']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- อัตราปลูก -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['planting_rate']}}</small>
                                            <input type="text"
                                                   value="{{$data->value['planting_rate']}}"
                                                   name="input[{{$var['input']['planting_rate']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- พันะุ์ที่ใช้ -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['varieties_used']}}</small>
                                            <input type="text"
                                                   value="{{$data->value['varieties_used']}}"
                                                   name="input[{{$var['input']['varieties_used']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <!-- การเตรียมเมล็ดพันธ์ -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['seed_preparation']}}</small>
                                            <input type="text"
                                                   value="{{$data->value['seed_preparation']}}"
                                                   name="input[{{$var['input']['seed_preparation']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                        <!-- วันปลูกซ่อมหรือถอดแยก -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['repair_day']}}</small>
                                            <input type="date"
                                                   value="{{$data->value['repair_day']}}"
                                                   name="input[{{$var['input']['repair_day']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                        <!-- วันเก็บเกี่ยว -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['harvest_day']}}</small>
                                            <input type="date"
                                                   value="{{$data->value['harvest_day']}}"
                                                   name="input[{{$var['input']['harvest_day']}}]"
                                                   placeholder="Text" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                        <!-- ประเภทดิน -->
                                            <small
                                                class="form-text text-muted">{{$var['name']['soil_type']}}</small>
                                            <select name="input[{{$var['input']['soil_type']}}]" class="form-control">
                                                @foreach ($soil_type as $key => $value)
                                                    @if($data->value['soil_type'] == $key)
                                                        <option value="{{$key}}" selected>{{$value}}</option>
                                                    @else
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col col-md-12">
                                            <small
                                                class="form-text text-muted">Gallery :</small>
                                            <div class="lightbox-gallery">
                                                <div class="container">
                                                    <div class="row photos">
                                                        @foreach ($img as $key => $value)
                                                            <div data-toggle="modal" data-target="#exampleModal" class="col-sm-6 col-md-4 col-lg-2 item" id="{{$value->id}}"><img class="img-fluid" id="{{$value->id}}" src="{{url('upload/image/'.$value->name_img)}}"></div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-md-3">
                                            <small
                                                class="form-text text-muted">Photos (Max : 2 MB.) Extension not allowed, please choose a JPEG or PNG file.</small>
                                        </div>

                                        <div class="col-12 col-md-12">
                                            <input type="file"  name="upload_img[]"  multiple class="form-control-file">
                                        </div>
                                        <div class="col col-md-12"></div>
                                        <div class="col col-md-3">
                                            <small
                                                class="form-text text-muted">บันทึกเตือนความจำ</small>
                                        </div>

                                        <div class="col-12 col-md-12">
                                            <textarea name="input[note]" id="textarea-input" rows="9" placeholder="Note..." class="form-control">{{$data->value['note']}}</textarea>
                                        </div>

                                    </div>
                                    {{ csrf_field() }}
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button onclick="location.reload();" type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </form>

                                <div class="row m-t-30">
                                    <div class="col-md-12">

                                        <div class="table-responsive m-b-40">
                                            <table class="table table-borderless table-data3">
                                                <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>วันที่<sup class="text-uppercase">[โรงเรือน]</sup></th>
                                                    <th>ความชื้น</th>
                                                    <th>อุณหภูมิ</th>
                                                    <th>การให้น้ำ</th>
                                                    <th>การให้ปุ๋ย</th>
                                                    <th>รหัสดิน</th>
                                                    <th>หัวหน้าโรงเรือน</th>
                                                    <th>หัวหน้าโรงเรือน</th>
                                                    <th>Note</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $row_number  = 1;
                                                ?>
                                                @foreach ($row_building_info as $index => $val)
                                                    <?php
                                                    $value = json_decode($row_building_info[$index]->value, true)
                                                    ?>
                                                    <tr>
                                                        <td>{{$row_number}}</td>
                                                        <td>{{$value['date']}}<sup class="text-uppercase">{{$value['building']}}</sup></td>
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
                                                        <td><i class="fas fa-comments"></i></td>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Photos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="col-md-12" style="display: inline-flex;">
                        <div class="col-md-5">
                            <img class="img-fluid" src="">
                        </div>
                        <div class="col-md-7">
                            <div class="form-group has-success">
                                <label for="cc-name" class="control-label mb-1">Title :</label>
                                <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid"
                                       data-val="true" data-val-required="Please enter the name on card"
                                       autocomplete="cc-name" aria-required="true" aria-invalid="false"
                                       aria-describedby="cc-name-error" placeholder="Title...">
                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                      data-valmsg-replace="true"></span>
                            </div>
                            <div class="form-group has-success">
                                <label for="cc-name" class="control-label mb-1">Contect :</label>
                                <textarea name="textarea-input" id="textarea-input" rows="9" placeholder="Content..."
                                          class="form-control"></textarea>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" name="save-content-img"><i class="fa fa-floppy-o"></i> Save</button>
                    <button type="button" class="btn btn-danger" name="del-img-by-id" id=""><i
                            class="fa fa-recycle"></i> Delete
                    </button>
                </div>
        </div>
    </div>
</div>
    <script type="application/javascript">
        function swalTopEnd(status){
            Swal.fire({
                position: 'top-end',
                icon: status,
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            })
        }
        $(document).on("click",".img-fluid", function () {
            var getImg = $(this).attr('src'); // or var clickedBtnID = this.src
            var getIDImg = $(this).attr('id'); // or var clickedBtnID = this.id
           $('.modal .img-fluid').attr({src : getImg})
           $('.modal [name="del-img-by-id"]').attr({id : getIDImg})

            $.ajax({
                type: 'GET',
                url: "{{url('admin/profile/get-img')}}/"+getIDImg,
                success: function (data) {
                    $('.modal input#cc-name').val(data.title);
                    $('.modal textarea#textarea-input').val(data.content);
                }
            });

        });

        //Delete Img
        $(document).on('click','.modal [name="del-img-by-id"]', function () {
            var getImg = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    id_img : + getImg,
                    url: '{{url('admin/profile/del-img').'/'}}' + getImg,
                    success: function (response) {
                        console.log(response);
                        swalTopEnd(response.status);
                        $('[aria-label="Close"]').click();
                        $('div [data-toggle="modal"][id="'+getImg+'"]').remove();
                    }
                });
            }
        })
        });

        $(document).on('click','[name="save-content-img"]', function () {
            var id = $('.modal button[name="del-img-by-id"]').attr('id');
            var title = $('.modal input#cc-name').val();
            var content = $('.modal textarea#textarea-input').val();
            $.ajax({
                type: 'POST',
                dataType:'json',
                data:{
                    id : id,
                    title : title,
                    content :  content,
                    _token : '{{csrf_token()}}'
                },
                url: '{{url('admin/profile/insert-content-img')}}',
                success: function (response) {
                    swalTopEnd(response.status);
                }
            });
        });
        $(document).ready(function() {
            $('.select2').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });

    </script>
@endsection
