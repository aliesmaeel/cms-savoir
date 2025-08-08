@extends('layouts.app')

@push('head')
    <title>Export & Uploaded Files</title>

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
       html {
            scroll-behavior: smooth;
        }

        .alert-success {

            margin: 3px 20px;
            color: #0f6848;
            background-color: #d2f4e8;
            border-color: #bff0de;
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
        #dataTable_length,#dataTable_filter,.dataTables_scroll{
            background:#fff;
        }
        #dataTable_length{
            position: absolute;
            right: 48%;
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
#landingname,#agent{
    font-family: 'Lato-Regular'!important;
    font-size: 12px!important;
    display: inline-block;
    /*width: 100%;*/
    height: calc(2.25rem + 2px);
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    line-height: 1.5;
    vertical-align: middle;
    border-radius: 0!important;
    background: transparent;
    border: 1px solid #184d47;
    color: #184d47;

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
        padding: 0 2rem;
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
    margin-top: 0px;
    /* margin-bottom: 10px; */
    margin-left: 0px;
    position: absolute;
    top: 2px;
    left: 93px;
    margin-right: -40px;
}
#img-div img{
    width: 66%;
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
          /*margin-top: -3.5rem!important;*/
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

.justify-content-start{
    top: 47px;
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

.bottom-row .card{
border-bottom: 1px solid #184d47;
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
.bottom-row .card .card-body{
    margin-top: 0!important
}
.sidebar hr.sidebar-divider{
    display: none!important;
}
.img-span{
        position: absolute;
    top: -3px;
    left: -8px;
}
.img-span img{
    width: 34px;
    height: calc(2.25rem + 16px);
    object-fit: fill;
}
.img-span2{
position: absolute;
    top: 3px;
    left: -8px;
}
.img-span2 img{
  width: 34px;
    height: calc(2.25rem + 14px);
    object-fit: fill;
    transform: scaleX(-1);
}
#buttonsubmit{
    width: 7.2rem;
    padding: 5px 17px;
    border-radius: 0;
    /* background: #184d47; */
    height: calc(2.25rem + 0px);
    font-family: 'Lato-Regular';
    font-size: 15px;
}
.content-all{
    border: 1px solid #dbd5d5;
    padding: 1rem 0 0 0;
    background: #fff;
    border-radius: 4px;

}
#input-search{
    width: 90%;
    margin: auto;
    padding: 0 36px;
    outline: none!important;
    box-shadow: inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
    border-radius: 0!important;
    border: 1px solid #d8d5cd;
    height: 2.1rem;
}
.span-search{
position: absolute;
    left: 4%;
    top: 49px;
    width: 25px;
    border-right: 2px solid #b9c3c2;
    text-align: center;

}
.span-search i{
        color: #9D865C;
}
.span-img{
        position: absolute;
    top: 43px;
    right: 30%;
}
.span-img img{
        width: 8rem;
    height: 2.1rem;
    object-fit: contain;
}
.card-footer {
    padding: 10px 0px 10px 0px!important;
    background-color: transparent!important;
    border-top: none!important;
    }
.card-footer h3{
    color: #050506!important;
    font-family: 'Lato-Semibold';
    font-size: 14px;
}

.file{
    text-align: right;
}
.file img{
    width: 10rem;
}
.file-img{
    position: absolute;
    bottom: 0;
    right: 13px;    
}
@media(max-width: 500px){
.file-img{
    position: absolute;
    bottom: 0;
    right: 13px;    
}
.file img{
    width: 7rem;
}
.container-fluid{
    padding-right: 1rem!important;
}
.content-all .form-group{
    width: 96%!important;
}
#input-search{
    width: 95%;
}
.span-img{
    right: 15px;
}
.span-img img{
    width: 5rem;
}
}
.content-all{
    width: 100%;
    overflow: scroll!important;
}
    </style>

@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-8" >
            <h3 class="top-title">Export & Uploaded Files</h3>
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
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <!-- <h3 class="m-0 font-weight-bold" style="color: #70cacc;">
                            Uploaded Files
                            <div class="form-group">

                            </div>
                            <div class="form-group">

                            </div>
                            <div class="form-group">

                            </div>
                        </h3> -->

                    </div>

                   <div class="card-bod">
                        <div class="table-responsiv">
                          <div class="content-all">
                            <div class="form-group pull-right" style="width: 70%;background: #fff;margin-bottom:0!important;text-align: left;">
                                <span class="span-search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                                <input id="input-search" type="text" placeholder="Type and press Enter" class="search form-control" >
                                <span class="span-img">
                                    <img src="img/search-remax.jpg">
                                </span>
                            </div>
                            <div style="display:none" id="success" class="alert alert-success alert-dismissible fade show"
                                role="alert">
                                <strong>Success</strong> File deleted successfully
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <table class="table table-bordere" style="margin-top: 1.8rem;max-height: 80vh;overflow:scroll" id="dataTabl"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><span class="table-title">File Name</span></th>
                                        <th><span class="table-title">On Date</span></th>
                                        <th><span class="table-title">Rows Count</span></th>
                                        <th><span class="table-title"></span></th>
                                        <th><span class="table-title"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr class="ro" data-type="{{ $file->fileName }}">
                                            <td>{{ str_replace('uploadedFiles/', ' ', $file->fileName) }}</td>
                                            <td>{{ $file->created_at }}</td>
                                            <td>{{ $file->numberofimportedrows }}</td>
                                            <td><a class="btn btn-primary"
                                                    href="{{ url('/downloadFile/' . str_replace('uploadedFiles/', '/', $file->fileName)) }}">Download</a>
                                            </td>
                                            <td>
                                                <form class="form" action="{{ route('deleteFile', $file->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <span id="delete">Delete</span>

                                                    </button>


                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                            <div class="card-footer py-3">
                                <h3 class="m-0 font-weight-bold" style="color: #2c2d7c;">
                                    <div>Total Rows : {{ $totaRowsCount }}</div>
                                    <div class="form-group">

                                    </div>
                                    <div class="form-group">

                                    </div>
                                    <div class="form-group">

                                    </div>
                                </h3>

                            </div>
                            

                        </div>
                       

                    </div>


                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->
    <div class="row file-img">
                                <div class="col-12 file">
                                    <img src="img/file.png">
                                </div>
                            </div>
@endsection

@section('content')
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-clock-o"></i> Please Wait</h4>
                </div>
                <div class="modal-body center-block">
                    <div style="text-align:center" id='wait' class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span>Please wait until file deleted</span>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
        $(".filter").change(function() {
            var filterValue = $('.filter').val();
            var filterValue1 = $('.filter1').val();
            var filterValue2 = $('.filter2').val();
            if (filterValue != 'Show') {
                var row = $('.ro');

                row.hide()
                row.each(function(i, el) {
                    if ($(el).attr('data-type') == filterValue || $(el).attr('data-typee') ==
                        filterValue1 || $(el).attr('data-typeee') == filterValue2) {
                        $(el).show();
                    }
                })
            } else {
                var row = $('.ro');

                row.hide()
                row.each(function(i, el) {

                    $(el).show();

                })
            }


        });
    </script>

    <!-- jQuery library -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            $('.form').ajaxForm({

                beforeSend: function() {


                    $('.btn-danger').prop('disabled', true);

                    $('#myModal').modal('show');



                },

                success: function(data) {

                    location.reload();
                    $('#success').css('display', 'block');
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('div#emirates').show();
            $('div#usage').hide();
            $('div#nationality').hide();

        });
        $(".filter").change(function() {
            var filterValue = $(this).val();
            if (filterValue == 'emirates') {
                $('div#emirates').show();
                $('div#usage').hide();
                $('div#nationality').hide();
            }
            if (filterValue == 'usage') {
                $('div#usage').show();
                $('div#emirates').hide();
                $('div#nationality').hide();
            }
            if (filterValue == 'nationality') {
                $('div#nationality').show();
                $('div#emirates').hide();
                $('div#usage').hide();
            }

            // row.each(function(i, el) {
            //      if($(el).attr('data-type') == filterValue) {
            //          $(el).show();
            //      }
            // })



        });
    </script>
    <script>
        $(document).ready(function() {
            $('.search').on('keyup', function(e) {
                if (e.keyCode == 13) {
                var searchTerm = $(this).val().toLowerCase();
                $('#dataTabl tbody tr').each(function() {
                    var lineStr = $(this).text().toLowerCase();
                    if (lineStr.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            }
            });
        });
    </script>

@endpush