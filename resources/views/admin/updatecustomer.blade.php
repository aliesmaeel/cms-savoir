@extends('layouts.app')

@push('head')
    <title>Update customer</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('images/css/dash.css') }}">

    <style>
        body {
          
          
        }

        * {
            box-sizing: border-box;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
            
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
            width: 10%;
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
           /* background-color: white;*/
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
            width: 10%;
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
.custom-file-input {
  color: transparent;
}
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}
.custom-file-input::before {
  content: 'Select some files';
  color: black;
  display: inline-block;
  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;
}
.custom-file-input:hover::before {
  border-color: black;
}
.custom-file-input:active {
  outline: 0;
}
.custom-file-input:active::before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9); 
}

label.file {
    width: 100%;
    position: relative;
    display: inline-block;
    cursor: pointer;
    height: 2.5rem;
}
label.file input {
    height: calc(2.25rem + 2px);
    width: 100%;
    padding: 9px 24px 5px 24px!important;
    margin: 0;
    filter: alpha(opacity=1);
    opacity: 1;
    background-color: transparent!important;
    color: #8b7777!important;
}
::-webkit-file-upload-button {
   display: none;
}
.file-custom {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 5;
    height: calc(2.25rem + 3px);
    padding: 0.5rem 1rem;
    line-height: 1.5;
    color: #878b8f;
    font-family: 'Lato-Semibold'!important;
    font-size: 12px!important;
    /*background-color: #fff;*/
    border: 1px solid #184d47;
    /*border-radius: 0.25rem;
    box-shadow: inset 0 0.2rem 0.4rem rgb(0 0 0 / 5%);*/
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.file-custom:before {
    position: absolute;
    top: -0.075rem;
    right: -0.075rem;
    bottom: -0.075rem;
    z-index: 6;
    display: block;
    font-family: 'Lato-Semibold'!important;
    font-size: 12px!important;
    width: 9rem;
    text-align: center;
    content: "Choose File";
    height: calc(2.25rem + 3px);
    padding: 0.5rem 1rem;
    line-height: 1.5;
    color: #fff;
    /* background:url(img/choose22.png) no-repeat; */
    /*border: 0.075rem solid #ddd;
    border-radius: 0 0.25rem 0.25rem 0;*/
    background-size: cover;
}
.file-custom:after {
    content: "No File Choosen";
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
.sidebar hr.sidebar-divider{
    display: none!important;
}

/*form#maindata {
    width: 56rem;
    margin: auto;
}*/
#import-title{
    font-family: 'Lato-Semibold';
    font-size: 17px;
    color: #000;
}

#import{
    background-color:#6c4d18;
    color: white;
    padding: 5px 30px;
    border-radius: 0;
    font-family: 'Lato-Semibold';
    font-size: 14px;
    border: none;
}
#file{
    background-color: #babec5;
    color: #241d12;
    padding: 5px 24px;
    border-radius: 0;
    font-family: 'Lato-Semibold';
    font-size: 14px;
    border: none;
}
#maindata {
    /* box-shadow: 0px 0px 4px 1px #6c4d18; */
    margin: 5px;
    /* border: 1px solid #e4aa47; */
    border-radius: 5px;
    padding: 20px 51px;
    width: 50rem;
    margin: 0rem auto 4rem auto;
}
#wrapper #content-wrapper {
    overflow-y: scroll;
}
#name,#email,#phone,#projectname,#notes{
    font-family: 'Lato-Semibold'!important;
    font-size: 12px!important;
    display: inline-block;
    /* width: 100%; */
    height: calc(2.25rem + 2px);
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    line-height: 1.5;
    color: #878b8f;
    vertical-align: middle;
    border-radius: 0!important;
    background: #fff!important;
    /* border: 1px solid #d1cccc6b!important; */
    text-align: left;
    /* border-right: 3px solid #e4aa47!important; */
    box-shadow: 0 4px 2px -2px #d9d1d1;
        margin-bottom: 3px!important;
}
div#container-all {
    height: 34rem;
    overflow-y: scroll;
    overflow-x: hidden;
        margin-right: -16px;
    padding-right: 8px;
    margin-bottom: 10px;
}
div#container-all::-webkit-scrollbar {
  width: 5px;
}
div#container-all::-webkit-scrollbar {
  width: 8px!important;

}

/* Track */
div#container-all::-webkit-scrollbar-track {
  background: transparent;!important;
   border-radius: 8px;
}

/* Handle */
div#container-all::-webkit-scrollbar-thumb {
  background: #9D865C;
  border-radius: 8px;
}

/* Handle on hover */
div#container-all::-webkit-scrollbar-thumb:hover {
  background: #9D865C;
  border-radius: 8px;
}
#wrapper {
    height: auto;
}
input[type=text], input[type=password]{
    margin: 0!important;
}
.sub-title{
    font-family: 'Lato-Semibold'!important;
    font-size: 12px!important;
    color: #184d47;
}

#wrapper #content-wrapper {
    width: 100%;
    overflow-x: inherit!important;
}
#buttonsubmit{
 padding: 9px 11px;
    /* background: #15443f; */
    width: 9rem;
    border-radius: 0;
    height: 100%;
    margin: 0;
    font-family: 'Lato-Semibold';
    font-size: 14px;
    /* background:#6c4d18; */
}
.sidebar-divider{
    display: none;
}
.title-input{
    color: #143e39;
    font-family: 'Lato-Bold';
    font-size: 13px;
}

/*responsive*/
@media(max-width: 1400px){
    #bookslist_filter label::before{
        top: 133px;
    }
    #bookslist_filter label::after{
        top: 127px;
    }
}
.label h4{
    font-size: 15px;
    color:#241907;
}
@media(max-width: 1350px) and (min-width: 1200px){
.top-title{
    font-size: 16px;
    
}
}
#bg-top {
    width: 116%;
    margin-left: -2rem;
    margin-top: -4rem;
}
#bookslist_filter label::after{
    top: 121px;
    right: 31px;
}
#bookslist_filter label::before{
    top: 126px;
    right: 281px;
}
.label h4{
    font-size: 15px;
    color:#241907;
}
.top-title{
    font-size: 16px;
}

@media(max-width: 768px){
    #wrapper {
    height: auto;
}
.group-button{
    margin-top: 2rem;
}
#maindata{
    padding: 20px 35px;
    width: auto;
    margin: 0!important;
}
.card-body{
    padding: 0!important;
}
}
@media(max-width: 500px){
    .top-title{
        font-size: 15px!important;
           
    }
    #maindata{
            padding: 20px 0px;
    width: auto;
    margin: 3rem 0 2rem 1.3rem;
    }
    #wrapper {
    height: 100%;
}
    #bg-top {
    width: 66%;
    margin-left: 0;
    margin-top: 0;
   }
   .group-button{
    margin-top: 0rem!important;
}
   #bookslist_filter label::before {
    top: 405px!important;
    right: 189px!important;
}}
@media (max-width: 500px){
#bookslist_filter label::after {
    top: 10px!important;
    right: 42px!important;
    position: relative;
}
#bookslist_length{
    background: transparent;
}
}
@media (max-width: 1350px) and (min-width: 1200px){
#bookslist_filter label::after {
    top: 127px;
}}
@media (max-width: 768px) and (min-width: 600px){
#bookslist_filter label::after {
    top: 128px;
}}
/*end responsive*/ 
    </style>
@endpush

@section('wrapper_content')
    <!-- Content Wrapper -->
    <div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-8">
            <h3 class="top-title">Update customer</h3>
        </div>
    </div> 
    </div> 
    <div id="content-wrapper" class="d-flex flex-column" >
        <!-- <h3 style="margin: auto" class="mt-4 mb-4">Update customer</h3> -->
        <form id="maindata">
            <div class="container">
                <span id="alertdata"></span>
                <div class="mt-3">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="customerenquiry">
                            <h3>Import from csv file</h3>
                        </label>
                      </div>
                    </div>
                    <div class="row">
                     <div class="col-md-12">
                      <label class="file">
                        <input type="file" id="file" name="file" class=" mb-5" aria-label="File browser example">
                        <span class="file-custom"></span>
                      </label>
                     </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-5 col-md-7">
                            <input type="button" id="import" class="btn btn-md btn-success mt-0 mb-3"
                         value="Import">
                            <input type="button" id="file" name="file" class="btn btn-md btn-success ml-2 mb-3"
                         value="Template"
                            onclick="location.href='{{ url('template/enquriycustomertemplate.csv') }}'">
                        </div>
                    </div>
                </div>

               <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Name</label>
                    </div>
                    <div class="col-md-9">
                       <input type="text" placeholder="Enter Customer Name" name="name" value="{{ $username }}" id="name" required>
                   </div>
               </div>

               <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Email</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Enter Email" name="email" value="{{ $useremail }}" id="email" required>
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Phone</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Enter Phone" name="phone" value="{{ $userphone }}" id="phone" required>
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Project name</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Enter Project Name" name="projectname" value="{{ $projectname }}" id="projectname" required>
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-2">
                        <label class="title-input" for="property">Notes</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Enter Notes" name="notes" value="{{ $notes }}" id="notes" required>
                    </div>
                </div>

                {{-- <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>

                <label for="password_confirm"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="password_confirm" id="password_confirm" required> --}}
              <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" type="button" class="registerbtn">Update</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- <form id="maindata">
            <div class="container">
                <span id="alertdata"></span>
                
                <input type="text" id="userid" name="userid" value="{{ $userid }}" hidden>
                <label for="name"><b>Name</b></label>
                <input type="text" placeholder="Enter Agent Name" name="name" value="{{ $username }}" id="name"
                    required>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" value="{{ $useremail }}" id="email" required>

                <label for="phone"><b>Phone</b></label>
                <input type="text" placeholder="Enter Phone" name="phone" value="{{ $userphone }}" id="phone" required>

                <label for="projectname"><b>Project name</b></label>
                <input type="text" placeholder="Enter Project Name" name="projectname" value="{{ $projectname }}" id="projectname" readonly>

                <label for="notes"><b>Notes</b></label>
                <input type="text" placeholder="Enter Notes" name="notes" value="{{ $notes }}" id="notes" readonly>

                {{-- <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>

                <label for="password_confirm"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="password_confirm" id="password_confirm" required> --}}
                <hr>

                <button id="buttonsubmit" type="button" class="registerbtn center">Update</button>
            </div>
        </form> -->




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
    <script>
        $(document).ready(function() {

            $('select.custom-select').val($('select.custom-select > option:last').val()).change();

        });
    </script>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>

    <script>
        $('#buttonsubmit').click(function(e) {
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
                url: "{{ route('update_customer') }}",
                success: function(result) {
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    window.location.href = "{{ route('showbooksindex') }}";
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
                }
            });
        });
    </script>

@endpush
