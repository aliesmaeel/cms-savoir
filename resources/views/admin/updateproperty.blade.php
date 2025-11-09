@extends('layouts.app')

@push('head')
    <title>Update Property</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('images/css/dash.css') }}">


    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" /> --}}
    <link href="{{ asset('select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
    <!-- jQuery library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
    </script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/admin/js/pages/property/removeImages.js') }}"></script>

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
            /* background-color: white; */
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
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
        }

        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;

            padding-right: 20px;
        }

        html .ui-autocomplete {
            height: 200px;
            width: 40%
        }

        .registerbtn2 {
            padding: 5px 32px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
            background: #9D865C;
            border: 0px;
            color: #fff;
        }

        .top-title {
            font-family: 'Lato-Semibold';
            font-size: 20px;
            color: #9D865C;
            height: 4rem;
            padding: 14px 35px;

            border-radius: 0 0px 55px 0;
            /* background-image: linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
        }

        .sidebar-divider {
            display: none;
        }

        .title-input {
            color: #143e39;
            font-family: 'Lato-Bold';
            font-size: 13px;
        }

        #property,
        #area,
        #price,
        #status,
        #buyerid {
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
            border: none;
            text-align: left;
            /* border-right: 3px solid #e4aa47!important; */
            box-shadow: 0 4px 2px -2px #d9d1d1;
        }

        input[type=text],
        input[type=password] {
            margin: 0 !important;
        }

        #maindata {
            /* box-shadow: 0px 0px 4px 1px #6c4d18; */
            margin: 5px;
            /* border: 1px solid #e4aa47; */
            border-radius: 5px;
            padding: 20px 51px;
            width: 87%;
            margin: 5rem auto 20rem auto;
        }

        @font-face {
            font-family: 'Lato-Semibold';
            src: url('font/Lato-Semibold.ttf');
        }

        #buttonsubmit {
            /* background:#6c4d18; */
            padding: 5px 32px;
            border-radius: 0;
            font-family: 'Lato-Semibold';
        }

        /*responsive*/
        @media(max-width: 1200px) and (min-width: 1000px) {
            .top-title {
                font-size: 17px;
            }
        }

        @media(max-width: 768px) {
            #maindata {
                width: auto;
                margin: 5rem 1rem;
            }

            .top-title {
                font-size: 17px;
            }

            #wrapper {
                height: auto;
            }
        }

        @media(max-width: 500px) {
            #maindata {
                padding: 20px 0px;
            }

            .col-title {
                position: absolute;
                left: 27px;
            }
        }

        @media(max-width: 390px) {
            .full-content {
                padding: 0 0 0 23px;
            }

            .col-title {
                left: 33px;
            }

            .top-title {
                font-size: 15px;
            }
        }

        /*end responsive*/

        .cke_contents.cke_reset {
            height: 100px !important;
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

        .row-img {
            height: 8rem;
            overflow-y: scroll;
            overflow-x: hidden;
            padding-left: 0.5rem;
        }

        .btn {
            border-radius: 0.4rem !important;
        }

        .row-img::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        .row-img::-webkit-scrollbar-track {
            background: #c5c5c5;
            border-radius: 8px;
        }

        /* Handle */
        .row-img::-webkit-scrollbar-thumb {
            background: #ef2027 !important;
            border-radius: 8px;
        }

        /* Handle on hover */
        .row-img::-webkit-scrollbar-thumb:hover {
            background: #ef2027 !important;
            border-radius: 8px;
        }

        #top-div {
            margin-left: 30px;
        }

        #img {
            width: 500px;
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

        @media (max-width: 500px) {
            .center-text {
                text-align: center !important;
                justify-content: center !important;
            }

            .card-footer {
                text-align: center !important;
            }

            #img {
                width: 100%;
            }

            .div-grid {
                overflow-x: scroll;
            }

            .div-grid-property {
                overflow-x: scroll;
            }

            #top-div {
                margin-left: 0px;
                text-align: center
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
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-9">
                <h3 class="top-title">Update Property</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- <h2 style="margin-left: 30%" class="mt-5 mb-5">Create new property</h2> -->
        <form id="maindata" class="" enctype="multipart/form-data">
            <div class="container">
                <button id="btn2" type="button" class="registerbtn2">BACK
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                </button>
                <span id="alertdata"></span>
                <!-- ALL INPUT-->

                <!-- star Row 1-->
                <h5 class="mt-3 mb-3">Property Details:</h5>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    {{-- <div class="col-md-4 col-12">
                        <label class="title-input" for="reference_number">Reference Number <span
                                style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Reference Number"
                            name="reference_number" id="reference_number" value="{{ $newProperty->reference_number }}"
                            required unique>
                    </div> --}}
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="permit_number">Permit Number <span
                                style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Permit Number" name="permit_number"
                            id="permit_number" value="{{ $newProperty->permit_number }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="property_type">Property Type <span
                                style="color:red">*</span></label>
                        <select id="property_type" name="property_type" class="form-control input-form" required>
                            <optgroup label="Residential">
                                @foreach ($property_type_residential as $item => $data)
                                    @if ($newProperty->property_type == $item)
                                        <option selected value="{{ $item }}">{{ $data }}</option>
                                    @else
                                        <option value="{{ $item }}">{{ $data }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Commercial">
                                @foreach ($property_type_Commercial as $item => $data)
                                    @if ($newProperty->property_type == $item)
                                        <option selected value="{{ $item }}">{{ $data }}</option>
                                    @else
                                        <option value="{{ $item }}">{{ $data }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
                <!-- end Row 1-->
                <!-- star Row 2-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="offering_type">Offering Type <span
                                style="color:red">*</span></label>
                        <select id="offering_type" name="offering_type" class="form-control input-form">
                            @foreach ($type as $item => $data)
                                @if ($newProperty->offering_type == $item)
                                    <option selected value="{{ $item }}">{{ $data }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $data }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="price">Price <span style="color:red">*</span></label>
                        <input type="text" min="0" class="input-form" placeholder="Enter Price"
                            name="price" id="price"
                            @if ($newProperty->price != '') value="{{ $newProperty->price }}"
                            @else value="{{ $newProperty->price }}" @endif
                            required>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="title-input" for="price-name">Price Name <span style="color:red"></span></label>
                        <input type="text" min="0" class="input-form" placeholder="Enter Price Name"
                               name="price_name" id="price-name"
                               @if ($newProperty->price_name != '') value="{{ $newProperty->price_name }}"
                               @else value="{{ $newProperty->price_name }}" @endif
                               >
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="country_id">Country</label>
                        <select id="country_id" name="country" class="form-control input-form" >
                            <option value="">Select Country </option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->name }}" data-id="{{ $country->id }}"  @if( $country->name == $newProperty->country) selected @endif>{{ $country->name }}</option>
                            @endforeach

                        </select>


                    </div>

                    <div class="col-md-4 col-12">
                        <label class="title-input" for="city">City <span style="color:red">*</span></label>
                        <select id="city" name="city" class="form-control input-form" required>
                            @foreach ($cities as $city)
                            <option value="{{ $city->name }}" @if( $city->name == $newProperty->city) selected @endif>{{ $city->name }}</option>

                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
                <!-- end Row 2-->
                @if (Auth::user()->isAgent())
                    <!-- star Row 3-->
                    <div class="row mt-4 mb-4" style="align-items: center;">
                        <div class="col-md-6 col-12">
                            <label class="title-input" for="community">Community <span style="color:red">*</span></label>
                            {{-- <input type="text" class="input-form" placeholder="Enter Community" name="community"
                                id="community" value="{{ $newProperty->community }}"> --}}
                            <select id="community" name="community" class="form-control input-form" required>
                                <option></option>
                                @foreach ($communities as $community)
                                    <option {{ $newProperty->community == $community->id ? 'selected' : '' }}
                                        value="{{ $community->id }}">{{ ucfirst($community->name) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{-- Please enter {{__('labels.users.languages')}}. --}}
                            </div>
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="title-input" for="sub_community">Sub Community <span
                                    style="color:red">*</span></label>
                            <!-- <input type="text" class="input-form" placeholder="Enter Sub Community"
                                name="sub_community" id="sub_community" value="{{ $newProperty->sub_community }}" hidden> -->
                            <select id="sub_community" name="sub_community" class="form-control input-form" required>
                                <option value=""></option>
                                @foreach ($subCommunities as $subCommunity)
                                    <option {{ $newProperty->sub_community == $subCommunity->id ? 'selected' : '' }}
                                        value="{{ $subCommunity->id }}">{{ ucfirst($subCommunity->name) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{-- Please enter {{__('labels.users.languages')}}. --}}
                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                    <!-- end Row 3-->
                @else
                    <!-- star Row 3-->
                    <div class="row mt-4 mb-4" style="align-items: center;">
                        <div class="col-md-6 col-12">
                            <label class="title-input" for="user_id">Agent <span style="color:red">*</span></label>
                            <select id="user_id" name="user_id" class="form-control input-form">
                                <option></option>
                                @foreach ($users as $user)
                                    @if ($user->id == $newProperty->user_id)
                                        <option selected value="{{ $newProperty->user_id }}">
                                            {{ $newProperty->user->name }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{-- Please enter {{__('labels.users.languages')}}. --}}
                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                    <!-- end Row 3-->
                @endif
                <!-- star Row 4-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="title_en">Title EN <span style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Title EN" name="title_en"
                            id="title_en" value="{{ $newProperty->title_en }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="title_ar">Title AR</label>
                        <input type="text" class="input-form" placeholder="Enter Title AR" name="title_ar"
                            id="title_ar" value="{{ $newProperty->title_ar }}">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="description_en">Description EN <span
                                style="color:red">*</span></label>
                        <textarea type="text" class="ckeditor input-form" placeholder="Enter Description EN" name="description_en"
                            id="description_en" required>{!! $newProperty->description_en !!}</textarea>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="title-input" for="description_ar">Description AR</label>
                        <textarea type="text" class="ckeditor input-form" placeholder="Enter Description AR" name="description_ar"
                            id="description_ar">{!! $newProperty->description_ar !!}</textarea>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="size">Size <span style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Size" name="size" id="size"
                            min="0"
                            @if ($newProperty->size != '') value="{{ number_format($newProperty->size) }}"
                            @else value="{{ $newProperty->size }}" @endif
                            required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="bedroom">Bedroom <span style="color:red">*</span></label>
                        <select id="bedroom" name="bedroom" class="form-control input-form" required>
                            @foreach ($bedrooms as $item => $data)
                                @if ($newProperty->bedroom == $item)
                                    <option selected value="{{ $item }}">{{ $data }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $data }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
                <!-- end Row 5-->
                <!-- star Row 6-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="bathroom">Bathroom</label>
                        <input type="number" class="input-form" placeholder="Enter No. of Bathrooms" name="bathroom"
                            id="bathroom" min="0" max="10" value="{{ $newProperty->bathroom }}" required>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="parking">Parking</label>
                        <input type="number" class="input-form" placeholder="Enter Parking" name="parking"
                            id="parking" min="0" max="999" value="{{ $newProperty->parking }}">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="title-input" for="slug">Slug <span
                                style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Slug" name="slug"
                            id="slug" value="{{ $newProperty->slug }}" required>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="property_status">Property Status </label>
                        <select id="property_status" name="property_status" class="form-control input-form" required>
                            <option></option>
                            <option @if($newProperty->property_status == 'Live') selected @endif value="Live">Live</option>
                            <option @if($newProperty->property_status == 'Archive') selected @endif value="Archive">Archive</option>
                        </select>
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="property_name">Property Name </label>
                        <input type="text" value="{{ $newProperty->property_name }}"  class="input-form" placeholder="Enter Property Name"
                            name="property_name" id="property_name" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="completion_status">Completion Status <span style="color:red">*</span></label>
                        <select id="completion_status" name="completion_status" class="form-control input-form"
                            onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                            <option></option>
                            <option @if($newProperty->completion_status == 'completed') selected @endif value="completed">Completed</option>
                            <option @if($newProperty->completion_status == 'off_plan') selected @endif value="off_plan">Off_Plan</option>

                        </select>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>

                     </div>

                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="project_name">Project Name <span style="color:red">*</span></label>
                        <input type="text" value="{{ $newProperty->project_name }}" class="input-form" placeholder="Project Name" name="project_name" id="project_name"
                            required>
                    </div>


                    <div class="col-md-4 col-12">
                        <input type="checkbox" name="featured" @if($newProperty->featured) checked @endif  id="featured">
                        <label class="title-input"  for="featured">Is Featured </label>

                        <div class="invalid-feedback">
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="title-input" for="has_tour">Has Tour <span style="color:red">*</span></label>
                        <input type="text" value="{{$newProperty->has_tour}}"  class="input-form" placeholder="Has Tour Link" name="has_tour" id="has_tour"
                               required>
                    </div>

                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-12 col-12">
                        <label class="title-input" for="private_amenities">Private Amenities</label>
                        <select id="private_amenities" name="private_amenities[]" class="form-control input-form"
                            multiple>
                            @foreach ($private_amenities as $item => $data)
                                @if (in_array($item, explode(',', $newProperty->private_amenities)))
                                    <option selected value="{{ $item }}">{{ $data }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $data }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                    </div>
                </div>


                <!-- end Row 6-->
                <!-- star Row 7-->
                <h5>Media:</h5>
                {{-- <div class="row mt-4 mb-4" style="align-items: center;">
                                    <div class="col-md-12 col-12">
                                        <label class="title-input" for="photo">Photo</label>
                                        <input type="file" class="input-form" placeholder="Enter Photo" name="photo[]"
                                            id="photo" multiple>
                                        @foreach ($property_images as $property_imag)
                                            <img src="{{ asset('storage/properties/images/' . $property_imag->url) }}" alt=""
                                                width="75px" height="75px">
                                        @endforeach
                                    </div>
                                </div> --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3 form-group">
                            <label class="form-label" for="photo">
                            Photo
                            </label>
                            <div class="row row-img">
                                <div class="div-grid">
                                    <div class="grid-img">
                                        <div class="wrapper">
                                            <div class="file-upload-multi">
                                                <input name="photo[]" id="photo" type="file" multiple />
                                                    <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($property_images)
                                        @foreach ($property_images as $property_imag)
                                            <div class="img-thumb-wrapper grid-img card shadow" style="width: 100%">
                                                <img class="img-thumb image-grid"
                                                @if($property_imag->is_external_image)
                                                src="{{  $property_imag->url }}"
                                                @else
                                                src="{{ config('services.cms_link').'/storage/properties/images/'.$property_imag->url }}"
                                                @endif
                                                title="" />
                                                <span class="remove">
                                                <i class="fa fa-trash"></i>
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            @error('inventory_images')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- end Row 7-->
                <!-- star Row 8-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-12 col-12">
                        <label class="title-input" for="floor_plan">Floor Plan</label>
                        <input type="file" class="input-form" placeholder="Enter Floor Plan" name="floor_plan[]"
                            id="floor_plan" multiple>
                        @foreach ($property_floor as $property_floors)
                            <img src="{{ config('services.cms_link').'/storage/properties/FloorPrperty/'. $property_floors->url }}"
                                alt="" width="75px" height="75px">
                        @endforeach
                    </div>
                </div>

                <!-- end Row 8-->

                <h5>Location:</h5>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="community">Community <span style="color:red">*</span></label>
                        {{-- <input type="text" class="input-form" placeholder="Enter Community" name="community"
                        id="community" value="{{ $newProperty->community }}"> --}}
                        <select id="community" name="community" class="form-control input-form" required>
                                <option></option>
                                @foreach ($communities as $community)
                                    <option {{ $newProperty->community == $community->id ? 'selected' : '' }}
                                        value="{{ $community->id }}">{{ ucfirst($community->name) }}</option>
                                @endforeach
                            </select>
                        <div class="invalid-feedback">
                        {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                        </div>
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="sub_community">Sub Community <span
                        style="color:red">*</span></label>
                        <!-- <input type="text" class="input-form" placeholder="Enter Sub Community" name="sub_community"
                        id="sub_community" value="{{ $newProperty->sub_community }}" hidden> -->
                        <select id="sub_community" name="sub_community" class="form-control input-form" required>
                                <option value=""></option>
                                @foreach ($subCommunities as $subCommunity)
                                    <option {{ $newProperty->sub_community == $subCommunity->id ? 'selected' : '' }}
                                        value="{{ $subCommunity->id }}">{{ ucfirst($subCommunity->name) }}</option>
                                @endforeach
                            </select>
                        <div class="invalid-feedback">
                        {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>





                <!-- search input box -->
                <div class="form-group input-group">
                    <input type="text" id="search_location" class="form-control" placeholder="Search location">
                    <div class="input-group-btn">
                        <!-- <button class="btn btn-default get_map" type="submit">
                        Locate
                        </button> -->
                    </div>
                </div>
                <!-- display google map -->
                <div id="geomap"></div>

                <!-- display selected location information -->
                {{-- <h4>Location Details</h4> --}}
                {{-- <p>Address: --}}
                <input type="text" class="search_addr" size="45" hidden>
                {{-- </p> --}}
                {{-- <p>Latitude: --}}
                <input type="text" class="search_latitude" id="search_latitude" name="search_latitude" value="{{$newProperty->lat}}"  size="30" hidden>
                {{-- </p> --}}
                {{-- <p>Longitude: --}}
                <input type="text" class="search_longitude" id="search_longitude" name="search_longitude" value="{{$newProperty->lng}}"  size="30" hidden>
                {{-- </p> --}}

                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" type="button" class="registerbtn">Update
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            hidden></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Modal -->
        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Logo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="watermark">Logo</label>
                                <input class="form-control" type="file" name="watermark" id="watermark">
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="watermark_width">Width</label>
                                <input class="form-control" type="number" min="0" name="watermark_width"
                                id="watermark_width">
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="watermark_height">Height</label>
                                <input class="form-control" type="number" min="0" name="watermark_height"
                                id="watermark_height">
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="watermark_position">Position</label>
                                <select name="watermark_position" id="watermark_position" class="form-control">
                                <option value="top-left">top-left</option>
                                <option value="top">top</option>
                                <option value="top-right">top-right</option>
                                <option value="left">left</option>
                                <option value="center">center</option>
                                <option value="right">right</option>
                                <option value="bottom-left">bottom-left</option>
                                <option value="bottom">bottom</option>
                                <option value="bottom-right">bottom-right</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="modal_close">Ok</button>
                    </div>
                </div>
            </div>
        </div> --}}
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
{{-- <script src="vendor/jquery/jquery.min.js"></script> --}}

<!-- Core plugin JavaScript-->
{{-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> --}}

<!-- Custom scripts for all pages-->
{{-- <script src="js/sb-admin-2.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('select.custom-select').val($('select.custom-select > option:last').val()).change();
    });
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>

<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

{{-- <script src="{{ asset('select2/admin/upload_image.js') }}"></script> --}}

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
</script>
<script src="{{ asset('select2/js/select2.min.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script>
    // $('#photo').change(function() {
    //     $('#exampleModal').modal('show');
    // });
    // $('#modal_close').click(function() {
    //     $('#exampleModal').modal('hide');
    // });

    // $('#watermark').change(function(e) {
    //     var reader = new FileReader();
    //     reader.readAsDataURL($(this).prop('files')[0]);
    //     reader.onload = function(e) {
    //         var image = new Image();
    //         image.src = e.target.result;
    //         image.onload = function() {
    //             var height = this.height;
    //             var width = this.width;
    //             $('#watermark_width').val(width);
    //             $('#watermark_height').val(height);
    //         };
    //     }
    // });
</script>

<script>
    $('#offering_type').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>

<script>
    $('#property_type').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>

<script>
    $('#city').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>

<script>
    $('#community').select2({
        width: '100%',
        placeholder: "Select an Community",
        allowClear: true,
    });
</script>

<script>
    $('#sub_community').select2({
        width: '100%',
        placeholder: "Select an Sub Community",
        allowClear: true,
    });
</script>

<script>
    $('#property_name').select2({
        width: '100%',
        placeholder: "Select an Property Name",
        allowClear: true,
    });
</script>
<script>
    $('#private_amenities').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>

<script>
    $('#bedroom').select2({
        width: '100%',
        placeholder: "Select an Bedroom",
        allowClear: true,
    });
</script>
<script>
    $('#bathroom').select2({
        width: '100%',
        placeholder: "Select an Bathroom",
        allowClear: true,
    });
</script>
<script>
    $('#completion_status').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true
    });
</script>
<script>
    $('#cheques').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true
    });
</script>
<script>
    $('#furnished').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#d_furnished').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#view360').select2({
        width: '100%',
        placeholder: "Select an View360",
        allowClear: true,
    });
</script>
<script>
    $('#user_id').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#property_purpose').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#property_status').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#off_plan').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#rent_Frequency').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#property_size_unit').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $('#tower_name').select2({
        width: '100%',
        placeholder: "Select an Option",
        allowClear: true,
    });
</script>
<script>
    $(function() {
        $('#Dubizzle').each(function showDubizzle() {
            var bayuttext = document.getElementById("bayut_input");
            var bayuttext2 = document.getElementById("bayut_input2");
            var bayuttext3 = document.getElementById("bayut_input3");

            var dubizzletext = document.getElementById("dubizzle_input");
            var dubizzletext2 = document.getElementById("dubizzle_input2");
            var dubizzletext3 = document.getElementById("dubizzle_input3");

            var findertext = document.getElementById("finder_input");
            var findertext2 = document.getElementById("finder_input2");
            var findertext3 = document.getElementById("finder_input3");

            if ($(this).is(":checked")) {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";

                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";

                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";

                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";

                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        }
                    }
                }

            } else {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    $(function() {
        $('#Bayut').each(function showDubizzle() {
            var bayuttext = document.getElementById("bayut_input");
            var bayuttext2 = document.getElementById("bayut_input2");
            var bayuttext3 = document.getElementById("bayut_input3");

            var dubizzletext = document.getElementById("dubizzle_input");
            var dubizzletext2 = document.getElementById("dubizzle_input2");
            var dubizzletext3 = document.getElementById("dubizzle_input3");

            var findertext = document.getElementById("finder_input");
            var findertext2 = document.getElementById("finder_input2");
            var findertext3 = document.getElementById("finder_input3");
            if ($(this).is(":checked")) {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                }

            } else {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    $(function() {
        $('#finder').each(function showDubizzle() {
            var bayuttext = document.getElementById("bayut_input");
            var bayuttext2 = document.getElementById("bayut_input2");
            var bayuttext3 = document.getElementById("bayut_input3");

            var dubizzletext = document.getElementById("dubizzle_input");
            var dubizzletext2 = document.getElementById("dubizzle_input2");
            var dubizzletext3 = document.getElementById("dubizzle_input3");

            var findertext = document.getElementById("finder_input");
            var findertext2 = document.getElementById("finder_input2");
            var findertext3 = document.getElementById("finder_input3");

            if ($(this).is(":checked")) {
                if ($('#Bayut').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                }

            } else {
                if ($('#Bayut').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    $(function() {
        $('#emiratesEstate').each(function showDubizzle() {
            var bayuttext = document.getElementById("bayut_input");
            var bayuttext2 = document.getElementById("bayut_input2");
            var bayuttext3 = document.getElementById("bayut_input3");

            var dubizzletext = document.getElementById("dubizzle_input");
            var dubizzletext2 = document.getElementById("dubizzle_input2");
            var dubizzletext3 = document.getElementById("dubizzle_input3");

            var findertext = document.getElementById("finder_input");
            var findertext2 = document.getElementById("finder_input2");
            var findertext3 = document.getElementById("finder_input3");

            if ($(this).is(":checked")) {
                if ($('#Bayut').is(":checked")) {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                }

            } else {
                if ($('#Bayut').is(":checked")) {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                } else {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "block";
                            findertext2.style.display = "block";
                            findertext3.style.display = "block";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            bayuttext2.style.display = "block";
                            bayuttext3.style.display = "block";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "block";
                            dubizzletext2.style.display = "block";
                            dubizzletext3.style.display = "block";
                        } else {
                            bayuttext.style.display = "none";
                            bayuttext2.style.display = "none";
                            bayuttext3.style.display = "none";
                            findertext.style.display = "none";
                            findertext2.style.display = "none";
                            findertext3.style.display = "none";
                            dubizzletext.style.display = "none";
                            dubizzletext2.style.display = "none";
                            dubizzletext3.style.display = "none";
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    function showBayut() {
        var Dubizzle = document.getElementById("Dubizzle");
        var Bayut = document.getElementById("Bayut");
        var emiratesEstate = document.getElementById("emiratesEstate");
        var finder = document.getElementById("finder");
        var bayuttext = document.getElementById("bayut_input");
        var bayuttext2 = document.getElementById("bayut_input2");
        var bayuttext3 = document.getElementById("bayut_input3");

        var dubizzletext = document.getElementById("dubizzle_input");
        var dubizzletext2 = document.getElementById("dubizzle_input2");
        var dubizzletext3 = document.getElementById("dubizzle_input3");

        var findertext = document.getElementById("finder_input");
        var findertext2 = document.getElementById("finder_input2");
        var findertext3 = document.getElementById("finder_input3");

        if (Bayut.checked == true) {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            }
        } else {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            }
        }
    }
</script>
<script>
    function showDubizzle() {
        var Dubizzle = document.getElementById("Dubizzle");
        var Bayut = document.getElementById("Bayut");
        var emiratesEstate = document.getElementById("emiratesEstate");
        var finder = document.getElementById("finder");
        var bayuttext = document.getElementById("bayut_input");
        var bayuttext2 = document.getElementById("bayut_input2");
        var bayuttext3 = document.getElementById("bayut_input3");

        var dubizzletext = document.getElementById("dubizzle_input");
        var dubizzletext2 = document.getElementById("dubizzle_input2");
        var dubizzletext3 = document.getElementById("dubizzle_input3");

        var findertext = document.getElementById("finder_input");
        var findertext2 = document.getElementById("finder_input2");
        var findertext3 = document.getElementById("finder_input3");
        if (Dubizzle.checked == true) {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    }
                }
            }
        } else {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            }
        }
    }
</script>
<script>
    function showfinder() {
        var Dubizzle = document.getElementById("Dubizzle");
        var Bayut = document.getElementById("Bayut");
        var emiratesEstate = document.getElementById("emiratesEstate");
        var finder = document.getElementById("finder");
        var bayuttext = document.getElementById("bayut_input");
        var bayuttext2 = document.getElementById("bayut_input2");
        var bayuttext3 = document.getElementById("bayut_input3");

        var dubizzletext = document.getElementById("dubizzle_input");
        var dubizzletext2 = document.getElementById("dubizzle_input2");
        var dubizzletext3 = document.getElementById("dubizzle_input3");

        var findertext = document.getElementById("finder_input");
        var findertext2 = document.getElementById("finder_input2");
        var findertext3 = document.getElementById("finder_input3");

        if (finder.checked == true) {
            if (Dubizzle.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            }
        } else {
            if (Dubizzle.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            }
        }
    }
</script>
<script>
    function showEmiratesEstate() {
        var Dubizzle = document.getElementById("Dubizzle");
        var Bayut = document.getElementById("Bayut");
        var emiratesEstate = document.getElementById("emiratesEstate");
        var finder = document.getElementById("finder");
        var bayuttext = document.getElementById("bayut_input");
        var bayuttext2 = document.getElementById("bayut_input2");
        var bayuttext3 = document.getElementById("bayut_input3");

        var dubizzletext = document.getElementById("dubizzle_input");
        var dubizzletext2 = document.getElementById("dubizzle_input2");
        var dubizzletext3 = document.getElementById("dubizzle_input3");

        var findertext = document.getElementById("finder_input");
        var findertext2 = document.getElementById("finder_input2");
        var findertext3 = document.getElementById("finder_input3");

        if (emiratesEstate.checked == true) {
            if (Dubizzle.checked == true) {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            } else {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            }
        } else {
            if (Dubizzle.checked == true) {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "block";
                        dubizzletext2.style.display = "block";
                        dubizzletext3.style.display = "block";
                    }
                }
            } else {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "block";
                        findertext2.style.display = "block";
                        findertext3.style.display = "block";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        bayuttext2.style.display = "block";
                        bayuttext3.style.display = "block";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        bayuttext2.style.display = "none";
                        bayuttext3.style.display = "none";
                        findertext.style.display = "none";
                        findertext2.style.display = "none";
                        findertext3.style.display = "none";
                        dubizzletext.style.display = "none";
                        dubizzletext2.style.display = "none";
                        dubizzletext3.style.display = "none";
                    }
                }
            }
        }
    }
</script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });
</script>
<script>
    function updateTextView(_obj) {
        var num = _obj.val();
        if (isNaN(num)) {
            _obj.val('');
        } else {
            _obj.val(num.toLocaleString());
        }
    }

    function getNumber(_str) {
        var arr = _str.split('');
        var out = new Array();
        for (var cnt = 0; cnt < arr.length; cnt++) {
            if (isNaN(arr[cnt]) == false) {
                out.push(arr[cnt]);
            }
        }
        return Number(out.join(''));
    }
    $(document).ready(function() {
        $('#price').on('keyup', function() {
            updateTextView($(this));
        });

        $('#size').on('keyup', function() {
            updateTextView($(this));
        });
        $('#plot_size').on('keyup', function() {
            updateTextView($(this));
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('select[name="completion_status"]').on('change', function() {
            var SectionId = $(this).val();
            if (SectionId) {
                if (SectionId == 'completed') {
                    $('select[name="off_plan"]').empty();
                    $('select[name="off_plan"]').append(
                        '<option>No</option>');
                } else {
                    $('select[name="off_plan"]').empty();
                    $('select[name="off_plan"]').append(
                        '<option>Yes</option>');
                }
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        if (window.File && window.FileList && window.FileReader) {
            $("#photo").on("change", function(e) {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;
                        $("<div class=\"img-thumb-wrapper grid-img card shadow\" style=\"width: 100%\">" +
                            "<img class=\"img-thumb image-grid\" src=\"" + e.target.result +
                            "\" title=\"" + file.name + "\"/>" +
                            "<span class=\"remove\"><i class=\"fa fa-trash\"></i></span>" +
                            "</div>").appendTo(".div-grid");
                        $(".remove").click(function() {
                            $(this).parent(".img-thumb-wrapper").remove();
                        });

                    });
                    fileReader.readAsDataURL(f);
                }
                console.log(files);
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
        $(".remove").click(function() {
            $(this).parent(".img-thumb-wrapper").remove();
        });
    });
</script>
<script>
        $('#community').change(function() {
            var communit_id = $(this).val();
            $.ajax({
                url: "{{ route('get_sub_community') }}" + "/" + communit_id,
                success: function(result) {
                    $('#sub_community').empty();
                    var emptyRow = "<option value=''></option>";
                    $('#sub_community').append(emptyRow);
                    $.each(result, function(item, value) {
                        var row = "<option value=" + value.id + ">" + value.name + "</option>";
                        $('#sub_community').append(row);
                    });
                }
            });
        });
    </script>
    <script>
        $('#sub_community').change(function() {
            var sub_community_id = $(this).val();
            $.ajax({
                url: "{{ route('get_tower_name') }}" + "/" + sub_community_id,
                success: function(result) {
                    $('#tower_name').empty();
                    var emptyRow = "<option value=''></option>";
                    $('#tower_name').append(emptyRow);
                    $.each(result, function(item, value) {
                        var row = "<option value=" + value.id + ">" + value.building_name + "</option>";
                        $('#tower_name').append(row);
                    });
                }
            });
        });
    </script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map_key') }}&libraries=places"></script>
<script>
    var geocoder;
    var map;
    var marker;

    /*
     * Google Map with marker
     */
    function initialize() {
        var temp = "{{ $initial_pos }}";
        var initialLat = $('.search_latitude').val();
        var initialLong = $('.search_longitude').val();
        initialLat = initialLat ? initialLat : temp.split(",")[0];
        initialLong = initialLong ? initialLong : temp.split(",")[1];

        var latlng = new google.maps.LatLng(initialLat, initialLong);
        var options = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("geomap"), options);

        geocoder = new google.maps.Geocoder();

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: latlng
        });

        google.maps.event.addListener(marker, "dragend", function() {
            var point = marker.getPosition();
            map.panTo(point);
            geocoder.geocode({
                'latLng': marker.getPosition()
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    $('.search_addr').val(results[0].formatted_address);
                    $('.search_latitude').val(marker.getPosition().lat());
                    $('.search_longitude').val(marker.getPosition().lng());
                    $('#geopoints').val($("#search_latitude").val() + "," + $("#search_longitude")
                        .val())
                    $('#d_geopoints').val($("#search_latitude").val() + "," + $("#search_longitude")
                        .val())
                }
            });
        });

    }

    $(document).ready(function() {
        //load google map
        initialize();

        /*
         * autocomplete location search
         */
        var PostCodeid = '#search_location';
        $(function() {
            $(PostCodeid).autocomplete({
                source: function(request, response) {
                    var input = document.getElementById('search_location');
                            var autocomplete = new google.maps.places.Autocomplete(input);
                            autocomplete.addListener('place_changed', function () {
                                var place = autocomplete.getPlace();
                                $('#search_latitude').val(place.geometry['location'].lat());
                                $('#search_longitude').val(place.geometry['location'].lng());
                                $('#geopoints').val($("#search_latitude").val() + "," + $(
                                    "#search_longitude").val())
                                $('#d_geopoints').val($("#search_latitude").val() + "," + $(
                                    "#search_longitude").val())
                                var latlng = new google.maps.LatLng(place.geometry['location'].lat(), place.geometry['location'].lng());
                                marker.setPosition(latlng);
                                initialize();
                            });
                    // geocoder.geocode({
                    //     'address': request.term
                    // }, function(results, status) {
                    //     response($.map(results, function(item) {
                    //         return {
                    //             label: item.formatted_address,
                    //             value: item.formatted_address,
                    //             lat: item.geometry.location.lat(),
                    //             lon: item.geometry.location.lng(),
                    //         };
                    //     }));
                    // });
                },
                // select: function(event, ui) {
                //     $('.search_addr').val(ui.item.value);
                //     $('.search_latitude').val(ui.item.lat);
                //     $('.search_longitude').val(ui.item.lon);
                //     $('#geopoints').val($("#search_latitude").val() + "," + $(
                //         "#search_longitude").val())
                //     $('#d_geopoints').val($("#search_latitude").val() + "," + $(
                //         "#search_longitude").val())
                //     var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
                //     marker.setPosition(latlng);
                //     initialize();
                // }
            });
        });

        /*
         * Point location on google map
         */
        $('.get_map').click(function(e) {
            var address = $(PostCodeid).val();
            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    $('.search_addr').val(results[0].formatted_address);
                    $('.search_latitude').val(marker.getPosition().lat());
                    $('.search_longitude').val(marker.getPosition().lng());
                    $('#geopoints').val($("#search_latitude").val() + "," + $(
                        "#search_longitude").val())
                    $('#d_geopoints').val($("#search_latitude").val() + "," + $(
                        "#search_longitude").val())

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
            e.preventDefault();
        });

        //Add listener to marker for reverse geocoding
        google.maps.event.addListener(marker, 'drag', function() {
            geocoder.geocode({
                'latLng': marker.getPosition()
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        $('.search_addr').val(results[0].formatted_address);
                        $('.search_latitude').val(marker.getPosition().lat());
                        $('.search_longitude').val(marker.getPosition().lng());
                        $('#geopoints').val($("#search_latitude").val() + "," + $(
                            "#search_longitude").val())
                        $('#d_geopoints').val($("#search_latitude").val() + "," + $(
                            "#search_longitude").val())

                    }
                }
            });
        });
    });
</script>
<script>
    $('#buttonsubmit').click(function(e) {
        $("#alertdata").empty();
        e.preventDefault();
        var formData = new FormData();

        $('#maindata').serializeArray().forEach(function(field) {
            formData.append(field.name, field.value);
        });

        formData.append("_token", "{{ csrf_token() }}");

        let TotalFiles = $('#photo')[0].files.length; //Total files
        let files = $('#photo')[0];
        for (let i = 0; i < TotalFiles; i++) {
            formData.append('files' + i, files.files[i]);
        }
        formData.append('TotalFiles', TotalFiles);
        let FloorPlan = $('#floor_plan')[0].files.length; //Total videos
        let floorplans = $('#floor_plan')[0];
        for (let i = 0; i < FloorPlan; i++) {
            formData.append('floorplans' + i, floorplans.files[i]);
        }
        formData.append('FloorPlan', FloorPlan);


        var description_en = CKEDITOR.instances.description_en.getData();
        var description_ar = CKEDITOR.instances.description_ar.getData();
        formData.append('description_en', description_en);
        formData.append('description_ar', description_ar);

        var old_images = [];
        $(".img-thumb").each(function(val, obj) {
            old_images.push(obj.src);
        });
        formData.append('old_images', JSON.stringify(old_images));

        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            enctype: 'multipart/form-data',
            url: "{{ route('update_new_property', $newProperty->id) }}",
            beforeSend: function() {
                $('#buttonsubmit').attr('disabled', 'disabled');
                $('.spinner-border').removeAttr('hidden');
            },
            success: function(result) {
                if (result.success) {
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $("#maindata")[0].reset();
                    $('#buttonsubmit').removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
                    window.location.href = "{{ route('list_properties_index') }}";
                    // window.location.href = "http://localhost:8000/listpropertiesindex";

                } else {
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-danger'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $('#buttonsubmit').removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
                }
            },
            error: function(error) {
                $("#alertdata").empty();
                $.each(error.responseJSON.errors, function(index, value) {
                    $("#alertdata").append(
                        "<div class= 'alert alert-danger'>" +
                        "   " + value + "</div>");
                });
                $("#alertdata").attr('hidden', false);
                $('#buttonsubmit').removeAttr('disabled');
                $('.spinner-border').attr('hidden', 'hidden');
            }
        });
    });
</script>
<script>
    $('#btn2').click(function(e) {
        $("#alertdata").empty();
        e.preventDefault();
        var formData = new FormData();


        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            enctype: 'multipart/form-data',
            url: "{{ route('list_properties_index') }}",
            beforeSend: function() {
                $('#btn2').attr('disabled', 'disabled');
                $('.spinner-border').removeAttr('hidden');
                window.location.href = "{{ route('list_properties_index') }}";

            },

        });
    });
</script>
<script>

    $(document).ready(function() {
        $('#country_id').on('change',function(){
            if ($(this).find(':selected').data('id')) {
                $.ajax({
                    url: "{{ route('get_cities') }}" + "/" + $(this).find(':selected').data('id'),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#city').empty();
                        var empty_row = '<option value="">Select City</option>';
                        $('#city').append(empty_row);
                        $.each(data, function(key, value) {
                            $('#city').append(
                                '<option value="' + value.name + '">' + value
                                .name +
                                '</option>');
                        });

                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        })
    })
</script>
@endpush
