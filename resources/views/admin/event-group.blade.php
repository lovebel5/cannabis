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
                                                        <button type="button" class="tag-button"
                                                                @if($key == 'selling') style="background-color: #ff0000;" @endif
                                                                onclick="addTag(this.value,this.lang, this)" value="{{$key}}" lang="{{ $value }}">{{ $value }}
                                                        </button>
                                                    @endforeach
                                                </div>

                                                <input type="text" id="text-input" name="message"
                                                       placeholder="{{ __('message.add_comment') }}" class="form-control" onkeypress="submitOnEnter(event)" oninput="validateForm()">
                                                <small class="form-text text-muted">{{ __('message.please_fill_in_at_least') }}</small>
                                                <div id="selected-tags" class="selected-tags"></div>
                                                <input type="hidden" id="tags-input" name="tags" onchange="validateForm()">
                                                <input type="hidden" value="" name="id_basic_info"/>
                                                <div class="col-md-12 m-1 text-right">
                                                    <button type="button" id="startButton" disabled>{{ __('message.start_scan_qr_code') }}</button>
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
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        const successMessage = @json(__('message.sent_successfully'));
        const errorMessage = @json(__('message.sent_data_error'));
        const codeAlreadyMessage = @json(__('message.qr_code_already_scanned'));

        let scanningAllowed = true; // เปลี่ยนเป็น true เพื่ออนุญาตให้เริ่มการสแกน
        let reQrcode = true;
        const beep = new Audio('{{ url('scan/beep-08b.wav') }}');
        const scannedCodes = new Set();
        let html5QrCode;
        let formObject = {};
        let lastScanTime = 0; // เวลาของการสแกนล่าสุด
        const scanDelay = 3000; // ระยะเวลา (มิลลิวินาที) ที่ต้องรอระหว่างการสแกน
        const h2 = document.getElementById('title');

        function setDate() {
            const date = new Date();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }

        function onScanSuccess(decodedText, decodedResult) {
            const currentTime = new Date().getTime(); // เวลาปัจจุบัน
            const idInfo = decodedText.split('/').pop();
            if (!scanningAllowed) {
                startScanning();
                return;
            }

            // ตรวจสอบว่าการสแกนเกิดขึ้นในช่วงเวลาที่สั้นเกินไปหรือไม่
            if (currentTime - lastScanTime < scanDelay) {
                console.log('การสแกนเกิดขึ้นเร็วเกินไป');
                return; // หยุดการสแกน
            }

            lastScanTime = currentTime; // อัพเดทเวลาของการสแกนล่าสุด

            if (scannedCodes.has(idInfo)) {
                console.log(`รหัส QR Code นี้ถูกสแกนไปแล้ว: ${idInfo}`);
                Toast.fire({
                    icon: 'error',
                    title: codeAlreadyMessage
                });
                h2.textContent = idInfo;
                h2.setAttribute('style', 'color: #ff0000');
                return; // หยุดหาก QR Code นี้ถูกสแกนไปแล้ว
            }
            // console.log(`รหัส QR Code ถูกสแกน: ${idInfo}`);
            scannedCodes.add(idInfo);

            setTimeout(() => {


                if (!isNaN(parseFloat(idInfo)) && isFinite(idInfo)) {
                    const date = setDate();
                    const tags = Array.from(document.querySelectorAll('.selected-tag'));
                    const lang = tags.map(tag => tag.getAttribute('lang'));
                    const form = document.querySelector('#results-list');
                    const formData = new FormData(form);

                    formObject = {};
                    formData.forEach((value, key) => {
                        formObject[key] = value;
                    });

                    formObject['id_basic_info'] = idInfo;
                    formObject['date'] = date;

                    const listItem = document.createElement('p');
                    listItem.textContent =  idInfo + ' ' + date + ' ' + formObject.message + ' ' + lang.join(',');


                    h2.textContent = idInfo;
                    h2.setAttribute('style', 'color: #006b28');

                    listItem.setAttribute('type', 'text');
                    listItem.setAttribute('id', idInfo);
                    listItem.setAttribute('name', 'id[' + idInfo + ']');
                    listItem.value = idInfo;

                    console.log('dataToSend:', formObject);

                    fetch('{{url('admin/event/inset-for-qr-code')}}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(formObject)
                    })
                        .then(response => response.json())
                        .then(data => {
                            // alert('การจัดการหลังจากส่งข้อมูลสำเร็จ');
                            beep.play();

                            document.getElementById('list_qr_code').prepend(listItem);
                            Toast.fire({
                                icon: 'success',
                                title: successMessage + ' ID : ' + idInfo,
                            });
                            scanningAllowed = true; // อนุญาตให้สแกนใหม่

                        })
                        .catch(error => {
                            console.error('เกิดข้อผิดพลาด:', error);
                            alert('เกิดข้อผิดพลาดในการส่งข้อมูล.');
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage +' ID : ' + idInfo
                            });
                            startScanning(); // เริ่มต้นการสแกนใหม่หากเกิดข้อผิดพลาด
                        });
                }
            }, 1000); // กำหนดเวลาให้การสแกนใหม่แต่ละครั้ง
        }

        function startScanning() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.start(
                        {facingMode: "environment"},
                        {fps: 2, qrbox: 300},
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
                    {fps: 2, qrbox: 300},
                    onScanSuccess
                ).catch(err => {
                    console.error('เกิดข้อผิดพลาด:', err);
                });
            }
            scanningAllowed = true; // อนุญาตให้สแกน
            document.getElementById('startButton').style.display = 'none'; // ซ่อนปุ่มหลังจากคลิก
        }

        // ฟังก์ชันเริ่มต้นการสแกนเมื่อกดปุ่ม
        document.getElementById('startButton').addEventListener('click', function () {
            startScanning();
        });



        function addTag(value, lang, button) {
            const existingTags = Array.from(document.querySelectorAll('.selected-tag')).map(tag => tag.dataset.value);
            if (existingTags.includes(value)) {
                return;
            }

            const tagsContainer = document.getElementById('selected-tags');
            const tagElement = document.createElement('div');
            tagElement.className = 'selected-tag';
            tagElement.textContent = button.textContent;
            tagElement.dataset.value = value;
            tagElement.setAttribute('lang', lang);

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
            validateForm();
            updateHiddenInput();
        }

        function updateHiddenInput() {
            const tags = Array.from(document.querySelectorAll('.selected-tag'));
            const dataValue = tags.map(tag => tag.getAttribute('data-value'));
            document.getElementById('tags-input').value = dataValue.join(',');
        }

        function submitOnEnter(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById('comment-form').submit();
            }
        }

        function validateForm() {
            const textInput = document.getElementById('text-input').value.trim();
            const tagsInput = document.getElementById('tags-input').value.trim();

            // ถ้ามีข้อความใน message หรือ tags อย่างน้อย 1 ค่า จะเปิดปุ่ม startButton
            if (textInput.length > 0 || tagsInput.length > 0) {
                document.getElementById('startButton').disabled = false;
            } else {
                document.getElementById('startButton').disabled = true;
            }

        }
    </script>

@endsection
