@extends('layouts.app')
@push('head')
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <title>Import Data</title>

    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">
    <style>
        .custom-file-input {
            color: transparent;
        }

        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Select some files';
            color: black;
            display: inline-block;
            background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
            border: 1px solid #999;
            border-radius: 3px;
            padding: 5px 8px;
            outline: none;
            white-space: nowrap;
            -webkit-user-select: none;
            cursor: pointer;
            text-shadow: 1px 1px #fff;
            font-weight: 700;
            font-size: 10pt;
        }

        .custom-file-input:hover::before {
            border-color: black;
        }

        .custom-file-input:active {
            outline: 0;
        }

        .custom-file-input:active::before {
            background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
        }

        @font-face {
            font-family: 'Lato-Regular';
            src: url('font/Lato-Regular.ttf');
        }

        @font-face {
            font-family: 'Lato-Semibold';
            src: url('font/Lato-Semibold.ttf');
        }

        @font-face {
            font-family: 'Lato-Bold';
            src: url('font/Lato-Bold.ttf');
        }

        @font-face {
            font-family: 'Lato-Thin';
            src: url('font/Lato-Thin.ttf');
        }

        label.file {
            width: 100%;
            position: relative;
            display: inline-block;
            cursor: pointer;
            height: 2.5rem;
        }

        label.file input {
            width: 100%;
            margin: 0;
            filter: alpha(opacity=0);
            opacity: 0;
        }

        .file-custom {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 5;
            height: calc(2.25rem + 2px);
            padding: 0.5rem 1rem;
            line-height: 1.5;
            color: #878b8f;
            font-family: 'Lato-Semibold' !important;
            font-size: 12px !important;
            /*background-color: #fff;*/
            border: 1px solid #9D865C;
            /*border-radius: 0.25rem;
        box-shadow: inset 0 0.2rem 0.4rem rgb(0 0 0 / 5%);*/
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .file-custom:before {
            position: absolute;
            top: -0.075rem;
            right: -0.075rem;
            bottom: -0.075rem;
            z-index: 6;
            display: block;
            font-family: 'Lato-Semibold' !important;
            font-size: 12px !important;
            width: 9rem;
            text-align: center;
            content: "Choose File";
            height: calc(2.25rem + 2px);
            padding: 0.5rem 1rem;
            line-height: 1.5;
            color: #fff;
            /* background:url(img/choose22.png) no-repeat; */
            /*border: 0.075rem solid #ddd;
        border-radius: 0 0.25rem 0.25rem 0;*/
            background-size: cover;
        }

        .file-custom:after {
            content: "No File Choosen";
        }

        .top-title {
            font-family: 'Lato-Semibold';
            font-size: 20px;
            color: #9D865C;
            height: 4rem;
            padding: 14px 35px;

            border-radius: 0 0px 55px 0;
            /* background-image:linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
        }

        .sidebar hr.sidebar-divider {
            display: none !important;
        }

        form#maindata {
            width: 56rem;
            margin: auto;
        }

        #import-title {
            font-family: 'Lato-Semibold';
            font-size: 17px;
            color: #000;
        }

        #import {
            background-color: #6c4d18;
            color: white;
            padding: 5px 7px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
            font-size: 14px;
            border: none;
        }

        #link-down {
            font-family: 'Lato-Semibold';
            background: #babec5;
            border: none;
            border-radius: 0;
            width: 36rem;
            padding: 8px 8px;
            color: #241d12;
            margin-left: 11px;
        }

        #file {
            background-color: #ffb400;
            color: white;
            padding: 5px 24px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
            font-size: 14px;
            border: none;
        }


        div#container-all {
            height: 34rem;
            overflow-y: scroll;
            overflow-x: hidden;
            margin-right: -16px;
            padding-right: 8px;
            margin-bottom: 10px;
        }

        div#container-all::-webkit-scrollbar {
            width: 5px;
        }

        div#container-all::-webkit-scrollbar {
            width: 8px !important;

        }

        /* Track */
        div#container-all::-webkit-scrollbar-track {
            background: transparent;
             !important;
            border-radius: 8px;
        }

        /* Handle */
        div#container-all::-webkit-scrollbar-thumb {
            background: #9D865C;
            border-radius: 8px;
        }

        /* Handle on hover */
        div#container-all::-webkit-scrollbar-thumb:hover {
            background: #9D865C;
            border-radius: 8px;
        }

        #wrapper {
            height: auto;
        }

        input[type=text],
        input[type=password] {
            margin: 0 !important;
        }

        .sub-title {
            font-family: 'Lato-Semibold' !important;
            font-size: 12px !important;
            color: #184d47;
        }

        #wrapper #content-wrapper {
            width: 100%;
            overflow-x: inherit !important;
        }

        #buttonsubmit {
            padding: 5px 20px;
            /* background: #15443f; */
            width: 11rem;
            border-radius: 0;
            height: 78%;
            margin: 0;
            font-family: 'Lato-Semibold';
            font-size: 12px;
            /* background-image:linear-gradient(to bottom, #184d47, #184d47, #0f3e39, #0c302d, #0c2826 , #061a18 ); */
        }

        .form-control:disabled,
        .form-control[readonly] {
            opacity: 0 !important;
        }

        #uploadForm,
        #importForm {
            width: 53rem;
            margin: auto;
        }

        #uploadForm .container {
            margin-top: 5rem;
        }

        #status {
            margin: 0 0 5px 0;
            font-family: 'Lato-Semibold';
            font-size: 15px;
        }

        #loaded_n_total {
            margin: 0;
            font-family: 'Lato-Semibold';
            font-size: 12px;
        }

        #wrapper {
            height: 100% !important;
        }

        /*start*/
        .page-item.active .page-link {
            z-index: 3;
            /* color: #6d4e18!important; */
            font-family: 'Lato-Semibold' !important;
            background-color: #ffffff !important;
            /* border-color: #ffffff; */
            top: 0px !important;
            /* border: none!important; */
            /* border-bottom: 2px solid #6d4e18!important; */
        }

        .page-link:focus {
            box-shadow: inset 0px 2px 0px 0px rgb(115 115 115 / 75%) !important;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #114c45;
            background-color: #fff;
            border: none;
        }

        .page-link:hover {
            z-index: 2;
            color: #9D865C;
            text-decoration: none;
            background-color: #e9edec87 !important;
            /*border-color: #e5e5e5;*/
            color: #114c45 !important;
        }

        .page-link:hover {
            z-index: 2;
            color: #9D865C;
            text-decoration: none;
            background-color: #e9edec87 !important;
            /* border-color: #e5e5e5; */
            color: #bec7c6 !important;
        }

        /*end*/

        .progress-bar {
            /* background-color:#8e681f!important; */
        }

        .font {
            font-family: 'Lato-Semibold';
        }

        #startproccess {
            margin-top: 1rem;
        }

        #width {
            width: 70%;
        }

        /*responsive*/
        @media(max-width:1024px) {

            #uploadForm,
            #importForm {
                width: 46rem;
            }
        }

        @media(max-width: 768px) {

            #uploadForm,
            #importForm {
                width: auto;
            }

            .top-title {
                font-size: 15px;
            }

            #width {
                width: 100%;
            }
        }

        @media(max-width: 500px) {
            #width {
                width: 100%;
            }

            .top-title {
                font-size: 15px;
            }

            #uploadForm,
            #importForm {
                width: auto !important;
            }

            .col-title {
                position: absolute;
                left: 27px;
            }

            #wrapper #content-wrapper {
                margin-top: 4rem;
            }

            #startproccess {
                padding-left: 1rem;
            }

            .card-header {
                padding-right: 0 !important;
            }

            #dataTable_length {
                background: transparent !important;
            }

            #tablepaginate {
                justify-content: center !important;
                padding-right: 0 !important;
            }

            .img-row {
                position: inherit !important;
            }

            #import {
                height: 2.5rem;
                padding: 5px 23px;
            }

            #link-down {
                font-size: 11px;
            }
        }

        @media(max-width: 390px) {
            .col-title {
                left: 33px;
            }

            .top-title {
                font-size: 15px;
            }
        }

        /*end responsive*/
        .img-row {
            position: absolute;
            bottom: 30px;
            right: 125px;
        }
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-8">
                <h3 class="top-title">Import Data</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- <h1 style="margin: auto" class="mt-4 mb-4 pt-5">Import Excel File</h1> -->

        <div id="width" style="margin: +2rem auto auto auto;">


            <span id="field_errors"></span>

            {{-- submit form --}}
            <form id="uploadForm" method="POST">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="file">
                                <div class="alert alert-success pb-3 mt-3" role="alert" id="alertdiv" hidden></div>
                                <input type="file" name="uploadFile" id="uploadFile" class="form-control"
                                    onchange="uploadFile1()">
                                <span class="file-custom"></span>
                            </label>
                        </div>
                    </div>


                    <div class="progress" style="margin-top: 1rem">
                        <div id="upload-progress-bar" class="progress-bar" role="progressbar" aria-valuenow=""
                            aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            0%
                        </div>
                    </div>

                    <h3 id="status"></h3>
                    <p id="loaded_n_total"></p>

                </div>
            </form>

            {{-- import form --}}
            <form id="importForm" action="{{ url('/import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="startproccess">
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <h1 class="font">We are importing your data now</h1>
                            <h3 class="font"> You can leave this page and you will receive an email when the process is
                                completed.
                            </h3>
                            <h5 class="font">Thanks</h5>
                        </div>
                        <div class="col-md-4 col-12">
                            <img src="{{ asset('img/logoemail1.JPG') }}" width="200" height="200" alt="">
                        </div>

                    </div>
                </div>

                <br />
                <div id="success">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-5" style="display: flex;">
                            <button type="submit" id="import" onclick="stratImport()" name="save"
                                class="btn btn-primary btn-block">Import
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                    hidden></span>
                            </button>
                            <a id="link-down" class="btn btn-primary" href="{{ url('template/template.xlsx') }}">Download
                                Template</a><span></span>
                        </div>
                    </div>
            </form>
        </div>

        <div class="row img-row">
            <div class="col-md-8"></div>
            <div class="col-md-4 text-right">
                <img src="img/file.png" style="height: 8rem">
            </div>
        </div>

    </div>
    <!-- End of Content Wrapper -->
@endsection

@section('content')
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
@endsection

@push('scripts')
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        $(document).ready(function() {

            $('select.custom-select').val($('select.custom-select > option:last').val()).change();

        });
    </script>

    {{-- upload process --}}
    <script>
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile1() {
            $('#alertdiv').attr('hidden', true);
            $("#field_errors").empty();
            var file = _("uploadFile").files[0];
            var formdata = new FormData();
            formdata.append("uploadFile", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "file_upload_parser.php");
            ajax.send(formdata);
        }

        function progressHandler(event) {
            var totalfilesize = parseInt(event.total) / (1024 * 1024);
            var fileinprogress = parseInt(event.loaded) / (1024 * 1024);
            _("loaded_n_total").innerHTML = "Uploaded " + fileinprogress.toFixed(2) + " Mbytes of " + totalfilesize
                .toFixed(2);
            var percent = (event.loaded / event.total) * 100;
            $('#upload-progress-bar').css('width', parseInt(percent) + '%');
            $('#upload-progress-bar').text(parseInt(percent) + '%');
            _("status").innerHTML = "Uploading... please wait";
        }

        function completeHandler(event) {
            _("status").innerHTML = event.target.responseText;
            $('#upload-progress-bar').css('width', 100 + '%');
        }

        function errorHandler(event) {
            _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
        }
    </script>

    {{-- filter data --}}
    <script>
        $(".filter").change(function() {
            var filterValue = $(this).val();
            if (filterValue != 'Show') {
                var row = $('.ro');

                row.hide()
                row.each(function(i, el) {
                    if ($(el).attr('data-type') == filterValue) {
                        $(el).show();
                    }
                })
            } else {
                var row = $('.ro');

                row.hide()
                row.each(function(i, el) {

                    $(el).show();

                })
            }


        });
    </script>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

    <script>
        function stratImport() {
            $('#startproccess').prop('hidden', false);
            var file_data = $('#uploadFile').prop('files')[0];
            var form_data = new FormData();
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append('file', file_data);
            $.ajax({
                async: true,
                type: $('#importForm').attr('method'),
                url: $('#importForm').attr('action'),
                contentType: false,
                cache: false,
                processData: false,
                data: form_data,
                dataType: 'JSON',
                beforeSend: function() {
                    $('.spinner-border').removeAttr('hidden');
                },
                success: function(val) {
                    console.log(val);
                    if (val.success == "true") {
                        $('#uploadFile').prop('disabled', false);
                        $('#import').prop('disabled', false);
                        $('.spinner-border').attr('hidden', 'hidden');
                        $('#upload-progress-bar').text('0%');
                        $('#upload-progress-bar').css('width', 0);
                        $('#uploadFile').val('');
                        _("status").innerHTML = "";
                        _("loaded_n_total").innerHTML = "";
                        $("#field_errors").attr('hidden', false);
                        $("#field_errors").append(
                            "<ul class='alert alert-success'>" +
                            val.message + "</ul>")
                        $('#startproccess').prop('hidden', true);
                    } else {
                        $("#field_errors").append(
                            "<ul class='alert alert-danger'>" +
                            val.message + "</ul>")
                        $('#startproccess').prop('hidden', true);

                        $('#import').prop('disabled', false);
                        $('#uploadFile').prop('disabled', false);
                        $('#alertdiv').attr('hidden', true);
                        $("#field_errors").attr('hidden', false);
                    }
                },
                error: function(val) {
                    console.log(val);
                    if (val.responseJSON.message.includes('getClientOriginalExtension')) {
                        $("#field_errors").append(
                            "<ul class='alert alert-danger'>" +
                            'you should select valid csv file only' + "</ul>")
                    } else {
                        $("#field_errors").append(
                            "<ul class='alert alert-danger'>" +
                            val.message + "</ul>")
                    }

                    $('#startproccess').prop('hidden', true);

                    $('#import').prop('disabled', false);
                    $('.spinner-border').attr('hidden', 'hidden');
                    $('#uploadFile').prop('disabled', false);
                    $('#alertdiv').attr('hidden', true);
                    $("#field_errors").attr('hidden', false);
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            if ({{ Auth::user()->getcurrentproccessstatus() }} == 0) {
                $('#startproccess').prop('hidden', false);
                $("#field_errors").empty();
                $('#import').prop('disabled', true);
                $('#uploadFile').prop('disabled', true);
            } else {
                $('#startproccess').prop('hidden', true);
                $("#field_errors").empty();
                $('#import').prop('disabled', false);
                $('#uploadFile').prop('disabled', false);
            }
            $('#importForm').submit(function(e) {
                e.preventDefault();
                $("#field_errors").empty();
                $('#import').prop('disabled', true);
                $('#uploadFile').prop('disabled', true);

            });
        })
    </script>
@endpush
