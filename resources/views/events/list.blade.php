@extends('layouts.app')
@push('head')
    <title>Events List</title>

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

        nav.justify-between,
        .leading-5 {
            margin-top: 15px;
        }


        .items-center .justify-between {
            display: none;
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
            /* background-image:linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
        }

        nav ul li:last-child {
            border-bottom: 0 !important;
        }

        .content-input {
            display: flex;
            align-items: center;
        }

        .label {
            width: auto;
            padding-right: 12px;
        }

        .dropdown {
            width: 55%;
        }

        .label h4 {
            color: #241907;
            font-family: 'Lato-Semibold';
            font-size: 17px;
        }

        .dropdown select {
            box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
            border-right: 2px solid #db9d33;
            color: #db9d33;
            font-family: 'Lato-Regular';
            font-size: 15px;
        }

        #dataTable_filter label::after {
            content: "";
            width: 70px;
            height: 28px;
            /* background: url(img/search-remax.jpg) no-repeat; */
            top: 10px;
            right: 71px;
            position: relative;
            display: inline-block;
            background-size: cover;
        }

        #dataTable_filter label::before {
            font-family: fontAwesome;
            content: "\f002";
            width: 26px;
            height: 20px;
            top: 1px;
            left: 83px;
            border-right: 2px solid #e3e0e0;
            position: relative;
            display: inline-block;
            /* color:rgb(228 170 71); */
        }

        #dataTable_filter input {
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

        #dataTable_length select {
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

        .loginPopupComment th {

            /* background: #6d4e18; */

            /* width: auto!important; */
            /* display: inline;/ */
        }

        span.table-title {
            width: 100%;
            font-size: 12px;
            font-family: 'Lato-Semibold';
            color: #fff;
            /* border-right: 1px solid;*/
        }

        /* #bookslist_wrapper{
                            border: 1px solid #e5d5d5;
                            border-radius: 5px;
                        } */
        #dataTable_length,
        #dataTable_filter,
        .dataTables_scroll {
            background: #fff;
        }

        #dataTable_length {
            position: absolute;
            right: 50%;
            margin-top: 2.1rem;
            /* border: 1px solid #e5d5d5;
                            border-bottom: none;
                            border-radius: 8px 8px 0 0; */
        }

        #dataTable_filter {
            border-top: 1px solid #e5d5d5;
            border-left: 1px solid #e5d5d5;
            border-right: 1px solid #e5d5d5;
            border-radius: 8px 8px 0 0;
            padding: 1rem;
            height: 5rem;
        }

        #dataTable_filter label {
            margin-top: 0.5rem;
        }

        .dataTables_scroll {
            border-left: 1px solid #e5d5d5;
            border-right: 1px solid #e5d5d5;
            border-bottom: 1px solid #e5d5d5;
            border-radius: 0px 0px 8px 8px;
        }

        .group-button {
            position: relative;
            margin-top: 1.5rem;
            top: 0px;
            left: 18px;
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
                padding: 2px;
            }

            #dataTable_filter input {
                width: 14rem !important;
            }

            #dataTable_filter label::before {
                top: 126px;
                right: 192px;
            }

            #dataTable_filter label::after {
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

            #dataTable_length {
                position: inherit;
            }

            #dataTable_filter input {
                width: 13rem !important;
            }

            #dataTable_filter label::after {
                top: 281px !important;
                right: 30px !important;
            }

            #dataTable_filter label::before {
                top: 283px;
                right: 179px;
            }

            #bookslist_info {
                position: inherit;
            }

            #wrapper {
                background-size: cover !important;

            }

            .top-title {
                /*margin-left:20px!important;*/
            }

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

        #sel1:focus-visible,
        #daymonthvalue:focus-visible,
        #rangedate:focus-visible,
        #datasource:focus-visible {
            outline: none;
        }

        #sel1,
        #datasource {
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

        #daymonthvalue,
        #rangedate {
            box-shadow: 0 4px 2px -2px #d9d1d1;
            color: #878b8f;
            vertical-align: middle;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 1.75rem 0.375rem 0.75rem;
            font-size: 12px;
            font-family: 'Lato-Regular' !important;
        }

        #daymonthfilter,
        #rangefilter {
            margin-left: -5px;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            background: #fff;
            height: calc(2.25rem + 2px);
            position: absolute;
            right: 0;
            z-index: 1000;
            width: 3rem;

        }

        #border {
            margin-right: -8px;
            margin-left: -5px;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            height: calc(2.25rem + 2px);
            /* padding: 0.475rem 5px 0.775rem 5px; */
            width: 54px;
        }

        #border img {
            width: 138%;
            margin-right: -25px;
            height: 100%;
            transform: scaleX(1);
        }

        #border2 {
            margin-right: -8px;
            margin-left: -5px;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            height: calc(2.25rem + 2px);
            /* padding: 0.475rem 5px 0.775rem 5px; */
            width: 46px;
        }

        #border2 img {
            width: 135%;
            margin-right: -21px;
            height: 100%;
            transform: scaleY(-1);
        }

        #border3 {
            margin-right: -39px;
            margin-left: -12px;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            height: calc(2.25rem + 1px);
            /* padding: 0.475rem 5px 0.775rem 5px; */
            width: 46px;
        }

        #border3 img {
            width: 89%;
            /* margin-right: -21px; */
            height: 103%;
            transform: scaleX(-2);
        }

        #border4 {
            margin-right: -33px;
            margin-left: -20px;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            height: calc(2.25rem + 2px);
            /* padding: 0.475rem 5px 0.775rem 5px; */
            width: 46px;
        }

        #border4 img {
            width: 89%;
            /* margin-right: -21px; */
            height: 100%;
            transform: scaleX(1.3);
        }

        #datetimepicker2 label {
            width: 21%;
            text-align: left;
            color: #143e39;
            font-family: 'Lato-Bold';
            font-size: 13px;
        }

        .card-header {
            /* padding: 0 10rem;*/
        }

        .pad-row {
            padding: 0 4.8rem;
        }

        .row3 {
            margin-top: -4rem;
        }

        #img-div {
            margin-top: -15px;
            margin-bottom: 7px;
            margin-left: -7px;
        }

        #resid:after {
            content: '';
            position: absolute;
            top: 25px;
            border-radius: 100%;
            /* border: 48px solid transparent; */
            border-top: 35px solid #f7f8f8;
            display: block;
            width: 7rem;
            height: 0;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: -1px -3px 3px -2px #d9d1d1;
            /* border-top: 1px solid #d9d1d1;*/
        }

        #resid2:before {
            content: '';
            position: absolute;
            bottom: 25px;
            border-radius: 100%;
            /* border: 48px solid transparent; */
            border-bottom: 35px solid #f7f8f8;
            display: block;
            width: 7rem;
            height: 0px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: -1px 3px 2px -2px #d9d1d1;
            /* border-top: 1px solid #d9d1d1;*/
        }

        #dataTable_length,
        #dataTable_filter,
        .dataTables_scroll {
            background: #fff;
        }

        .card-body {
            /* margin-top: -rem!important; */
        }

        #wrapper {
            height: 100% !important;
        }



        div.dataTables_scrollBody::-webkit-scrollbar {
            width: 5px;
        }

        div.dataTables_scrollBody::-webkit-scrollbar {
            width: 3px !important;

        }

        /* Track */
        div.dataTables_scrollBody::-webkit-scrollbar-track {
            background: #c5c5c5 !important;
        }

        /* Handle */
        div.dataTables_scrollBody::-webkit-scrollbar-thumb {
            background: #6d4e18;
            border-radius: 0px;
            border-radius: 8px;
        }

        /* Handle on hover */
        div.dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
            background: #6d4e18;
            border-radius: 8px;
        }

        .justify-content-start {
            left: 20px;
            top: 6px;
        }

        #dataTable_next a::after {
            content: "";
            width: 70px;
            height: 30px;
            /* background: url(img/right.jpg) no-repeat; */
            top: 0px;
            right: -65px;
            position: absolute;
            display: inline-block;
            background-size: contain;
        }

        #dataTable_previous a::before {
            content: "";
            width: 70px;
            height: 30px;
            /* background: url(img/left.jpg) no-repeat; */
            top: 0px;
            left: -49px;
            position: absolute;
            display: inline-block;
            background-size: contain;
        }

        #tablepaginate {
            padding-right: 4rem;
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
        @media(max-width: 1100px) and (min-width: 1000px) {
            #dataTable_length {
                right: 51%;
            }

            #dataTable_filter label {
                margin-left: 22rem;
                width: 55%;
            }

            .img-row {
                margin-bottom: 1rem;
                padding-right: 2rem;

            }
        }

        table.table-bordered.dataTable td:last-child,
        table.table-bordered.dataTable td:last-child {
            text-align: center;
        }

        .btn-info {
            margin-top: 0px !important;
        }

        @media(max-width: 768px) and (min-width: 550px) {

            .container-fluid,
            .card-header {
                padding: 0 !important;
            }

            .card-body {
                padding: 10px;
            }

            #dataTable_length {
                right: 49% !important;
                margin-top: 2.2rem !important;
            }

            .justify-content-start {
                top: -3px;
                align-items: center;
            }

            #tablepaginate {
                padding-right: 0rem !important;
                justify-content: space-around !important;
            }

            #dataTable_filter label::before {
                top: 1px !important;
            }

            #dataTable_filter label::after {
                top: 10px;
                right: 3px;
            }
        }

        .img-row {
            margin-bottom: 1rem;
            padding-right: 2rem;
        }

        @media(max-width: 500px) {

            /* .img-row {
                    position: inherit;
                    margin-bottom: 7rem;
                    } */
            #dataTable_filter label::after {
                top: 10px !important;
                right: 58px !important;
            }

            #dataTable_filter label::before {
                top: 2px !important;
                right: 179px !important;
            }

            .container-fluid,
            .card-body {
                padding: 0 !important;
            }

            .justify-content-start {
                top: 0 !important;
                left: 0 !important;
                justify-content: center !important;
            }

            #dataTable_length {
                margin-top: 6.1rem !important;
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
                left: 25px;
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
                position: inherit;
            }
        }

        @media(max-width: 390px) {
            .col-title {
                left: 31px;
            }

            .top-title {
                font-size: 15px;
            }
        }

        #dataTable {
            overflow: scroll !important;
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
            margin-top: 8px;
        }

        .select2-selection__rendered {
            width: 220px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 15px;
            margin-top: 10px;
            /* right: -17px !important; */
            width: 20px;
        }

        .select2 {
            width: 100%;
            /* margin-top: 20px */
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

        #name,
        #SpecificData,
        #phone,
        #date,
        #user,
        #status {
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

        .loginPopupComment {
            text-align: center;
            width: 60%;
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

        .loginPopupComment span {
            display: block;
            width: 150px;
            /* color: #db9d33 */

        }

        .color {
            color: turquoise
        }

        .loginPopupComment .btn {
            background-color: tomato;
            color: white
        }

        /* .table-responsive{
                    overflow: hidden!important;
                } */
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

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
    </script>

    <!--  datetime range -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@section('wrapper_content')

    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-5 col-8">
                <h3 class="top-title">Events List</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid" style="margin-top:1.5rem">

                <!-- Page Heading -->
                <div class="alert  pb-3 mt-3" role="alert" id="alertapprov" hidden>

                </div>
                <h1 class="h3 mb-2 text-gray-800"></h1>
                <div class="row mt-4 mb-4">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Status</label>
                    </div>
                    <div class="col-md-4">
                        <select name="status" id="status">
                            <option value="ALL">Select Status</option>
                            <option value="passed">Passed</option>
                            <option value="coming">Coming</option>
                            <option value="rejected">rejected</option>
                            <option value="pending">pending</option>
                        </select>
                    </div>
                    <div class="col-md-1 mr-1">
                        <label class="title-input" for="property">User</label>
                    </div>
                    <div class="col-md-4" style="margin-top:-10px">
                        <select name="user" class="select2 " id="user">
                            <option value="ALL">Select user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-4 mb-4">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Specific Data</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" placeholder="enter Specific Data" name="SpecificData" class="SpecificData"
                            id="SpecificData" />
                    </div>
                    <div class="col-md-1 mr-1">
                        <label class="title-input" for="property">Date</label>
                    </div>
                    <div class="col-md-4">
                        <select name="date" class="date" id="date">
                            <option value="ALL">Select Date</option>
                            <option value="today">Today</option>
                            <option value="tomorrow">Tomorrow</option>
                            <option value="thismonth">This Month</option>
                            <option value="thisweek">This Week</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="lastweek">Last Week</option>
                            <option value="lastmonth">Last Month</option>
                        </select>
                    </div>
                </div>



                <!-- DataTales Example -->
                <div class="alert  pb-3 mt-3" role="alert" id="alertedit" hidden>

                </div>

                <div id="parent" class="card shadow mb-4">
                    <div class="card-header py-3">
                        <!-- <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                                            Show users
                                        </h3> -->

                        <div class=" pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                        <input value="" type="text" name="search" id="filter" hidden />
                        @if (Auth::user()->isAdmin() || Auth::user()->isAgent() || Auth::user()->isPhotographer())
                            <div class="mt-5">
                                <div class=" row">
                                    @if (Auth::user()->isAdmin())
                                        <a style="background-color:#9D865C;width:150px;color:#fff"
                                            class=" delete ml-5  btn">Delete Event</a>
                                    @endif
                                    <a class='edit ml-1 btn '
                                        @if (Auth::user()->isAdmin()) style="background-color:#9D865C;width:150px;color:#fff" @else style="background-color:#9D865C;width:150px;color:#fff;display:none" @endif>Edit
                                        Event</a>
                                    <a style="background-color:#9D865C;width:150px;color:#fff"
                                        @if (Auth::user()->isPhotographer() || Auth::user()->isAgent()) class='show_detalis ml-5 btn' @else class='show_detalis ml-1 btn' @endif>Show
                                        Event Details </a>
                                    @if (Auth::user()->isAdmin())
                                        <a style="background-color:#9D865C;width:150px;color:#fff;display:none"
                                            class='reject  ml-1 btn'>Reject Event</a>
                                        <a style="background-color:#9D865C;width:150px;color:#fff;display:none"
                                            class='approve ml-1 btn'>Approve Event</a>
                                    @endif
                                </div>
                            </div>
                        @endif



                        <div class="card-body ">

                            <div class="table-responsive" style="max-height:278vh;overflow:scroll">
                                <table class="table table-bordered table-hover" id="dataTable">
                                    <thead style="background: #70cacc;color: aliceblue;">
                                        <tr>
                                            <th><span class="table-title">check</span></th>
                                            <!-- <th><span class="table-title">id</span></th> -->
                                            <th><span class="table-title">Name</span></th>
                                            <th><span class="table-title">DateTime</span></th>
                                            <th><span class="table-title">Address</span></th>
                                            <th><span class="table-title">Description</span></th>
                                            <th><span class="table-title">created by</span></th>
                                            {{-- <th><span class="table-title">Action</span></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input id="startdate" type="text" hidden>
                                        <input id="enddate" type="text" hidden>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-2">
                                <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                                <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                            </div>
                        </div>
                        <div class="loginPopupComment" id="details">
                            <h4 style="text-align: left">Event Details</h4>
                            <div hidden id="list">

                            </div>
                            <div hidden id="Attend" style="text-align: left">

                            </div>
                            <hr>
                            <div style="overflow-x: auto;height: 300px;overflow-y: auto;display:block">
                                <table class="table table-bordered  table-striped ">
                                    <thead id="tabledetalis">

                                    </thead>
                                    <tbody id="tabledetailsbody">

                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn cancel btn-dange mt-3"
                                onclick="closedetalis()">Close</button>
                        </div>

                    </div>

                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">

                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        {{-- <div class="row img-row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4 text-right">
                        <img src="img/people.png" style="height: 8rem">
                    </div>
                </div> --}}
        <!-- End of Content Wrapper -->
    @endsection

    @section('content')
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    @endsection


    @push('scripts')
        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {


                let table = $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    scrollY: 500,
                    scrollX: true,
                    scrollCollapse: true,
                    "stripeClasses": [],
                    "pageLength": 100,
                    "deferRender": true,
                    "paging": true,
                    "ajax": {
                        "url": "{{ route('list_event_datatable') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function(d) {
                            return $.extend({}, d, {
                                _token: "{{ csrf_token() }}",
                                'status': document.getElementById("status").value,
                                'user': document.getElementById("user").value,
                                'date': document.getElementById("date").value,
                                'SpecificData': document.getElementById("SpecificData").value
                            });
                        },
                        beforeSend: function() {
                            $("#parent").LoadingOverlay("show", {
                                background: "rgba(78, 115, 223, 0.5)"
                            });

                        },
                        complete: function() {
                            $("#parent").LoadingOverlay("hide", true);

                        }
                    },
                    "columns": [{
                            data: "check",
                            width: '150px'
                        },
                        // {
                        //     data: "id",
                        //     width: '50px'
                        // },
                        {
                            data: "name",
                            width: '200px'
                        },
                        {
                            data: "date",
                            width: '200px'
                        },
                        {
                            data: "address",
                            width: '200px'
                        },
                        {
                            data: "description",
                            width: '200px'
                        },
                        {
                            data: "username",
                            width: '200px'
                        },

                    ],
                    "createdRow": function(row, data, dataIndex) {
                        if (data.status == 'coming') {
                            $(row).css("background-color", "#98FF98")
                            $(row).css("color", "#fff")
                        } else if (data.status == 'pending') {
                            $(row).css("background-color", "#7dcfb6")
                            $(row).css("color", "#fff")
                        } else if (data.status == 'rejected') {
                            $(row).css("background-color", "#f79256")
                            $(row).css("color", "#fff")
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
                    "paging": true,
                    "buttons": [],
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
                $('#status').change(function() {
                    $("#alertdiv").empty();
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        'status': document.getElementById("status").value,
                        'user': document.getElementById("user").value,
                        'date': document.getElementById("date").value,
                        'SpecificData': document.getElementById("SpecificData").value
                    }, );
                    $('#dataTable').DataTable().draw();
                });
                $('#user').change(function() {
                    $("#alertdiv").empty();
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        'status': document.getElementById("status").value,
                        'user': document.getElementById("user").value,
                        'date': document.getElementById("date").value,
                        'SpecificData': document.getElementById("SpecificData").value
                    }, );
                    $('#dataTable').DataTable().draw();
                });
                $('#date').change(function() {
                    $("#alertdiv").empty();
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        'status': document.getElementById("status").value,
                        'user': document.getElementById("user").value,
                        'date': document.getElementById("date").value,
                        'SpecificData': document.getElementById("SpecificData").value
                    }, );
                    $('#dataTable').DataTable().draw();
                });
                $('#SpecificData').change(function() {
                    $("#alertdiv").empty();
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        'status': document.getElementById("status").value,
                        'user': document.getElementById("user").value,
                        'date': document.getElementById("date").value,
                        'SpecificData': document.getElementById("SpecificData").value
                    }, );
                    $('#dataTable').DataTable().draw();
                });


                $('#dataTable').DataTable().draw();

                function newexportaction(e, dt, button, config) {
                    var self = this;
                    var oldStart = dt.settings()[0]._iDisplayStart;
                    dt.one('preXhr', function(e, s, data) {
                        // Just this once, load all data from the server...
                        data.start = 0;
                        data.length = 2147483647;
                        dt.one('preDraw', function(e, settings) {
                            // Call the original action function
                            if (button[0].className.indexOf('buttons-copy') >= 0) {
                                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt,
                                    button, config);
                            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt,
                                        button, config) :
                                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt,
                                        button, config);
                            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt,
                                        button, config) :
                                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt,
                                        button, config);
                            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt,
                                        button, config) :
                                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt,
                                        button, config);
                            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                            }
                            dt.one('preXhr', function(e, s, data) {
                                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                                // Set the property to what it was before exporting.
                                settings._iDisplayStart = oldStart;
                                data.start = oldStart;
                            });
                            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                            setTimeout(dt.ajax.reload, 0);
                            // Prevent rendering of the full data to the DOM
                            return false;
                        });
                    });
                    // Requery the server with the new one-time export settings
                    dt.ajax.reload();
                }

                $('#dataTable').on('search.dt', function() {
                    var value = $('.dataTables_filter input').val();
                    var s = $('#filter:text').val(value);
                    $('#alertdiv').attr('hidden', true);
                });
                $('body').on('click', '.delete', function() {
                    var data = [];
                    var checked_rows = table.rows('.selected').data();
                    $.each(checked_rows, function(index, rowId) {
                        data.push(rowId.id);
                    });
                    if (data.length == 0) {
                        $('#alertedit').empty();
                        $('#alertapprov').empty();
                        $('#alertedit').append("<div class= 'alert alert-danger'>You Shoud Select data</div>");
                        $('#alertedit').attr('hidden', false);
                    } else {
                        var id = data.toString();
                        $('#alertedit').attr('hidden', true);
                        $('#alertapprov').empty();
                        swal({
                            title: 'Are you sure?',
                            text: 'This record and it`s details will be permanantly deleted!',
                            icon: 'warning',
                            buttons: ["Cancel", "Yes!"],
                        }).then(function(value) {
                            if (value) {

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('delete_event') }}",
                                    data: {
                                        id: id
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        if (result.state) {
                                            $('#alertedit').empty();
                                            $('#alertedit').append(
                                                "<div class= 'alert alert-success'>" +
                                                result.message + "</div>");
                                            $('#alertedit').attr('hidden', false);
                                            table.clear().draw();
                                        } else {
                                            $('#alertedit').empty();
                                            $('#alertedit').append(
                                                "<div class= 'alert alert-danger'>" +
                                                result.message + "</div>");
                                            $('#alertedit').attr('hidden', false);
                                        }
                                    },
                                });
                            }
                        });
                    }
                });
                $('body').on('click', '.edit', function() {
                    var data = [];
                    var checked_rows = table.rows('.selected').data();
                    $.each(checked_rows, function(index, rowId) {
                        data.push(rowId.id);
                    });
                    // console.log(data);
                    if (data.length == 0) {
                        $('#alertedit').empty();
                        $('#alertapprov').empty();
                        $('#alertedit').append("<div class= 'alert alert-danger'>You Shoud Select data</div>");
                        $('#alertedit').attr('hidden', false);
                    } else {
                        $('#alertedit').attr('hidden', true);
                        $('#alertapprov').empty();
                        $('#alertedit').empty();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "Get",
                            url: "{{ route('edit_event') }}/" + data,
                            dataType: 'html',
                            success: function(result) {
                                window.location.href = "{{ route('edit_event') }}/" + data;
                            },
                        });
                    }
                });
                $('body').on('click', '.selected', function() {
                    var status = table.row(this.closest('tr')).data()['status'];
                    var createdby = table.row(this.closest('tr')).data()['created_by'];
                    var user = {{ Auth::user()->role_id }};
                    var user_id = {{ Auth::user()->id }}
                    if (user == "1") {
                        if (status == 'pending') {
                            $('.reject').css('display', 'block');
                            $('.approve').css('display', 'block');
                        } else {
                            $('.reject').css('display', 'none');
                            $('.approve').css('display', 'none');
                        }
                    } else {
                        if (status == 'pending' && user_id == createdby) {
                            $('.edit').css('display', 'block');
                        } else {
                            $('.edit').css('display', 'none');
                        }
                    }
                });
                $('body').on('click', '.approve', function() {
                    var id = table.row(this.closest('tr')).data()['id']
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('approved_crm') }}",
                        data: {
                            id: id
                        },
                        beforeSend: function() {
                            $('#alertapprov').empty();
                            $('#alertedit').empty();
                            $('#alertapprov').append(
                                "<div class= 'alert alert-warning'>Please Wait for Sending Email</div>"
                            );
                            $('#alertapprov').attr('hidden', false);
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.state) {
                                $('#alertapprov').empty();
                                $('#alertedit').empty();
                                $('#alertapprov').append("<div class= 'alert alert-success'>" +
                                    result.message + "</div>");
                                $('#alertapprov').attr('hidden', false);
                                table.clear().draw();
                                $('.reject').css('display', 'none');
                                $('.approve').css('display', 'none');
                            } else {
                                $('#alertapprov').empty();
                                $('#alertedit').empty();
                                $('#alertapprov').append("<div class= 'alert alert-danger'>" +
                                    result.message + "</div>");
                                $('#alertapprov').attr('hidden', false);
                            }
                        },
                    });

                });
                $('body').on('click', '.reject', function() {
                    var id = table.row(this.closest('tr')).data()['id']
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('reject_crm') }}",
                        data: {
                            id: id
                        },
                        beforeSend: function() {
                            $('#alertapprov').empty();
                            $('#alertedit').empty();
                            $('#alertapprov').append(
                                "<div class= 'alert alert-warning'>Please Wait for Sending Email</div>"
                            );
                            $('#alertapprov').attr('hidden', false);
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.state) {
                                $('#alertapprov').empty();
                                $('#alertedit').empty();
                                $('#alertapprov').append("<div class= 'alert alert-success'>" +
                                    result.message + "</div>");
                                $('#alertapprov').attr('hidden', false);
                                table.clear().draw();
                                $('.reject').css('display', 'none');
                                $('.approve').css('display', 'none');
                            } else {
                                $('#alertapprov').empty();
                                $('#alertedit').empty();
                                $('#alertapprov').append("<div class= 'alert alert-danger'>" +
                                    result.message + "</div>");
                                $('#alertapprov').attr('hidden', false);
                            }
                        },
                    });

                });
                $('body').on('click', '.show_detalis', function() {
                    var data = [];
                    var checked_rows = table.rows('.selected').data();
                    $.each(checked_rows, function(index, rowId) {
                        data.push(rowId.id);
                    });
                    if (data.length == 0) {
                        $('#alertedit').empty();
                        $('#alertapprov').empty();
                        $('#alertedit').append("<div class= 'alert alert-danger'>You Shoud Select data</div>");
                        $('#alertedit').attr('hidden', false);
                    } else {
                        $('#alertedit').attr('hidden', true);
                        $('#alertapprov').empty();
                        var id = data.toString();
                        document.getElementById("details").style.display = "block";
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: "{{ route('eventdetalis') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(result) {

                                var image = '';
                                if (result.image) {
                                    image = '<img src="' + result.image +
                                        '" width="200" height="200">';
                                } else {
                                    image = "";
                                }
                                var list = [];
                                $.each(result.atten_list, function(key, value) {
                                    $('#list').append('<ul><li>' + value.name +
                                        '</li></ul>');
                                });
                                $('#Attend').empty();
                                $('#tabledetailsbody').empty();
                                $('#tabledetalis').empty();
                                if (result.event.status == 'pending' || result.event.status ==
                                    'rejected') {
                                    $('#tabledetalis').append(
                                        '<tr >' +
                                        '<th width="70%" ><span width="70%" class="table-title">Name</span></th>' +
                                        '<th width="70%"><span width="70%" class="table-title">Date</span></th>' +
                                        '<th width="10%"><span width="70%" class="table-title">Address</span></th>' +
                                        '<th width="10%"><span width="70%" class="table-title">Description</span></th>' +
                                        '<th width="10%"><span width="70%"class="table-title">image</span></th>' +
                                        '</tr>'
                                    );
                                    $('#tabledetailsbody').append(
                                        '<tr>' +
                                        '<td width="70%">' + result.event.name + '</td>' +
                                        '<td width="70%">' + result.event.date + '</td>' +
                                        '<td>' + result.event.address + '</td>' +
                                        '<td>' + result.event.description + '</td>' +
                                        '<td>' + image + '</td>' +
                                        '</tr>');
                                    $('#list').empty();
                                } else {
                                    $('#tabledetalis').append(
                                        '<tr >' +
                                        '<th width="70%" ><span width="70%" class="table-title">Name</span></th>' +
                                        '<th width="70%"><span width="70%" class="table-title">Date</span></th>' +
                                        '<th width="10%"><span width="70%" class="table-title">Address</span></th>' +
                                        '<th width="10%"><span width="70%" class="table-title">Description</span></th>' +
                                        '<th width="10%"><span width="70%"class="table-title">image</span></th>' +
                                        '<th width="10%"><span width="70%" class="table-title">Attenders List</span></th>' +
                                        '<th width="10%"><span width="70%" class="table-title">Action</span></th>' +
                                        '<th width="10%"><span  width="70%"class="table-title">Upload Attendance Proof</span></th>' +
                                        '</tr>'
                                    );
                                    $('#tabledetailsbody').append(
                                        '<tr>' +
                                        '<td width="70%">' + result.event.name + '</td>' +
                                        '<td width="70%">' + result.event.date +
                                        '</td>' +
                                        '<td>' + result.event.address + '</td>' +
                                        '<td>' + result.event.description + '</td>' +
                                        '<td>' + image + '</td>' +
                                        '<td class="list' + result.event.id + '">' + $('#list')
                                        .html() + '</td>' +
                                        '<td class="attend' + result.event.id + '">' +
                                        '' + result.attend + '' +
                                        '</td>' +
                                        '<td>' + result.form + '</td>' +
                                        '</tr>');
                                    $('#list').empty();
                                }
                            },
                        });
                    }
                });
            });

            function closedetalis() {
                document.getElementById("details").style.display = "none";
                $('#Attend').empty();
            }
            $('.select2').select2();
        </script>
        <script>
            function Attend(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('Attend') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.state) {
                            $('#Attend').empty();
                            $('#Attend').append("<div class= 'alert alert-success'>" + result.message + "</div>");
                            $('#Attend').attr('hidden', false);
                            $('.list' + id).append('<ul><li>' + result.name + '</li></ul>');
                            $('.attend' + id).empty();
                        } else {
                            $('#Attend').empty();
                            $('#Attend').append("<div class= 'alert alert-danger'>" + result.message + "</div>");
                            $('#Attend').attr('hidden', false);

                        }

                    }
                });
            }
        </script>
        <script>
            // $('#upload').click(function(e) {
            $('body').on('click', '.upload', function() {

                var formData = new FormData($('#upload')['0']);
                formData.append("_token", "{{ csrf_token() }}");
                // formData.append("id", id);
                $.ajax({
                    type: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    enctype: 'multipart/form-data',
                    url: "{{ route('upload_attend_poof') }}",
                    dataType: 'json',
                    success: function(result) {
                        if (result.state) {
                            $('#Attend').empty();
                            $('#Attend').append("<div class= 'alert alert-success'>" + result.message +
                                "</div>");
                            $('#Attend').attr('hidden', false).delay(5000).fadeOut();
                            $("#upload")[0].reset();
                        } else {
                            $('#Attend').empty();
                            $('#Attend').append("<div class= 'alert alert-danger'>" + result.message +
                                "</div>");
                            $('#Attend').attr('hidden', false).delay(5000).fadeOut();
                        }

                    }
                });
            });
        </script>


        <!-- jQuery library -->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
        </script>
    @endpush
