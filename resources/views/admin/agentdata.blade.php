@extends('layouts.app')
@push('head')
    <title>Agent data</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>


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

        .top-title{
            font-family: 'Lato-Semibold';
            font-size:20px;
            color:#9D865C;
            height: 4rem;
            padding: 14px 35px;

            border-radius: 0 0px 55px 0;
            /* background-image: linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
        }
        nav ul li:last-child {
            border-bottom: 0!important;
        }
        .content-input{display: flex;align-items: center;}
        .label{
            width: auto;
            padding-right: 12px;}
        .dropdown{width: 55%;}
        .label h4{
            color:#241907;
            font-family: 'Lato-Semibold';
            font-size:17px;
        }
        .dropdown select{
            box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
            border-right: 2px solid #db9d33;
            color:#db9d33;
            font-family: 'Lato-Regular';
            font-size:15px;
        }
         #dataTable_filter label::after{
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
         #dataTable_filter label::before{
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
         #dataTable_filter input{
               padding: 0 36px;
               width: 20rem!important;
               outline: none!important;
               box-shadow:inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
               border-radius: 0!important;
               border: 1px solid #d8d5cd;
               height: 2.1rem;
        }
        label{
            font-family: 'Lato-Regular';
        }
         .dt-buttons button{
            margin-right: 13px;
            background: #6d4e18;
            border: #6d4e18;
            font-family: 'Lato-Regular';
            font-size:15px;
            color:#fff;
            width: 6rem;
            border-radius: 9px!important;
            box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
         }
         #dataTable_length select{
            box-shadow: inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
            border-radius: 0!important;
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

        th{

            /* background: #6d4e18; */

            /* width: 25px!important; */
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
        #dataTable_length,#dataTable_filter,.dataTables_scroll{
            background:#fff;
        }
        #dataTable_length{
            position: absolute;
            right: 50%;
            margin-top: 2rem;
            /* border: 1px solid #e5d5d5;
            border-bottom: none;
            border-radius: 8px 8px 0 0; */
        }
        #dataTable_filter{
            border-top: 1px solid #e5d5d5;
            border-left: 1px solid #e5d5d5;
            border-right: 1px solid #e5d5d5;
            border-radius: 8px 8px 0 0;
            padding: 1rem;
            height: 5rem;
        }
        #dataTable_filter label{
            margin-top: 0.5rem;
        }
        .dataTables_scroll{
            border-left: 1px solid #e5d5d5;
            border-right: 1px solid #e5d5d5;
            border-bottom: 1px solid #e5d5d5;
            border-radius: 0px 0px 8px 8px;
        }
        .group-button{
            position:relative;
            margin-top: 1.5rem;
            top: 0px;
            left: 18px;
        }
        .first a{
         /* background:url(/img/left-remax.jpg) no-repeat; */
         background-position: center;
         background-size: cover;
         width:5rem;
         text-align: left;
         color:#fff!important;
         font-size: 13px!important;
         font-family: 'Lato-Regular'!important;

        }
        .last a{
         /* background:url(/img/right-remax.jpg) no-repeat; */
         background-position: center;
         background-size: cover;
         width:5rem;
         text-align: right;
         color:#fff!important;
         font-size: 13px!important;
         font-family: 'Lato-Regular'!important;
        }
        #bookslist_info{
            color:#000!important;
         font-size: 13px!important;
         font-family: 'Lato-Regular'!important;
         position: absolute;
         margin-top: 1rem;
        }
        #bookslist_paginate{
            margin-top: 2rem;
        }
        .pagination li a
        {
            box-shadow: inset 0px 2px 0px 0px rgb(115 115 115 / 75%);
        }
        .odd td{
            background:#e9eaeeb5;
        }

        select::-ms-expand {
display: none;
}
.custom-select{
    /* background: url('img/select.jpg'); */
    background-size: contain;
    background-repeat: no-repeat;
    background-position: right;
}
@media(max-width:768px){
    .top-title {
    font-size: 15px;
    color: #9D865C;
    height: 3rem;
    padding: 11px 30px;

    }

    #tablebuttonexcel button, #tablebuttoncsv button
    {
        font-size: 10px;
    color: #fff;
    width: 4rem;
    padding: 2px;
    }
    #dataTable_filter input{
        width: 14rem!important;
    }
    #dataTable_filter label::before{
        top: 0;
    right: 192px;
    }
    #dataTable_filter label::after {
   width: 61px;
    top: 10px;
    right: 48px;
    }
    .label h4{
        font-size: 13px;
    }
}
@media(max-width:500px){
    .content-input{
        margin-bottom: 10px;
    }
    .label {
       width: 8rem;
    }
    .group-button {
    position: initial;
    justify-content: center!important;
    }
    #dataTable_length {
    position: inherit;
    }
    #dataTable_filter input{
        width: 13rem!important;
    }
    #dataTable_filter label::after{
        top: 281px!important;
        right: 30px!important;
    }
    #dataTable_filter label::before{
        top: 283px;
        right: 179px;
    }
    #bookslist_info{
        position: inherit;
    }
    #wrapper{
        background-size: cover!important;

    }
    .top-title{

    }
    /*sidebar mobile */
    .sidebar .sidebar-brand {
    height: auto;
    }
    .sidebar-brand-icon{
        display: grid;
    }
    .user-name {
    width: 100%;
    }
    nav ul li {
    line-height: 7px!important;
    }
    #sbitem1 .link-content, #sbitem2 .link-content, #sbitem3 .link-content, #sbitem4 .link-content, #sbitem5 .link-content, #sbitem6 .link-content
    {
        height: 4rem;
    padding: 9px 6px;
    }
    .left-title {
    width: 90%;
    font-size: 12px;
    line-height: 1;
    }
    .icon-title{
        font-size: 10px!important;
    }
    #sbitem1_1,#sbitem1_2,#sbitem1_3,#sbitem1_4,#sbitem1_5,#sbitem1_6,#sbitem1_7,#sbitem1_8,#sbitem1_9{
        line-height: 17px!important;
        margin-bottom: 10px;
    }
    #sbitem1_1 a,#sbitem1_2 a,#sbitem1_3 a,#sbitem1_4 a,#sbitem1_5 a,#sbitem1_6 a,#sbitem1_7 a,#sbitem1_8 a,#sbitem1_9 a
        {
            padding-left: 15px!important;
            font-size: 12px!important;
        }
    #sbitem2_1,#sbitem2_2,#sbitem2_3,#sbitem2_4,#sbitem2_5,#sbitem2_6,#sbitem2_7,#sbitem2_8,#sbitem2_9,#sbitem2_10,#sbitem2_11{
        line-height: 17px!important;
        margin-bottom: 10px!important;
    }
    #sbitem2_1 a,#sbitem2_2 a,#sbitem2_3 a,#sbitem2_4 a,#sbitem2_5 a,#sbitem2_6 a,#sbitem2_7 a,#sbitem2_8 a,#sbitem2_9 a,#sbitem2_10 a,#sbitem2_11 a

        {
            padding-left: 15px!important;
            font-size: 12px!important;
        }
}


 #bg-top{
   width: 157%;
    margin-left: -5rem;
    margin-top: -9rem;
}
#sel1:focus-visible,#daymonthvalue:focus-visible,#rangedate:focus-visible,#datasource:focus-visible{
    outline: none;
}
#sel1,#datasource{
    font-family: 'Lato-Regular'!important;
    font-size: 12px!important;
    display: inline-block;
    /*width: 100%;*/
    height: calc(2.25rem + 2px);
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    line-height: 1.5;
    color: #878b8f;
    vertical-align: middle;
    border-radius: 0!important;
    background: #fff!important;
    /* border: 1px solid #fff!important; */
    text-align: left;
    /* border-right: 3px solid #e4aa47!important; */
    box-shadow: 0 4px 2px -2px #d9d1d1;

}
#daymonthvalue,#rangedate{
    box-shadow: 0 4px 2px -2px #d9d1d1;
    color: #878b8f;
    vertical-align: middle;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-size: 12px;
        font-family: 'Lato-Regular'!important;
}
#daymonthfilter,#rangefilter{
        margin-left: -5px;
   box-shadow: 0 4px 2px -2px #d9d1d1;
       background: #fff;
    height: calc(2.25rem + 2px);
       position: absolute;
    right: 0;
    z-index: 1000;
    width: 3rem;

}
#border{
        margin-right: -8px;
    margin-left: -5px;
    box-shadow: 0 4px 2px -2px #d9d1d1;
    height: calc(2.25rem + 2px);
    /* padding: 0.475rem 5px 0.775rem 5px; */
    width: 54px;
}
#border img{
        width: 138%;
    margin-right: -25px;
    height: 100%;
    transform: scaleX(1);
}
#border2{
    margin-right: -8px;
    margin-left: -5px;
    box-shadow: 0 4px 2px -2px #d9d1d1;
    height: calc(2.25rem + 2px);
    /* padding: 0.475rem 5px 0.775rem 5px; */
    width: 46px;
}
#border2 img{
    width: 135%;
    margin-right: -21px;
    height: 100%;
        transform: scaleY(-1);
}
#border3{
       margin-right: -39px;
    margin-left: -12px;
    box-shadow: 0 4px 2px -2px #d9d1d1;
    height: calc(2.25rem + 1px);
    /* padding: 0.475rem 5px 0.775rem 5px; */
    width: 46px;
}
#border3 img{
       width: 89%;
    /* margin-right: -21px; */
    height: 103%;
    transform: scaleX(-2);
}
#border4{
 margin-right: -33px;
    margin-left: -20px;
    box-shadow: 0 4px 2px -2px #d9d1d1;
    height: calc(2.25rem + 2px);
    /* padding: 0.475rem 5px 0.775rem 5px; */
    width: 46px;
}
#border4 img{
        width: 89%;
    /* margin-right: -21px; */
    height: 100%;
    transform: scaleX(1.3);
}
#datetimepicker2 label{
    width:23%;
    text-align: left;
    color: #143e39;
    font-family: 'Lato-Bold';
    font-size: 13px;
}
.card-header{
        padding: 0 10rem;
}
.pad-row{
    padding: 0 4.4rem 0 5rem;
}
.row3{
    margin-top: -4rem;
}
#img-div{
   margin-top: -15px;
    margin-bottom: 7px;
    margin-left: -7px;
}
#resid:after{
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
    transform: translateX(-55%);
    box-shadow:-1px -3px 3px -2px #d9d1d1;
    /* border-top: 1px solid #d9d1d1;*/
}
#resid2:before{
    content: '';
    position: absolute;
    bottom: 22px;
    border-radius: 100%;
    /* border: 48px solid transparent; */
    border-bottom: 35px solid #f7f8f8;
    display: block;
    width: 7rem;
    height: 0px;
    left: 50%;
    transform: translateX(-55%);
    box-shadow:-1px 3px 2px -2px #d9d1d1;
    /* border-top: 1px solid #d9d1d1;*/
}
#dataTable_length, #dataTable_filter, .dataTables_scroll{
    background: #fff;
}
 .card-body{
          margin-top: -5rem!important;
        }
        #wrapper{
            height: auto!important;
        }



        div.dataTables_scrollBody::-webkit-scrollbar {
  width: 5px;
}
div.dataTables_scrollBody::-webkit-scrollbar {
  width: 3px!important;

}

/* Track */
div.dataTables_scrollBody::-webkit-scrollbar-track {
  background: #c5c5c5!important;
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

.flex-wrap{
    top: 59px;
    left: 18px;
}
/*start*/
.page-item.active .page-link {
    z-index: 3;
    /* color: #6d4e18!important; */
    font-family: 'Lato-Semibold'!important;
    background-color: #ffffff!important;
    /* border-color: #ffffff; */
    top: 0px!important;
    /* border: none!important; */
    /* border-bottom: 2px solid #6d4e18!important; */
}
.page-link:focus{
    box-shadow: inset 0px 2px 0px 0px rgb(115 115 115 / 75%)!important;
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
    background-color: #e9edec87!important;
    /*border-color: #e5e5e5;*/
    color: #114c45!important;
}
.page-link:hover {
    z-index: 2;
    color: #9D865C;
    text-decoration: none;
    background-color: #e9edec87!important;
    /* border-color: #e5e5e5; */
    color: #bec7c6!important;
}
/*end*/
#mobile{
    display: none;
}
/*responsive*/
@media(max-width: 1300px) and (min-width: 1201px){
    .card-header {
    padding: 0 8rem;
}
}
@media(max-width: 1200px) and (min-width: 1025px){
    .card-header {
    padding: 0 5rem;
}
}
@media(max-width: 1024px) and (min-width: 800px){
    .pad-row {
    padding: 0 4.8rem 0 5rem;
}
#datetimepicker2 label{
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
    height: auto!important;
}
#dataTable_filter label {
    margin-top: 0.3rem;
    width: 50%;
}
}

@media(max-width: 768px) and (min-width: 499px){
    .btn-group, .btn-group-vertical{
        position: inherit;
    display: block;
    }
    .flex-wrap{
        top: 0px;
     left: 0px;
    margin-bottom: 1rem;

    margin-top: 3rem;
    }
    #dataTable_length{
        right: 64%;
    }
.card-header,#container-f{
    padding:0!important;
}
.row3{
        margin-top: -3rem;
}
.pad-row{
    padding: 0 3.6rem!important;
    margin-bottom:0.5rem!important;
}
#datetimepicker2{
    align-items: center;
}
#resid:after,#resid2:before{
    width: 6rem;
}
#pad-row1{
    margin-bottom: 0.7rem!important;
}
#pad-row2{
    margin-top: -0.5rem
}
#img-div {
    margin-top: -6px;
    margin-bottom: -5px;
    margin-left: -7px;
}
#wrapper {
    height: auto!important;
}
#dataTable_filter label{

    margin-top: 0.3rem!important;

}
#datetimepicker2{
    margin-bottom: 0!important;
}
.top-mar{
    margin-top: 0.7rem;
}
}



@media(max-width: 500px){
    .card-header ,.pad-row{
    padding: 0!important;
}
#resid:after,#border img,#border2,#resid2:before,#border4 img,#border3,.none,#border4,#border{
    display: none;
}
#img-div {
     display: none;
    }
    #img-div img{
        width: 100%!important;
    }
    .row3,.card-body{
        margin-top: 0!important;
    }
    #daymonthfilter, #rangefilter{
        right: 4px;
    }
    #daymonthvalue, #rangedate{
            /* border-right: 3px solid #e4aa47!important; */
    }
    #wrapper {
    height: auto!important;
}
#wrapper #content-wrapper {
    width: 100%;
    overflow-x: inherit;
    }
    .btn-group{
            display: block!important;
    }
    .flex-wrap {
    top: 0;
    left: 0;
}
#desktop{
    display: none;
}
#mobile{
    display: block;
    padding-left: 10px;
    text-align: left;
    color: #143e39;
    font-family: 'Lato-Bold';
    font-size: 13px;
}
#container-f{
    padding-right: 0!important;
}
#dataTable_length{
    background: transparent;
    margin-top: 0;
}
#left-input{
    margin-bottom: 0!important;
}
div.dataTables_wrapper div.dataTables_filter label{
        white-space: inherit!important;
}
#dataTable_filter label::before{
    top: 29px!important;
    left: 16px!important;
}
#dataTable_filter label::after{
      top: -29px!important;
    left: 151px!important;
}

}
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
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-7" >
            <h3 class="top-title">Show Agent Data</h3>
        </div>
    </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column" >

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid" style="margin-top:1.5rem">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"></h1>



                <!-- DataTales Example -->
                <div id="parent" class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;display:none">
                            Show agent data
                        </h3>

                        <div class="alert alert-danger pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                        <input id="filtertype" name="filtertype" type="text" value="0" hidden>


                        <!-- <div class="row mt-5 mb-4 ml-5">

                            <div class="col-md-3">
                                <input class="form-control" type="text" id="daymonthvalue" placeholder="DD-MM"
                                    maxlength="5">
                            </div>
                            <div class="col-md-2">
                                <input type="button" value="filter" class="btn btn-sm btn-outline-primary ml-2 mt-2"
                                    style="font-size:.7rem;font-weight:bold" id="daymonthfilter">
                            </div>-->

                            <!-- choose range date -->
                            <!-- <div class="col-md-4">
                                <div class="input-group date mb-3" id="datetimepicker2">
                                    <label for="rangedate" class="mt-2">Range date</label>
                                    <input id="rangedate" type="text" name="daterange"
                                        class="form-control datetimepicker-input ml-3" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input type="button" value="filter range" class="btn btn-sm btn-outline-primary ml-2 mt-2"
                                    style="font-size:.7rem;font-weight:bold" id="rangefilter">
                            </div>
                        </div>  -->

                        <!-- <input value="" type="text" name="search" id="filter" hidden /> -->
                        <!-- <div class="row mt-5 ml-5 mr-5 mb-5">
                            <div class="col-md-3">
                                <select name="area" class="form-control filter" id="sel1"
                                    style="font-size:.7rem;font-weight:bold">
                                    <option selected value="Show">Area</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->AREA }}">{{ $area->AREA }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="emirate" class="form-control filter1" id="sel1"
                                    style="font-size:.7rem;font-weight:bold">
                                    <option selected value="Show">Emirates</option>
                                    @foreach ($emirates as $emirate)
                                        <option value="{{ $emirate->EMIRATE }}">{{ $emirate->EMIRATE }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">

                                <select name="residence" class="form-control filter2" id="sel1"
                                    style="font-size:.7rem;font-weight:bold">
                                    <option selected value="Show">Residence Country</option>
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->RESIDENCE_COUNTRY }}">
                                            {{ $residence->RESIDENCE_COUNTRY }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="datasource" class="form-control filter4" id="datasource"
                                    style="font-size:.7rem;font-weight:bold">
                                    <option selected value="Show">Data source</option>
                                    @foreach ($datasource as $data)
                                        <option value="{{ $data->source }}">
                                            {{ $data->source }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->

                        <div class="row pad-row mb-3">
                            <div id="resid" class="col-md-12">
                                <select name="residence" class="form-control filter2" id="sel1"
                                    style="">
                                    <option selected value="Show">Residence Country</option>
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->RESIDENCE_COUNTRY }}">
                                            {{ $residence->RESIDENCE_COUNTRY }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-5">
                                {{--<label id="mobile" for="daymonthvalue" class="mt-2">Date</label>
                                <div class="input-group date mb-3" id="datetimepicker2">
                                <label id="desktop" for="daymonthvalue" class="mt-2">Date</label>
                                <input class="form-control ml-1" type="text" id="daymonthvalue" placeholder="DD-MM"
                                    maxlength="5">
                                    <span type="button" class="btn btn-sm btn-outline-primary  "
                                    style="" id="daymonthfilter"><img src="img/filter-remax.png" style="width: 100%"></span>
                                    <span id="border" >
                                        <img src="img/border.png" style="">
                                    </span>
                                </div>--}}
                            </div>
                            <div class="col-md-2" style="    z-index: 1000;">
                                <div id="img-div">
                                    <img src="img/circle-remax.png" style="width: 105%">
                                </div>
                            </div>
                          <!--   <div class="col-md-3">
                                <input class="form-control" type="text" id="daymonthvalue" placeholder="DD-MM"
                                    maxlength="5">
                            </div>
                            <div class="col-md-2">
                                <input type="button" value="filter" class="btn btn-sm btn-outline-primary ml-2 mt-2"
                                    style="font-size:.7rem;font-weight:bold" id="daymonthfilter">
                            </div> -->
                            <div class="col-md-4">
                                <div class="input-group date mb-3" id="datetimepicker2">
                                <span id="border3" >
                                        <img src="img/border.png" style="">
                                    </span>
                                <select name="area" class="form-control filter" id="sel1"
                                    style="">
                                    <option selected value="Show">Area</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->AREA }}">{{ $area->AREA }}</option>
                                    @endforeach
                                </select>
                               </div>
                            </div>
                        </div>
                        <input value="" type="text" name="search" id="filter" hidden />
                        <div class="row row3">

                            <!-- choose range date -->
                            <div class="col-md-5">
                                <label id="mobile" for="rangedate" class="mt-2">Range date</label>
                                <div class="input-group date mb-3" id="datetimepicker2">
                                    <label id="desktop" for="rangedate" class="mt-2">Range date</label>
                                    <input id="rangedate" type="text" name="daterange"
                                        class="form-control datetimepicker-input ml-1" />
                                        <span type="button" value="filter range" class="btn btn-sm btn-outline-primary "
                                    style="" id="rangefilter">
                                        <img src="img/filter-remax.png" style="width: 100%">
                                    </span>
                                    <span id="border2" >
                                        <img src="img/border.png" style="">
                                    </span>

                                </div>
                            </div>



                            <!--end range date-->
                            <div class="col-md-2"></div>
                            <div class="col-md-4 top-mar">
                                <div class="input-group date mb-3" id="datetimepicker2">
                                <span id="border4" >
                                        <img src="img/border4.png" style="">
                                    </span>
                                <select name="emirate" class="form-control filter1" id="sel1"
                                    style="">
                                    <option selected value="Show">Emirates</option>
                                    @foreach ($emirates as $emirate)
                                        <option value="{{ $emirate->EMIRATE }}">{{ $emirate->EMIRATE }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                            <div class="row pad-row">
                                <div id="resid2" class="col-md-12 ">
                                   <select name="datasource" class="form-control filter4" id="datasource"
                                    style="">
                                        <option selected value="Show">Data source</option>
                                        @foreach ($datasource as $data)
                                        <option value="{{ $data->source }}">
                                            {{ $data->source }}</option>
                                         @endforeach
                                    </select>
                                 </div>
                            </div>
                    </div>


                    <div class="row mt-4">
                        @if (Auth::user()->isadmin())
                            <div class="col-md-3 d-flex justify-content-start">
                                <div id="tablebuttoncsv" class="mr-1 ml-3"></div>
                                <div id="tablebuttonexcel" class="mr-1"></div>
                                <div id="tablebuttonpdf" class="mr-1"></div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body mt-3">
                        <div id="loader" class="lds-dual-ring hidden overlay"></div>

                        <table class="table table-bordered table-hover" style="width: 600%" id="dataTable">
                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th><span class="table-title">
                                        Unique&nbsp&nbsp<div style="display: inline-block;" data-toggle="tooltip"
                                                data-placement="right" title="Project unit"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                </svg></div>

                                      </span>
                                    </th>
                                    <th><span class="table-title">Name</span></th>
                                    <th><span class="table-title">Phone</span></th>
                                    <th><span class="table-title">whatsup phone</span></th>
                                    <th><span class="table-title">Mobile</span></th>
                                    <th><span class="table-title">whatsup mobile</span></th>
                                    <th><span class="table-title">Secondary mobile</span></th>
                                    <th><span class="table-title">whatsup secondary mobile</span></th>
                                    <th><span class="table-title">Email</span></th>
                                    <th><span class="table-title">
                                        <div class="row">P-number&nbsp&nbsp<div data-toggle="tooltip"
                                                data-placement="right" title="Plot Number"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                </svg></div>
                                        </div></span>
                                    </th>
                                    <th><span class="table-title">Area</span></th>
                                    <th><span class="table-title">Usage</span></th>
                                    <th><span class="table-title">Total area</span></th>
                                    <th><span class="table-title">Plot number</span></th>
                                    <th><span class="table-title">Emirate</span></th>
                                    <th><span class="table-title">Area owned</span></th>
                                    <th><span class="table-title">Address</span></th>
                                    <th><span class="table-title">Fax</span></th>
                                    <th><span class="table-title">Po box</span></th>
                                    <th><span class="table-title">Gender</span></th>
                                    <th><span class="table-title">
                                        <div class="row">DOB&nbsp&nbsp<div data-toggle="tooltip"
                                                data-placement="right" title="Date of birthday"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                </svg></div>
                                        </div></span>
                                    </th>
                                    <th><span class="table-title">Passport</span></th>
                                    <th><span class="table-title">Issue date</span></th>
                                    <th><span class="table-title">Expiry date</span></th>
                                    <th><span class="table-title">Place of issue</span></th>
                                    <th><span class="table-title">Emirates id number</span></th>
                                    <th><span class="table-title">Emirates id expiry date</span></th>
                                    <th><span class="table-title">Residence country</span></th>
                                    <th><span class="table-title">Nationality</span></th>
                                    <th><span class="table-title">Master project</span></th>
                                    <th><span class="table-title">Project</span></th>
                                    <th><span class="table-title">Building name</span></th>
                                    <th><span class="table-title">Agents</span></th>
                                    <th><span class="table-title">Flat number</span></th>
                                    <th><span class="table-title">No of beds</span></th>
                                    <th><span class="table-title">Floor</span></th>
                                    <th><span class="table-title">Registration number</span></th>
                                    <th><span class="table-title">Lat</span></th>
                                    <th><span class="table-title">Lang</span></th>
                                    <th><span class="table-title">Source</span></th>

                                </tr>
                            </thead>
                            <tbody>
                                <input id="startdate" type="text" hidden>
                                <input id="enddate" type="text" hidden>
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
    <!-- End of Content Wrapper -->
@endsection

@section('content')
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
@endsection

@push('scripts')
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
                    "url": "{{ route('allposts2') }}",
                    "dataType": "json",

                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            "emirates": $('.filter1').val(),
                            "area": $('.filter').val(),
                            "residence": $('.filter2').val(),
                            "datasource": $('#datasource').val(),
                            "startdate": $('#startdate').val(),
                            "enddate": $('#enddate').val(),
                            'searchday': $('#daymonthvalue').val(),
                            'filtertype': $('#filtertype').val()
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
                        data: "unique",
                        width: '100px'
                    },
                    {
                        data: "NAME",
                        width: '300px'
                    },
                    {
                        data: "PHONE",
                        width: '100px'
                    },
                    {
                        "data": "phone_whatsup",
                        "render": function(data, type, row, meta) {
                            if (data != '-' && data != '') {
                                return data = '<a href="' + data + '" target="_blank">' + data +
                                    '</a>';
                            } else
                                return data;
                        }
                    },
                    {
                        data: "MOBILE",
                        width: '100px'
                    },
                    {
                        "data": "MOBILE_whatsup",
                        "render": function(data, type, row, meta) {
                            if (data != '-' && data != '') {
                                return data = '<a href="' + data + '" target="_blank">' + data +
                                    '</a>';
                            } else
                                return data;
                        }
                    },
                    {
                        data: "SECONDARY_MOBILE",
                        width: '150px'
                    },
                    {
                        "data": "SECONDARY_MOBILE_wahtsup",
                        "render": function(data, type, row, meta) {
                            if (data != '-' && data != '') {
                                return data = '<a href="' + data + '" target="_blank">' + data +
                                    '</a>';
                            } else
                                return data;
                        }
                    },
                    {
                        data: "EMAIL",
                        width: '100px'
                    },
                    {
                        data: "P_NUMBER",
                        width: '100px'
                    },
                    {
                        data: "AREA",
                        width: '100px'
                    },
                    {
                        data: "USAGE",
                        width: '100px'
                    },
                    {
                        data: "TOTAL_AREA",
                        width: '100px'
                    },
                    {
                        data: "PLOT_NUMBER",
                        width: '100px'
                    }, {
                        data: "EMIRATE",
                        width: '100px'
                    },
                    {
                        data: "AREA_OWNED",
                        width: '100px'
                    }, {
                        data: "ADDRESS",
                        width: '300px'
                    },
                    {
                        data: "FAX",
                        width: '100px'
                    }, {
                        data: "PO_BOX",
                        width: '100px'
                    }, {
                        data: "GENDER",
                        width: '50px'
                    }, {
                        data: "DOB",
                        width: '100px'
                    },
                    {
                        data: "PASSPORT",
                        width: '100px'
                    }, {
                        data: "ISSUE_DATE",
                        width: '100px'
                    }, {
                        data: "EXPIRY_DATE",
                        width: '100px'
                    }, {
                        data: "PLACE_OF_ISSUE",
                        width: '150px'
                    }, {
                        data: "EMIRATES_ID_NUMBER",
                        width: '140px'
                    }, {
                        data: "EMIRATES_ID_EXPIRY_DATE",
                        width: '200px'
                    },
                    {
                        data: "RESIDENCE_COUNTRY",
                        width: '150px'
                    }, {
                        data: "NATIONALITY",
                        width: '100px'
                    }, {
                        data: "Master_Project",
                        width: '100px'
                    }, {
                        data: "Project",
                        width: '100px'
                    }, {
                        data: "Building_Name",
                        width: '100px'
                    }, {
                        data: "Agents",
                        width: '100px'
                    }, {
                        data: "Flat_Number",
                        width: '100px'
                    },
                    {
                        data: "No_of_Beds",
                        width: '100px'
                    }, {
                        data: "Floor",
                        width: '100px'
                    }, {
                        data: "registration_number",
                        width: '200px'
                    }, {
                        data: "lat",
                        width: '100px'
                    }, {
                        data: "lng",
                        width: '100px'
                    }, {
                        data: "source",
                        width: '150px'
                    }
                ],
                "lengthMenu": [
                    [100, 500, 1000, 2000, 5000, 10000],
                    [100, 500, 1000, 2000, 5000, 10000]
                ],
                "language":{
                    searchPlaceholder:"Type and press Enter"
                },
                "dom": 'Blftip',
                "buttons": [{
                        "extend": 'excel',
                        "action": newexportaction,
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        "extend": 'csv',
                        "action": newexportaction,
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    }
                ]
            });
            $("div.dataTables_filter input").unbind();
            $("div.dataTables_filter input").keyup(function(
                e) {
                console.log(e.keyCode);
                if (e.keyCode == 13) {
                    table.search(this.value).draw();
                }
            });

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

            $(".filter1,.filter,.filter2, .filter4").change(function(e) {
                $('#alertdiv').attr('hidden', true);
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "emirates": $('.filter1').val(),
                    "area": $('.filter').val(),
                    "residence": $('.filter2').val(),
                    "datasource": $('#datasource').val(),
                    "startdate": $('#startdate').val(),
                    "enddate": $('#enddate').val(),
                    'searchday': $('#daymonthvalue').val(),
                    'filtertype': $('#filtertype').val()
                }, );
                $('#dataTable').DataTable().draw();
            });

            var searchval = "";
            $('#daymonthvalue').keyup(function(e) {
                if (e.keyCode == 13) {
                    $('#daymonthfilter').click();
                }
                $('#alertdiv').attr('hidden', true);
                $text = $(this);

                if ($text.val().length == 1 && parseInt($text.val()) > 3) {
                    $('#alertdiv').attr('hidden', false);
                    $('#alertdiv').text("maximum day value is 31");
                    $text.val(searchval);
                }

                if ($text.val().length == 2) {
                    if (parseInt($text.val()) > 31) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("maximum day value is 31");
                        $text.val(searchval);
                    }
                }
                if ($text.val().length == 3) {
                    if ((e.keyCode != 109 && e.keyCode != 189) && e.keyCode != 8) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("you should enter -");
                        $text.val(searchval);
                    }
                } else if ($text.val().length == 4) {
                    if (parseInt($text.val().substring(3, 4)) > 1) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("maximum month value is 12");
                        $text.val(searchval);
                    }
                } else if ($text.val().length == 5) {
                    if (parseInt($text.val().substring(3, 5)) > 12) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("maximum month value is 12");
                        $text.val(searchval);
                    }
                } else if (e.keyCode != 8) {
                    if (e.keyCode < 48 || (e.keyCode > 57 && e.keyCode < 96) || e.keyCode > 105) {
                        $('#alertdiv').attr('hidden', false);
                        $('#alertdiv').text("you should enter just numbers");
                        $text.val(searchval);
                    }
                }
                searchval = $text.val();
            });

            $('#daymonthfilter').click(function(e) {
                $('#filtertype').val('1');
                $('#alertdiv').attr('hidden', true);
                if ($('#daymonthvalue').val().length < 5) {
                    e.preventDefault();
                    $('#alertdiv').attr('hidden', false);
                    $('#alertdiv').text("you should enter day");
                } else {
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        "emirates": $('.filter1').val(),
                        "area": $('.filter').val(),
                        "residence": $('.filter2').val(),
                        "datasource": $('#datasource').val(),
                        "startdate": $('#startdate').val(),
                        "enddate": $('#enddate').val(),
                        'searchday': $('#daymonthvalue').val(),
                        'filtertype': $('#filtertype').val()
                    }, );
                    $('#dataTable').DataTable().draw();
                }
            });

            $('#startdate').val($('input[name="daterange"]').val().split('-')[0]);
            $('#enddate').val($('input[name="daterange"]').val().split('-')[1]);

            $('#rangefilter').click(function(e) {
                $('#filtertype').val('2');
                $('#alertdiv').attr('hidden', true);
                if ($('#startdate').val() == '' || $('#enddate').val() == '') {
                    e.preventDefault();
                    $('#alertdiv').attr('hidden', false);
                    $('#alertdiv').text("you should select start and end dates");
                } else {
                    $('#dataTable').data("dt_params", {
                        _token: "{{ csrf_token() }}",
                        "emirates": $('.filter1').val(),
                        "area": $('.filter').val(),
                        "residence": $('.filter2').val(),
                        "datasource": $('#datasource').val(),
                        "startdate": $('#startdate').val(),
                        "enddate": $('#enddate').val(),
                        'searchday': $('#daymonthvalue').val(),
                        'filtertype': $('#filtertype').val()
                    }, );
                    $('#dataTable').DataTable().draw();
                }
            });

            $('#dataTable').on('search.dt', function() {
                var value = $('.dataTables_filter input').val();
                var s = $('#filter:text').val(value);
                $('#alertdiv').attr('hidden', true);
            });
        });
    </script>

    <!-- jQuery library -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script>
        $(document).ready(function() {

            $('div#emirates').show();
            $('div#usage').hide();
            $('div#nationality').hide();

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>
@endpush
