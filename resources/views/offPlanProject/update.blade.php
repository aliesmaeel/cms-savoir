@extends('layouts.app')

@push('head')
    <title>Update Off-Plan Project</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
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
        #details{
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
            /* border: 1px solid #fff!important; */
            text-align: left;
            /* border-right: 3px solid #e4aa47!important; */
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

        .wrapper .file-upload-multi {
            height: 100px;
            width: 100px;
            border-radius: 10px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 4px solid #FFFFFF;
            overflow: hidden;
            background-image: linear-gradient(to bottom, #2590EB 50%, #FFFFFF 50%);
            background-size: 100% 200%;
            transition: all 1s;
            color: #FFFFFF;
            font-size: 100px;
        }

        .wrapper .file-upload-multi input[type=file] {
            height: 200px;
            width: 200px;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-multi i {
            font-size: 64px
        }

        .wrapper .file-upload-multi:hover {
            background-position: 0 -100%;
            color: #9D865C;
        }

        /* */
        .remove {
            /* display: block; */
            border: 1px solid none;
            background-color: rgb(37 144 235);
            opacity: 0.7;
            background-size: cover;
            color: white;
            padding: 9px 15px 9px 15px;
            left: 28%;
            top: 30px;
            border-radius: 74px;
            text-align: center;
            cursor: pointer;
            position: absolute;
        }

        .remove:hover {
            opacity: 1;
            color: white;
        }

        .file-upload .file-upload-select {
            color: #dbdbdb;
            cursor: pointer;
            text-align: left;
            background: transparent;
            overflow: hidden;
            position: relative;
            border-radius: 6px;
        }

        .file-upload .file-upload-select .file-select-button {
            background: #9D865C;
            padding: 0.275rem 1.75rem !important;
            display: inline-block;
            border-radius: 5px;
            color: aliceblue;
        }

        .file-upload .file-upload-select .file-select-name {
            display: none;
            padding: 10px;
        }

        .file-upload .file-upload-select:hover .file-select-button {
            background: #9D865C;
            color: #ffffff;
            transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
        }

        .file-upload .file-upload-select input[type="file"] {
            display: none;
        }

        .grid-img {
            margin-right: 1rem;
            margin-bottom: 1rem;
            height: 100px;
            width: 100px !important;
        }

        .div-grid {
            overflow-x: scroll;
        }

        .div-grid-property {
            overflow-x: scroll;
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

        @media (max-width: 1024px) {
            #img {
                width: 100%;
            }

            .div-grid {
                overflow-x: scroll;
            }

            .div-grid-property {
                overflow-x: scroll;
            }
        }

        .image-grid {
            box-shadow: 0 0 2px #ef2027, 0 2px 4px #ef2027 !important;
            border: 1px solid #ef2027;
            border-radius: 10px;
            width: 100%;
            height: 130px;
        }

        .div-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
            grid-gap: 10px;
        }

        .div-grid-property {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
            grid-gap: 10px;
        }

        .image2 {
            background: #ef2027;
            color: #fff;
            box-shadow: 0 0 2px #ef2027, 0 2px 4px #ef2027 !important;
            border: 1px solid #ef2027;
            border-radius: 10px;
            width: 130px;
            height: 130px;

        }

        .photo-title {
            color: #3d4040;
            font-weight: 400;
            font-family: 'SF-Pro-Text-Regular' !important;
        }

        #pac-input {
            z-index: 999;
            position: inherit;
            width: 100%;
            border: aliceblue;
            border-radius: 7px;
            padding: 12px;
        }

        #geomap {
            width: 100%;
            height: 400px;
        }

        /*end responsive*/
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-8">
                <h3 class="top-title">Update Off-Plan Project</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">
        <img id="img-top" src="{{asset('/storage/img/bg-top.png')}}">
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
                            <img id="imgPreview" src="{{ $off_plan->image }}" alt="pic" width="100" height="100" />
                        </div>
                    </div>
                </div>

                <!-- Header Images -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="header_images">Header Images</label>
                    </div>
                    <div class="col-md-8">
                        <div class="row row-img">
                            <div class="div-grid">
                                <div class="grid-img">
                                    <div class="wrapper">
                                        <div class="file-upload-multi">
                                            <input type="file" name="header_images[]" id="header_images" multiple accept="image/*" />
                                            <i class="fa fa-plus"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Existing header images --}}
                                {{-- Existing header images --}}
                                @if ($header_images)
                                    @foreach ($header_images as $image)
                                        <div class="img-thumb-wrapper grid-img card shadow" style="width: 100%">
                                            <!-- mark this as an existing image -->
                                            <img class="img-thumb image-grid existing-img"
                                                 data-existing="1"
                                                 src="{{ $image }}"
                                                 alt="Header Image" />
                                            <span class="remove">
                <i class="fa fa-trash"></i>
            </span>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

                        @error('header_images')
                        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                        @enderror
                    </div>
                </div>


                <!-- Title -->
                <x-input-row label="Title" name="title" value="{{$off_plan->title}}" placeholder="Enter Title"/>

                <!-- Area -->
                <x-input-row label="Area" name="area" value="{{$off_plan->area}}" placeholder="Enter Area"/>

                <!-- Order -->
                <x-input-row label="Order" name="order" value="{{$off_plan->order}}" placeholder="Enter Order"/>

                <!-- Link -->
                <x-input-row label="Link" name="link" value="{{$off_plan->link}}" placeholder="Enter Link"/>

                <!-- Location -->
                <x-input-row label="Location" name="location" value="{{$off_plan->location}}" placeholder="Enter Location"/>

                <!-- First Installment -->
                <x-input-row label="First Installment" name="first_installment" value="{{$off_plan->first_installment}}" placeholder="Enter First Installment"/>

                <!-- During Construction -->
                <x-input-row label="During Construction" name="during_construction" value="{{$off_plan->during_construction}}" placeholder="Enter During Construction"/>

                <!-- On Handover -->
                <x-input-row label="On Handover" name="on_handover" value="{{$off_plan->on_handover}}" placeholder="Enter On Handover"/>

                <!-- Completion Date -->
                <x-input-row label="Completion Date" name="completion_date" value="{{$off_plan->completion_date}}" placeholder="Enter Completion Date"/>

                <!-- Developer -->
                <x-input-row label="Developer" name="developer" value="{{$off_plan->developer}}" placeholder="Enter Developer"/>

                <!-- Starting Price -->
                <x-input-row label="Starting Price" name="starting_price" value="{{$off_plan->starting_price}}" placeholder="Enter Starting Price"/>

                <!-- Project Size -->
                <x-input-row label="Project Size" name="project_size" value="{{$off_plan->project_size}}" placeholder="Enter Project Size"/>

                <!-- Lifestyle -->
                <x-input-row label="Lifestyle" name="lifestyle" value="{{$off_plan->lifestyle}}" placeholder="Enter Lifestyle"/>

                <!-- Title Type -->
                <x-input-row label="Title Type" name="title_type" value="{{$off_plan->title_type}}" placeholder="Enter Title Type"/>

                <!-- Features -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="features">Features</label>
                    </div>
                    <div class="col-md-8" style="overflow: scroll;min-height: 150px">
                        <div id="feature-input" class=""
                             style="background: #fff!important; padding: 8px; border: 1px solid #ccc; min-height: 45px; display: flex; flex-wrap: wrap; gap: 5px;">
                            <input type="text" id="feature-text" placeholder="Type a feature and press Enter"
                                   style="border: none; outline: none; flex: 1; min-width: 150px;">
                        </div>
                        <input type="hidden" name="features" id="features" value="{{ $off_plan->features }}">
                    </div>
                </div>


                <!-- Lat & Lng -->
                <x-input-row label="Lat" type="number" name="lat" value="{{$off_plan->lat}}" placeholder="Enter Lat"/>
                <x-input-row label="Lng" type="number" name="lng" value="{{$off_plan->lng}}" placeholder="Enter Lng"/>

                <!-- Description -->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description">Description</label></div>
                    <div class="col-md-8">
                        <textarea name="description" id="description" required placeholder="Enter Description" class="input_off_plan" style="border-right: 3px solid #9D865C!important">{{$off_plan->description}}</textarea>
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="youtube_link">YouTube Link</label></div>
                    <div class="col-md-8">
                        <input type="text" name="youtube_link" id="youtube_link" value="{{$off_plan->youtube_link}}" placeholder="Enter YouTube Link" class="input_off_plan"/>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" class="btn btn-primary" type="button">Update
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('feature-input');
            const input = document.getElementById('feature-text');
            const hiddenInput = document.getElementById('features');

            let features = [];

            // 🟩 Load existing features from backend (comma-separated string)
            if (hiddenInput.value.trim() !== '') {
                features = hiddenInput.value.split(',').map(f => f.trim()).filter(f => f !== '');
                features.forEach(addTag);
            }

            // 🟩 Add feature on Enter key
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && input.value.trim() !== '') {
                    e.preventDefault();
                    const value = input.value.trim();

                    if (!features.includes(value)) {
                        features.push(value);
                        addTag(value);
                        updateHiddenInput();
                    }
                    input.value = '';
                }
            });

            // 🟩 Create a tag (chip)
            function addTag(text) {
                const tag = document.createElement('span');
                tag.textContent = text;
                tag.className = 'badge bg-primary';
                tag.style.padding = '6px 10px';
                tag.style.borderRadius = '20px';
                tag.style.display = 'flex';
                tag.style.alignItems = 'center';
                tag.style.gap = '6px';
                tag.style.fontSize = '14px';
                tag.style.margin = '2px';

                const removeBtn = document.createElement('span');
                removeBtn.textContent = '×';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.fontWeight = 'bold';
                removeBtn.onclick = function() {
                    features = features.filter(f => f !== text);
                    tag.remove();
                    updateHiddenInput();
                };

                tag.appendChild(removeBtn);
                container.insertBefore(tag, input);
            }

            // 🟩 Update hidden input value
            function updateHiddenInput() {
                hiddenInput.value = features.join(',');
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

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>

    <script>
        $(document).ready(function () {
            if (window.File && window.FileList && window.FileReader) {
                $("#header_images").on("change", function (e) {
                    const files = e.target.files;
                    const filesLength = files.length;

                    for (let i = 0; i < filesLength; i++) {
                        const f = files[i];
                        const fileReader = new FileReader();

                        fileReader.onload = function (event) {
                            $("<div class='img-thumb-wrapper grid-img card shadow' style='width:100%'>" +
                                "<img class='img-thumb image-grid' src='" + event.target.result + "' title='" + f.name + "'/>" +
                                "<span class='remove'><i class='fa fa-trash'></i></span>" +
                                "</div>").appendTo(".div-grid");
                        };
                        fileReader.readAsDataURL(f);
                    }
                });


                // Remove preview (for new or existing images)
                $(document).on("click", ".div-grid .remove", function () {
                    $(this).closest(".img-thumb-wrapper").remove();
                });
            } else {
                alert("Your browser doesn't support File API");
            }
        });
    </script>

 <script>

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

            var old_images = [];
            $(".img-thumb.existing-img").each(function() {
                old_images.push($(this).attr('src'));
            });

            old_images.forEach(function(img) {
                formData.append('old_images[]', img);
            });

            formData.append('old_images', JSON.stringify(old_images));

            let singleImageInput = document.getElementById('image');
            if (singleImageInput.files.length > 0) {
                formData.append('image', singleImageInput.files[0]);
            }

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: "{{ route('off_plan_project_update', $off_plan->id) }}",
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
