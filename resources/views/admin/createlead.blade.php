@extends('layouts.app')
@push('head')
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <title>Create Lead</title>

    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">
    <script src="js/intlTelInput-jquery.min.js"></script>
    <script src="js/intlTelInput.js"></script>
    <script src="js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="css/intlTelInput.css">
    <link rel="stylesheet" href="css/intlTelInput.min.css">
    <style>
        #leadform {
            box-shadow: 0px 0px 4px 1px #9D865C;
            border: 1px solid #9D865C;
            margin-top: 2rem;
            padding: 2rem 0;
            border-radius: 6px;

        }

        .top-title {
            font-family: 'Lato-Semibold';
            font-size: 20px;
            color: #9D865C;
            height: 4rem;
            padding: 14px 35px;
            /* margin-left: -5px; */
            border-radius: 0 0px 55px 0;
            /*background-image: linear-gradient(to bottom, #184d47,#184d47, #133944, #1d2532, #19151b, #000000);*/
        }

        .iti {
            width: 100%;
        }

        .iti__country-list--dropup {
            bottom: 100%;
            margin-bottom: -1px;
            color: black;

        }

        .iti__country {
            direction: ltr;
            text-align: left;
            width: 100%;
            padding: 5px 10px;
            outline: 0;
        }

        .iti__arrow {
            border-left: 5px solid transparent !important;
            border-right: 5px solid #03030300 !important;
            /* border-top: 6px solid #000!important; */
        }

        .iti-flag {
            background-image: "{{ asset('public/img/flags.png') }}";
        }

        @media(-webkit-min-device-pixel-ratio:2),
        (min-resolution:192dpi) {
            .iti-flag {
                background-image: "{{ asset('public/img/flags@2x.png') }}"
            }
        }

        @media screen and (max-width: 767px) {

            .iti-mobile .iti--container {
                top: 30px;
                bottom: 30px;
                left: 39px;
                right: 0px;
                position: fixed;
            }
        }

        .iti {
            position: inherit !important;
            display: block !important;
        }

        .phone-input {
            background: transparent;
            border: none;
        }

        #width {
            width: 63%;
        }

        #pphone {
            height: 2rem !important;
            width: 100%;
            padding-bottom: 9px;
        }

        .form-title {
            text-align: center;
            margin-bottom: 3rem !important;
            margin-top: 1rem !important;
            color: #9D865C;
        }

        .form-input,
        .iti--allow-dropdown {
            width: 60% !important;
            display: block !important;
            margin: auto !important;
            height: 3rem !important;
            margin-bottom: 2rem !important;
            padding: 10px 0 !important;
            border: 1px solid transparent !important;
            border-bottom: 1px solid #9D865C !important;
            background: transparent !important;
        }

        .form-input:focus,
        .iti--allow-dropdown:focus {

            outline: none !important;
        }

        .form-input:focus-visible,
        .iti--allow-dropdown:focus-visible {

            outline: none !important;
        }

        #pphone:focus {
            outline: none !important;
            border: none !important;
        }

        #pphone:focus-visible {
            outline: none !important;
            border: none !important;
        }

        .leadform {
            text-align: center;
        }

        .reg-btn {
            height: 52px;
            padding: 1rem;
            display: block;
            width: 60%;
            margin: auto;
            background-color: #212529 !important;
            border: none !important;
            font-size: 1rem;
            color: #fff;
            margin-top: 2rem !important;
        }

        #buttonsubmit:hover {
            cursor: pointer;
            background-color: #fff !important;
            color: #9D865C !important;
            border: 1px solid #9D865C !important;
        }

        /*responsive*/

        @media(max-width: 768px) {

            .top-title {
                font-size: 15px;
            }

            #width {
                width: 80%;
            }
        }

        @media(max-width: 500px) {
            #width {
                width: 90%;
            }

            .form-input,
            .iti--allow-dropdown {
                width: 100% !important;
            }

            .reg-btn {
                width: 70%;
            }

            .top-title {
                font-size: 15px;
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

        .file-custom {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 5;
            height: calc(2.25rem + 3px);
            padding: 0.5rem 1rem;
            line-height: 1.5;
            color: #878b8f;
            font-family: 'Lato-Semibold' !important;
            font-size: 12px !important;
            /*background-color: #fff;*/
            border: 1px solid #184d47;
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
            height: calc(2.25rem + 3px);
            padding: 0.5rem 1rem;
            line-height: 1.5;
            color: #9D865C;
            /* background:url(img/choose22.png) no-repeat; */
            /*border: 0.075rem solid #ddd;
        border-radius: 0 0.25rem 0.25rem 0;*/
            background-size: cover;
        }

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

        .file-custom:after {
            content: "No File Choosen";
            display: none;
        }

        label.file {
            width: 100%;
            position: relative;
            display: inline-block;
            cursor: pointer;
            height: 2.5rem;
        }

        label.file input {
            height: calc(2.25rem + 2px);
            width: 100%;
            padding: 9px 24px 5px 24px !important;
            margin: 0;
            filter: alpha(opacity=1);
            opacity: 1;
            background-color: transparent !important;
            color: #8b7777 !important;
        }

        ::-webkit-file-upload-button {
            display: none;
        }

        .custom-file-input {
            color: transparent;
        }

        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        #file {
            background-color: #fff;
            color: #212529;
            border: 1px solid #212529 !important;
            padding: 5px 24px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
            font-size: 14px;
            border: none;
        }

        #import {
            background-color: #6c4d18;
            color: white;
            padding: 5px 30px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
            font-size: 14px;
            border: none;
        }

        /*end responsive*/
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-6">
                <h3 class="top-title">Create Lead</h3>
    <h1></h1>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="width" style="margin: +2rem auto auto auto;">
            <span id="field_errors"></span>
            {{-- submit form --}}
            <form id="leadform">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="form-title">Create Lead</h2>
                        </div>
                    </div>
                    <div class="row">

                        <div style="width: 60%;margin:auto">
                            <span id="alertdata"></span>
                            <div class="col-12">
                                <label for="customerenquiry">
                                    <h3>Import from csv file</h3>
                                </label>
                            </div>
                            <div class="col-12">
                                <label class="file">
                                    <input type="file" id="file" name="file" class=" mb-5"
                                        aria-label="File browser example">
                                    <span class="file-custom"></span>
                                </label>

                            </div>
                            <div class="col-12">
                                <button type="button" id="import" class="btn btn-md btn-success mt-0 mb-3">Import
                                    <span class="spinner-import spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true" hidden></span>
                                </button>
                                <input type="button" id="file" name="file" class="btn btn-md btn-success ml-2 mb-3"
                                    value="Template"
                                    onclick="location.href='{{ url('template/enquriycustomertemplate.csv') }}'">
                            </div>
                        </div>
                        <div class="col-12">
                            <input class="form-input" id="name-form" type="text" name="name" placeholder="Name"
                                required>
                        </div>
                        <div class="col-12">
                            <input class="form-input" id="email-form" type="email" name="email" placeholder="Email"
                                required>
                        </div>
                        <div class="col-12">
                            <input class="phone-input" class="" type="tel" pattern="[+]{0,1}[0-9]{8,13}"
                                name="pphone" id="pphone" value="+971" required />
                        </div>
                        <div class="col-12">
                            <select id="project" class="form-input" name="project" >
                                <option value="">Select project</option>
                                <option value="Damac Lagoons">Damac Lagoons</option>
                                <option value="Safa">Safa</option>
                                <option value="West Wood Residence">West Wood Residence</option>
                                <option value="JVC">JVC</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <input class="form-input" id="source" type="text" name="source" placeholder="Source" required>
                        </div>
                        <div class="col-12">
                            <input class="form-input" id="propertytype" type="text" name="property_type" placeholder="Property Type" required>
                        </div>
                        <div class="col-12">
                            <input class="form-input" id="location" type="text" name="location" placeholder="Location" required>
                        </div>
                        <div class="col-12">
                            <button class="reg-btn" id="buttonsubmit" type="button">Submit
                                <span class=" spinner-create spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true" hidden></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
    <script src="js/intlTelInput-jquery.min.js"></script>
    <script src="js/intlTelInput.js"></script>
    <script src="js/intlTelInput.min.js"></script>
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
        var inputt = document.querySelector('#pphone');
        var countryData = window.intlTelInputGlobals.getCountryData();
        var addressDropdow = document.querySelector("#addresss-country");
        var it2 = window.intlTelInput(inputt, {
            utilScript: 'js/utils.js'
        });
        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            // addressDropdow.appendChild(optionNode);
        }

        // addressDropdow.value = it2.getSelectedCountryData().iso2;

        // listen to the telephone input for changes
        // inputt.addEventListener('countrychange', function(e) {
        //     addressDropdow.value = it2.getSelectedCountryData().iso2;
        // });

        // listen to the address dropdown for changes
        // addressDropdow.addEventListener('change', function() {
        //     it2.setCountry(this.value);
        // });
    </script>
    <script>
        $(document).ready(function() {

            $('select.custom-select').val($('select.custom-select > option:last').val()).change();

        });
    </script>

    {{-- submit Form --}}
    <script>
        $('#buttonsubmit').click(function(e) {
            e.preventDefault();
            var formData = new FormData();

            $('#leadform').serializeArray().forEach(function(field) {
                formData.append(field.name, field.value);
            });

            formData.append("_token", "{{ csrf_token() }}");

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: "{{ route('create_new_lead') }}",
                beforeSend: function() {
                    $('#buttonsubmit').attr('disabled', 'disabled');
                    $('.spinner-create').removeAttr('hidden');
                },
                success: function(result) {
                    if (result.success) {
                        $("#field_errors").empty();
                        $("#field_errors").append("<div class= 'alert alert-success'>" + result
                            .message +
                            "</div>");
                        $("#field_errors").attr('hidden', false);
                        $("#leadform")[0].reset();
                        $('#buttonsubmit').removeAttr('disabled');
                        $('.spinner-create').attr('hidden', 'hidden');
                    } else {
                        $("#field_errors").empty();
                        $("#field_errors").append("<div class= 'alert alert-danger'>" + result
                            .message +
                            "</div>");
                        $("#field_errors").attr('hidden', false);
                        $('#buttonsubmit').removeAttr('disabled');
                        $('.spinner-create').attr('hidden', 'hidden');
                    }
                },
                error: function(error) {
                    $("#field_errors").empty();
                    $.each(error.responseJSON.errors, function(index, value) {
                        $("#field_errors").append(
                            "<div class= 'alert alert-danger'>" +
                            "   " + value + "</div>");
                    });
                    $("#field_errors").attr('hidden', false);
                    $('#buttonsubmit').removeAttr('disabled');
                    $('.spinner-create').attr('hidden', 'hidden');
                }
            });
        });
        $('#import').click(function(e) {
            $("#alertdata").empty();
            e.preventDefault();
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append('file', file_data);
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: form_data,
                enctype: 'multipart/form-data',
                url: "{{ route('import_enquiry_customer') }}",
                beforeSend: function() {
                    $('#import').attr('disabled', 'disabled');
                    $('.spinner-import').removeAttr('hidden');
                },
                success: function(result) {
                    if (result.success) {
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                        $('#file').val(null);
                        $('#import').removeAttr('disabled');
                        $('.spinner-import').attr('hidden', 'hidden');
                    } else {
                        console.log(result);
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-danger'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                        $('#import').removeAttr('disabled');
                        $('.spinner-import').attr('hidden', 'hidden');
                    }
                },
                error: function(error) {
                    $("#alertdata").empty();
                    // $.each(error.responseJSON.errors, function(index, value) {
                    //     $("#alertdata").append(
                    //         "<div class= 'alert alert-danger'>" +
                    //         index +
                    //         "   " + value + "</div>");
                    // });
                    $("#alertdata").attr('hidden', false);
                    $('#import').removeAttr('disabled');
                    $('.spinner-import').attr('hidden', 'hidden');
                }
            });
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
@endpush
