@extends('layouts.app')

@push('head')
    <title>Appointments List</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />


    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        nav.justify-between svg {
            width: 3%;
        }

        .model1 {
            width: 50%;
            /* height: 25%; */
            border: 1px solid;
            padding: 30px;
            position: fixed;
            z-index: 1000;
            top: 55%;
            background-color: white;
            transform: translate(-50%, -50%);
            left: 50%;
            text-align: center;
            display: none;
        }

        #times1 {
            position: absolute;
            left: 90%;
            top: 5%;
            z-index: 10;
            cursor: pointer;

        }

        nav.justify-between,
        .leading-5 {
            margin-top: 15px;
        }


        .items-center .justify-between {
            display: none;
        }

        /*Hidden class for adding and removing*/
        .lds-dual-ring.hidden {
            display: none;
        }

        /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
        .overlay {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, .8);
            z-index: 999;
            opacity: 1;
            transition: all 0.5s;
        }

        /*Spinner Styles*/
        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 5% auto;
            border-radius: 50%;
            border: 6px solid #fff;
            border-color: #fff transparent #fff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .disabledbutton {
            pointer-events: none;
            opacity: 0.4;
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

        html {
            scroll-behavior: smooth;
        }

        nav.justify-between svg {
            width: 3%;
        }

        nav.justify-between,
        .leading-5 {
            margin-top: 15px;
        }


        .items-center .justify-between {
            display: none;
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

        nav ul li:last-child {
            border-bottom: 0 !important;
        }

        .content-input {
            display: flex;
            align-items: center;
        }

        .label {
            width: 35%;
            padding-right: 12px;
        }

        .dropdown {
            width: 55%;
        }

        .label h4 {
            color: #241907;
            font-family: 'Lato-Semibold';
            font-size: 15px;
        }

        .dropdown select {
            box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
            border-right: 2px solid #db9d33;
            color: #7d7a76;
            font-family: 'Lato-Regular';
            font-size: 15px;
            border-radius: 0 !important;
        }

        .dropdown select:focus-visible {
            outline: none;
        }

        #bookslist_filter label::after {
            content: "";
            width: 70px;
            height: 28px;
            /* background: url(img/search-remax.jpg) no-repeat; */
            top: 10px;
            right: 70px;
            position: relative;
            display: inline-block;
            background-size: cover;
        }

        #bookslist_filter label::before {
            font-family: fontAwesome;
            content: "\f002";
            width: 26px;
            height: 20px;
            top: 1px;
            left: 86px;
            border-right: 2px solid #e3e0e0;
            position: relative;
            display: inline-block;
            /* color:#DB9D33; */
        }

        #bookslist_filter input {
            padding: 0 36px;
            width: 20rem !important;
            outline: none !important;
            box-shadow: inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
            border-radius: 0 !important;
            border: 1px solid #d8d5cd;
            height: 2.1rem;
        }

        label {
            font-family: 'Lato-Regular';
        }

        #tablebuttonexcel button,
        #tablebuttoncsv button {
            background: #6d4e18;
            border: #6d4e18;
            font-family: 'Lato-Regular';
            font-size: 15px;
            color: #fff;
            width: 6rem;
            border-radius: 9px;
            box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
        }

        #bookslist_length select {
            box-shadow: inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
            border-radius: 0 !important;
            height: 2.2rem;
            color: #184d47;
            font-family: 'Lato-Regular';
            padding: 7px 22px 7px 6px;
        }

        button.btn.buttons-csv::after {
            font-family: fontAwesome;
            content: "\f019";
            padding-left: 6px;
            font-size: 14px;
        }

        button.btn.buttons-excel::after {
            font-family: fontAwesome;
            content: "\f019";
            padding-left: 6px;
            font-size: 14px;
        }

        th {

            /* background: #6d4e18; */

            /* width: 25px!important; */
        }

        span.table-title {
            width: 100%;
            font-size: 12px;
            font-family: 'Lato-Semibold';
            color: #fff;
        }

        /* #bookslist_wrapper{
                                        border: 1px solid #e5d5d5;
                                        border-radius: 5px;
                                    } */
        #bookslist_length,
        #bookslist_filter,
        .dataTables_scroll {
            background: #fff;
        }

        #bookslist_length {
            position: absolute;
            right: 50%;
            margin-top: 2.2rem;
            /* border: 1px solid #e5d5d5;
                                        border-bottom: none;
                                        border-radius: 8px 8px 0 0; */
        }


        #bookslist_filter {
            border-top: 1px solid #e5d5d5;
            border-left: 1px solid #e5d5d5;
            border-right: 1px solid #e5d5d5;
            border-radius: 8px 8px 0 0;
            padding: 1rem;
            height: 5rem;
        }

        #bookslist_filter label {
            margin-top: 0.5rem;
        }

        .dataTables_scroll {
            border-left: 1px solid #e5d5d5;
            border-right: 1px solid #e5d5d5;
            border-bottom: 1px solid #e5d5d5;
            border-radius: 0px 0px 8px 8px;
        }

        .group-button {
            position: absolute;
            margin-top: 2.5rem;
        }

        .first a {
            /* background:url(img/left.jpg) no-repeat; */
            background-position: center;
            background-size: cover;
            width: 5rem;
            text-align: left;
            color: #fff !important;
            font-size: 13px !important;
            font-family: 'Lato-Regular' !important;

        }

        .last a {
            /* background:url(img/right.jpg) no-repeat; */
            background-position: center;
            background-size: cover;
            width: 5rem;
            text-align: right;
            color: #fff !important;
            font-size: 13px !important;
            font-family: 'Lato-Regular' !important;
        }

        #bookslist_info {
            color: #000 !important;
            font-size: 13px !important;
            font-family: 'Lato-Regular' !important;
            position: absolute;
            margin-top: 1rem;
        }

        #bookslist_paginate {
            margin-top: 2rem;
        }

        .pagination li a {
            box-shadow: inset 0px 2px 0px 0px rgb(115 115 115 / 75%);
        }

        .odd td {
            background: #e9eaeeb5;
        }

        select::-ms-expand {
            display: none;
        }

        .custom-select {
            /* background: url('img/select.jpg'); */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: right;
        }

        @media(max-width:768px) {
            .top-title {
                font-size: 15px;
                color: #9D865C;
                height: 3rem;
                padding: 11px 30px;

            }

            #tablebuttonexcel button,
            #tablebuttoncsv button {
                font-size: 10px;
                color: #fff;
                width: 4rem;
                padding: px;
            }

            #bookslist_filter input {
                width: 14rem !important;
            }

            #bookslist_filter label::before {
                top: 126px;
                right: 192px;
            }

            #bookslist_filter label::after {
                width: 61px;
                top: 121px;
                right: 27px;
            }

            .label h4 {
                font-size: 13px;
            }
        }

        @media(max-width:500px) {
            .content-input {
                margin-bottom: 10px;
            }

            .label {
                width: 8rem;
            }

            .group-button {
                position: initial;
                justify-content: center !important;
            }

            #bookslist_length {
                position: inherit;
            }

            #bookslist_filter input {
                width: 10rem !important;
            }

            #bookslist_filter label::after {
                top: 10px !important;
                right: 61px !important;
                position: relative !important;
            }

            #bookslist_filter label::before {
                top: 1px;
                left: 79px;
                position: relative;
            }

            #bookslist_length {
                background: transparent;
            }

            #bookslist_info {
                position: inherit;
            }

            #wrapper {
                background-size: cover !important;
            }

            .top-title {}

            /*sidebar mobile */
            .sidebar .sidebar-brand {
                height: auto;
            }

            .sidebar-brand-icon {
                display: grid;
            }

            .user-name {
                width: 100%;
            }

            nav ul li {
                line-height: 7px !important;
            }

            #sbitem1 .link-content,
            #sbitem2 .link-content,
            #sbitem3 .link-content,
            #sbitem4 .link-content,
            #sbitem5 .link-content,
            #sbitem6 .link-content {
                height: 4rem;
                padding: 9px 6px;
            }

            .left-title {
                width: 90%;
                font-size: 12px;
                line-height: 1;
            }

            .icon-title {
                font-size: 10px !important;
            }

            #sbitem1_1,
            #sbitem1_2,
            #sbitem1_3,
            #sbitem1_4,
            #sbitem1_5,
            #sbitem1_6,
            #sbitem1_7,
            #sbitem1_8,
            #sbitem1_9 {
                line-height: 17px !important;
                margin-bottom: 10px;
            }

            #sbitem1_1 a,
            #sbitem1_2 a,
            #sbitem1_3 a,
            #sbitem1_4 a,
            #sbitem1_5 a,
            #sbitem1_6 a,
            #sbitem1_7 a,
            #sbitem1_8 a,
            #sbitem1_9 a {
                padding-left: 15px !important;
                font-size: 12px !important;
            }

            #sbitem2_1,
            #sbitem2_2,
            #sbitem2_3,
            #sbitem2_4,
            #sbitem2_5,
            #sbitem2_6,
            #sbitem2_7,
            #sbitem2_8,
            #sbitem2_9,
            #sbitem2_10,
            #sbitem2_11 {
                line-height: 17px !important;
                margin-bottom: 10px !important;
            }

            #sbitem2_1 a,
            #sbitem2_2 a,
            #sbitem2_3 a,
            #sbitem2_4 a,
            #sbitem2_5 a,
            #sbitem2_6 a,
            #sbitem2_7 a,
            #sbitem2_8 a,
            #sbitem2_9 a,
            #sbitem2_10 a,
            #sbitem2_11 a {
                padding-left: 15px !important;
                font-size: 12px !important;
            }
        }


        #bg-top {
            width: 157%;
            margin-left: -5rem;
            margin-top: -9rem;
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

        .swal-button {
            background-color: #0d2825 !important;
            color: #fff !important;
        }

        .swal-button:not([disabled]):hover {
            background-color: #899297 !important;
        }

        /*end*/


        /*responsive*/
        @media(max-width: 1400px) {
            #bookslist_filter label::before {
                top: 1px;
            }

            #bookslist_filter label::after {
                top: 10px;

            }
        }

        @media(max-width: 1024px) and (min-width: 769px) {
            #bg-top {
                width: 116%;
                margin-left: -2rem;
                margin-top: -4rem;
            }

            #bookslist_filter label::after {
                top: 10px;
                right: 31px;
            }

            #bookslist_filter label::before {
                top: 1px;
                right: 281px;
            }

            .label h4 {
                font-size: 15px;
            }

            #bookslist_length {
                right: 52%;
            }
        }

        @media(max-width: 768px) {
            #wrapper {
                height: auto;
            }
        }

        @media(max-width: 500px) {
            #bg-top {
                width: 66%;
                margin-left: 0;
                margin-top: 0;
            }

            #bookslist_filter label::before {
                top: 2px !important;
            }

            .pagination li .page-link {
                font-size: 10px !important;
                padding: 0.5rem 0.15rem !important;
            }

            .page-item.disabled .page-link {
                text-align: center !important;
            }

            .justify-content-end {
                justify-content: center !important;
            }
        }

        @media (max-width: 1350px) and (min-width: 1200px) {
            #bookslist_filter label::after {
                top: 10px;
            }
        }

        @media (max-width: 768px) and (min-width: 600px) {
            #bookslist_filter label::after {
                top: 10px;
                right: 60px !important;
            }

            .group-button {
                position: inherit;
                margin-top: 0.5rem;
            }

            #bookslist_length {
                right: 68%;
            }

            .dropdown {
                width: 65%;
            }

            #bg-top {
                height: 6rem;
                width: 10rem;
                margin-left: 0;
                margin: auto;
                margin-top: 17px;
            }

            .con-img {
                text-align: center;
            }
        }

        @media(max-width:1300px) {
            .select2-container .select2-selection--single {
                width: 100% !important;
            }
        }

        @media(width:1200px) {
            .select2-container .select2-selection--single {
                width: 100% !important;
            }
        }

        .select2-container--default .select2-selection--single {
            background: #fff !important;
            border-radius: 0 !important;
            height: calc(2.25rem + 2px) !important;
            padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
            vertical-align: middle !important;
            text-align: left;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            border-right: 3px solid #9D865C !important;
            border-top: none !important;
            border-bottom: none !important;
            border-left: none !important;

        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: inline-block;
            height: 28px;
            -webkit-user-select: none;
            width: 100%;
        }

        .select2-selection__rendered {
            width: 220px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 5px;
            /* right: -17px !important; */
            width: 20px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            width: 150px;
            display: block;
            font-family: 'Lato-Regular' !important;
            font-size: 12px !important;
            line-height: 1.5 !important;
            color: #878b8f !important;
            padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
        }

        .model {

            display: none;
        }

        #times {
            position: absolute;
            left: 90%;
            top: 5%;
            z-index: 10;
            cursor: pointer;

        }

        #sel2:focus-visible {
            outline: none;
        }

        #sel2 {
            font-family: 'Lato-Regular' !important;
            font-size: 12px !important;
            display: inline-block;
            /*width: 100%;*/
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

        .model2 {
            width: 50%;
            /* height: 25%; */
            border: 1px solid;
            padding: 30px;
            position: fixed;
            z-index: 1000;
            top: 45%;
            background-color: white;
            transform: translate(-50%, -50%);
            left: 50%;
            text-align: center;
            display: none;
        }

        #times2 {
            position: absolute;
            left: 90%;
            top: 5%;
            z-index: 10;
            cursor: pointer;

        }

        .bookappointmentmodel1 {
            text-align: center;
            width: 85%;
            border: 1px solid;
            padding: 30px;
            position: fixed;
            z-index: 1000;
            top: 45%;
            background-color: white;
            transform: translate(-50%, -50%);
            left: 50%;
            display: none;
        }

        /*end responsive*/
    </style>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.js"
        crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.css"
        crossorigin="anonymous" />

    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-7">
                <h3 class="top-title">Appointments List</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid" style="margin-top:2.5rem ">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"></h1>

                <!-- DataTales Example -->
                <div id="parent" class="card shadow mb-4">
                    <div class="card-header">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;display:none">
                            List Appointments
                        </h3>
                    </div>

                    <div class="card-body" style=" width: 96%; margin-left: 2%">
                        <div class="alert  pb-3 mt-3" role="alert" id="alertdiv1" hidden></div>
                        @if (session('message'))
                            <div class="alert alert-danger" id="alertse">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div id="loader" class="lds-dual-ring hidden overlay"></div>
                        {{-- ////////////////////////////////////////////// --}}


                        <div class=" mt-4 mb-2 mr-5" style="padding-left:150px;">
                            <div class=" row">
                                @if (Auth::user()->isAdmin() || Auth::user()->isAgent())
                                    <div id="tablebuttoncsv" class="mr-1 ml-3 " hidden></div>
                                    <div id="tablebuttonexcel" class="mr-1 " hidden></div>
                                    <div id="tablebuttonpdf" class="mr-1" hidden></div>
                                    {{-- <div class="mr-1">
                                    <button id="bookappointment" class="btn"
                                        style="background-color:#9D865C;width:150px;color:#fff">
                                        Book Appointment
                                    </button>
                                    </div> --}}
                                    <div class="mr-1">
                                        <button id="editappointment" class="btn"
                                            style="background-color:#9D865C;width:150px;color:#fff">
                                            Edit Appointment
                                        </button>
                                    </div>
                                    <div class="mr-1">
                                        <button id="deleteappointment" class="btn"
                                            style="background-color:#9D865C;width:150px;color:#fff">
                                            Delete Appointment
                                        </button>
                                    </div>
                                @endif
                                @if (Auth::user()->isPhotographer())
                                    <div class="mr-1">
                                        <button id="comfirmappointment" class="btn"
                                            style="background-color:#9D865C;width:170px;color:#fff">
                                            Confirm Appointment
                                        </button>
                                    </div>
                                    <div class="mr-1">
                                        <button id="rejectappointment" class="btn"
                                            style="background-color:#9D865C;width:150px;color:#fff">
                                            Reject Appointment
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <table class="table table-bordere" style="overflow:scroll;" id="bookslist" width="200%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th><span class="table-title">Check</span></th>
                                    <th><span class="table-title">Date</span></th>
                                    <th><span class="table-title">Time</span></th>
                                    <th><span class="table-title">Agent name</span></th>
                                    <th><span class="table-title">Location</span></th>
                                    <th><span class="table-title">Building Name</span></th>
                                    <th><span class="table-title">Apartment Number</span></th>
                                    <th><span class="table-title">Comment</span></th>
                                    <th><span class="table-title">Photosheet Type</span></th>
                                    <th><span class="table-title">Status</span></th>
                                    <th><span class="table-title">Photographer</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                        <div class="row mt-2">
                            <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                            <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <div class="bookappointmentmodel1" id="bookappointmentmodel1">
        <div class="alert mt-1" role="alert" id="alertdiv2" hidden></div>

        <h4 style="text-align: center">Appointments List</h4>
        <hr>
        <div style="height: 150;overflow-y: auto;display:block; width:auto">
            <table class="table table-bordered  table-striped" id="tableComment">
                <thead>
                    <tr>
                        <th width="10%"><span class="table-title">Date</span></th>
                        <th width="10%"><span class="table-title">Time</span></th>
                        <th width="10%"><span class="table-title">Agent name</span></th>
                        <th width="8%"><span class="table-title">Location</span></th>
                        <th width="8%"><span class="table-title">Building Name</span></th>
                        <th width="10%"><span class="table-title">Apartment Number</span></th>
                        <th width="10%"><span class="table-title">Comment</span></th>
                        <th width="8%"><span class="table-title">Photosheet Type</span></th>
                        <!-- <th width="17%"><span class="table-title">Photographer</span></th> -->
                        <th width="9%"><span class="table-title">Action</span></th>
                    </tr>
                </thead>
                <tbody id="bodybookappointmentmodel1">

                </tbody>
            </table>
            <div id="list" hidden></div>
        </div>
        <button type="button" id="closeFormAppoitment" class="btn cancel btn-primary mt-3">Close</button>
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
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
    </script>

    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src=""></script>
    <script src='{{ asset('tinymce/tinymce.min.js') }}'></script>
    <script>
        $(document).ready(function() {
            var table = $('#bookslist').DataTable({
                "processing": true,
                "serverSide": true,
                scrollY: 500,
                scrollX: true,
                "stripeClasses": [],
                scrollCollapse: true,
                "pageLength": 100,
                "deferRender": true,
                "paging": true,
                "pagingType": "full_numbers",
                "ajax": {
                    "url": "{{ route('show_appointment') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                        });
                    },
                    beforeSend: function() {
                        $('#loader').removeClass('hidden')
                        $("#parent").addClass("disabledbutton");
                    },
                    complete: function() {
                        $('#loader').addClass('hidden')
                        $("#parent").removeClass("disabledbutton");
                    }
                },
                columns: [{
                        data: "check",
                        width: '100px'
                    },
                    {
                        data: "date",
                        width: 200
                    },
                    {
                        data: 'time',
                        name: 'date',
                        width: 200
                    },
                    {
                        data: 'agentname',
                        name: 'agentname',
                        width: 200
                    },
                    {
                        data: 'location',
                        name: 'location',
                        width: 200
                    },
                    {
                        data: 'building_name',
                        name: 'building_name',
                        width: 200
                    },
                    {
                        data: 'apartment_no',
                        name: 'apartment_no',
                        width: 150,

                    },
                    {
                        data: 'comment',
                        name: 'comment',
                        width: 250,
                    },
                    {
                        data: 'photoshoot_type',
                        name: 'photoshoot_type',
                        width: 250
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width: 200
                    },
                    {
                        data: 'photographer',
                        name: 'photographer',
                        width: 200
                    },

                ],
                "createdRow": function( row, data, dataIndex){
                        if( data.status ==  'Rejected'){
                            $( row ).css( "background-color", "#f79256" )
                            $( row ).css( "color", "#fff" )
                        }else if(data.status ==  'Pending'){
                            $( row ).css( "background-color", "#7dcfb6" )
                            $( row ).css( "color", "#fff" )
                        }else if(data.status ==  'Confirmed'){
                            $( row ).css( "background-color", "#98FF98" )
                            $( row ).css( "color", "#fff" )
                        }
                    },
                "lengthMenu": [
                    [100, 500, 1000, 2000, 5000, 10000],
                    [100, 500, 1000, 2000, 5000, 10000]
                ],
                "language": {
                    searchPlaceholder: "Type and press Enter"
                },
                dom: 'lftipB',
                "buttons": [{
                        "extend": 'excel'
                    },
                    {
                        "extend": 'csv'
                    }
                ],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    selector: 'td:first-child'
                },
                initComplete: (settings, json) => {
                    $('#tablepaginate').empty();
                    $('#dataTable_paginate').appendTo('#tablepaginate');
                    $('#tableinfo').empty();
                    $('#dataTable_info').appendTo('#tableinfo');
                    $('#tablebuttoncsv').empty();
                    $('.btn.btn-secondary.buttons-csv.buttons-html5').appendTo(
                        '#tablebuttoncsv');
                    $('#tablebuttonexcel').empty();
                    $('.btn.btn-secondary.buttons-excel.buttons-html5').appendTo(
                        '#tablebuttonexcel');
                    $('#tablebuttonpdf').empty();
                    $('.btn.btn-secondary.buttons-pdf.buttons-html5').appendTo(
                        '#tablebuttonpdf');
                }
            });

            $("div.dataTables_filter input").unbind();
            $("div.dataTables_filter input").keyup(function(
                e) {
                console.log(e.keyCode);
                if (e.keyCode == 13) {
                    table.search(this.value).draw();
                }
            });
            $('#bookappointment').click(function(e) {

                e.preventDefault();
                var data = [];
                var checked_rows = table.rows('.selected').data();
                $.each(checked_rows, function(index, rowId) {
                    data.push(rowId.id);
                });
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                if (data.length > 0) {
                    formData.append("data", JSON.stringify(data));
                    $.ajax({
                        method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        url: "{{ route('book_appointment') }}",

                        success: function(result) {

                            $("#alertse").empty();
                            $("#alertdiv1").empty();
                            document.getElementById("bookappointmentmodel1").style.display =
                                "block";
                            if (result.success) {
                                $("#alertse").empty();
                                $("#alertdiv1").empty();
                                $('#list').empty();
                                // $('#list').append('<select class="form-control" id="bookappoint">' +
                                //     '<option value="">Select Photographer</option>' +
                                //     '</select>');
                                // $.each(result.users, function(key, value) {
                                //         $('#list select').append(
                                //             '<option value="' + value.id + '">' + value
                                //             .name + '</option>'
                                //         );
                                //     })
                                $('#bodybookappointmentmodel1').empty();
                                $.each(result.data[0], function(key, value) {

                                    $('#bodybookappointmentmodel1').append(
                                        '<tr>' +
                                        '<td>' + value.date + '</td>' +
                                        '<td>' + value.time + '</td>' +
                                        '<td>' + value.agentname + '</td>' +
                                        '<td>' + value.location + '</td>' +
                                        '<td>' + value.building_name + '</td>' +
                                        '<td>' + value.apartment_no + '</td>' +
                                        '<td>' + value.comment + '</td>' +
                                        '<td>' + value.photoshoot_type + '</td>' +
                                        // '<td>' + $('#list').html() + '</td>' +
                                        '<td><button class="requestappointment btn btn-primary" id="' +
                                        value.id + '">Request</button></td>' +
                                        '</tr>');
                                });
                            }
                            table.rows().deselect();
                            $("th.select-checkbox").removeClass("selected");
                        },
                        error: function(error) {

                            $("#alertdiv1").empty();
                            $("#alertse").empty();
                            $("#alertdiv1").attr('hidden', false);
                            $("#parent").removeClass("disabledbutton");
                            $('#loader').addClass('hidden');
                        }
                    });
                } else {
                    $('#alertdiv1').empty();
                    $("#alertse").empty();
                    $('#alertdiv1').append(
                        "<div class= 'alert alert-danger'>You Shoud Select data</div>");
                    $('#alertdiv1').attr('hidden', false);
                }
            });

            $('#closeFormAppoitment').click(function(e) {
                document.getElementById("bookappointmentmodel1").style.display =
                    "none";
            });

            $('#deleteappointment').click(function(e) {
                e.preventDefault();
                var data = [];
                var checked_rows = table.rows('.selected').data();
                $.each(checked_rows, function(index, rowId) {
                    data.push(rowId.id);
                });
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                if (data.length > 0) {
                    $('#alertdiv1').empty();
                    $("#alertdata").empty();
                    $('#alertse').attr('hidden', true);
                    $("#alertse").empty();
                    swal({
                        title: 'Are you sure?',
                        text: 'This record and it`s details will be permanantly deleted!',
                        icon: 'warning',
                        buttons: ["Cancel", "Yes!"],
                        }).then(function(value) {
                            if (value) {
                                formData.append("data", JSON.stringify(data));
                                $.ajax({
                                    method: 'post',
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    data: formData,
                                    enctype: 'multipart/form-data',
                                    url: "{{ route('delete_appointment') }}",
                                    beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                        $('#loader').removeClass('hidden')
                                        $("#parent").addClass("disabledbutton");
                                    },
                                    success: function(result) {
                                        if (result.success) {
                                            $("#alertdiv1").empty();
                                            $("#alertse").empty();
                                            $("#alertdata").empty();
                                            $("#alertdiv1").append("<div class= 'alert alert-success'>" +
                                             result
                                                .message + "</div>");
                                            $("#alertdiv1").attr('hidden', false);
                                // reload data
                                            $('#bookslist').DataTable().draw();
                                        } else {
                                            $("#alertdata").empty();
                                            $("#alertse").empty();
                                            $("#alertdiv1").empty();
                                            $("#alertdiv1").append("<div class= 'alert alert-danger'>" +
                                                result
                                                .message + "</div>");
                                            $("#alertdiv1").attr('hidden', false);
                                            $('#loader').addClass('hidden')
                                            $("#parent").removeClass("disabledbutton");
                                         }
                                         table.rows().deselect();
                                         $("th.select-checkbox").removeClass("selected");
                                    },
                                    error: function(error) {
                                        $("#alertdiv1").empty();
                                        $("#alertse").empty();
                                        $("#alertdata").empty();
                                        $.each(error.responseJSON.errors, function(index, value) {
                                            $("#alertdiv1").append(
                                                "<div class= 'alert alert-danger'>" +
                                                index +
                                                "   " + value + "</div>");
                                        });
                                        $("#alertdata").attr('hidden', false);
                                        $("#parent").removeClass("disabledbutton");
                                        $('#loader').addClass('hidden');
                                    }
                                });
                            }
                        });
                } else {
                    $("#alertdata").empty();
                    $("#alertse").empty();
                    $('#alertse').attr('hidden', true);
                    $('#alertdiv1').empty();
                    $('#alertdiv1').append(
                        "<div class= 'alert alert-danger'>You Should Select data</div>");
                    $('#alertdiv1').attr('hidden', false);
                }
            });
            $('#editappointment').click(function() {
                var data = [];
                var table = $('#bookslist').DataTable();
                var checked_rows = table.rows('.selected').data();
                $.each(checked_rows, function(index, rowId) {
                    data.push(rowId.id);
                });
                if (data.length == 0) {
                    $('#alertdiv1').empty();
                    $("#alertse").empty();
                    $('#alertse').attr('hidden', true);
                    $("#alertdata").empty();
                    $('#alertdiv1').append("<div class= 'alert alert-danger'>You Should Select data</div>");
                    $('#alertdiv1').attr('hidden', false);
                } else {
                    $('#alertdiv1').empty();
                    $("#alertse").empty();
                    $('#alertse').attr('hidden', true);
                    $("#alertdata").empty();
                    var id = data.toString();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "Get",
                        url: "{{ route('update_appointment_index') }}/" + id,
                        dataType: 'html',
                        success: function(result) {
                            window.location.href = "{{ route('update_appointment_index') }}/" +
                                id;
                        },
                        error: function(erorr) {
                            console.log(erorr);
                            $("#alertdata").empty();
                            $("#alertse").empty();
                            $('#alertse').attr('hidden', true);
                            $('#alertdiv1').empty();
                            $.each(error.responseJSON.errors, function(index, value) {
                                $("#alertdiv1").append(
                                    "<div class= 'alert alert-danger'>" +
                                    index +
                                    "   " + value + "</div>");
                            });
                            $('#alertdiv1').attr('hidden', false);
                        }
                    });
                }
            });
            $('#comfirmappointment').click(function() {
                var data = [];
                var checked_rows = table.rows('.selected').data();
                $.each(checked_rows, function(index, rowId) {
                    data.push(rowId.id);
                });
                if (data.length == 0) {
                    $('#alertdiv1').empty();
                    $("#alertse").empty();
                    $('#alertse').attr('hidden', true);
                    $("#alertdata").empty();
                    $('#alertdiv1').append("<div class= 'alert alert-danger'>You Should Select data</div>");
                    $('#alertdiv1').attr('hidden', false);
                } else {
                    $('#alertdiv1').empty();
                    $("#alertdata").empty();
                    $("#alertse").empty();
                    var id = data.toString();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ route('confirm_appointment_crm') }}",
                        data: {
                            id: id,
                        },
                        success: function(result) {
                            if (result.success) {
                                $("#alertdata").empty();
                                $("#alertse").empty();
                                $('#alertse').attr('hidden', true);
                                $('#alertdiv1').empty();
                                $('#alertdiv1').append(
                                    "<div class= 'alert alert-success'>" +
                                    result
                                    .message +
                                    "</div>");
                                $('#alertdiv1').attr('hidden', false);
                                $('#bookslist').DataTable().draw();

                            } else {
                                $("#alertdata").empty();
                                $('#alertdiv1').empty();
                                $("#alertse").empty();
                                $('#alertse').attr('hidden', true);
                                $('#alertdiv1').append(
                                    "<div class= 'alert alert-danger'>" +
                                    result
                                    .message +
                                    "</div>");
                                $('#alertdiv1').attr('hidden', false);
                            }
                            table.rows().deselect();
                            $("th.select-checkbox").removeClass("selected");
                        },
                        error: function(erorr) {
                            console.log(erorr);
                        }
                    });
                }
            });
            $('#rejectappointment').click(function() {
                var data = [];
                var checked_rows = table.rows('.selected').data();
                $.each(checked_rows, function(index, rowId) {
                    data.push(rowId.id);
                });
                if (data.length == 0) {
                    $('#alertdiv1').empty();
                    $("#alertse").empty();
                    $('#alertse').attr('hidden', true);
                    $('#alertdiv1').append("<div class= 'alert alert-danger'>You Should Select data</div>");
                    $('#alertdiv1').attr('hidden', false);
                } else {
                    $('#alertdiv1').empty();
                    var id = data.toString();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ route('reject_appointment_crm') }}",
                        data: {
                            id: id,
                        },
                        success: function(result) {
                            if (result.success) {
                                $("#alertdata").empty();
                                $("#alertse").empty();
                                $('#alertse').attr('hidden', true);
                                $('#alertdiv1').empty();
                                $('#alertdiv1').append(
                                    "<div class= 'alert alert-success'>" +
                                    result
                                    .message +
                                    "</div>");
                                $('#alertdiv1').attr('hidden', false);
                                $('#bookslist').DataTable().draw();
                            } else {
                                $("#alertdata").empty();
                                $('#alertse').attr('hidden', true);
                                $("#alertse").empty();
                                $('#alertdiv1').empty();
                                $('#alertdiv1').append(
                                    "<div class= 'alert alert-danger'>" +
                                    result
                                    .message +
                                    "</div>");
                                $('#alertdiv1').attr('hidden', false);
                            }
                            table.rows().deselect();
                            $("th.select-checkbox").removeClass("selected");
                        },
                        error: function(erorr) {
                            console.log(erorr);
                        }
                    });
                }
            });

            //     $(document).on ('click','.requestappointment',function(){
            //         var id = $(this).attr('id');
            //         var photographer = $('#bookappoint').val();
            //             $.ajaxSetup({
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 }
            //             });
            //             // ajax
            //             $.ajax({
            //                 type: "POST",
            //                 url: "{{ route('request_apponitment') }}",
            //                 data: {
            //                     id: id,
            //                     // photographer: photographer
            //                 },
            //                 success: function(result) {
            //                     if (result.success) {
            //                         $('#alertdiv2').empty();
            //                         $('#alertdiv2').append(
            //                             "<div class= 'alert alert-success'>" +
            //                             result
            //                             .message +
            //                             "</div>");
            //                         $('#alertdiv2').attr('hidden', false);
            //                     } else {
            //                         $('#alertdiv2').empty();
            //                         $('#alertdiv2').append(
            //                             "<div class= 'alert alert-danger'>" +
            //                             result
            //                             .message +
            //                             "</div>");
            //                         $('#alertdiv2').attr('hidden', false);
            //                     }
            //                 },
            //                 error: function(erorr) {
            //                     console.log(erorr);
            //                 }
            //             });

            // });
        });
    </script>
@endpush
