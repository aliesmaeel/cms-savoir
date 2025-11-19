@extends('layouts.app')

@push('head')
    <title>Create Career</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('images/css/dash.css') }}">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: white;
        }

        * {
            box-sizing: border-box;
        }

        .container {
            padding: 16px;
        }

        input[type=text] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus {
            background-color: #ddd;
            outline: none;
        }

        .registerbtn {
            background-color: #70cacc;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            width: 10%;
            opacity: 0.9;
        }

        .registerbtn:hover {
            opacity: 1;
        }

        .top-title {
            font-family: 'Lato-Semibold';
            font-size: 20px;
            color: #9D865C;
            height: 4rem;
            padding: 14px 35px;
            border-radius: 0 0 55px 0;
        }

        .title-input {
            color: #143e39;
            font-family: 'Lato-Bold';
            font-size: 13px;
        }

        #title,
        #location {
            font-family: 'Lato-Regular' !important;
            font-size: 12px !important;
            display: inline-block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 1.75rem 0.375rem 0.75rem;
            line-height: 1.5;
            color: #878b8f;
            vertical-align: middle;
            border-radius: 0 !important;
            background: #fff !important;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            margin: 0 !important;
        }

        #maindata {
            margin: 5px;
            border-radius: 5px;
            padding: 20px 51px;
            width: 50rem;
            margin: 5rem auto;
        }

        #buttonsubmit {
            width: 10rem;
            padding: 5px 32px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
        }

        #wrapper #content-wrapper {
            padding-bottom: 3rem;
        }

        @media(max-width: 500px) {
            .top-title {
                font-size: 15px !important;
            }

            #maindata {
                padding: 20px 0;
                width: auto;
                margin: 3rem 1rem 2rem 1rem;
            }
        }
    </style>
@endpush

@section('wrapper_content')
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-8">
                <h3 class="top-title">Create Career</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">
        <form id="maindata">
            <div class="container">
                <span id="alertdata"></span>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="title">Title</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Job Title" name="title" id="title" required>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="image">Image URL</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" placeholder="" name="image" id="image">
                    </div>
                </div>


                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="location">Location</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Job Location" name="location" id="location">
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" type="button" class="registerbtn">Create
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
            crossorigin="anonymous"></script>

    <script>
        $('#buttonsubmit').click(function (e) {
            e.preventDefault();

            var formData = new FormData();

            $('#maindata').serializeArray().forEach(function (field) {
                formData.append(field.name, field.value);
            });
            var imageFile = $('#image')[0].files[0];
            formData.append('image', imageFile);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: '{{ route('career_create') }}',
                beforeSend: function () {
                    $('#buttonsubmit').attr('disabled', 'disabled');
                    $('.spinner-border').removeAttr('hidden');
                },
                success: function (result) {
                    if (result.success) {
                        $('#alertdata').empty();
                        $('#alertdata').append("<div class='alert alert-success'>" + result.message + "</div>");
                        $('#alertdata').attr('hidden', false);
                        $('#maindata')[0].reset();
                        $('#buttonsubmit').removeAttr('disabled');
                        $('.spinner-border').attr('hidden', 'hidden');
                        window.location.href = '{{ route('career_list') }}';
                    } else {
                        $('#alertdata').empty();
                        $('#alertdata').append("<div class='alert alert-danger'>" + result.message + "</div>");
                        $('#alertdata').attr('hidden', false);
                        $('#buttonsubmit').removeAttr('disabled');
                        $('.spinner-border').attr('hidden', 'hidden');
                    }
                },
                error: function (error) {
                    $('#alertdata').empty();
                    if (error.responseJSON && error.responseJSON.errors) {
                        $.each(error.responseJSON.errors, function (index, value) {
                            $('#alertdata').append("<div class='alert alert-danger'>" + value + "</div>");
                        });
                    }
                    $('#alertdata').attr('hidden', false);
                    $('#buttonsubmit').removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
                }
            });
        });
    </script>
@endpush


