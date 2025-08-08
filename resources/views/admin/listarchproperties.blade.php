@extends('layouts.app')
@push('head')

    <title>List Archived Properties</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="{{ asset('select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

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
            /* background-image:linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
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
         #tablebuttoncsv button,#tablebuttonexcel button{
            margin-right: 13px;
            background: #6d4e18;
            border: #6d4e18;
            font-family: 'Lato-Regular';
            font-size:12px;
            color:#fff;
            width: 6rem;
            height: 2.5rem;
            border-radius: 9px!important;
            box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
         }
         .buttons-select-all{
            background: #434a49!important;
            border: #434a49!important;
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
        #dataTable_length,#dataTable_filter,#.dataTables{
            background:#fff;
        }
        #dataTable_length{
            position: absolute;
            right: 45%;
            margin-top: 30px;
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
         /* background:url(img/left.jpg) no-repeat; */
         background-position: center;
         background-size: cover;
         width:5rem;
         text-align: left;
         color:#fff!important;
         font-size: 13px!important;
         font-family: 'Lato-Regular'!important;

        }
        .last a{
         /* background:url(img/right.jpg) no-repeat; */
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
            background:#e9eaee00;
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
        top: 126px;
    right: 192px;
    }
    #dataTable_filter label::after {
    width: 61px;
    top: 121px;
    right: 27px;
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
        width: 10rem!important;
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
#agentname,#userstatus,#username{
    font-family: 'Lato-Semibold'!important;
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
    /* border:1px solid #d1cccc6b!important; */
    text-align: left;
    /* border-right: 3px solid #e4aa47!important; */
    box-shadow: 0 4px 2px -2px #d9d1d1;

}
#areafilter,#residencecountryfilter{
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
    right: 4px;
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
    width:21%;
    text-align: left;
    color: #143e39;
    font-family: 'Lato-Bold';
    font-size: 13px;
    margin-left: -10px;
}
.card-header{
        padding: 0 1.3rem;
       /* margin-top: 3rem;*/
}
.pad-row{
    padding: 0 4.8rem 0 4rem;
}
.pad-row2{
    padding: 0 4.8rem 0 0;
}
.row3{
    margin-top: -4.5rem;
}
#img-div{
margin-top: -20px;
    margin-bottom: 10px;
    margin-left: -10px;
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
    transform: translateX(-50%);
    box-shadow:-1px -5px 3px -3px #d9d1d1;
    /* border-top: 1px solid #d9d1d1;*/
}
#resid2:before{
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
    transform: translateX(-43%);
    box-shadow:-1px 4px 4px -3px #d9d1d1;
    /* border-top: 1px solid #d9d1d1;*/
}
#dataTable_length, #dataTable_filter, .dataTables_scroll{
    background: #fff;
}
 .card-body{
          margin-top: -3.5rem!important;
        }
        #wrapper{
            height: auto!important;
        }



        div.table-responsive::-webkit-scrollbar {
  width: 5px;
}
div.table-responsive::-webkit-scrollbar {
  width: 3px!important;

}

/* Track */
div.table-responsive::-webkit-scrollbar-track {
  background: #c5c5c5!important;
}

/* Handle */
div.table-responsive::-webkit-scrollbar-thumb {
  /* background: #6d4e18; */
  border-radius: 0px;
  border-radius: 8px;
}

/* Handle on hover */
div.table-responsive::-webkit-scrollbar-thumb:hover {
  /* background:#6d4e18; */
  border-radius: 8px;
}

.col-md-3.justify-content-start{
    top: 29px;
    left: 18px;
}
.content-input{
        display: flex;
    align-items: center;
}
.content-input span{
    width: 28%;
    color: #143e39;
    font-family: 'Lato-Bold';
    font-size: 13px;
}
.content-input select{
        width: 55%;
}
.bottom-row{
    justify-content: flex-start;
    padding: 0 0 0 3rem;
}
.bottom-row .card{
/*border-bottom: 1px solid #184d47;*/
    border-radius: 0;
}
.bottom-row .card .card-header{
 font-family: 'Lato-Bold';
 font-size: 10px;
 color: #184d47;
 padding: 0.75rem 0.1rem!important;
}
.bottom-row .card .card-header .sp{
    padding: 0rem 1rem!important;
    border-right: 1px solid #251a08;
        border-right: 1px solid #251a08;
}
.bottom-row .card .card-header .sp2{
    padding: 0rem 1rem!important;
   /* border-right: 1px solid #184d47;*/
/*        border-right: 1px solid #184d47;*/
}
.bottom-row .card .card-body{
    margin-top: 0!important;
    border-bottom: 1px solid #184d47;
}
#wrapper #content-wrapper{
        overflow-x: inherit!important;
}
table.dataTable{
    margin-top: 0!important;
}
#card-bottom .card-body{
    margin-top: 0!important;
    padding: 10px!important;
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
/*.pagination li::before {
    font-family: fontAwesome;
    content: "First";
    width: 26px;
    height: 20px;
    top: 1px;
    left: 83px;
    border-right: 2px solid #e3e0e0;
    position: relative;
    display: inline-block;
    color: rgb(24 77 71);
}*/
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

 #tablepaginate{
    padding-right: 4rem;
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
/*responsive*/
@media(max-width: 1200px) and (min-width: 1000px){
.top-title{
    font-size: 17px;
}
#dataTable_length{
    right: 51%;
}
}
@media(max-width: 768px) and (min-width: 550px){
    #maindata{
        width: auto;
    margin: 5rem 1rem;
    }
    .top-title{
    font-size: 17px;
}
#wrapper {
    height: auto;
}
.col-md-3.justify-content-start{
    top: -42px;
}
.top-row{
    margin-top: 0!important;
}
#dataTable_length{
        right: 66%;
}
#dataTable_filter label::after {
    top: 10px!important;
    }
#dataTable_filter label::before {
    top: 2px!important;
}

}
#img-right{
    width: 100%;
    height: 11rem;
    object-fit: contain;
    margin-top: -6rem;
}
.col-img{
    text-align:right;
}
.img-text img{
    width: 60%!important;

}
@media(max-width: 500px){
  #maindata{
    padding: 20px 0px;
  }
  .col-title{
    position: absolute;
    left: 27px;
  }
  #content-wrapper{
    margin-top: 3rem;
  }
  .full-content{
    padding: 0 0 0 16px;
}
.col-md-3.justify-content-start{
        top: -42px;
        left: 5px;
}
.card-body{
    padding: 5px!important;
}
#dataTable_filter {
    border-top: none!important;
    border-left: none!important;
    border-right: none!important;
    }
    #dataTable_filter label::before {
    top: 2px!important;
}
#dataTable_filter label::after {
    top: 10px!important;
    }
    .justify-content-start {
    justify-content: center!important;
}
#tablepaginate{
    justify-content: center!important;
    padding-right: 0!important;
}
.bottom-row .card .card-header{
        font-size: 11px;
    height: 4rem;
    text-align: center;
}
.bottom-row .card{
    width: 50%;
}
.bottom-row .card .card-header .sp{
    border-right: none!important;
}
.bottom-row{
    justify-content: center;
    padding: 0 0 0 0rem;
}
.img-text{
    text-align: center;
}
.img-text img{
    width: 37%!important;
     margin-top: 1rem;
}
.col-img{
    text-align:center;
}
#img-right {
    width: 100%;
    height: 8rem;
    object-fit: contain;
    margin-top: -1rem;
}
#dataTable_length, #dataTable_filter, .dataTables_scroll {
    background: transparent;
}
.img-text img {
    width: 29%!important;
}

}

@media(max-width: 390px){
.full-content{
    padding: 0 0 0 23px;
}
.col-title{
    left: 33px;
  }
  .top-title{
    font-size: 15px;
}
#dataTable_filter label::after{
    right: 63px!important;
}
}
/*end responsive*/
.bg-primary{
    background: transparent!important;
}

    </style>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->

    <!-- <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"> -->
    {{-- </script> --}}

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
        <link type="text/css" href="{{ asset('css/dataTables.checkboxes.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="{{ asset('js/dataTables.checkboxes.min.js') }}"></script>


    <!--  datetime range -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{-- swal alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@section('wrapper_content')

    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-6" >
            <h3 class="top-title">List Archived Properties</h3>
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
                        <!-- <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Show properties
                        </h3> -->

                        <div class=" pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                        <input value="" type="text" name="search" id="filter" hidden />
                        <div class="row  mb-3">
                            <div class="col-md-5 col-12">
                                <input class="input-form" placeholder="Reference Number"
                                       id="reference_number" name="reference_number" type="text" />
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-6 col-12 col-img">
                                <img id="img-right" src="img/bg-top.png">
                            </div>
                        </div>

                        <div class=" pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>

                        <input value="" type="text" name="search" id="filter2" hidden />
                        <div class="row  mb-3">
                            <div class="col-md-5 col-12">
                                <label class="title-input" for="community">community</label>
                                <select name="community" id="community" class="form-control input-form filter-input">
                                    <option></option>
                                    @foreach ($communities as $community)

                                    <option value="{{ $community->id }}">
                                        {{ $community->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-1"></div>

                        </div>
                        <div class="row">
                           <div class="col-md-3 col-4">
                                <label class="title-input" for="agent">Agent</label>
                                <select id="agent" name="user_id" class="form-control input-form filter-input">
                                    <option></option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                           </div>
                           <div class="col-md-3 col-12">
                                <label class="title-input" for="country_id">Country</label>
                                <select id="country_id" name="country" class="form-control input-form" >
                                    <option value="">Select Country </option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"  >{{ $country->name }}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="col-md-3 col-4">
                                <label class="title-input" for="city">City</label>
                                <select id="city" name="city" class="form-control input-form filter-input">

                                </select>
                            </div>
                            <div class="col-md-3 col-4">
                                <label class="title-input" for="bedrooms">Bedrooms</label>
                                <select id="bedrooms" name="bedrooms" class="form-control input-form filter-input">
                                    <option></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="row mt-4 top-row">
                        @if (Auth::user()->isadmin())
                            <div class="col-md-3 d-flex justify-content-start">
                                <div id="tablebuttoncsv" class="mr-1 ml-3"></div>
                                <div id="tablebuttonexcel" class="mr-1"></div>
                                <div id="tablebuttonpdf" class="mr-1"></div>
                            </div>
                        @endif
                    </div>

                    <div class="card-body mt-3">

                        <!-- <div class="table-responsive" style="max-height:278vh;overflow:scroll"> -->
                            <table class="table table-bordered table-hover table-responsive " id="dataTable" style="max-height:185vh;overflow:scroll;">
                                <thead style="background: #70cacc;color: aliceblue;">
                                    <tr>
                                        <th><span class="table-title">Reference Number</span></th>
                                        <th><span class="table-title">property_name</span></th>
                                        <th><span class="table-title">property_status</span></th>
                                        <th><span class="table-title">User</span></th>
                                        <th><span class="table-title">Title</span></th>
                                        <th><span class="table-title">City</span></th>
                                        <th><span class="table-title">Size</span></th>
                                        <th><span class="table-title">Bedrooms</span></th>
                                        <th><span class="table-title">Bathrooms</span></th>
                                        <th><span class="table-title">Type</span></th>
                                        <th><span class="table-title">Offering</span></th>
                                        <th><span class="table-title">Price</span></th>
                                        <th><span class="table-title">community</span></th>
                                        <th><span class="table-title">Updated</span></th>

                                        <th><span class="table-title">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input id="startdate" type="text" hidden>
                                    <input id="enddate" type="text" hidden>
                                </tbody>
                            </table>
                        <!-- </div> -->
                        <div class="row mt-2">
                            <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                            <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->

            <div class="container">
            <div class="row bottom-row"  >
                <div class="col-lg-9 col-md-8 col-12" style="display: flex;">
                    <div id="card-bottom" class="card  text-white bg-primary  justify-content-center" style="display: inline-block!important;">
                        <div  class="card-header" style="background: orange!important;border-radius:0!important"><span class="sp">Total properties count</span></div>
                        <div class="card-body"  style="color: black;background-color: #fff;border-left: 1px solid #184d47;">
                            <h3 id="totalpropertiescount" class="card-text d-flex justify-content-center">
                                {{ isset($totalpropertiescount) ? $totalpropertiescount : 0 }}</h3>
                        </div>
                    </div>
                    <div id="card-bottom" class="card text-white bg-primary  justify-content-center" style="display: inline-block!important;">
                        <div class="card-header" style="background: orange!important;border-radius:0!important"><span class="sp2">Total properties amount</span></div>
                        <div class="card-body"  style="color: black;background-color: #fff;border-right: 1px solid #184d47;">
                            <h3 id="totalpropertiesamount" class="card-text d-flex justify-content-center">
                                {{ isset($totalpropertiesamount) ? $totalpropertiesamount : 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 img-text">
                    <img src="img/text.png" >
                </div>
            </div>
</div>



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
                "endDate": Date.now(),
                "minYear": 1900,

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
                'bPaginate': false,
                "deferRender": true,
            "paging": true,
            // "pagingType": "full_numbers",
                "ajax": {
                    "url": "{{ route('list_archived_properties') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        return $.extend({}, d, {
                            _token: "{{ csrf_token() }}",
                            reference_number: $('#reference_number').val(),
                            user_id: $('#agent').val(),
                            bedrooms: $('#bedrooms').val(),
                            portals: $('#portals').val(),
                            city: $('#city').val(),
                            community: $('#community').val(),
                            search: $('input[type=search]').val()
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
                "columns": [
                    {
                        data: "reference_number",
                        width: '200px'
                    },
                    {
                        data: "property_name",
                        width: '200px'
                    },
                    {
                        data: "property_status",
                        width: '200px'
                    },
                    {
                        data: "user",
                        name:"user.name",
                        width: '200px'
                    },
                    {
                        data: "title_en",
                        width: '200px'
                    },
                    {
                        data: "city",
                        width: '200px'
                    },
                    {
                        data: "size",
                        width: '200px'
                    },
                    {
                        data: "bedroom",
                        width: '200px'
                    },
                    {
                        data: "bathroom",
                        width: '200px'
                    },
                    {
                        data: "property_type",
                        width: '200px',
                    },
                    {
                        data: "offering_type",
                        width: '200px',
                    },
                    {
                        data: "price",
                        width: '200px',
                        render: function(val) {
                            return parseFloat(val).toLocaleString();
                        }
                    },
                    {
                        data: "community_name",
                        width: '200px'
                    },
                    {
                        data: "updated_at",
                        width: '200px'
                    },

                    {
                        data: "actions",
                        width: '200px'
                    }
                ],
                "createdRow": function( row, data, dataIndex){
                        if( data.property_status ==  'Live'){
                            $( row ).css( "background-color", "#98FF98" )
                            $( row ).css( "color", "#000" )
                        }else if(data.property_status ==  'Archive'){
                            $( row ).css( "background-color", "#f79256" )
                            $( row ).css( "color", "#000" )
                        }
                        else if(data.property_status ==  ''){
                            $( row ).css( "background-color", "" )
                            $( row ).css( "color", "#000" )
                        }
                    },

                "lengthMenu": [
                    [100, 500, 1000, 2000, 5000, 10000],
                    [100, 500, 1000, 2000, 5000, 10000]
                ],
                "language":{
                    searchPlaceholder:"Type and press Enter"
                },
                dom: 'lftipB',
                "paging": true,
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
            $('input[type=search]').keyup(function(e) {
                    table.search(this.value).draw();
            });
            $("#reference_number").keyup(function(
                e) {
                    table.draw();

            });

            $("div.dataTables_filter2 input").unbind();
            $('input[type=search]').keyup(function(e) {
                    table.search(this.value).draw();
            });
            $("#community").keyup(function(
                e) {
                    table.draw();

            });

            $('#dataTable').DataTable().draw();
            $('.filter-input').change(function(){
                table.draw();
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

            $('#username').change(function(e) {
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "username": $('#username').val()
                }, );
                $('#dataTable').DataTable().draw();
       // get payments info
                $.ajax({
                    url: "{{ route('get_customer_properties_info') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#username').val(),
                    },
                    success: function(result) {
                        $("#totalpropertiescount").text(result.totalpropertiescount);
                        $("#totalpropertiesamount").text(parseFloat(result
                            .totalpropertiesamount).toLocaleString());
                    }
                })
            });

            $('#dataTable').on('search.dt', function() {
                var value = $('.dataTables_filter input').val();
                var s = $('#filter:text').val(value);
                $('#alertdiv').attr('hidden', true);
            });
            $('#dataTable').on('search.dt', function() {
                var value = $('.dataTables_filter2 input').val();
                var s = $('#filter2:text').val(value);
                $('#alertdiv').attr('hidden', true);
            });
            // Delete a record
            $('body').on('click', '.delete', function() {
                var id = table.row(this.closest('tr')).data()['id'];
                swal({
                    title: 'Are you sure?',
                    text: 'This record and it`s details will be permanantly deleted!',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // ajax
                        $.ajax({
                            type: "POST",
                            url: "{{ route('delete_property') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(result) {
                                if (result.success) {
                                    $('#alertdiv').empty();
                                    $('#alertdiv').append(
                                        "<div class= 'alert alert-success'>" +
                                        result
                                        .message +
                                        "</div>");
                                    $('#alertdiv').attr('hidden', false);
                                    table.clear().draw();
                                }
                                else
                                {
                                    $('#alertdiv').empty();
                                    $('#alertdiv').append(
                                        "<div class= 'alert alert-danger'>" +
                                        result
                                        .message +
                                        "</div>");
                                    $('#alertdiv').attr('hidden', false);
                                }
                            },
                            error: function(erorr) {
                                console.log(erorr);
                            }
                        });
                    }
                });
            });
              // Edit a record
              $('body').on('click', '.edit', function() {
                    var id = table.row(this.closest('tr')).data()['id'];

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "Get",
                        url: "{{ route('upnewproperty') }}/" + id,
                        dataType: 'html',
                        success: function(result) {
                            window.location.href = "{{ route('upnewproperty') }}/" +
                                id;
                        },
                        error: function(erorr) {
                            console.log(erorr);
                        }
                    });

                });
                 // Show details
              $('body').on('click', '.Show', function() {
                    var id = table.row(this.closest('tr')).data()['id'];

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "Get",
                        url: "{{ route('shownewproperty') }}/" + id,
                        dataType: 'html',
                        success: function(result) {
                            window.location.href = "{{ route('shownewproperty') }}/" +
                                id;
                        },
                        error: function(erorr) {
                            console.log(erorr);
                        }
                    });

                });

                // Duplicate a record
                $('body').on('click', '.duplicate', function() {
                    var id = table.row(this.closest('tr')).data()['id'];

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "Get",
                        url: "{{ route('duplicateproperty') }}/" + id,
                        dataType: 'html',
                        success: function(result) {
                            window.location.href = "{{ route('duplicateproperty') }}/" +
                                id;
                        },
                        error: function(erorr) {
                            console.log(erorr);
                        }
                    });

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

    <script src="{{ asset('select2/js/select2.min.js') }}"></script>
    <script>
        $('.filter-input').select2({
            width: '100%',
            placeholder: "Select an Option",
            allowClear: true,
        });
    </script>
    <script>

        $(document).ready(function() {
            $('#country_id').on('change',function(){
                if ($(this).val()) {
                    $.ajax({
                        url: "{{ route('get_cities') }}" + "/" + $(this).val(),
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
