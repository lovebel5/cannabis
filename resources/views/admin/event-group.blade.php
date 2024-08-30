@extends('admin.layout.teampage')

@section('title', __('message.event') )

@section('content')
    <style>
        #reader {
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        #startButton {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        @media only screen and (max-width: 768px) {
            #reader {
                max-width: 100%;
                width: 100%;
            }

            video {
                width: 100%;
            }
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
        @media (max-width: 991px) {
            .main-content {
                padding-top: 0px;
                padding-bottom: 100px;
            }
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
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <strong>{{ __('message.qr_code_scanner') }}</strong>
                            </div>
                            <div class="container">
                                <h2 id="title" class="text-center">QR Code Scanner</h2>
                                <div id="reader"></div>
                                <ol class="timeline">
                                    <div class="col-md-12 p-0">
                                        <div class="new-comment">
                                            <form id="results-list">
                                                <div class="tags-container">
                                                    @foreach (__('message.tags') as $key => $value)
                                                        <button type="button" class="tag-button" @if($key == 'selling') style="background-color: #ff0000;" @endif
                                                                onclick="addTag('{{ $value }}', this)">{{ $value }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                <input type="text" id="text-input" name="message"
                                                       placeholder="{{ __('message.add_comment') }}" class="form-control">
                                                <div id="selected-tags" class="selected-tags"></div>
                                                <input type="hidden" id="tags-input" name="tags">
                                                <input type="hidden" value="" name="id_basic_info"/>
                                                <div class="col-md-12 m-1 text-right">
                                                    {{--                                                    <button type="submit" class="btn btn-success btn-sm"><i--}}
                                                    {{--                                                            class="fas fa-save"></i> Save--}}
                                                    {{--                                                    </button>--}}
                                                    <button type="button" id="startButton">{{ __('message.start_scan_qr_code') }}</button>
                                                </div>
                                                {{ csrf_field() }}
                                            </form>
                                            <div id="list_qr_code">
                                                <p></p>
                                            </div>
                                        </div>
                                    </div>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript" src="{{ url('scan/html5-qrcode.min.js') }}"></script>
    <script>


        let scanningAllowed = false; // ตัวแปรในการควบคุมการสแกน
        const beep = new Audio('{{ url('scan/beep-08b.wav') }}');
        const scannedCodes = new Set(); // Set สำหรับติดตาม QR code ที่สแกนแล้ว
        let html5QrCode; // ประกาศตัวแปร global สำหรับ Html5Qrcode

        // ฟังก์ชันในการจัดรูปแบบวันที่และเวลา
        function setDate() {
            const date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // เดือน 1-12
            const day = String(date.getDate()).padStart(2, '0'); // วัน 1-31
            const hours = String(date.getHours()).padStart(2, '0'); // ชั่วโมง 0-23
            const minutes = String(date.getMinutes()).padStart(2, '0'); // นาที 0-59
            const seconds = String(date.getSeconds()).padStart(2, '0'); // วินาที 0-59

            return `${hours}:${minutes}:${seconds}`;

        }


        function onScanSuccess(decodedText, decodedResult) {
            if (!scanningAllowed) {
                return; // หยุดหากไม่อนุญาตให้สแกน
            }

            const h2 = document.getElementById('title');
            // const resultsList = document.getElementById('results-list');
            const resultsList = document.getElementById('list_qr_code');
            const listItem = document.createElement('p');
            const idInfo = decodedText.split('/').pop();




            // ตรวจสอบว่ารหัส QR Code นี้ถูกสแกนไปแล้วหรือไม่
            if (scannedCodes.has(decodedText)) {
                // h2.textContent = 'Scanned this time ' + idInfo;
                // h2.setAttribute('style', 'color: #ff0000');
                console.log(`รหัส QR Code นี้ถูกสแกนไปแล้ว: ${decodedText}`);
                return;
            }

            console.log(`รหัส QR Code ถูกสแกน: ${decodedText}`);

            // เพิ่มรหัสที่สแกนแล้วลงใน Set
            scannedCodes.add(decodedText);

            // เพิ่มรหัสที่สแกนแล้วลงใน <form>
            if (!isNaN(parseFloat(idInfo)) && isFinite(idInfo)) {

                var date = setDate();
                const form = document.querySelector('#results-list');
                const formData = new FormData(form);
                const formObject = {};
                formData.forEach((value, key) => {
                    formObject[key] = value;
                });

                formObject['id_basic_info'] = idInfo;
                formObject['date'] = date;
                listItem.textContent = idInfo + ' ' + date + ' ' +formObject.message + ' ' + formObject.tags ;
                resultsList.prepend(listItem); // เพิ่มรายการใหม่ไปที่ด้านบนสุดของ <form>

                // เล่นเสียงปิ๊บ

                // listItem.textContent = idInfo +' '+ date ;
                // resultsList.prepend(listItem); // เพิ่มรายการใหม่ไปที่ด้านบนสุดของ <form>

                // เล่นเสียงปิ๊บ
                beep.play();

                h2.textContent = idInfo;
                h2.setAttribute('style', 'color: #006b28');

                // ตั้งค่าคุณสมบัติของ input
                listItem.setAttribute('type', 'text');
                listItem.setAttribute('id', idInfo);
                listItem.setAttribute('name', 'id[' + idInfo + ']');
                listItem.value = idInfo;



                console.log('dataToSend:', formObject);
// ส่งข้อมูลด้วย fetch API
                fetch('{{url('admin/event/inset-for-qr-code')}}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(dataToSend)
                })
                    .then(response => response.json()) // เปลี่ยนเป็น .text() หากเซิร์ฟเวอร์ส่งกลับข้อความธรรมดา
                    .then(data => {
                        // การจัดการหลังจากส่งข้อมูลสำเร็จ
                        console.log(data);
                        alert('ส่งข้อมูลสำเร็จ!');

                        // หยุดการสแกนชั่วคราวและเริ่มใหม่หลังจาก 10 วินาที
                        scanningAllowed = false;
                        setTimeout(() => {
                            scanningAllowed = true;
                        }, 1000);
                    })
                    .catch(error => {
                        // การจัดการข้อผิดพลาด
                        console.error('เกิดข้อผิดพลาด:', error);
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล.');
                    });

            }
        }

        // ฟังก์ชันเริ่มต้นการสแกนเมื่อกดปุ่ม
        document.getElementById('startButton').addEventListener('click', function () {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.start(
                        {facingMode: "environment"},
                        {fps: 5, qrbox: 300},
                        onScanSuccess
                    ).catch(err => {
                        console.error('เกิดข้อผิดพลาด:', err);
                    });
                }).catch(err => {
                    console.error('เกิดข้อผิดพลาดในการหยุดการสแกน:', err);
                });
            } else {
                html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start(
                    {facingMode: "environment"},
                    {fps: 5, qrbox: 300},
                    onScanSuccess
                ).catch(err => {
                    console.error('เกิดข้อผิดพลาด:', err);
                });
            }
            scanningAllowed = true; // อนุญาตให้สแกน

            // ซ่อนปุ่มหลังจากคลิก
            this.style.display = 'none'; // ใช้ 'none' เพื่อทำให้ปุ่มหายไป
            // หรือใช้ this.style.visibility = 'hidden'; หากต้องการปุ่มให้มีที่ว่างในเลย์เอาต์
        });


        function addTag(tag, button) {
            const existingTags = Array.from(document.querySelectorAll('.selected-tag')).map(tag => tag.textContent.trim().replace('x', '').trim());
            if (existingTags.includes(tag)) {
                return;
            }

            const tagsContainer = document.getElementById('selected-tags');
            const tagElement = document.createElement('div');
            tagElement.className = 'selected-tag';
            tagElement.textContent = tag;

            const removeButton = document.createElement('button');
            removeButton.className = 'remove-tag';
            removeButton.textContent = 'x';
            removeButton.onclick = function () {
                tagsContainer.removeChild(tagElement);
                button.classList.remove('disabled');
                updateHiddenInput();
            };

            tagElement.appendChild(removeButton);
            tagsContainer.appendChild(tagElement);

            button.classList.add('disabled');
            updateHiddenInput();
        }

        function updateHiddenInput() {
            const tags = Array.from(document.querySelectorAll('.selected-tag')).map(tag => tag.textContent.trim());
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
