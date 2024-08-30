@extends('admin.layout.teampage')

@section('title', 'Evnt ID : '.$id)

@section('content')
    <style>
        .tags-container {
            margin-bottom: 15px;
        }

        .tag-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s, opacity 0.3s;
        }

        .tag-button:hover {
            background-color: #0056b3;
        }

        .tag-button.disabled:hover {
            cursor: no-drop;
        }

        .tag-button.disabled {
            background-color: #dcdcdc;
            color: #6c757d;
            opacity: 0.7;
            pointer-events: none; /* Prevent clicking */
        }

        .selected-tags {
            display: flex;
            flex-wrap: wrap;
        }

        .selected-tag {
            background-color: #f1f3f5;
            color: #495057;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            padding: 3px 6px;
            margin: 5px;
            display: flex;
            align-items: center;
            font-size: 10px;
        }

        .selected-tag .remove-tag {
            background: transparent;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-weight: bold;
            margin-left: 4px;
            font-size: 11px;
        }


        @import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap");
        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        :root {
            --c-grey-100: #f4f6f8;
            --c-grey-200: #e3e3e3;
            --c-grey-300: #b2b2b2;
            --c-grey-400: #7b7b7b;
            --c-grey-500: #3d3d3d;
            --c-blue-500: #688afd;
        }

        /* Some basic CSS overrides */


        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        a {
            color: inherit;
        }

        img {
            display: block;
            max-width: 100%;
        }

        /* End basic CSS override */
        .timeline {
            width: 85%;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            flex-direction: column;
            padding: 32px 0 32px 32px;
            border-left: 2px solid var(--c-grey-200);
            font-size: 1.125rem;
        }

        .timeline-item {
            display: flex;
            gap: 24px;
        }

        .timeline-item + * {
            margin-top: 24px;
        }

        .timeline-item + .extra-space {
            margin-top: 48px;
        }

        .new-comment {
            width: 100%;
        }

        .new-comment input#comment-input {
            border: 1px solid var(--c-grey-200);
            border-radius: 6px;
            height: 48px;
            padding: 0 16px;
            width: 100%;
        }

        .new-comment input::-moz-placeholder {
            color: var(--c-grey-300);
        }

        .new-comment input:-ms-input-placeholder {
            color: var(--c-grey-300);
        }

        .new-comment input::placeholder {
            color: var(--c-grey-300);
        }

        .new-comment input:focus {
            border-color: var(--c-grey-300);
            outline: 0;
            box-shadow: 0 0 0 4px var(--c-grey-100);
        }

        .timeline-item-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: -52px;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 0 0 6px #fff;
        }

        .timeline-item-icon svg {
            width: 20px;
            height: 20px;
        }

        .timeline-item-icon.faded-icon {
            background-color: var(--c-grey-100);
            color: var(--c-grey-400);
        }

        .timeline-item-icon.filled-icon {
            background-color: var(--c-blue-500);
            color: #fff;
        }

        .timeline-item-description {
            display: flex;
            padding-top: 6px;
            gap: 8px;
            color: var(--c-grey-400);
        }

        .timeline-item-description img {
            flex-shrink: 0;
        }

        .timeline-item-description a {
            color: var(--c-grey-500);
            font-weight: 500;
            text-decoration: none;
        }

        .timeline-item-description a:hover, .timeline-item-description a:focus {
            outline: 0;
            color: var(--c-blue-500);
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
            aspect-ratio: 1/1;
            flex-shrink: 0;
            width: 40px;
            height: 40px;
        }

        .avatar.small {
            width: 28px;
            height: 28px;
        }

        .avatar img {
            -o-object-fit: cover;
            object-fit: cover;
        }

        .comment {
            margin-top: 12px;
            color: var(--c-grey-500);
            border: 1px solid var(--c-grey-200);
            box-shadow: 0 4px 4px 0 var(--c-grey-100);
            border-radius: 6px;
            padding: 16px;
            font-size: 1rem;
        }

        .button {
            border: 0;
            padding: 0;
            display: inline-flex;
            vertical-align: middle;
            margin-right: 4px;
            margin-top: 12px;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            height: 32px;
            padding: 0 8px;
            background-color: var(--c-grey-100);
            flex-shrink: 0;
            cursor: pointer;
            border-radius: 99em;
        }

        .button:hover {
            background-color: var(--c-grey-200);
        }

        .button.square {
            border-radius: 50%;
            color: var(--c-grey-400);
            width: 32px;
            height: 32px;
            padding: 0;
        }

        .button.square svg {
            width: 24px;
            height: 24px;
        }

        .button.square:hover {
            background-color: var(--c-grey-200);
            color: var(--c-grey-500);
        }

        .show-replies {
            color: var(--c-grey-300);
            background-color: transparent;
            border: 0;
            padding: 0;
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 1rem;
            cursor: pointer;
        }

        .show-replies svg {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
        }

        .show-replies:hover, .show-replies:focus {
            color: var(--c-grey-500);
        }

        .avatar-list {
            display: flex;
            align-items: center;
        }

        .avatar-list > * {
            position: relative;
            box-shadow: 0 0 0 2px #fff;
            margin-right: -8px;
        }

    </style>

    <!-- MAIN CONTENT-->
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
                                <strong>Timeline events {{$id}} :  {{$info->value['varieties_used']}} </strong>
                            </div>


                            <div class="container">
                                <ol class="timeline">
                                    <li class="timeline-item">
		<span class="timeline-item-icon | avatar-icon">
			<i class="avatar">
				<img src="https://assets.codepen.io/285131/hat-man.png"/>
			</i>
		</span>

                                        <div class="col-md-12 p-0">
                                            <form action="{{url('admin/event/inset')}}" method="post"
                                                  enctype="multipart/form-data" id="comment-form">
                                                <div class="new-comment">
                                                    <div class="tags-container">
                                                        @foreach (__('message.tags') as $key => $value)
                                                            <button type="button" class="tag-button" @if($key == 'selling') style="background-color: #ff0000;" @endif
                                                            onclick="addTag('{{ $value }}', this)">{{ $value }}
                                                            </button>
                                                        @endforeach
                                                    </div>

                                                    <input type="text" id="comment-input" name="message"
                                                           placeholder="Add a comment..."
                                                           onkeydown="submitOnEnter(event)"/>
                                                    <div id="selected-tags" class="selected-tags"></div>
                                                    <input type="hidden" id="tags-input" name="tags">
                                                    <input type="hidden" value="{{$id ?? '' }}" name="id_basic_info"/>

                                                    <div class="col-md-12 m-1 text-right">
                                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save
                                                        </button>
                                                    </div>
                                                </div>
                                                {{ csrf_field() }}
                                            </form>




                                        </div>

                                    </li>
                                    @foreach ($data as $index => $value)
                                        <?php
                                        $val = json_decode($data[$index]->val_json, true);
                                        $tag = explode(',', $val['data']['tags']);
//                                        dd($tag);
                                        ?>
                                            <li class="timeline-item | extra-space m-0">
		<span class="timeline-item-icon | filled-icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
				<path fill="none" d="M0 0h24v24H0z"/>
				<path fill="currentColor"
                      d="M6.455 19L2 22.5V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H6.455zM7 10v2h2v-2H7zm4 0v2h2v-2h-2zm4 0v2h2v-2h-2z"/>
			</svg>
		</span>
                                                <div class="timeline-item-wrapper">
                                                    <div class="timeline-item-description">
                                                        <i class="avatar | small">
                                                            <img src="https://assets.codepen.io/285131/hat-man.png"/>
                                                        </i>
                                                        <span><a class="d-none" href="#">Yoan Almedia</a><time
                                                                datetime="{{$val['date']}}">{{$val['date']}}</time></span>
                                                    </div>
                                                    @if(!is_null($val['data']['message']) || !is_null($val['data']['tags']))
                                                    <div class="comment">
                                                        <p>{{$val['data']['message']}}</p>
                                                        @if(!is_null($val['data']['tags']))
                                                            @foreach ($tag as $value)
                                                                <button class="button"><p>{{$value}}</p></button>
                                                            @endforeach
                                                        @endif
                                                        <button class="button | square d-none">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                 width="24" height="24">
                                                                <path fill="none" d="M0 0h24v24H0z"/>
                                                                <path fill="currentColor"
                                                                      d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zM7 12a5 5 0 0 0 10 0h-2a3 3 0 0 1-6 0H7z"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @endif
                                                    <i class="avatar | small d-none">
                                                        <img src="{{url('images/tag.png')}}"/>
                                                    </i>
                                                    <button class="show-replies d-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="icon icon-tabler icon-tabler-arrow-forward" width="44"
                                                             height="44" viewBox="0 0 24 24" stroke-width="2"
                                                             stroke="currentColor" fill="none" stroke-linecap="round"
                                                             stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M15 11l4 4l-4 4m4 -4h-11a4 4 0 0 1 0 -8h1"/>
                                                        </svg>
                                                        Show 3 replies
                                                        <span class="avatar-list">

					<i class="avatar | small d-none">
						<img src="https://assets.codepen.io/285131/winking-girl.png"/>
					</i> <i class="avatar | small d-none">
						<img src="https://assets.codepen.io/285131/smiling-girl.png"/>
					</i>
				</span>
                                                    </button>
                                            </li>
                                    @endforeach
                                    <li class="timeline-item">
		<span class="timeline-item-icon | faded-icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
				<path fill="none" d="M0 0h24v24H0z"/>
				<path fill="currentColor" d="M12 13H4v-2h8V4l8 8-8 8z"/>
			</svg>
		</span>
                                        <div class="timeline-item-description">
                                            <i class="avatar | small">
                                                <img src="https://assets.codepen.io/285131/hat-man.png"/>
                                            </i>
                                            <span><a href="#">{{ __('message.planting_date') }} :</a> {{$info->value['planting_date']}}  <a
                                                    href="#">📚 </a>  <time datetime="{{$info->value['planting_date']}}"></time></span>
                                        </div>
                                    </li>

                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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


    <link rel="stylesheet" type="text/css" href="{{url('css/jquery.dataTables.min.css?v=1')}}"/>

    <script type="text/javascript" src="{{url('js/datatables.js')}}"></script>
    <script>
        function addTag(tag, button) {
            // ป้องกันการเพิ่มแท็กที่มีอยู่แล้ว
            const existingTags = Array.from(document.querySelectorAll('.selected-tag')).map(tag => tag.textContent.trim().replace('x', '').trim());
            if (existingTags.includes(tag)) {
                return;
            }

            // สร้างแท็กใหม่
            const tagsContainer = document.getElementById('selected-tags');
            const tagElement = document.createElement('div');
            tagElement.className = 'selected-tag';
            tagElement.textContent = tag;

            // สร้างปุ่มลบแท็ก
            const removeButton = document.createElement('button');
            removeButton.className = 'remove-tag';
            removeButton.textContent = 'x';
            removeButton.onclick = function () {
                tagsContainer.removeChild(tagElement);
                button.classList.remove('disabled');
                updateHiddenInput();
            };

            // เพิ่มปุ่มลบแท็กไปยังแท็กที่สร้าง
            tagElement.appendChild(removeButton);

            // เพิ่มแท็กใหม่ไปยัง container ของแท็กที่เลือก
            tagsContainer.appendChild(tagElement);

            // ปิดการใช้งานปุ่มที่ถูกคลิก
            button.classList.add('disabled');

            // อัปเดตค่าใน input ที่ซ่อนอยู่
            updateHiddenInput();
        }

        function updateHiddenInput() {
            const tags = Array.from(document.querySelectorAll('.selected-tag')).map(tag => tag.textContent.trim());
            // ลบ 'x' ออกจากแท็กหากมี
            document.getElementById('tags-input').value = tags.map(tag => tag.replace('x', '').trim()).join(',');
        }

        function submitOnEnter(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById('comment-form').submit();
            }
        }
    </script>
@endsection

