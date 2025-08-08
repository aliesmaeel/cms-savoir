@extends('layouts.app')

@push('head')
    <title>Create payment</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">

    <!-- jQuery library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
    </script>

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
        .top-title {
    font-family: 'Lato-Semibold';
    font-size: 20px;
    color: #fff;
    height: 4rem;
    padding: 14px 35px;
    
    border-radius: 0 0px 55px 0;
    /* background-image: linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
}
.sidebar-divider{
    display: none;
}
.title-input{
    color: #143e39;
    font-family: 'Lato-Bold';
    font-size: 13px;
}

#property,#datetimepicker,#amount,#status,#buyerid{
    font-family: 'Lato-Regular'!important;
    font-size: 12px!important;
    display: inline-block;
     width: 100%; 
    height: calc(2.25rem + 2px);
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    line-height: 1.5;
    color: #878b8f;
    vertical-align: middle;
    border-radius: 0!important;
    background: #fff!important;
    border: none;
    text-align: left;
    /* border-right: 3px solid #e4aa47!important; */
    box-shadow: 0 4px 2px -2px #d9d1d1;
}

input[type=text], input[type=password]{
    margin: 0!important;
}

#maindata{
    /* box-shadow: 0px 0px 4px 1px #6c4d18;
    border: 1px solid #e4aa47; */
    margin: 5px;
    /* border: 1px solid #e4aa47; */
    border-radius: 5px;
    padding: 20px 39px;
        width: 50rem;
    margin: 5rem auto;
}
@font-face {
     font-family: 'Lato-Semibold';
            src: url('font/Lato-Semibold.ttf');
        }
#buttonsubmit{
    /* background: #6c4d18; */
    padding: 5px 32px;
    border-radius: 0;
    font-family: 'Lato-Semibold';
}
/*responsive*/
@media(max-width: 1200px) and (min-width: 1000px){
.top-title{
    font-size: 17px;
}
}
@media(max-width: 768px){
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
}
@media(max-width: 500px){
  #maindata{
    padding: 20px 0px;
  } 
  .col-title{
    position: absolute;
    left: 27px;
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
}
/*end responsive*/
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-9" >
            <h3 class="top-title">Create payment</h3>
        </div>
    </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- <h2 style="margin-left: 30%" class="mt-5 mb-5">Create new payment</h2> -->
        <form id="maindata" class="mt-5">
            <div class="container">
                <span id="alertdata"></span>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Buyer name</label>
                    </div>
                    <div class="col-md-9">  
                        <select name="buyerid" class="form-control filter mt-2" style="height:40px" id="buyerid"
                            style="font-size:.7rem;font-weight:bold">
                            <option selected value="">User name</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Property</label>
                    </div>
                    <div class="col-md-9">  
                        <input type="text" placeholder="Enter Property" name="property" id="property" required>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Amount</label>
                    </div>
                    <div class="col-md-9">
                       <input class="form-control" type="text" placeholder="Enter Payment Amount" name="amount" id="amount" required >
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Payment date</label>
                    </div>
                    <div class="col-md-9">
                       <input type="text" placeholder="Enter Payment Date" name="Paymentdate" id="datetimepicker" required>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" type="button" class="registerbtn">Create
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>




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

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
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

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: "{{ route('create_new_payment') }}",
                beforeSend: function(){
                    $('#buttonsubmit').attr('disabled','disabled');
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
                        $('.spinner-border').attr('hidden','hidden');
                    } else {
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-danger'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                        $('#buttonsubmit').removeAttr('disabled');
                        $('.spinner-border').attr('hidden','hidden');
                    }
                },
                error: function(error) {
                    $("#alertdata").empty();
                    $.each(error.responseJSON.errors, function(index, value) {
                        $("#alertdata").append(
                            "<div class= 'alert alert-danger'>" +
                            index +
                            "   " + value + "</div>");
                    });
                    $("#alertdata").attr('hidden', false);
                    $('#buttonsubmit').removeAttr('disabled');
                    $('.spinner-border').attr('hidden','hidden');
                }
            });
        });
    </script>

    {{-- add comma for input --}}
    {{-- <script>
        $("#amount").blur(function() {
            $("#amount").val(parseFloat($("#amount").val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")
                .toString());
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            var properties = {!! $properties !!};
            var users = {!! $users !!};
            $("#property").autocomplete({
                source: properties
            });
        });
    </script>

@endpush
