@extends('layouts.app')

@push('head')
    <title>Show property</title>

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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>image slider</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

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
            color: #9D865C;
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
        .image-slider {
            width: 50%;
            height: auto;
            display: flex;
            justify-content: center;
            margin: auto;
            margin-top: 3rem;
            margin-bottom: 3rem;
        }

        .image-holder {
            width: 150%;
            height: 150px;
            border-radius: 25px;
            margin: 5px auto;
            box-shadow: 0 0 15px black;
            transition: all 0.5s ease-in;
        }

        .material-icons-outlined {
            font-size: 50px;
            position: relative;
            top: 50px;
            border-radius: 30px;
            background-color: rgba(158, 170, 170, 0.541);
            height: 50px;
            padding: 5px;
            color: rgb(66, 65, 65);
            box-shadow: 0 0 15px black;
            cursor: pointer;
            user-select: none;


        }

        .back {
            left: 5%;
        }

        .back:active {
            background-color: rgba(28, 207, 207, 0.541);

        }

        .forward {
            right: 5%;
        }

        .forward:active {
            background-color: rgba(28, 207, 207, 0.541);
        }
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-9">
                <h3 class="top-title">Show Property</h3>
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
                <!-- star Row 7-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-12 col-12">
                        <label class="title-input" for="photo">Photo</label>
                        <input type="text" class="input-form" placeholder="Enter Photo" name="photo[]" id="photo"
                            multiple readonly>
                        @foreach ($property_images as $property_imag)
                            <img @if($property_imag->is_external_image)
                            src="{{  $property_imag->url }}"
                            @else
                            src="{{ config('services.cms_link').'/storage/properties/images/' . $property_imag->url }}"
                            @endif alt=""
                                width="75px" height="75px">
                        @endforeach
                    </div>
                </div>
                <!-- end Row 7-->
                <!-- star Row 8-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-12 col-12">
                        <label class="title-input" for="floor_plan">Floor Plan</label>
                        <input type="text" class="input-form" placeholder="Enter Floor Plan" name="floor_plan[]"
                            id="floor_plan" multiple readonly>
                        @foreach ($property_floor as $property_floors)
                            <img src="{{ config('services.cms_link') .'/storage/properties/FloorPrperty/' . $property_floors->url }}"
                                alt="" width="75px" height="75px">
                        @endforeach
                    </div>
                </div>
                <!-- end Row 8-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="reference_number">Reference Number <span
                                style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Reference Number"
                            name="reference_number" id="reference_number" value="{{ $newProperty->reference_number }}"
                            readonly unique>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="permit_number">Permit Number <span
                                style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Permit Number" name="permit_number"
                            id="permit_number" value="{{ $newProperty->permit_number }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="property_type">Property Type <span
                                style="color:red">*</span></label>
                        <select id="property_type" name="property_type" class="form-control input-form" readonly>
                            @foreach ($property_type as $item => $data)
                                @if ($newProperty->property_type == $item)
                                    <option selected value="{{ $item }}">{{ $data }}</option>
                                @endif
                            @endforeach
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
                        <select id="offering_type" name="offering_type" class="form-control input-form" readonly>
                            @foreach ($type as $item => $data)
                                @if ($newProperty->offering_type == $item)
                                    <option selected value="{{ $item }}">{{ $data }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="price">Price <span style="color:red">*</span></label>
                        <input type="number" min="0" class="input-form" placeholder="Enter Price"
                            name="price" id="price" value="{{ $newProperty->price }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="city">City <span style="color:red">*</span></label>
                        <select id="city" name="city" class="form-control input-form" readonly>
                            @foreach ($city as $item => $data)
                                @if ($newProperty->city == $item)
                                    <option selected value="{{ $item }}">{{ $data }}</option>
                                @endif
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
                            <input type="text" class="input-form" placeholder="Enter Community" name="community"
                                id="community" value="{{ $newProperty->pcommunity->name }}" readonly>
                            {{-- <input type="text" class="input-form" placeholder="Enter Community" name="community"
                                id="community" value="{{ $community }}" readonly> --}}
                            <div class="invalid-feedback">
                                {{-- Please enter {{__('labels.users.languages')}}. --}}
                            </div>
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="title-input" for="sub_community">Sub Community <span
                                    style="color:red">*</span></label>
                            <input type="text" class="input-form" placeholder="Enter Sub Community"
                                name="sub_community" id="sub_community" value="{{ $newProperty->psubcommunity->name }}" readonly>
                            {{-- <input type="text" class="input-form" placeholder="Enter Sub Community"
                                name="sub_community" id="sub_community" value="{{ $subCommunity }}" readonly> --}}
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
                        <div class="col-md-4 col-12">
                            <label class="title-input" for="community">Community <span style="color:red">*</span></label>
                            <input type="text" class="input-form" placeholder="Enter Community" name="community"
                                id="community" value="{{ $newProperty->pcommunity->name }}" readonly>
                            {{-- <input type="text" class="input-form" placeholder="Enter Community" name="community"
                                id="community" value="{{ $community }}" readonly> --}}
                            <div class="invalid-feedback">
                                {{-- Please enter {{__('labels.users.languages')}}. --}}
                            </div>
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-4 col-12">
                            <label class="title-input" for="sub_community">Sub Community <span
                                    style="color:red">*</span></label>
                            <input type="text" class="input-form" placeholder="Enter Sub Community"
                                name="sub_community" id="sub_community" value="{{ $newProperty->psubcommunity->name }}"
                                readonly>
                            {{-- <input type="text" class="input-form" placeholder="Enter Sub Community"
                                name="sub_community" id="sub_community" value="{{ $subCommunity }}"
                                readonly> --}}
                            <div class="invalid-feedback">
                                {{-- Please enter {{__('labels.users.languages')}}. --}}
                            </div>
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-4 col-12">
                            <label class="title-input" for="user_id">Agent <span style="color:red">*</span></label>
                            <select id="user_id" name="user_id" class="form-control input-form" readonly>
                                <option></option>
                                @foreach ($users as $user)
                                    @if ($user->id == $newProperty->user_id)
                                        <option selected value="{{ $newProperty->user_id }}">
                                            {{ $newProperty->user->name }}</option>
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
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="title_en">Title EN <span style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Title EN" name="title_en"
                            id="title_en" value="{{ $newProperty->title_en }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="title_ar">Title AR</label>
                        <input type="text" class="input-form" placeholder="Enter Title AR" name="title_ar"
                            id="title_ar" value="{{ $newProperty->title_ar }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="description_en">Description EN <span
                                style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Description EN"
                            name="description_en" id="description_en" value="{{ $newProperty->description_en }}"
                            readonly>
                    </div>
                </div>
                <!-- end Row 4-->
                <!-- star Row 5-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="description_ar">Description AR</label>
                        <input type="text" class="input-form" placeholder="Enter Description AR"
                            name="description_ar" id="description_ar" value="{{ $newProperty->description_ar }}"
                            readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="size">Size <span style="color:red">*</span></label>
                        <input type="text" class="input-form" placeholder="Enter Size" name="size" id="size"
                            min="0" value="{{ $newProperty->size }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="bedroom">Bedroom <span style="color:red">*</span></label>
                        <input type="number" class="input-form" placeholder="Enter No. of Bedrooms" name="bedroom"
                            id="bedroom" min="0" max="10" value="{{ $newProperty->bedroom }}" readonly>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
                <!-- end Row 5-->
                <!-- star Row 6-->
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="bathroom">Bathroom</label>
                        <input type="number" class="input-form" placeholder="Enter No. of Bathrooms" name="bathroom"
                            id="bathroom" min="0" max="10" value="{{ $newProperty->bathroom }}" readonly>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                        {{-- </div> --}}
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="title-input" for="private_amenities">Private Amenities</label>
                        <select id="private_amenities" name="private_amenities[]" class="form-control input-form"
                            multiple readonly>
                            @foreach ($private_amenities as $item => $data)
                                @if (in_array($item, explode(',', $newProperty->private_amenities)))
                                    <option selected value="{{ $item }}">{{ $data }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{-- Please enter {{__('labels.users.languages')}}. --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="title-input" for="bathroom">has tour</label>
                    <input type="text" class="input-form"  name="has_tour"
                           id="bathroom"  value="{{ $newProperty->has_tour }}" readonly>
                    <div class="invalid-feedback">
                        {{-- Please enter {{__('labels.users.languages')}}. --}}
                    </div>
                    {{-- </div> --}}
                </div>

                <!-- end Row 6-->
                <!-- finder_input-->
                <div style="display: none" id="finder_input">
                    <!-- star Row 9-->
                    <div class="row mt-4 mb-4" style="align-items: center;">
                        <div class="col-md-4 col-12">
                            <label class="title-input" for="service_charge">Service Charge</label>
                            @if (isset($finder_property->service_charge))
                                <input type="number" class="input-form" placeholder="Enter Service Charge"
                                    name="service_charge" id="service_charge" min="0"
                                    value="{{ $finder_property->service_charge }}" readonly>
                            @elseif(isset($emirates_property->service_charge))
                                <input type="number" class="input-form" placeholder="Enter Service Charge"
                                    name="service_charge" id="service_charge" min="0"
                                    value="{{ $emirates_property->service_charge }}" readonly>
                            @else
                                <input type="number" class="input-form" placeholder="Enter Service Charge"
                                    name="service_charge" id="service_charge" min="0" value="" readonly>
                            @endisset
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="title-input" for="cheques">Cheques</label>
                        @if (isset($finder_property->cheques))
                            <input type="number" min="1" max="12" class="input-form"
                                placeholder="Enter cheques" name="cheques" id="cheques"
                                value="{{ $finder_property->cheques }}" readonly>
                        @elseif(isset($emirates_property->cheques))
                            <input type="number" min="1" max="12" class="input-form"
                                placeholder="Enter cheques" name="cheques" id="cheques"
                                value="{{ $emirates_property->cheques }}" readonly>
                        @else
                            <input type="number" min="1" max="12" class="input-form"
                                placeholder="Enter cheques" name="cheques" id="cheques" value="" readonly>
                        @endisset
                </div>
                <div class="col-md-4 col-12">
                    <label class="title-input" for="plot_size">Plot Size</label>
                    @if (isset($finder_property->plot_size))
                        <input type="text" class="input-form" placeholder="Enter Plot Size" name="plot_size"
                            id="plot_size" min="0" value="{{ $finder_property->plot_size }}" readonly>
                    @elseif(isset($emirates_property->plot_size))
                        <input type="text" class="input-form" placeholder="Enter Plot Size" name="plot_size"
                            id="plot_size" min="0" value="{{ $emirates_property->plot_size }}" readonly>
                    @else
                        <input type="text" class="input-form" placeholder="Enter Plot Size" name="plot_size"
                            id="plot_size" min="0" value="" readonly>
                    @endisset
            </div>
        </div>
        <!-- end Row 9-->
        <!-- star Row 10-->
        <div class="row mt-4 mb-4" style="align-items: center;">
            <div class="col-md-4 col-12">
                <label class="title-input" for="developer">Developer</label>
                @if (isset($finder_property->developer))
                    <input type="text" class="input-form" placeholder="Enter Developer" name="developer"
                        id="developer" value="{{ $finder_property->developer }}" readonly>
                @elseif(isset($emirates_property->developer))
                    <input type="text" class="input-form" placeholder="Enter Developer" name="developer"
                        id="developer" value="{{ $emirates_property->developer }}" readonly>
                @elseif(isset($dubizzle_property->developer))
                    <input type="text" class="input-form" placeholder="Enter Developer" name="developer"
                        id="developer" value="{{ $dubizzle_property->developer }}" readonly>
                @else
                    <input type="text" class="input-form" placeholder="Enter Developer" name="developer"
                        id="developer" value="" readonly>
                @endisset
        </div>
        <div class="col-md-4 col-12">
            <label class="title-input" for="build_year">Build Year</label>
            @if (isset($finder_property->build_year))
                <input type="number" class="input-form" placeholder="Enter Build Year"
                    name="build_year" id="build_year" min="0"
                    value="{{ $finder_property->build_year }}" readonly>
            @elseif(isset($emirates_property->build_year))
                <input type="number" class="input-form" placeholder="Enter Build Year"
                    name="build_year" id="build_year" min="0"
                    value="{{ $emirates_property->build_year }}" readonly>
            @else
                <input type="number" class="input-form" placeholder="Enter Build Year"
                    name="build_year" id="build_year" min="0" value="" readonly>
            @endisset
    </div>
    <div class="col-md-4 col-12">
        <label class="title-input" for="completion_status">Completion Status</label>
        <select id="completion_status" name="completion_status" class="form-control input-form"
            readonly>
            @foreach ($completion_status as $item => $data)
                @if (isset($finder_property->completion_status))
                    @if ($finder_property->completion_status == $item)
                        <option selected value="{{ $item }}">{{ $data }}</option>

                    @endif
                @elseif(isset($emirates_property->completion_status))
                    @if ($emirates_property->completion_status == $item)
                        <option selected value="{{ $item }}">{{ $data }}</option>

                    @endif
                @else
                    <option></option>
                    <option value="{{ $item }}">{{ $data }}</option>
                @endisset
            @endforeach
    </select>
    <div class="invalid-feedback">
        {{-- Please enter {{__('labels.users.languages')}}. --}}
    </div>
    {{-- </div> --}}
</div>
</div>
<!-- end Row 10-->
<!-- star Row 11-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-4 col-12">
    <label class="title-input" for="floor">Floor</label>
    @if (isset($finder_property->floor))
        <input type="number" class="input-form" placeholder="Enter Floor" name="floor"
            id="floor" min="0" value="{{ $finder_property->floor }}" readonly>
    @elseif(isset($emirates_property->floor))
        <input type="number" class="input-form" placeholder="Enter Floor" name="floor"
            id="floor" min="0" value="{{ $emirates_property->floor }}" readonly>
    @else
        <input type="number" class="input-form" placeholder="Enter Floor" name="floor"
            id="floor" min="0" value="" readonly>
    @endisset
</div>
<div class="col-md-4 col-12">
<label class="title-input" for="stories">stories</label>
@if (isset($finder_property->stories))
    <input type="number" class="input-form" placeholder="Enter Stories" name="stories"
        id="stories" min="0" value="{{ $finder_property->stories }}" readonly>
@elseif(isset($emirates_property->stories))
    <input type="number" class="input-form" placeholder="Enter Stories" name="stories"
        id="stories" min="0" value="{{ $emirates_property->stories }}" readonly>
@else
    <input type="number" class="input-form" placeholder="Enter Stories" name="stories"
        id="stories" min="0" value="" readonly>
@endisset
</div>
<div class="col-md-4 col-12">
<label class="title-input" for="parking">Parking</label>
@if (isset($finder_property->parking))
<input type="number" class="input-form" placeholder="Enter Parking" name="parking"
    id="parking" min="0" max="999"
    value="{{ $finder_property->parking }}" readonly>
@elseif(isset($emirates_property->parking))
<input type="number" class="input-form" placeholder="Enter Parking" name="parking"
    id="parking" min="0" max="999"
    value="{{ $emirates_property->parking }}" readonly>
@else
<input type="number" class="input-form" placeholder="Enter Parking" name="parking"
    id="parking" min="0" max="999" value="" readonly>
@endisset
</div>
</div>
<!-- end Row 11-->
<!-- star Row 12-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-4 col-12">
<label class="title-input" for="furnished">Furnished</label>
<select id="furnished" name="furnished" class="form-control input-form" readonly>
@foreach ($furnished as $item => $data)
@if (isset($finder_property->furnished))
    @if ($finder_property->furnished == $item)
        <option selected value="{{ $item }}">{{ $data }}</option>
    @else
        <option value="{{ $item }}">{{ $data }}</option>
    @endif
@elseif(isset($emirates_property->furnished))
    @if ($emirates_property->furnished == $item)
        <option selected value="{{ $item }}">{{ $data }}</option>
    @else
        <option value="{{ $item }}">{{ $data }}</option>
    @endif
@elseif(isset($dubizzle_property->furnished))
    @if ($dubizzle_property->furnished == $item)
        <option selected value="{{ $item }}">{{ $data }}</option>
    @else
        <option value="{{ $item }}">{{ $data }}</option>
    @endif
@else
    <option></option>
    <option value="{{ $item }}">{{ $data }}</option>
@endisset
@endforeach
</select>
<div class="invalid-feedback">
{{-- Please enter {{__('labels.users.languages')}}. --}}
</div>
{{-- </div> --}}
</div>
<div class="col-md-4 col-12">
<label class="title-input" for="geopoints">Geopoints</label>
@if (isset($finder_property->geopoints))
<input type="text" class="input-form" placeholder="Enter Geopoints" name="geopoints"
id="geopoints" value="{{ $finder_property->geopoints }}" readonly>
@elseif(isset($emirates_property->geopoints))
<input type="text" class="input-form" placeholder="Enter Geopoints" name="geopoints"
id="geopoints" value="{{ $emirates_property->geopoints }}" readonly>
@elseif(isset($dubizzle_property->geopoints))
<input type="text" class="input-form" placeholder="Enter Geopoints" name="geopoints"
id="geopoints" value="{{ $dubizzle_property->geopoints }}" readonly>
@else
<input type="text" class="input-form" placeholder="Enter Geopoints" name="geopoints"
id="geopoints" value="" readonly>
@endisset
</div>
</div>
<!-- end Row 12-->
<!-- star Row 13-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-4 col-12">
<label class="title-input" for="title_deed">Title Deed</label>
@if (isset($finder_property->title_deed))
<input type="text" class="input-form" placeholder="Enter Title Deed"
name="title_deed" id="title_deed" value="{{ $finder_property->title_deed }}"
readonly>
@elseif(isset($emirates_property->title_deed))
<input type="text" class="input-form" placeholder="Enter Title Deed"
name="title_deed" id="title_deed" value="{{ $emirates_property->title_deed }}"
readonly>
@else
<input type="text" class="input-form" placeholder="Enter Title Deed"
name="title_deed" id="title_deed" value="" readonly>
@endisset
</div>
<div class="col-md-4 col-12">
<label class="title-input" for="availability_date">Availability Date</label>
@if (isset($finder_property->availability_date))
<input type="Date" class="input-form" placeholder="Enter Availability Date"
name="availability_date" id="availability_date"
value="{{ $finder_property->availability_date }}" readonly>
@elseif(isset($emirates_property->availability_date))
<input type="Date" class="input-form" placeholder="Enter Availability Date"
name="availability_date" id="availability_date"
value="{{ $emirates_property->availability_date }}" readonly>
@else
<input type="Date" class="input-form" placeholder="Enter Availability Date"
name="availability_date" id="availability_date" value="" readonly>
@endisset
</div>
<div class="col-md-4 col-12">
<label class="title-input" for="property_name">Property Name <span
style="color:red">*</span></label>
@if (isset($finder_property->property_name))
<input type="text" class="input-form" placeholder="Enter Property Name"
name="property_name" id="property_name"
value="{{ $finder_property->property_name }}" readonly>
@elseif(isset($emirates_property->property_name))
<input type="text" class="input-form" placeholder="Enter Property Name"
name="property_name" id="property_name"
value="{{ $emirates_property->property_name }}" readonly>
@else
<input type="text" class="input-form" placeholder="Enter Property Name"
name="property_name" id="property_name" value="" readonly>
@endisset
</div>
</div>
<!-- end Row 13-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-12 col-12">
<label class="title-input" for="view360">View360</label>
@if ($finder_property)
@if ($finder_property->view360 != '')
<input type="text" class="input-form" placeholder="Enter View360" name="view360"
id="view360" readonly>
<img src="{{ asset('storage/properties/view360/' . $finder_property->view360) }}"
alt="" width="75px" height="75px">
@else
<input type="text" class="input-form" placeholder="Enter View360" name="view360"
id="view360" readonly>
@endif
@elseif($emirates_property)
@if ($emirates_property->view360 != '')
<input type="text" class="input-form" placeholder="Enter View360" name="view360"
id="view360" readonly>
<img src="{{ asset('storage/properties/view360/' . $emirates_property->view360) }}"
alt="" width="75px" height="75px">
@else
<input type="text" class="input-form" placeholder="Enter View360" name="view360"
id="view360" readonly>
@endif
@elseif($dubizzle_property)
@if ($dubizzle_property->view360 != '')
<input type="text" class="input-form" placeholder="Enter View360" name="view360"
id="view360" readonly>
<img src="{{ asset('storage/properties/view360/' . $dubizzle_property->view360) }}"
alt="" width="75px" height="75px">
@else
<input type="text" class="input-form" placeholder="Enter View360" name="view360"
id="view360" readonly>
@endif
@else
<input type="text" class="input-form" placeholder="Enter View360" name="view360"
id="view360" readonly>
@endif
<div class="invalid-feedback">
{{-- Please enter {{__('labels.users.languages')}}. --}}
</div>
{{-- </div> --}}
</div>
</div>
</div>
<!-- end finder_input-->
<!-- dubizzle_input-->
<div style="display: none" id="dubizzle_input">
<!-- star Row 12-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-3 col-12">
<label class="title-input" for="d_developer">Developer</label>
@if (isset($dubizzle_property->developer))
<input type="text" class="input-form" placeholder="Enter Developer"
name="d_developer" id="d_developer" value="{{ $dubizzle_property->developer }}"
readonly>
@else
<input type="text" class="input-form" placeholder="Enter Developer"
name="d_developer" id="d_developer" value="" readonly>
@endisset
</div>
<div class="col-md-3 col-12">
<label class="title-input" for="d_furnished">Furnished</label>
<select id="d_furnished" name="d_furnished" class="form-control input-form" readonly>
@foreach ($furnished as $item => $data)
@if (isset($dubizzle_property->furnished))
@if ($dubizzle_property->furnished == $item)
<option selected value="{{ $item }}">{{ $data }}</option>
@else
<option value="{{ $item }}">{{ $data }}</option>
@endif
@else
<option></option>
<option value="{{ $item }}">{{ $data }}</option>
@endisset
@endforeach
</select>
<div class="invalid-feedback">
{{-- Please enter {{__('labels.users.languages')}}. --}}
</div>
{{-- </div> --}}
</div>
<div class="col-md-3 col-12">
<label class="title-input" for="d_geopoints">Geopoints</label>
@if (isset($dubizzle_property->geopoints))
<input type="text" class="input-form" placeholder="Enter Geopoints"
name="d_geopoints" id="d_geopoints" value="{{ $dubizzle_property->geopoints }}"
readonly>
@else
<input type="text" class="input-form" placeholder="Enter Geopoints"
name="d_geopoints" id="d_geopoints" value="" readonly>
@endisset
</div>
</div>
<!-- end Row 12-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-12 col-12">
<label class="title-input" for="d_view360">View360</label>
@if ($dubizzle_property)
@if ($dubizzle_property->view360 != '')
<input type="text" class="input-form" placeholder="Enter View360"
name="d_view360" id="d_view360" readonly>
<img src="{{ asset('storage/properties/view360/' . $dubizzle_property->view360) }}"
alt="" width="75px" height="75px">
@else
<input type="text" class="input-form" placeholder="Enter View360"
name="d_view360" id="d_view360" readonly>
@endif
@elseif ($finder_property)
@if ($finder_property->view360 != '')
<input type="text" class="input-form" placeholder="Enter View360"
name="d_view360" id="d_view360" readonly>
<img src="{{ asset('storage/properties/view360/' . $finder_property->view360) }}"
alt="" width="75px" height="75px">
@else
<input type="text" class="input-form" placeholder="Enter View360"
name="d_view360" id="d_view360" readonly>
@endif
@elseif ($emirates_property)
@if ($emirates_property->view360 != '')
<input type="text" class="input-form" placeholder="Enter View360"
name="d_view360" id="d_view360" readonly>
<img src="{{ asset('storage/properties/view360/' . $emirates_property->view360) }}"
alt="" width="75px" height="75px">
@else
<input type="text" class="input-form" placeholder="Enter View360"
name="d_view360" id="d_view360" readonly>
@endif
@else
<input type="text" class="input-form" placeholder="Enter View360" name="d_view360"
id="d_view360" readonly>
@endif
<div class="invalid-feedback">
{{-- Please enter {{__('labels.users.languages')}}. --}}
</div>
{{-- </div> --}}
</div>
</div>
</div>
<!-- end dubizzle_input-->
<!-- bayut_input-->
<div style="display: none" id="bayut_input">
<!-- star Row 15-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-4 col-12">
<label class="title-input" for="property_status">Property Status <span
style="color:red">*</span></label>
<select id="property_status" name="property_status" class="form-control input-form" readonly>
@foreach ($property_statuses as $property_status)
@if (isset($bayut_property->property_status))
@if ($bayut_property->property_status == $property_status)
<option selected value="{{ $property_status }}">{{ $property_status }}
</option>
@else
<option value="{{ $property_status }}">{{ $property_status }}</option>
@endif
@elseif(isset($dubizzle_property->property_status))
@if ($dubizzle_property->property_status == $property_status)
<option selected value="{{ $property_status }}">{{ $property_status }}
</option>
@else
<option value="{{ $property_status }}">{{ $property_status }}</option>
@endif
@else
<option></option>
<option value="{{ $property_status }}">{{ $property_status }}</option>
@endisset
@endforeach
</select>
<div class="invalid-feedback">
</div>
</div>
<div class="col-md-4 col-12">
<label class="title-input" for="off_plan">Off Plan <span style="color:red">*</span></label>
<select id="off_plan" name="off_plan" class="form-control input-form" readonly>
@foreach ($off_plans as $off_plan)
@if (isset($bayut_property->off_plan))
@if ($bayut_property->off_plan == $off_plan)
<option selected value="{{ $off_plan }}">{{ $off_plan }}</option>
@else
<option value="{{ $off_plan }}">{{ $off_plan }}</option>
@endif
@elseif(isset($dubizzle_property->off_plan))
@if ($dubizzle_property->off_plan == $off_plan)
<option selected value="{{ $off_plan }}">{{ $off_plan }}</option>
@else
<option value="{{ $off_plan }}">{{ $off_plan }}</option>
@endif
@else
<option></option>
<option value="{{ $off_plan }}">{{ $off_plan }}</option>
@endisset
@endforeach
</select>
<div class="invalid-feedback">
</div>
</div>
<div class="col-md-4 col-12">
<label class="title-input" for="tower_name">Tower Name <span
style="color:red">*</span></label>
@if (isset($bayut_property->tower_name))
<input type="text" class="input-form" placeholder="Enter Tower Name"
name="tower_name" id="tower_name" value="{{ $bayut_property->tower_name }}"
readonly>
@elseif(isset($dubizzle_property->tower_name))
<input type="text" class="input-form" placeholder="Enter Tower Name"
name="tower_name" id="tower_name" value="{{ $dubizzle_property->tower_name }}"
readonly>
@else
<input type="text" class="input-form" placeholder="Enter Tower Name"
name="tower_name" id="tower_name" value="" readonly>
@endisset
<div class="invalid-feedback">
</div>
</div>
</div>
<!-- end Row 15-->
<!-- star Row 17-->
<div class="row mt-4 mb-4" style="align-items: center;">
<div class="col-md-12 col-12">
<label class="title-input" for="videos">Videos</label>
<input type="text" class="input-form" placeholder="Enter videos" name="videos[]"
id="videos" multiple readonly>
@if ($bayutproperty_videos != '')
@foreach ($bayutproperty_videos as $bayutproperty_video)
<video width="250" height="150" controls>
<source
src="{{ asset('storage/properties/videos/' . $bayutproperty_video->url) }}"
alt="" type="video/mp4">
</video>
@endforeach
@elseif($dubizzleproperty_videos != '')
@foreach ($dubizzleproperty_videos as $dubizzleproperty_video)
<video width="250" height="150" controls>
<source
src="{{ asset('storage/properties/videos/' . $dubizzleproperty_video->url) }}"
alt="" type="video/mp4">
</video>
@endforeach
@endif
</div>
</div>
<!-- end Row 17-->
</div>
<!-- end bayut_input-->
<div class="row mt-5">
<div class="col-md-12 text-center">
<!-- <button id="buttonsubmit" type="button" class="registerbtn">Update
<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
hidden></span>
</button> -->
</div>
</div>
</div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

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

<script>
    $('#photo').change(function() {
        $('#exampleModal').modal('show');
    });
    $('#modal_close').click(function() {
        $('#exampleModal').modal('hide');
    });

    $('#watermark').change(function(e) {
        var reader = new FileReader();
        reader.readAsDataURL($(this).prop('files')[0]);
        reader.onload = function(e) {
            var image = new Image();
            image.src = e.target.result;
            image.onload = function() {
                var height = this.height;
                var width = this.width;
                $('#watermark_width').val(width);
                $('#watermark_height').val(height);
            };
        }
    });
</script>

<script>
    $('#offering_type').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>

<script>
    $('#property_type').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
        // readonly: true,
    });
</script>

<script>
    $('#city').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>

<script>
    $('#community').select2({
        width: '100%',
        placeholder: "Select an Community",
        // allowClear: true,
    });
</script>

<script>
    $('#sub_community').select2({
        width: '100%',
        placeholder: "Select an Sub Community",
        // allowClear: true,
    });
</script>

<script>
    $('#property_name').select2({
        width: '100%',
        placeholder: "Select an Property Name",
        // allowClear: true,
    });
</script>
<script>
    $('#private_amenities').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>

<script>
    $('#bedroom').select2({
        width: '100%',
        placeholder: "Select an Bedroom",
        // allowClear: true,
    });
</script>
<script>
    $('#bathroom').select2({
        width: '100%',
        placeholder: "Select an Bathroom",
        // allowClear: true,
    });
</script>
<script>
    $('#completion_status').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true
    });
</script>
<script>
    $('#furnished').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $('#d_furnished').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $('#view360').select2({
        width: '100%',
        placeholder: "Select an View360",
        // allowClear: true,
    });
</script>
<script>
    $('#user_id').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $('#property_purpose').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $('#property_status').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $('#off_plan').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $('#rent_Frequency').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $('#property_size_unit').select2({
        width: '100%',
        placeholder: "Select an Option",
        // allowClear: true,
    });
</script>
<script>
    $(function() {
        $('#Dubizzle').each(function showDubizzle() {
            var bayuttext = document.getElementById("bayut_input");
            var dubizzletext = document.getElementById("dubizzle_input");
            var findertext = document.getElementById("finder_input");
            if ($(this).is(":checked")) {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        }
                    }
                }

            } else {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Bayut').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
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
            var dubizzletext = document.getElementById("dubizzle_input");
            var findertext = document.getElementById("finder_input");
            if ($(this).is(":checked")) {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
                        }
                    }
                }

            } else {
                if ($('#finder').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
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
            var dubizzletext = document.getElementById("dubizzle_input");
            var findertext = document.getElementById("finder_input");
            if ($(this).is(":checked")) {
                if ($('#Bayut').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                }

            } else {
                if ($('#Bayut').is(":checked")) {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#emiratesEstate').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
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
            var dubizzletext = document.getElementById("dubizzle_input");
            var findertext = document.getElementById("finder_input");
            if ($(this).is(":checked")) {
                if ($('#Bayut').is(":checked")) {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    }
                }

            } else {
                if ($('#Bayut').is(":checked")) {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        } else {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
                        }
                    }
                } else {
                    if ($('#finder').is(":checked")) {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "block";
                            dubizzletext.style.display = "none";
                        }
                    } else {
                        if ($('#Dubizzle').is(":checked")) {
                            bayuttext.style.display = "block";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "block";
                        } else {
                            bayuttext.style.display = "none";
                            findertext.style.display = "none";
                            dubizzletext.style.display = "none";
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
        var dubizzletext = document.getElementById("dubizzle_input");
        var findertext = document.getElementById("finder_input");
        if (Bayut.checked == true) {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
                    }
                }
            }
        } else {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Dubizzle.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
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
        var dubizzletext = document.getElementById("dubizzle_input");
        var findertext = document.getElementById("finder_input");
        if (Dubizzle.checked == true) {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    }
                }
            }
        } else {
            if (finder.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
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
        var dubizzletext = document.getElementById("dubizzle_input");
        var findertext = document.getElementById("finder_input");
        if (finder.checked == true) {
            if (Dubizzle.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            }
        } else {
            if (Dubizzle.checked == true) {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    }
                }
            } else {
                if (emiratesEstate.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
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
        var dubizzletext = document.getElementById("dubizzle_input");
        var findertext = document.getElementById("finder_input");
        if (emiratesEstate.checked == true) {
            if (Dubizzle.checked == true) {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            } else {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                }
            }
        } else {
            if (Dubizzle.checked == true) {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    } else {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "block";
                    }
                }
            } else {
                if (finder.checked == true) {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "block";
                        dubizzletext.style.display = "none";
                    }
                } else {
                    if (Bayut.checked == true) {
                        bayuttext.style.display = "block";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
                    } else {
                        bayuttext.style.display = "none";
                        findertext.style.display = "none";
                        dubizzletext.style.display = "none";
                    }
                }
            }
        }
    }
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
        let TotalVideos = $('#videos')[0].files.length; //Total videos
        let videos = $('#videos')[0];
        for (let i = 0; i < TotalVideos; i++) {
            formData.append('videos' + i, videos.files[i]);
        }
        formData.append('TotalVideos', TotalVideos);

        let VideoPlan = $('#view360')[0].files.length; //Total videos
        let video = $('#view360')[0];
        for (let i = 0; i < VideoPlan; i++) {
            formData.append('video' + i, video.files[i]);
        }
        formData.append('VideoPlan', VideoPlan);

        let d_VideoPlan = $('#d_view360')[0].files.length; //Total videos
        let d_video = $('#d_view360')[0];
        for (let i = 0; i < d_VideoPlan; i++) {
            formData.append('d_video' + i, d_video.files[i]);
        }
        formData.append('d_VideoPlan', d_VideoPlan);

        // add logo data
        var logo = $('#watermark').prop('files')[0];
        var logo_width = $('#watermark_width').val();
        var logo_height = $('#watermark_height').val();
        var logo_position = $('#watermark_position').val();
        formData.append('watermark', logo);
        formData.append('watermark_width', logo_width);
        formData.append('watermark_height', logo_height);
        formData.append('watermark_position', logo_position);

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
    let holder = document.querySelector('.image-holder');
    let forward = document.querySelector('.forward');
    let back = document.querySelector('.back');

    // Lets make array of images
    let img_arr = [
        'https://cdn.pixabay.com/photo/2021/08/25/20/42/field-6574455_960_720.jpg',
        'https://cdn.pixabay.com/photo/2021/10/11/18/58/lake-6701636_960_720.jpg',
        'https://cdn.pixabay.com/photo/2021/09/20/21/32/lake-6641880_960_720.jpg',
        'https://cdn.pixabay.com/photo/2021/10/21/08/14/italy-6728318_960_720.jpg',
        'https://cdn.pixabay.com/photo/2021/10/18/08/39/pumpkin-6720424_960_720.jpg'
    ]

    let image_count = 0;

    // Function to increase image count
    const imageIncrease = () => {
        holder.src = img_arr[image_count]
        // console.log(image_count)
        // console.log(img_arr.length)
        if (image_count >= img_arr.length - 1) {
            image_count = 0;
        } else {
            image_count++;
        }
    }
    // function to decrease image count
    const imageDecrease = () => {
        holder.src = img_arr[image_count]
        // console.log(image_count)
        if (image_count === 0) {
            image_count = img_arr.length - 1;
        } else {
            image_count--;

        }
    }
    forward.addEventListener('click', imageIncrease)
    back.addEventListener('click', imageDecrease)
</script>
@endpush
