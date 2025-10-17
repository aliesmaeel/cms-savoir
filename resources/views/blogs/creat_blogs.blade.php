@extends('layouts.app')

@push('head')
    <title>Create Blog</title>

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
        .cke_notification{
            display: none;
        }
        .sidebar-divider {
            display: none;
        }

        .title-input {
            color: #143e39;
            font-family: 'Lato-Bold';
            font-size: 13px;
        }

        #language {
            border-right: 1px solid #70cacc;
        }

        #name,
        #email,
        #phone,
        #password,
        #password_confirm,
        #websiteId,
        #brn,
        #Job_Description,
        #bio,
        #image,
        #title,
        #posted_by,
        #date,
        #body,
        #slug,
        /* #publish_to_web_site, */
        #language {
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
            width: 65rem;
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
    <div id="content-wrapper" class="d-flex flex-column">
        <img id="img-top" src="img/bg-top.png">
        <form id="maindata">
            <div class="container">
                <span id="alertdata"></span>

                {{-- Title Details --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="title_details">Title in Details Page</label>
                    </div>
                    <div class="col-md-8">
                        <textarea class="ckeditor input-form" name="title_details" id="title_details" style="background: #fff!important"></textarea>
                    </div>
                </div>

                {{-- Title --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="title">Title</label></div>
                    <div class="col-md-8"><input type="text" name="title" id="title" placeholder="Enter Title" required></div>
                </div>

                {{-- Slug --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="slug">Slug</label></div>
                    <div class="col-md-8"><input type="text" name="slug" id="slug" placeholder="Enter Slug" required></div>
                </div>

                {{-- Posted By --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="posted_by">Posted By</label></div>
                    <div class="col-md-8"><input type="text" name="posted_by" id="posted_by" placeholder="Enter Posted By" required></div>
                </div>

                {{-- Date --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="date">Date</label></div>
                    <div class="col-md-8"><input type="date" name="date" id="date" required></div>
                </div>

                {{-- Description 1 --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_one_title">Description 1 Title</label></div>
                    <div class="col-md-8"><input type="text" name="description_one_title" id="description_one_title" placeholder="Enter Description 1 Title"></div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_one">Description 1</label></div>
                    <div class="col-md-8"><textarea class="ckeditor input-form" name="description_one" id="description_one" style="background: #fff!important"></textarea></div>
                </div>

                {{-- Description 2 --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_two_title">Description 2 Title</label></div>
                    <div class="col-md-8"><input type="text" name="description_two_title" id="description_two_title" placeholder="Enter Description 2 Title"></div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_two">Description 2</label></div>
                    <div class="col-md-8"><textarea class="ckeditor input-form" name="description_two" id="description_two" style="background: #fff!important"></textarea></div>
                </div>

                {{-- Description 3 --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_three_title">Description 3 Title</label></div>
                    <div class="col-md-8"><input type="text" name="description_three_title" id="description_three_title" placeholder="Enter Description 3 Title"></div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_three">Description 3</label></div>
                    <div class="col-md-8"><textarea class="ckeditor input-form" name="description_three" id="description_three" style="background: #fff!important"></textarea></div>
                </div>

                {{-- Description 4 --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_four_title">Description 4 Title</label></div>
                    <div class="col-md-8"><input type="text" name="description_four_title" id="description_four_title" placeholder="Enter Description 4 Title"></div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="description_four">Description 4</label></div>
                    <div class="col-md-8"><textarea class="ckeditor input-form" name="description_four" id="description_four" style="background: #fff!important"></textarea></div>
                </div>

                {{-- Main Image --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="image">Main Image</label></div>
                    <div class="col-md-8"><input type="file" name="image" id="image" style="background: #fff!important"></div>
                </div>

                {{-- Additional Images --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="first_image">First Image</label></div>
                    <div class="col-md-8"><input type="file" name="first_image" id="first_image" style="background: #fff!important"></div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="second_image">Second Image</label></div>
                    <div class="col-md-8"><input type="file" name="second_image" id="second_image" style="background: #fff!important"></div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="third_image">Third Image</label></div>
                    <div class="col-md-8"><input type="file" name="third_image" id="third_image" style="background: #fff!important"></div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" class="btn" type="button">Create <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>

        $(document).ready(function() {
            // Auto slug
            $('#title').on('keyup', function () {
                let slug = $(this).val().toLowerCase().trim().replace(/\s+/g,'-').replace(/[^a-z\-]/g,'');
                $('#slug').val(slug);
            });


            $('#buttonsubmit').click(function(e){
                e.preventDefault();
                var formData = new FormData($('#maindata')[0]);

                // CKEditor data
                ['title_details','description_one','description_two','description_three','description_four'].forEach(id=>{
                    formData.set(id, CKEDITOR.instances[id].getData());
                });

                $.ajax({
                    url: "{{ route('create_new_blog') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend:function(){ $('#buttonsubmit').attr('disabled',true); $('.spinner-border').removeAttr('hidden'); },
                    success:function(res){ alert(res.message); location.reload(); },
                    error:function(err){ console.log(err); alert('Check form for errors'); $('#buttonsubmit').removeAttr('disabled'); $('.spinner-border').attr('hidden','hidden'); }
                });
            });

            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
