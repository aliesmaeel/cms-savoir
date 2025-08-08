@extends('layouts.app')
@push('head')
    <title>Commented data</title>

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
            /* margin-left: -5px; */
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

        th {

            /* background: #6d4e18; */

            /* width: 25px!important; */
        }

        .formPopup {
            display: none;
        }

        .formContainer {
            max-width: 300px;
            padding: 20px;
            background-color: #fff;
        }

        .formContainer input[type=text],
        .formContainer input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 20px 0;
            border: none;
            background: #eee;
        }

        .formContainer input[type=text]:focus,
        .formContainer input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        .formContainer .btn {
            padding: 12px 20px;
            border: none;
            background-color: #8ebf42;
            color: #fff;
            cursor: pointer;
            width: 100%;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .formContainer .cancel {
            background-color: #cc0000;
        }

        .formContainer .btn:hover,
        .openButton:hover {
            opacity: 1;
        }

        .model {
            width: 50%;
            border: 1px solid;
            padding: 30px;
            position: fixed;
            z-index: 9;
            top: 50%;
            background-color: white;
            transform: translate(-50%, -50%);
            left: 50%;
            display: none;
        }

        #times {
            position: absolute;
            left: 90%;
            top: 5%;
            z-index: 10;
            cursor: pointer;

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
            margin-top: 2rem;
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
                /* margin-left: -2px; */
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
                top: 2px;
                right: 192px;
            }

            #dataTable_filter label::after {
                width: 61px;
                top: 10px;
                right: 58px;
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
                width: 11rem !important;
            }

            #dataTable_filter label::after {
                top: 10px !important;
                right: 63px !important;
            }

            #dataTable_filter label::before {
                top: 2px;
                right: 179px;
            }

            #bookslist_info {
                position: inherit;
            }

            #wrapper {
                background-size: cover !important;

            }

            .top-title {
                /* margin-left:20px!important; */
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

        #agentname:focus-visible,
        #userid:focus-visible,
        #userstatus:focus-visible,
        #sel1:focus-visible,
        #daymonthvalue:focus-visible,
        #rangedate:focus-visible,
        #datasource:focus-visible {
            outline: none;
        }

        #sel1,
        #datasource,
        #userstatus,
        #userid,
        #agentname {
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

        .select2-container--default .select2-selection--single {
    background: #fff!important;
    border-radius: 0!important;
    height: calc(2.25rem + 2px)!important;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
    vertical-align: middle !important;
    text-align: left;
    box-shadow: 0 4px 2px -2px #d9d1d1;
    border-right: 3px solid #9D865C!important;
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
.select2-selection__rendered{
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
.select2{
    width: 100%;
    /* margin-top: 20px */
}

.select2-container .select2-selection--single .select2-selection__rendered {
    width: 150px;
    display: block;
    font-family: 'Lato-Regular'!important;
    font-size: 12px!important;
    line-height: 1.5!important;
    color: #878b8f !important;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
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
            /* border-right: 3px solid #e4aa47!important; */
        }

        #daymonthfilter,
        #rangefilter {
            margin-left: -5px;
            box-shadow: 0 4px 2px -2px #d9d1d1;
            background: #fff;
            height: calc(2.25rem + 2px);
            position: absolute;
            right: 3px;
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
            padding: 0 10rem;
        }

        .pad-row {
            padding: 0 4.7rem;
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

        .card-body-one {
            margin-top: -7rem !important;
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

        i.fa-whatsapp {
            font-size: 19px;
            color: #5fb750;
        }

        #mobile {
            display: none;
        }

        /*responsive*/
        @media(max-width: 1300px) and (min-width: 1201px) {
            .card-header {
                padding: 0 8rem;
            }
        }

        @media(max-width: 1200px) and (min-width: 1025px) {
            .card-header {
                padding: 0 5rem;
            }
        }

        @media(max-width: 1024px) and (min-width: 800px) {
            .pad-row {
                padding: 0 4.8rem 0 5rem;
            }

            #datetimepicker2 label {
                width: 26%;
            }

            .row3 {
                margin-top: -4rem;
            }

            /*#resid:after,#resid2:before{
            width: 7rem;
            transform: translateX(-58%);
        }*/
            #img-div {
                margin-top: -14px;
                margin-bottom: 7px;
                margin-left: -7px;
            }

            .card-header {
                padding: 0
            }

            #wrapper {
                height: auto !important;
            }

            #dataTable_filter label {
                margin-top: 0.3rem;
                width: 50%;
            }
        }

        @media(max-width: 768px) and (min-width: 499px) {

            .card-header,
            #container-f {
                padding: 0 !important;
            }

            .row3 {
                margin-top: -3rem;
            }

            .pad-row {
                padding: 0 3.5rem !important;
            }

            #dataTable_length {
                right: 64%;
            }

            #resid:after,
            #resid2:before {
                width: 6rem;
            }

            #pad-row1 {
                margin-bottom: 0.7rem !important;
            }

            #pad-row2 {
                margin-top: -2rem
            }

            #desktop {
                width: 20%;
            }

            #img-div {
                margin-top: -10px;
                margin-bottom: 9px;
                margin-left: -7px;
            }

            .btn-group {
                top: 0;
                left: 0;
                margin-bottom: 1rem;
                margin-top: 1rem;
                position: inherit;
            }

            #wrapper {
                height: auto !important;
            }

            #dataTable_filter label {

                margin-top: 0.3rem !important;
                width: 55%;
            }

            .desc {
                width: 100% !important;
            }

            .group-button {
                position: inherit;
            }

            .card-body-one {
                margin-top: -2rem !important;
            }
        }



        @media(max-width: 500px) {

            .justify-content-start,
            .justify-content-end {
                justify-content: center !important;
            }

            .btn-group {
                position: inherit !important;
            }

            .card-header,
            .pad-row {
                padding: 0 !important;
            }

            #resid:after,
            #border img,
            #border2,
            #resid2:before,
            #border4 img,
            #border3,
            .none,
            #border4,
            #border {
                display: none;
            }

            #img-div {
                display: none;
            }

            #img-div img {
                width: 100% !important;
            }

            .row3,
            .card-body {
                margin-top: 0 !important;
            }

            #daymonthfilter,
            #rangefilter {
                right: 4px;
            }

            #daymonthvalue,
            #rangedate {
                /* border-right: 3px solid #e4aa47!important; */
            }

            #wrapper {
                height: auto !important;
            }

            #desktop {
                display: none;
            }

            #mobile {
                display: block;
                padding-left: 10px;
                text-align: left;
                color: #143e39;
                font-family: 'Lato-Bold';
                font-size: 13px;
            }

            #container-f {
                padding-right: 0 !important;
            }

            #dataTable_length {
                background: transparent;
                margin-top: 0;
            }

            #left-input {
                margin-bottom: 0 !important;
            }

        }

        .dt-buttons button {
            margin-right: 1px;
            background: #6d4e18;
            border: #6d4e18;
            font-family: 'Lato-Regular';
            font-size: 12px;
            color: #fff;
            width: 6rem;
            height: 2.5rem;
            /* border-radius: 9px!important; */
            box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
        }

        .btn-group {
            top: 59px;
            left: 10px;
        }

        th.headtable {
            background: orange !important;
        }

        span.sp {
            color: #3b2a0f;
            font-family: 'Lato-Regular';
            font-weight: 300;
            font-size: 12px;
        }

        #bottom-table {
            display: none;
        }

        @media(max-width: 1200px) {
            #bottom-table {
                display: block;
                width: 77rem;
            }

            td.bodytable {
                height: 3rem;
                background: #fff;
            }

            th.headtable {
                width: 10rem !important;
                text-align: center;
            }

            th.headtable span.sp {
                color: #3b2a0f;
                font-family: 'Lato-Regular';
                font-weight: 300;
                font-size: 12px;
            }

            #div1 {
                display: flex;
            }

            #div1 div {
                flex-basis: 100px;
                flex-wrap: wrap;
            }

            .scroll {
                overflow-x: scroll;
                margin-top: 3rem;
            }
        }

        .bottom-row .card {
            border-bottom: 1px solid #184d47;
            border-radius: 0;
            width: auto;
        }

        .bottom-row .card .card-header {
            font-family: 'Lato-Bold';
            font-size: 10px;
            color: #184d47;
            padding: 0.75rem 0.1rem !important;
        }

        .bottom-row .card .card-header .sp {
            padding: 0rem 4px !important;
            border-right: 1px solid #251a08;
            border-right: 1px solid #251a08;
            font-size: 11px;
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
            top: 1px;
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
        .loginPopupComment {
            text-align: center;
            width: 50%;
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

        .loginPopupComment .btn {
            background-color: tomato;
            color: white
        }
        .show_history{
            background-color: #049db3;
            color: white;
        }
    </style>

    <!--datatable-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!--datatable-->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.css"
        crossorigin="anonymous" />

    {{-- date range --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-10">
                <h3 class="top-title">Commented data</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid" style="margin-top:1.5rem">

                {{-- alert section --}}
                <div class="alert alert-danger" role="alert" id="alertdiv" hidden>
                </div>

                <div id="parent" class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;display:none">
                        Commented data
                        </h3>
                        {{-- <div class="row mt-5 mb-4 ">

                        </div> --}}
                        <div class="row mt-5 mb-4 ">
                            <div class="col-lg-4 col-md-6 col-12">
                                <label id="mobile" for="daymonthvalue" class="mt-2">Agent Name</label>
                                <div class="col-md-12 col-12">
                                    <label id="desktop" for="rangedate" class="desc mt-2">Stage</label>
                                </div>
                                <select id="stage" class="form-control select2 mt-2">
                                    <option value="">Stage</option>
                                    <option value="1">Imported Data</option>
                                    <option value="2">leads pool</option>
                                    <option value="3">qualified leads</option>
                                    <option value="4">follow up leads</option>
                                    <option value="5">proceed leads</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <label id="mobile" for="daymonthvalue" class="mt-2">Agent Name</label>
                                <div class="col-md-12 col-12">
                                    <label id="desktop" for="rangedate" class="desc mt-2">Agent Name</label>
                                </div>
                                <select id="agentname" class="form-control select2 mt-2">
                                    <option value="">Agent Name</option>
                                    @foreach ($agentnames as $agentname)
                                        <option value="{{ $agentname->id }}">{{ ucfirst($agentname->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-lg-4 col-md-6 col-12">
                                <label id="mobile" for="daymonthvalue" class="mt-2">User status</label>
                                <div class="col-md-12 col-12">
                                    <label id="desktop" for="rangedate" class="desc mt-2">User status</label>
                                </div>
                                <select id="userstatus" class="form-control mt-2">
                                    <option value="">All</option>
                                    <optgroup label="Dead">
                                        <option value="Others">Others</option>
                                        <option value="Invalid Number & Email">Invalid Number & Email</option>
                                        <option value="Wrong Number & Email">Wrong Number & Email</option>
                                        <option value="Number & Email Unavailable">Number & Email Unavailable</option>
                                        <option value="Not interested">Not interested</option>
                                    </optgroup>
                                    <optgroup label="Follow Up">
                                        <option value="Interested">Interested</option>
                                        <option value="Not Answered">Not Answered</option>
                                        <option value="Mobile Switched off">Mobile Switched off</option>
                                        <option value="Line Busy">Line Busy</option>
                                        <option value="Contacted Via Email">Contacted Via Email</option>
                                        <option value="Cancelation After Appointment">Cancelation After Appointment</option>
                                        <option value="Canceled">Canceled </option>
                                        <option value="Appointment is Faild">Appointment is Faild </option>
                                    </optgroup>
                                    <optgroup label="Won">
                                        <option value="Paid">Paid</option>
                                    </optgroup>
                                    <optgroup label="Qualified">
                                        <option value="Appointment is set">Appointment is set</option>
                                    </optgroup>
                                    <optgroup label="Proceeded">
                                        <option value="Appointment is Suceeded">Appointment is Suceeded</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        @if (Auth::user()->isadmin())
                            <div class="col-md-3 d-flex justify-content-start group-button">
                                <div id="tablebuttoncsv" class="mr-1 ml-3"></div>
                                <div id="tablebuttonexcel" class="mr-1"></div>
                                <div id="tablebuttonpdf" class="mr-1"></div>
                            </div>
                        @endif
                    </div>
                    <div class="alert  pb-3 mt-3" role="alert" id="alertdiv1" hidden></div>
                    <div class="card-body card-body-one mt-3">
                        <div id="loader" class="lds-dual-ring hidden overlay"></div>
                        {{-- variable to select date filter type by range or by specific date --}}
                        <input id="filtertype" name="filtertype" type="text" value="0" hidden>


                        {{-- //////////////////////////data tabe////////////////////////// --}}
                        <table class="table table-bordered table-hover" style="width: 200%" id="dataTable">
                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th><span class="table-title">Name</span></th>
                                    <th><span class="table-title">Commnets</span></th>
                                    <th><span class="table-title">User status</span></th>
                                    <th><span class="table-title">Mobile</span></th>
                                    <th><span class="table-title">Phone</span></th>
                                    <th><span class="table-title">Email</span></th>
                                    <th><span class="table-title">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                            <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                        </div>
                        {{-- //////////////////////////end data tabe////////////////////////// --}}
                        {{-- //////////////////////////Start Form Show Comment////////////////////////// --}}




                        {{-- //////////////////////////End Form Show Comment////////////////////////// --}}
                        <div class="loginPopupComment" id="allcomment">
                        <h4 style="text-align: left">All Comments</h4>
                        <hr>
                        <div style="height: 300px;overflow-y: auto;display:block; width:auto">
                            <table class="table table-bordered  table-striped" >
                                <thead>
                                    <tr>
                                        <th width="65%"><span class="table-title">Comments</span></th>
                                        <th width="35%"><span class="table-title">Date</span></th>
                                        <th width="35%"><span class="table-title">create At</span></th>
                                    </tr>
                                </thead>
                                <tbody id="tableallCommentbody">

                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn cancel btn-dange mt-3" onclick="closeallcomment()">Close</button>
                    </div>
                    <div class="loginPopupComment" id="showleadsinfo">
                        <h4 style="text-align: left">Leads Information</h4>
                        <hr>
                        <div style="height: 300px;overflow-y: auto;display:block; width:auto">
                            <table class="table table-bordered  table-striped" >
                                <thead>
                                    <tr>
                                        <th width="10%"><span class="table-title">Id</span></th>
                                        <th width="15%"><span class="table-title">Name</span></th>
                                        <th><span class="table-title">Phone</span></th>
                                        <th><span class="table-title">Email</span></th>
                                        <th><span class="table-title">Mobile</span></th>
                                        <th><span class="table-title">Project</span></th>
                                    </tr>
                                </thead>
                                <tbody id="tableshowleadsinfobody">

                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn cancel btn-dange mt-3" onclick="closeshowleadsinfot()">Close</button>
                    </div>


                        </div>
                    </div>
                </div>
                <div class="loginPopupComment" id="historycomment">
                    <h4 style="text-align: left">History Comments</h4>
                    <hr>
                    <div style="height: 300px;overflow-y: auto;display:block; width:auto">
                        <table class="table table-bordered  table-striped" >
                            <thead>
                                <tr>
                                    <th width="65%"><span class="table-title">Comments</span></th>
                                    <th width="35%"><span class="table-title">Userstatus</span></th>
                                </tr>
                            </thead>
                            <tbody id="tablehistorycommentbody">

                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn cancel btn-dange mt-3" onclick="closehistorycomment()">Close</button>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



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

        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
        </script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
        </script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.js"
            crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
        </script>

        {{-- swal alert --}}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!--  datetime range -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'center',
                    "showDropdowns": true,
                    "startDate": "01/01/2000",
                    "endDate": Date.now(),
                    "minYear": 2000,

                }, function(start, end, label) {
                    $('#startdate').val(start.format('YYYY-MM-DD'));
                    $('#enddate').val(end.format('YYYY-MM-DD'));
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                flatpickr('input[name="Paymentdate"]', {});
                $(document).on('click', '#times', function() {
                    $('.model').css('display', 'none');
                })

                //////////////////// customer status information
                // function getcommentsinfo() {
                //     $.ajax({
                //         url: "{{ route('get_admin_qualified_data_comments_info') }}",
                //         dataType: "json",
                //         type: "POST",
                //         data: {
                //             _token: "{{ csrf_token() }}",
                //             "userstatus": $('#userstatus').val(),
                //             "datasource": $('#datasource').val(),
                //             "agentname": $('#agentname').val(),
                //             "startdate": $('input[name="daterange"]').val().split('-')[0],
                //             "enddate": $('input[name="daterange"]').val().split('-')[1],
                //             'searchday': $('#daymonthvalue').val(),
                //             'filtertype': $('#filtertype').val()
                //         },
                //         success: function(result) {
                //             console.log(result);
                //             $("#appisfailed").text(result.appisfailed);
                //             $("#appissucceed").text(result.appissucceed);
                //             $("#total").text(result.total);
                //             $("#TotalAssigned").text(result.TotalAssigned);
                //         }
                //     })
                // }

                //////////////////// data table
                let table = $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    scrollY: 500,
                    scrollX: true,
                    scrollCollapse: true,
                    "pageLength": 100,
                    "deferRender": true,
                    "paging": true,
                    "pagingType": "full_numbers",
                    "ajax": {
                        "url": "{{ route('show_comments_admin') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function(d) {
                            return $.extend({}, d, {
                                _token: "{{ csrf_token() }}",
                                "agentname": $('#agentname').val(),
                                "userstatus": $('#userstatus').val(),
                                "stage": $('#stage').val(),
                            });
                        },
                        beforeSend: function() {
                            $("#parent").LoadingOverlay("show", {
                                background: "rgba(78, 115, 223, 0.5)"
                            });
                        },
                        complete: function() {
                            $("#parent").LoadingOverlay("hide", true);
                            // getcommentsinfo();
                        },
                        error: function(res) {
                            console.log(res);
                        },
                    },
                    "columns": [{
                            data: 'name',
                            name: 'name',
                            width: 200
                        },
                        {
                            data: 'comments',
                            name: 'comments',
                            width: 350
                        },
                        {
                            data: 'userstatus',
                            name: 'userstatus',
                            width: 250
                        },
                        {
                            data: 'mobile',
                            name: 'mobile',
                            width: 250,

                        },
                        {
                            data: 'phone',
                            name: 'phone',
                            width: 200
                        },
                        {
                            data: 'email',
                            name: 'email',
                            width: 200
                        },
                        {
                            data: "action",
                            width: 400
                        },
                    ],
                    "lengthMenu": [
                        [100, 500, 1000, 2000, 5000, 10000],
                        [100, 500, 1000, 2000, 5000, 10000]
                    ],
                    "language": {
                        searchPlaceholder: "Type and press Enter"
                    },
                    "dom": 'Blftip',
                    "buttons": [{
                            "extend": 'excel'
                        },
                        {
                            "extend": 'csv',
                        }
                    ],
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
                $("div.dataTables_filter input").keyup(function(e) {
                    if (e.keyCode == 13) {
                        table.search(this.value).draw();
                    }
                });
                //////////////////// agent name filter
                $('#agentname').change(function() {
                    $("#alertdiv").empty();
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        "userstatus": $('#userstatus').val(),
                        "agentname": $('#agentname').val(),
                        "stage": $('#stage').val(),
                    }, );
                    $('#dataTable').DataTable().draw();
                });
                 //////////////////// customer status filter
                 $('#userstatus').change(function() {
                    $("#alertdiv").empty();
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        "userstatus": $('#userstatus').val(),
                        "agentname": $('#agentname').val(),
                        "stage": $('#stage').val(),
                    }, );
                    $('#dataTable').DataTable().draw();
                });
                $('#stage').change(function() {
                    $("#alertdiv").empty();
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        "userstatus": $('#userstatus').val(),
                        "agentname": $('#agentname').val(),
                        "stage": $('#stage').val(),
                    }, );
                    $('#dataTable').DataTable().draw();
                });


                $('body').on('click', '.show_history', function() {
                    var id= table.row(this.closest('tr')).data()['data_id'];
                    document.getElementById("historycomment").style.display = "block";
                    var formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("data_id",id);
                    $.ajax({
                         method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        url: "{{ route('historycomment') }}",
                        success: function(data) {
                            $('#tablehistorycommentbody').empty();
                            $.each(data.data, function(key, value) {
                            $('#tablehistorycommentbody').append(
                                    '<tr>' +
                                    '<td>' + value.comment + '</td>' +
                                     '<td>' + value.userstatus + '</td>' +
                                    '</tr>');
                             });
                        },
                    });
                });
                // $('body').on('click', '.edit', function() {
                //     var qualified_id = table.row(this.closest('tr')).data()['id'];
                //     var user_id = table.row(this.closest('tr')).data()['user_id'];
                //     var commment = table.row(this.closest('tr')).data()['comment'];
                //     var user_status = table.row(this.closest('tr')).data()['userstatus'];
                //     var data_id = table.row(this.closest('tr')).data()['data_id'];
                //     $('.model').css('display', 'block');
                //     var appartment = table.row(this.closest('tr')).data()['appointment_date'];
                //     const $select = document.querySelector('#user-status');
                //     $select.value = user_status;
                //     $('input[name="Paymentdate"]').val(appartment);
                //     $('select[name="user-status"]').change();
                //     $('input[name="comment"] ').val(commment);
                //     $('input[name="data_id"] ').val(data_id);
                //     $('input[name="qualified_id"] ').val(qualified_id);
                //     $('#user-status').change(function(e) {
                //         e.preventDefault();
                //         if (this.value == "Set appointment") {
                //             openForm();
                //         } else
                //             closeForm();
                //     });
                // });
                // $('body').on('click', '.update', function(e) {
                //     var data_id = $('input[name="data_id"] ').val();
                //     var qualified_id = $('input[name="qualified_id"] ').val();
                //     var user_id = $('#agentname').val();

                //     var status = $('select[name="user-status"] ').val();
                //     var comm = $('input[name="comment"] ').val();
                //     var appartment = $('input[name="Paymentdate"]').val();
                //     e.preventDefault();
                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         }
                //     });
                //     $.ajax({
                //         type: "post",
                //         url: "{{ route('update_comment_quilify_data') }}",
                //         dataType: 'json',
                //         data: {
                //             // "_token":{{ csrf_token() }},
                //             "data_id": data_id,
                //             "qualified_id": qualified_id,
                //             "comment": comm,
                //             "status": status,
                //             'appartment': appartment,
                //             'user_id': user_id
                //         },
                //         beforeSend: function() {
                //             $('#loader').removeClass('hidden');
                //             $("#parent").addClass("disabledbutton");
                //         },
                //         complete: function() {
                //             $('#loader').addClass('hidden');
                //             $("#parent").removeClass("disabledbutton");
                //         },
                //         success: function(result) {
                //             console.log(result)
                //             if (result.status === true) {
                //                 $('#alertdiv1').empty();
                //                 $('#alertdiv1').append(
                //                     "<div class= 'alert alert-success'>" + result.message +
                //                     "</div>");
                //                 $('#alertdiv1').attr('hidden', false);
                //                 $('.model').css('display', 'none');
                //                 $('#errors').css('display', 'none');
                //                 $('#dataTable').DataTable().draw();
                //             } else if (result.status === "true1") {
                //                 $('#alertdiv1').empty();
                //                 $('#alertdiv1').append(
                //                     "<div class= 'alert alert-danger'>" + result.message +
                //                     "</div>");
                //                 $('#alertdiv1').attr('hidden', false);
                //                 $('.model').css('display', 'none');
                //                 $('#errors').css('display', 'none');
                //                 $('#dataTable').DataTable().draw();

                //             } else {
                //                 $('#alertdiv1').empty();
                //                 $.each(result.errors, function(key, value) {
                //                     $('#errors').css('display', 'block');
                //                     $('.alert-danger').empty();
                //                     $('.alert-danger').append('<p>' + value + '</p>');
                //                 });
                //             }
                //         },
                //     });
                // });
            });
            $('.select2').select2();
        </script>
        <script>
            function openForm(value) {
                document.getElementById("popupForm").style.display = "block";
                $('#popupForm').val(value);
            }

            function closeForm() {
                var index = $('#popupForm').val();
                document.getElementById("popupForm").style.display = "none";
            }
        </script>
        <script>
            function show_comments(stage,data_id){
                document.getElementById("allcomment").style.display = "block";
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("userid",$('#agentname').val());
                formData.append("stage", stage);
                // console.log(stage);
                formData.append("data_id", data_id);
                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    url: "{{ route('allcomments') }}",
                    success: function(data) {
                        $('#tableallCommentbody').empty();
                        $.each(data.data, function(key, value) {
                            var app_date='';
                            if(value.appoentment_date != null)
                                app_date = value.appoentment_date;
                            else
                                app_date='-';

                         $('#tableallCommentbody').append(
                                '<tr>' +
                                '<td>' + value.comment + '</td>' +
                                '<td>' + app_date + '</td>' +
                                '<td>' +  new Date(value.created_at).toLocaleString('en-GB')+ '</td>' +
                                '</tr>');
                        });
                    },
                });
            }
            function closeallcomment() {
                document.getElementById("allcomment").style.display = "none";
            }
            function closehistorycomment() {
                document.getElementById("historycomment").style.display = "none";
            }
        </script>
        <script>
            function ShowLead_Info(data_id){
                document.getElementById("showleadsinfo").style.display = "block";
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("userstatus", $('.showleadsinfo'+data_id).attr('id'));
                formData.append("data_id", data_id);
                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    url: "{{ route('showleadsinfo') }}",
                    success: function(data) {
                        $('#tableshowleadsinfobody').empty();
                            $('#tableshowleadsinfobody').append(
                                '<tr>' +
                                '<td>1</td>' +
                                '<td>' + data.data.name + '</td>' +
                                '<td>' + data.data.phone + '</td>' +
                                '<td>' + data.data.email + '</td>' +
                                '<td>' + data.data.mobile + '</td>' +
                                '<td>' + data.data.source + '</td>' +
                                '</tr>');
                    },
                });
            }
            function closeshowleadsinfot() {
                document.getElementById("showleadsinfo").style.display = "none";
            }
        </script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
        </script>
    @endpush
