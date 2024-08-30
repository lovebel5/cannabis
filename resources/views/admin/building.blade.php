@extends('admin.layout.teampage')

@section('title', $var['var']['name']['building'])

@section('content')
    <style>
        /*.select2-search.select2-search--inline{display: none}*/
        .lightbox-gallery{color:#000;overflow-x:hidden;width:100%}.lightbox-gallery p{color:#fff}.lightbox-gallery h2{font-weight:700;margin-bottom:40px;padding-top:40px;color:#fff}@media (max-width:767px){.lightbox-gallery h2{margin-bottom:25px;padding-top:25px;font-size:24px}}.lightbox-gallery .intro{font-size:16px;max-width:500px;margin:0 auto 40px}.lightbox-gallery .intro p{margin-bottom:0}.lightbox-gallery .photos{padding-bottom:20px}.lightbox-gallery .item{padding-bottom:30px;cursor:pointer}
        .zoom {
            transition: transform .2s;
        }

        .zoom:hover {
            -ms-transform: scale(1.3); /* IE 9 */
            -webkit-transform: scale(1.3); /* Safari 3-8 */
            transform: scale(1.3);
            color: #0c0c0c;
        }
        .zoom:hover i {
            color: #6793ea !important;
        }
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
                                <strong>{{ __('message.select_building') }}</strong><br>
                            </div>
{{--                            <div class="card-body card-block">--}}
{{--                            <div class="col-ms-12 text-center">--}}
                            <div class="container">
                                <div class="row">
                            @foreach($var['building'] as $index => $val)
                                <div class="col-sm text-uppercase zoom text-center">
                                    <a href="{{($val != 'null' ? url('admin/building/'.$val) : '')}}" title="{{$val}}" style="color: #757575;" >
                                    <i class="col-12 fa fa-home" style="font-size: 70px;padding: 40px 40px 10px 40px;"></i>
                                    <strong>{{$val}}</strong>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                    <button type="button" class="btn btn-primary" name="save-content-img"><i class="fa fa-floppy-o"></i>
                        Save
                    </button>
                    <button type="button" class="btn btn-danger" name="del-img-by-id" id=""><i
                            class="fa fa-recycle"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        function swalTopEnd(status) {
            Swal.fire({
                position: 'top-end',
                icon: status,
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            })
        }

        $(document).on("click", ".img-fluid", function () {
            var getImg = $(this).attr('src'); // or var clickedBtnID = this.src
            var getIDImg = $(this).attr('id'); // or var clickedBtnID = this.id
            $('.modal .img-fluid').attr({src: getImg})
            $('.modal [name="del-img-by-id"]').attr({id: getIDImg})

            $.ajax({
                type: 'GET',
                url: "{{url('admin/profile/get-img')}}/" + getIDImg,
                success: function (data) {
                    $('.modal input#cc-name').val(data.title);
                    $('.modal textarea#textarea-input').val(data.content);
                }
            });

        });

        //Delete Img
        $(document).on('click', '.modal [name="del-img-by-id"]', function () {
            var getImg = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) = > {
                if(result.isConfirmed
        )
            {
                $.ajax({
                    type: 'GET',
                    id_img: +getImg,
                    url: '{{url('admin/profile/del-img').'/'}}' + getImg,
                    success: function (response) {
                        console.log(response);
                        swalTopEnd(response.status);
                        $('[aria-label="Close"]').click();
                        $('div [data-toggle="modal"][id="' + getImg + '"]').remove();
                    }
                });
            }
        })
        });

        $(document).on('click', '[name="save-content-img"]', function () {
            var id = $('.modal button[name="del-img-by-id"]').attr('id');
            var title = $('.modal input#cc-name').val();
            var content = $('.modal textarea#textarea-input').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    title: title,
                    content: content,
                    _token: '{{csrf_token()}}'
                },
                url: '{{url('admin/profile/insert-content-img')}}',
                success: function (response) {
                    swalTopEnd(response.status);
                }
            });
        });
        $(document).ready(function () {
            $('.select2').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });

    </script>
@endsection
