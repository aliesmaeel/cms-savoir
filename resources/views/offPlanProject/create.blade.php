@extends('layouts.app')

@push('head')
    <title>Create Off-Plan Project</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: white;
        }

        * {
            box-sizing: border-box;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
            /*  background-color: white;*/
        }

        /* Full-width input fields */
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit button */
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

        .center {
            margin: 0 100 0 0;
            position: absolute;
            left: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .registerbtn:hover {
            opacity: 1;
        }

        /* Add a blue text color to links */
        a {
            color: #ef2027;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
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

        .sidebar-divider {
            display: none;
        }

        .title-input {
            color: #143e39;
            font-family: 'Lato-Bold';
            font-size: 13px;
        }
        #language{
            border-right: 1px solid #70cacc;
        }

        #link,
        #property_name,
        #image,
        #header_images,
        #details{
            border-right: 3px solid #9D865C!important;
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
            text-align: left;
            box-shadow: 0 4px 2px -2px #d9d1d1;
        }

        .input_off_plan {
            border-right: 3px solid #9D865C!important;
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
            text-align: left;
            box-shadow: 0 4px 2px -2px #d9d1d1;
        }

        input[type=text],
        input[type=password] {
            margin: 0 !important;
        }

        #img-top {
            position: absolute;
            top: -4px;
            right: 20px;
            width: 16rem;
        }

        #maindata {
            /* box-shadow: 0px 0px 4px 1px #6c4d18; */
            margin: 5px;
            /* border: 1px solid #e4aa47; */
            border-radius: 5px;
            padding: 20px 51px;
            width: 50rem;
            margin: 5rem auto;
        }

        @font-face {
            font-family: 'Lato-Semibold';
            src: url('font/Lato-Semibold.ttf');
        }

        #buttonsubmit {
            width: 9rem;
            /* background: #6c4d18; */
            padding: 5px 32px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
        }

        /*responsive*/
        @media(max-width: 1400px) {
            #bookslist_filter label::before {
                top: 133px;
            }

            #bookslist_filter label::after {
                top: 127px;
            }
        }

        @media(max-width: 1350px) and (min-width: 1200px) {
            .top-title {
                font-size: 16px;

            }
        }

        #bg-top {
            width: 116%;
            margin-left: -2rem;
            margin-top: -4rem;
        }

        #bookslist_filter label::after {
            top: 121px;
            right: 31px;
        }

        #bookslist_filter label::before {
            top: 126px;
            right: 281px;
        }

        .label h4 {
            font-size: 15px;
        }

        .top-title {
            font-size: 16px;
        }

        @media(max-width: 768px) {
            #wrapper {
                height: auto;
            }

            .group-button {
                margin-top: 2rem;
            }


        }

        #wrapper #content-wrapper {
            padding-bottom: 3rem;
        }

        @media(max-width: 500px) {
            .top-title {
                font-size: 15px !important;

            }

            #maindata {
                padding: 20px 0px;
                width: auto;
                margin: 3rem 1rem 2rem 1rem;
            }

            #wrapper {
                height: 100%;
            }

            #bg-top {
                width: 66%;
                margin-left: 0;
                margin-top: 0;
            }

            .group-button {
                margin-top: 0rem !important;
            }

            #bookslist_filter label::before {
                top: 405px !important;
                right: 189px !important;
            }
        }

        @media (max-width: 500px) {
            #bookslist_filter label::after {
                top: 10px !important;
                right: 42px !important;
                position: relative;
            }

            #bookslist_length {
                background: transparent;
            }

            #img-top {
                display: none;
            }
        }

        @media (max-width: 1350px) and (min-width: 1200px) {
            #bookslist_filter label::after {
                top: 127px;
            }
        }

        @media (max-width: 768px) and (min-width: 600px) {
            #bookslist_filter label::after {
                top: 128px;
            }

            #maindata {
                padding: 20px 35px;
                width: auto !important;
                margin: 6rem 1rem !important;
            }
        }

        /*end responsive*/
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-8">
                <h3 class="top-title">Create Off-Plan Project</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">
        <img id="img-top" src="img/bg-top.png">
        <!-- <h3 style="margin: auto" class="mt-4 mb-4">Create new agent</h3> -->
        <form id="maindata" enctype="multipart/form-data">
            <div class="container">
                <span id="alertdata"></span>

                <!-- Main Image -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="image">Image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" name="image" id="image" style="background: #fff!important">
                        <div class="holder mt-4">
                            <img id="imgPreview" src="#" alt="pic" width="100" height="100" hidden />
                        </div>
                    </div>
                </div>

                <!-- Header Images -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="header_images">Header Images</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" name="header_images[]" id="header_images" multiple accept="image/*" style="background: #fff!important">
                        <div class="holder mt-4" id="imgholder"></div>
                    </div>
                </div>

                <!-- Title -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="title">Title</label></div>
                    <div class="col-md-8">
                        <input type="text" name="title" id="title" required class="input_off_plan" placeholder="Enter Title" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- Area -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="area">Area</label></div>
                    <div class="col-md-8">
                        <input type="text" name="area" required class="input_off_plan" placeholder="Enter Area" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- Order -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="order">Order</label></div>
                    <div class="col-md-8">
                        <input type="text" name="order" required class="input_off_plan" placeholder="Enter Order" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- Link -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="link">Link</label></div>
                    <div class="col-md-8">
                        <input type="text" name="link" id="link" required placeholder="Enter Link" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- Location -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="location">Location</label></div>
                    <div class="col-md-8">
                        <input type="text" name="location" required placeholder="Enter Location" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="first_installment">First Installment</label></div>
                    <div class="col-md-8">
                        <input type="text" name="first_installment" required placeholder="Enter First Installment" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- During Construction -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="during_construction">During Construction</label></div>
                    <div class="col-md-8">
                        <input type="text" name="during_construction" required placeholder="Enter During Construction" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- On Handover -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="on_handover">On Handover</label></div>
                    <div class="col-md-8">
                        <input type="text" name="on_handover" required placeholder="Enter On Handover" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="completion_date">Completion Date</label></div>
                    <div class="col-md-8">
                        <input type="text" name="completion_date" required placeholder="Enter Completion Date" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="developer">Developer</label></div>
                    <div class="col-md-8">
                        <input type="text" name="developer" required placeholder="Enter Developer" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="starting_price">Starting Price</label></div>
                    <div class="col-md-8">
                        <input type="text" name="starting_price" required placeholder="Enter Starting Price" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="project_size">Project Size</label></div>
                    <div class="col-md-8">
                        <input type="text" name="project_size" required placeholder="Enter Project Size" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="lifestyle">Lifestyle</label></div>
                    <div class="col-md-8">
                        <input type="text" name="lifestyle" required placeholder="Enter Lifestyle" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="title_type">Title Type</label></div>
                    <div class="col-md-8">
                        <input type="text" name="title_type" required placeholder="Enter Title Type" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>



                <!-- Features -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="features">Features</label></div>
                    <div class="col-md-8">
                        <textarea name="features" id="features" class="ckeditor input-form" placeholder="Enter Features" style="background: #fff!important; visibility: hidden; display: none;"></textarea>
                    </div>
                </div>

                <!-- Lat -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="lat">Lat</label></div>
                    <div class="col-md-8">
                        <input type="number" name="lat" required placeholder="Enter Lat" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- Lng -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="lng">Lng</label></div>
                    <div class="col-md-8">
                        <input type="number" name="lng" required placeholder="Enter Lng" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- Description -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description">Description</label></div>
                    <div class="col-md-8">
                        <textarea name="description" id="description" required placeholder="Enter Description" class="input_off_plan" style="border-right: 3px solid #9D865C!important"></textarea>
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="youtube_link">YouTube Link</label></div>
                    <div class="col-md-8">
                        <input type="text" name="youtube_link" required placeholder="Enter YouTube Link" class="input_off_plan" style="border-right: 3px solid #9D865C!important">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" class="btn btn-primary" type="button">Create
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>





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

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
 {{-- preview image --}}
 <script>


     $('#header_images').change(function() {
         const files = this.files;

         if (files) {
             for (let i = 0; i < files.length; i++) {
                 let reader = new FileReader();

                 reader.onload = function(event) {
                     $('#imgholder').append(`
                    <img id="imgPreviewHeader${i}" src="${event.target.result}" alt="pic" width="100" height="100" hidden />
                `);
                     $(`#imgPreviewHeader${i}`).attr('hidden', false);
                 };

                 reader.readAsDataURL(files[i]);
             }
         }
     });

    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#imgPreview').attr('src', event.target.result);
                $('#imgPreview').attr('hidden', false);
            }
            reader.readAsDataURL(file);
        }
    });


</script>
    <script>
        $('#buttonsubmit').click(function(e) {
            e.preventDefault();
            var formData = new FormData();
            $('#maindata').serializeArray().forEach(function(field) {
                formData.append(field.name, field.value);
            });
            formData.append("_token", "{{ csrf_token() }}");

            let fileInput = document.getElementById('header_images');
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('header_images[]', fileInput.files[i]);
            }

            let singleImageInput = document.getElementById('image');
            if (singleImageInput.files.length > 0) {
                formData.append('image', singleImageInput.files[0]);
            }


            var feature = CKEDITOR.instances.features.getData();

            formData.append('features', feature);

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: "{{ route('off_plan_project_create') }}",
                beforeSend: function() {
                    $('#buttonsubmit').attr('disabled', 'disabled');
                    $('.spinner-border').removeAttr('hidden');
                },
                success: function(result) {
                    console.log(result);
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $("#maindata")[0].reset();
                    $("#buttonsubmit").removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
                    $('#imgPreview').attr('hidden', true);
                    window.location.href = "{{ route('off_plan_project_list') }}";
                },
                error: function(error) {
                    $("#alertdata").empty();
                    $.each(error.responseJSON.errors, function(index, value) {
                        $("#alertdata").append(
                            "<div class= 'alert alert-danger'>" +
                            "   " + value + "</div>");
                    });
                    $("#alertdata").attr('hidden', false);
                    $("#buttonsubmit").removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
                }
            });
        });
    </script>
@endpush
