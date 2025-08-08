@extends('layouts.app')

@push('head')
    <title>Assign Imported Data</title>

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
    top: 11px;
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
            margin-right: 1px;
            background: #6d4e18;
            border: #6d4e18;
            font-family: 'Lato-Regular';
            font-size:12px;
            color:#fff;
            width: 6rem;
            height: 2.5rem;
            /*border-radius: 9px!important;*/
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
        #dataTable_length,#dataTable_filter,.dataTables_scroll{
            background:#fff;
        }

        #dataTable_length{
            position: absolute;
            right: 45%;
            margin-top: -3rem;
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
#userid,#residencecountryfilter,#emiratefilter,#addresfilter,#nationalityfilter,#datasourcefilter{
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
#userid:focus-visible,#datasourcefilter,#residencecountryfilter:focus-visible,#emiratefilter:focus-visible,#addresfilter:focus-visible,#nationalityfilter:focus-visible{
    outline: none;
}



#areafilter,#residencecountryfilter{
    box-shadow: 0 4px 2px -2px #d9d1d1;
    color: #878b8f;
    vertical-align: middle;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-size: 12px:focus-visible


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
    width:22%;
    text-align: left;
    color: #143e39;
    font-family: 'Lato-Bold';
    font-size: 13px;
    margin-left: -10px;
}
#datetimepicker2{
    margin-bottom: 0.5rem!important;
}
.card-header{
        padding: 0 10rem;
}
.pad-row{
    padding: 0 4.6rem 0 4rem;
}
.pad-row2{
    padding: 0 4.6rem 0 0;
    align-items: center;
}
.row3{
    margin-top: -4.5rem;
}
#img-div{
margin-top: -20px;
    margin-bottom: 13px;
    margin-left: -10px;
}
#resid:after{
        content: '';
    position: absolute;
    top: 21px;
    border-radius: 100%;
    /* border: 48px solid transparent; */
    border-top: 35px solid #f7f8f8;
    display: block;
    width: 7rem;
    height: 0;
    left: 50%;
    transform: translateX(-48%);
    box-shadow:-1px -5px 3px -3px #d9d1d1;
    /* border-top: 1px solid #d9d1d1;*/
}
.form-control{
    font-size: 12px!important;
    font-family: 'Lato-Regular'!important;
}
#resid2{
    margin-top: 0.3rem;
}
#resid2:before{
    content: '';
    position: absolute;
    bottom: 21px;
    border-radius: 100%;
    /* border: 48px solid transparent; */
    border-bottom: 35px solid #f7f8f8;
    display: block;
    width: 7rem;
    height: 0px;
    left: 50%;
    transform: translateX(-45%);
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
            height: 100%!important;
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
.select2-container .select2-selection--single{
        width: 100%!important;
    }
    .select2{
        width: 100%!important;
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
    margin-top: -20px;
    margin-bottom: 13px;
    margin-left: -5px;
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
@media(max-width: 1250px) and (min-width: 1150px){
#resid2:before {
    transform: translateX(-46%);
}
#dataTable_length {
    right: 49%;
}
.select2-container .select2-selection--single{
        width: 100%!important;
    }
    .select2{
        width: 100%!important;
    }
}
@media(max-width: 1100px) and (min-width: 1000px){
#dataTable_length{
    right: 41%;
}
#resid2:before{
    transform: translateX(-52%);
}
.select2-container .select2-selection--single{
        width: 100%!important;
    }
    .select2{
        width: 100%!important;
    }
}
@media(max-width: 768px) and (min-width: 499px){
    .select2-container .select2-selection--single{
        width: 100%!important;
    }
    .select2{
        width: 100%!important;
    }
    .desc{
        margin-left: -29px!important;
        font-size:13px!important;
        margin-top: 0.5rem;
    }
    .r-4 {
    margin-top: 0.4rem!important;
}
.card-header,#container-f{
    padding:0!important;
}
.row3{
        margin-top: -2.8rem;
}

#resid:after,#resid2:before{
    width: 5.8rem;
}
#resid:after{
    transform: translateX(-56%)!important;
}
#resid2{
        margin-top: 0.3rem;
}
.card-body {
    margin-top: 0.5rem!important;
}
#pad-row1{
    margin-bottom: 0.7rem!important;
}
#pad-row2{
    margin-top: -0.5rem
}
#datetimepicker2{
    margin-bottom: 0.2rem!important;
}
#img-div {
    margin-top: -10px;
    margin-bottom: -3px;
    margin-left: -12px;
}
#img-div img{
    width: 110%!important;
}
#wrapper {
    height: auto!important;
}
#dataTable_filter label{

    margin-top: 0.3rem!important;
    width: 55%;
}
.pad-row2{
    padding:0 3.5rem 0 13px!important;
}
.pad-row{
    padding: 0 3.5rem 0 3.9rem!important;
}
#datetimepicker2 label{
    width: 30%;
}
#resid2:before{
    transform: translateX(-54%);
}
.flex-wrap{
    position: inherit!important;
    top: 0!important;
    left: 0!important;
    margin-bottom: 1rem;
}
#dataTable_length{
    right: 65%;
}
#dataTable_filter label::before {
    top: 1px!important;
}
#dataTable_filter label::after {
    width: 61px;
    top: 10px!important;
    right: 57px!important;
    }
    .table-responsive{
        overflow: hidden!important;
    }
}


.r-4{
    margin-top: 0.8rem;
}
@media(max-width: 500px){
    #userid, #residencecountryfilter, #emiratefilter, #addresfilter, #nationalityfilter{
        width: 100%!important;
    }
    .select2-container .select2-selection--single{
        width: 100%!important;
    }
    .select2{
        width: 100%!important;
    }

    .pad-row2{
        padding: 0!important;
    }
    #daymonthfilter, #rangefilter{
        right: 4px!important;
    }
    /*#rangefilter{
        top: 13px!important;
    }*/
    #areafilter{
            border-right: 3px solid #e4aa47!important;
    }
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
/*.container-fluid{
    padding: 0 0 0 10px!important;
}*/
.card-body{
    padding: 1rem 0;
}
.table-responsive{
    overflow: hidden!important;
}
.flex-wrap {
    top: 0!important;
    left: 0!important;
}
#dataTable_filter label::before{
    top: 2px!important;
}
#dataTable_filter label::after {
    top: 10px!important;
    right: 55px!important;
}
#dataTable_length {
    background: #fff!important;

    border-right: 1px solid #ddd8d8!important;
    border-left: 1px solid #ddd8d8!important;
}
.justify-content-start {
    justify-content: center!important;
}
.justify-content-end {
    justify-content: center!important;
}
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
    /* width: 750px; */

}
.select2{
    width: 100%;
}
.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: inline-block;
    height: 28px;
    -webkit-user-select: none;
    width: 100%;
}
.select2-selection__rendered{
    width: 220px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 1px;
    /* right: -px !important; */
    width: 20px;
    /* z-index: 10 !important; */
}
.select2-container .select2-selection--single .select2-selection__rendered {
    width: 600px;
    display: block;
    font-family: 'Lato-Regular'!important;
    font-size: 12px!important;
    line-height: 1.5!important;
    color: #878b8f !important;
    padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
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
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.0.5/js/dataTables.scroller.min.js"></script>

    <!--  datetime range -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-7" >
            <h3 class="top-title">Assign imported data</h3>
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
                <div id="parent" class="card shadow pb-5 mb-5">

                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold" style="color: #70cacc;display:none">
                            Assign agent data
                        </h3>
                        <div id="loader" class="lds-dual-ring hidden overlay"></div>
                        <div class="alert alert-error pb-3 mt-3" id="alertdata" role="alert" hidden>
                        </div>

                        <div class="alert alert-danger pb-3 mt-3" role="alert" id="alertdiv" hidden>
                        </div>
                        <div class="row pad-row2 mb-1">
                                    <label id="mobile" style="color: #143e39;font-family:'Lato-Bold';font-size: 13px;" for="userid" class="mt-2">Agent Name</label>
                                    <div  class="col-md-1 none"><label class="desc" id="desktop" style="color: #143e39;font-family:'Lato-Bold';font-size: 13px;margin-right: -32px;margin-left: -20px;margin-bottom:0px;" for="userid" class="mt-2">Agent Name</label></div>
                                    <div id="resid" class="col-md-11 col-12">
                                        <div class="input-group date mb-3" id="datetimepicker2">
                                       <!--  <label for="userid" class="mt-2">Agent Name</label> -->
                                        <select id="userid" class="select2">
                                            <option value="">Agent name</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                            @endforeach
                                        </select>
                                       </div>
                                    </div>
                        </div>
                        <div class="row mt-1">
                            <label id="mobile" for="areafilter" class="mt-2">Filter Date</label>
                            <div id="tfoot3" class="col-md-5 col-12">
                                <div class="input-group date mb-3" id="datetimepicker2">
                                    <label id="desktop" for="areafilter" class="mt-2">Filter Date</label>
                                    <select id="areafilter" class="form-control">
                                        <option value="">AREA</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->AREA }}">{{ $area->AREA }}</option>
                                        @endforeach
                                    </select>
                                    <span type="button" class="btn btn-sm btn-outline-primary  "
                                    style="right: -4px;" id="daymonthfilter"><img src="img/filter-remax.png" style="width: 100%"></span>
                                    <span id="border" >
                                    <img src="img/border.png" style="">
                                    </span>
                                </div>
                           </div>
                            <div class="col-md-2 col-12" style="    z-index: 1000;">
                                <div id="img-div">
                                    <img src="img/circle-remax.png" style="width: 105%">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="input-group date mb-3" id="datetimepicker2">
                                    <span id="border3" >
                                     <img src="img/border.png" style="">
                                    </span>
                                 <select id="residencecountryfilter" class="form-control">
                                        <option value="">RESIDENCE COUNTRY</option>
                                     @foreach ($residencecountries as $residencecountry)
                                         <option value="{{ $residencecountry->RESIDENCE_COUNTRY }}">
                                             {{ $residencecountry->RESIDENCE_COUNTRY }}</option>
                                     @endforeach
                                    </select>
                                    <span type="button" class="btn btn-sm btn-outline-primary  "
                                    style="" id="daymonthfilter"><img src="img/filter-remax.png" style="width: 100%"></span>
                                </div>
                        </div>
                            </div>
                                <div class="row row3">
                                    <div id="tfoot29" class="col-md-5 col-12">
                                        <div class="input-group date mb-3" id="datetimepicker2">
                                        <label id="desktop" for="areafilter" class="mt-2"></label>
                                        <select id="nationalityfilter" class="form-control">
                                        <option value="">NATIONALITY</option>
                                        @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality->NATIONALITY }}">
                                                {{ $nationality->NATIONALITY }}</option>
                                        @endforeach
                                    </select>
                                    <span type="button" value="filter range" class="btn btn-sm btn-outline-primary "
                                    style="right: -4px;" id="rangefilter">
                                        <img src="img/filter-remax.png" style="width: 100%">
                                    </span>
                                    <span id="border2" >
                                        <img src="img/border.png" style="">
                                    </span>
                                        </div>
                                    </div>
                                    <div id="tfoot10" class="col-md-2 none"></div>
                                    <div id="tfoot10" class="col-md-4 col-12">
                                        <div class="input-group date mb-3" id="datetimepicker2">
                                           <span id="border4" >
                                        <img src="img/border4.png" style="">
                                    </span>
                                    <select id="addresfilter" class="form-control">
                                        <option value="">ADDRESS</option>
                                        @foreach ($address as $addres)
                                            <option value="{{ $addres->ADDRESS }}">{{ $addres->ADDRESS }}
                                            </option>
                                        @endforeach
                                    </select>
                                         <span type="button" value="filter range" class="btn btn-sm btn-outline-primary "
                                    style="" id="rangefilter">
                                        <img src="img/filter-remax.png" style="width: 100%">
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pad-row">
                                    <div id="resid2" class="col-md-12 col-12">
                                    <select id="emiratefilter" class="form-control">
                                        <option value="">EMIRATE</option>
                                        @foreach ($emirates as $emirate)
                                            <option value="{{ $emirate->EMIRATE }}">
                                                {{ $emirate->EMIRATE }}</option>
                                        @endforeach
                                    </select>
                                        <span type="button" value="filter range" class="btn btn-sm btn-outline-primary "
                                    style="right: 14px!important;" id="rangefilter">
                                        <img src="img/filter-remax.png" style="width: 100%">
                                    </span>
                                    </div>
                                </div>
                                <div class="row pad-row2 r-4 mb-1">
                                    <label id="mobile" style="color: #143e39;font-family:'Lato-Bold';font-size: 13px;" for="userid" class="mt-2">Source</label>
                                    <div class="col-md-1 none" style="margin-top: 10px;"><label class="desc" id="desktop" style="color: #143e39;font-family:'Lato-Bold';font-size: 13px;margin-right: -32px;margin-left:10px;margin-bottom:14px;" for="userid" class="mt-2">Source</label></div>
                                    <div class="col-md-11 col-12">
                                    <div class="input-group date mb-3" id="datetimepicker2">
                                    <select id="datasourcefilter" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($datasources as $source)
                                            <option value="{{ $source->source }}">
                                                {{ $source->source }}</option>
                                        @endforeach
                                    </select>

                                    </div>
                                </div>
                            </div>
                    </div>



                    <div class="card-body mt-3">
                        <table class="table table-bordered table-hover" cellspacing="0" style="overflow:scroll" style="width: 550%" id="dataTable">

                            {{-- <h3 class="ml-4">Select user</h3> --}}
                            <!-- <div class="row mb-5">
                                <div class="col-md-3">
                                    <select id="userid" class="form-control">
                                        <option value="">Agent name</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                </div>
                                <div id="div1" class="col-md-2 bl-0" hidden>
                                    <div class="card text-white bg-primary d-flex justify-content-center"
                                        style="max-width: 12rem;">
                                        <div class="card-header" style="color: black">Total assigned data</div>
                                        <div class="card-body">
                                            <h3 id="assigneddatacount" class="card-text d-flex justify-content-center">
                                                {{ isset($assigneddatacount) ? $assigneddatacount : 0 }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div id="div2" class="col-md-3 bl-0" hidden>
                                    <div class="card text-white bg-primary d-flex justify-content-center"
                                        style="max-width: 14rem;">
                                        <div class="card-header" style="color: black">Total commented data</div>
                                        <div class="card-body">
                                            <h3 id="commenteddatacount" class="card-text d-flex justify-content-center">
                                                {{ isset($commenteddatacount) ? $commenteddatacount : 0 }}</h3>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <h3 class="ml-4">Filter data</h3>
                            <div class="row">
                                <label for="tfoot7" class="col-md-3">
                                    Emirate
                                </label>
                                <label for="tfoot10" class="col-md-3">
                                    Address
                                </label>
                                <label for="tfoot28" class="col-md-3">
                                    Residence country
                                </label>
                                <label for="tfoot29" class="col-md-3">
                                    Nationality
                                </label>
                            </div>
                            <div class="row mb-5">
                                <div id="tfoot7" class="col-md-3">
                                    <select id="emiratefilter" class="form-control">
                                        <option value="">EMIRATE</option>
                                        @foreach ($emirates as $emirate)
                                            <option value="{{ $emirate->EMIRATE }}">
                                                {{ $emirate->EMIRATE }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="tfoot10" class="col-md-3">
                                    <select id="addresfilter" class="form-control">
                                        <option value="">ADDRESS</option>
                                        @foreach ($address as $addres)
                                            <option value="{{ $addres->ADDRESS }}">{{ $addres->ADDRESS }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="tfoot28" class="col-md-3">
                                    <select id="residencecountryfilter" class="form-control">
                                        <option value="">RESIDENCE COUNTRY</option>
                                        @foreach ($residencecountries as $residencecountry)
                                            <option value="{{ $residencecountry->RESIDENCE_COUNTRY }}">
                                                {{ $residencecountry->RESIDENCE_COUNTRY }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="tfoot29" class="col-md-3">
                                    <select id="nationalityfilter" class="form-control">
                                        <option value="">NATIONALITY</option>
                                        @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality->NATIONALITY }}">
                                                {{ $nationality->NATIONALITY }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="tfoot7" class="col-md-3">
                                    Data source
                                </label>
                                <label for="tfoot7" class="col-md-3">
                                    Area
                                </label>
                            </div>
                            <div class="row mb-5">
                                <div id="tfoot7" class="col-md-3">
                                    <select id="datasourcefilter" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($datasources as $source)
                                            <option value="{{ $source->source }}">
                                                {{ $source->source }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="tfoot7" class="col-md-3">
                                    <select id="areafilter" class="form-control">
                                        <option value="">AREA</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->AREA }}">{{ $area->AREA }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->

                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th>check</th>
                                    <th>Name</th>
                                    <th>Nationality</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    {{-- <th>whatsup phone</th> --}}
                                    <th>Mobile</th>
                                    {{-- <th>whatsup mobile</th> --}}
                                    <th>Secondary mobile</th>
                                    {{-- <th>whatsup secondary mobile</th> --}}
                                    <th>
                                        <div class="row">P-number&nbsp&nbsp<div data-toggle="tooltip"
                                                data-placement="right" title="Plot Number"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                </svg></div>
                                        </div>
                                    </th>
                                    <th>Area</th>
                                    <th>Usage</th>
                                    <th>Total area</th>
                                    <th>Plot number</th>
                                    <th>Emirate</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Area owned</th>
                                    <th>Fax</th>
                                    <th>Po box</th>
                                    <th>
                                        <div class="row">DOB&nbsp&nbsp<div data-toggle="tooltip"
                                                data-placement="right" title="Date of birthday"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                </svg></div>
                                        </div>
                                    </th>
                                    <th>Passport</th>
                                    <th>Issue date</th>
                                    <th>Expiry date</th>
                                    <th>Place of issue</th>
                                    <th>Emirates id number</th>
                                    <th>Emirates id expiry date</th>
                                    <th>Residence country</th>
                                    <th>Master project</th>
                                    <th>Project</th>
                                    <th>Building name</th>
                                    <th>Agents</th>
                                    <th>Source</th>
                                    <th>Flat number</th>
                                    <th>No of beds</th>
                                    <th>Floor</th>
                                    <th>Registration number</th>
                                    <th>Lat</th>
                                    <th>Lang</th>
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
    <!-- End of Content Wrapper -->
@endsection

@push('scripts')
    <script>
        let table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            scrollY: 500,
            scrollX: true,
            LengthChange:false,
            scrollCollapse: true,
            "pageLength": 100,
            "deferRender": true,
            "paging": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "{{ route('serach_for_agent_data') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    return $.extend({}, d, {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#userid').val()
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
            "columns": [{
                    data: "check",
                    width: '150px'
                },
                {
                    data: "NAME",
                    width: '300px'
                }, {
                    data: "NATIONALITY",
                    width: '100px'
                },
                {
                    data: "EMAIL",
                    width: '100px'
                },
                {
                    data: "PHONE",
                    width: '100px',
                    render: function(data) {
                        if (data != "-" && data != null && data != "") {
                            return data + '&nbsp&nbsp <a href="https://wa.me/' + data +
                                '" target="_blank"><i class="fab fa-whatsapp fa-3x"></i></a>';
                        } else
                            return data;
                    }
                },
                {
                    data: "MOBILE",
                    width: '150px',
                    render: function(data) {
                        if (data != "-" && data != null && data != "") {
                            return data + '&nbsp&nbsp <a href="https://wa.me/' + data +
                                '" target="_blank"><i class="fab fa-whatsapp fa-3x"></i></a>';
                        } else
                            return data;
                    }
                },
                {
                    data: "SECONDARY_MOBILE",
                    width: '150px',
                    render: function(data) {
                        if (data != "-" && data != null && data != "") {
                            return data + '&nbsp&nbsp <a href="https://wa.me/' + data +
                                '" target="_blank"><i class="fab fa-whatsapp fa-3x"></i></a>';
                        } else
                            return data;
                    }
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
                },
                {
                    data: "EMIRATE",
                    width: '100px'
                },
                {
                    data: "AREA_OWNED",
                    width: '100px'
                },
                {
                    data: "ADDRESS",
                    width: '300px'
                },
                {
                    data: "FAX",
                    width: '100px'
                }, {
                    data: "PO_BOX",
                    width: '100px'
                },
                {
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
                },
                {
                    data: "Master_Project",
                    width: '100px'
                },
                {
                    data: "Project",
                    width: '100px'
                },
                {
                    data: "Building_Name",
                    width: '100px'
                },
                {
                    data: "Agents",
                    width: '100px'
                },
                {
                    data: "source",
                    width: '150px'
                },
                {
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
                },
                {
                    data: "lat",
                    width: '100px'
                }, {
                    data: "lng",
                    width: '100px'
                }
            ],
            "lengthMenu": [
                [100, 500, 1000, 2000, 5000, 10000],
                [100, 500, 1000, 2000, 5000, 10000]
            ],
            "language":{
                searchPlaceholder:"Type and press Enter"
            },
            "dom": 'Bfltip',
            "buttons": [
                'selectAll',
                'selectNone',
                {
                    text: '<span class="fa fa-plus-circle" aria-hidden="true"></span> Assign',
                    attr: {
                        id: 'assign_data',
                        class: "btn btn-primary"
                    }
                }
            ],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            initComplete: function() {
                $('#tablepaginate').empty();
                $('#dataTable_paginate').appendTo('#tablepaginate');
                $('#tableinfo').empty();
                $('#dataTable_info').appendTo('#tableinfo');
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

        $(document).ready(function() {

            $('#userid').change(function() {
                $("#alertdata").empty();
                $('#dataTable').data("dt_params", {
                    _token: "{{ csrf_token() }}",
                    "userid": $('#userid').val()
                }, );
                $('#dataTable').DataTable().draw();

                // get assigned data info
                $.ajax({
                    url: "{{ route('get_assigned_user_data_info') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        "userid": $('#userid').val()
                    },
                    success: function(result) {
                        $("#commenteddatacount").text(result.commenteddatacount);
                        $("#assigneddatacount").text(result.assigneddatacount);
                        userindex = $('#userid')[0].selectedIndex;
                        if (userindex == 0) {
                            $('#div1').attr('hidden', true);
                            $('#div2').attr('hidden', true);
                        } else {
                            $('#div1').attr('hidden', false);
                            $('#div2').attr('hidden', false);
                        }
                    }
                })
            });

            $('#areafilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(8).search(selectedValue).draw();
            });

            $('#emiratefilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(12).search(selectedValue).draw();
            });

            $('#addresfilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(13).search(selectedValue).draw();
            });

            $('#residencecountryfilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(25).search(selectedValue).draw();
            });

            $('#nationalityfilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(2).search(selectedValue).draw();
            });

            $('#datasourcefilter').change(function() {
                var selectedValue = $(this).val();
                table.columns(30).search(selectedValue).draw();
            });

            $('#assign_data').click(function(e) {
                $("#alertdata").empty();
                e.preventDefault();
                var data = [];

                var checked_rows = table.rows('.selected').data();
                $.each(checked_rows, function(index, rowId) {
                    data.push(rowId.id);
                });
                var userid = $('#userid').val();

                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("userid", userid);
                if (data.length > 0)
                    formData.append("data", JSON.stringify(data));

                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    enctype: 'multipart/form-data',
                    url: "{{ route('assign_agent_data') }}",
                    beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                        $("#parent").addClass("disabledbutton");
                    },
                    success: function(result) {
                        if (result.success) {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-success'>" + result
                                .message + "</div>");
                            $("#alertdata").attr('hidden', false);

                            // reload data
                            $('#dataTable').data("dt_params", {
                                _token: "{{ csrf_token() }}",
                                "userid": $('#userid').val()
                            }, );
                            $('#dataTable').DataTable().draw();

                            // $('#loader').addClass('hidden')
                            // $("#parent").removeClass("disabledbutton");
                        } else if (result.message == "There are some duplicated data") {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-danger'>" + result
                                .message +
                                "<a target='_blank' href={{ route('get_assigned_data_index') }}> show data</a>" +
                                "</div>");
                            $("#alertdata").attr('hidden', false);
                            $('#loader').addClass('hidden')
                            $("#parent").removeClass("disabledbutton");
                        } else {
                            $("#alertdata").empty();
                            $("#alertdata").append("<div class= 'alert alert-danger'>" + result
                                .message + "</div>");
                            $("#alertdata").attr('hidden', false);
                            $('#loader').addClass('hidden')
                            $("#parent").removeClass("disabledbutton");
                        }

                        table.rows().deselect();
                        $("th.select-checkbox").removeClass("selected");
                    },
                    error: function(error) {
                        $("#alertdata").empty();
                        $.each(error.responseJSON.errors, function(index, value) {
                            if (index == 'userid'){
                                $("#alertdata").append(
                                "<div class= 'alert alert-danger'>" +
                                "You should select agent first!"+ "</div>");
                            }else{
                                $("#alertdata").append(
                                "<div class= 'alert alert-danger'>" +
                                index +
                                "   " + value + "</div>");
                            }
                        });
                        $("#alertdata").attr('hidden', false);
                        $("#parent").removeClass("disabledbutton");
                        $('#loader').addClass('hidden');
                    }
                });
            });
            //////////////////////////////////////////////////
            $('.select2').select2();

        });
    </script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
@endpush
