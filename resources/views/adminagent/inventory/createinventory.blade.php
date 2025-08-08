@extends('layouts.app')

@push('head')
    <title>Create inventory</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link rel="stylesheet" href="images/css/dash.css">

    <!-- Autocomplete -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;

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
            color: #ef2027;
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
    width: 100%;
    margin: 0;
    filter: alpha(opacity=1);
    opacity: 1;
    background-color: transparent!important;
    color: #8b7777!important;
    padding:9px 24px 5px 24px!important;
}
.file-custom {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 5;
    height: calc(2.25rem + 2px);
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
    height: calc(2.25rem + 2px);
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
    display:none;
}
::-webkit-file-upload-button {
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

form#maindata {
    width: 56rem;
    margin: auto;
    margin-top:5rem;
    box-shadow:none!important;
    border: none!important;
}
#import-title{
    font-family: 'Lato-Semibold';
    font-size: 17px;
    color: #000;
}

#import{
    background-color: #6c4d18;
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

#serial_num, #date_listed, #agent_name,#category,#building_status,#building_status,#client_name,#unit_for_sales,#unit_number,#community_location,#property_type,#bedrooms,#specifications,#property_size,#price_aed,#remarks,#source_of_lead,#developer,#building_name,#property_name,#plot_area,#customer_name,#email_address,#mobile,#comments,#nationality,#furniture,#customer_type,#can_add,#roi,#telephone_number,#telephone_residence,#telephone_office,#general,#property_finder_link,#buyut_link,#dubizzle_link,#wow_propties_link,#other_links,#floors,#service_charge,#payment_plan,#rent,#ready_off,#handover,#bathrooms,#completion,#status {
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
        margin-bottom: 15px!important;
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
  background: #ef2027;
  border-radius: 8px;
}

/* Handle on hover */
div#container-all::-webkit-scrollbar-thumb:hover {
  background: #ef2027;
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
    padding-bottom: 3rem;
}
#buttonsubmit{
        padding: 5px 20px;
    /* background: #15443f; */
    width: 11rem;
    border-radius: 0;
    height: 78%;
    margin: 0;
    font-family: 'Lato-Semibold';
    font-size: 12px;
    /* background-image:linear-gradient(to bottom, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
}

/*responsive*/
@media(max-width: 768px){
    form#maindata{
        width: auto!important;
            margin-top: 4rem;
    }
}
@media(max-width: 500px){
    form#maindata{
        width: auto!important;
            margin-top: 4rem;
    }
    .col-title{
    position: absolute;
    left: 27px;
  }
  #buttonsubmit{
    height: 2rem;
  }
}
@media(max-width: 390px){
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
        <div class="col-lg-4 col-md-5 col-8" >
            <h3 class="top-title">Create inventory
            </h3>
        </div>
    </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- <h3 style="margin: auto" class="mt-4 mb-4">Create inventory</h3> -->
        <form id="maindata">
            <div class="container">
                <span id="alertdata"></span>
                <div class=" mt-3">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="customerenquiry">
                            <h3 id="import-title">Import from csv file</h3>
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
                        <div class="col-lg-4 col-md-6 col-12">
                            <button type="button" id="import" class="btn btn-md btn-success mt-0 mb-3">Import
                            <span id="spinner-import" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                            </button>
                            <input type="button" id="file" name="file" class="btn btn-md btn-success ml-2 mb-3" value="Template"
                            onclick="location.href='{{ url('template/inventory.csv') }}'">
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <label class="sub-title">Community Location</label>
                        </div>
                    </div>
                </div>
                <div id="container-all">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Serial Number" name="serial_num" id="serial_num" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Date Listed" name="date_listed" id="date_listed" required>
                    </div>
                    @if (Auth::user()->isadmin())
                        <div class="col-md-4 col-12">
                            <input type="text" placeholder="Agent Name" name="agent_name" id="agent_name" required>
                        </div>
                    @else
                        <div class="col-md-4 col-12">
                            <input type="text" placeholder="Agent Name" value="{{ Auth::user()->name }}" name="agent_name" id="agent_name" readonly>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <select class="form-control" name="category" id="category" >
                            <option value="">Category</option>
                            <option value="residential">Residential for sale</option>
                            <option value="buyer">Buyer</option>
                            <option value="residential for rent">Residential for rent</option>
                            <option value="land">Land</option>
                            <option value="commercial">Commercial</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <select class="form-control" name="building_status" id="building_status"
                            >
                            <option value="">Building Status</option>
                            <option value="ready">Ready</option>
                            <option value="off-plan">Off-plan</option>
                            <option value="near completion">Near completion</option>
                            <option value="secondary">Secondary</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Building Status" name="building_status" id="building_status"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Client Name" name="client_name" id="client_name" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Unit For Sales" name="unit_for_sales" id="unit_for_sales" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Unit Number" name="unit_number" id="unit_number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Community Location" name="community_location"
                            id="community_location" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <select class="form-control" name="property_type" id="property_type"
                           >
                            <option value="">Property type</option>
                            @foreach ($propertytype as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <select class="form-control" name="bedrooms" id="bedrooms" >
                            <option value="">Bedrooms</option>
                            <option value="studio">Studio</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8+">8+</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Specifications/View" name="specifications" id="specifications"
                            required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Property Size" name="property_size" id="property_size" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Price Aed" name="price_aed" id="price_aed" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Remarks" name="remarks" id="remarks" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <select class="form-control" name="source_of_lead" id="source_of_lead"
                            >
                            <option value="">Source of lead</option>
                            <option value="direct">Direct</option>
                            <option value="website">Website</option>
                            <option value="internal leads">Internal leads</option>
                            <option value="sms">Sms</option>
                            <option value="facebook">Facebook</option>
                            <option value="instagram">Instagram</option>
                            <option value="linkedin">Linkedin</option>
                            <option value="marketing">Marketing</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Developer" name="developer" id="developer" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Building Name" name="building_name" id="building_name" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Property Name" name="property_name" id="property_name" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Plot Area" name="plot_area" id="plot_area" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Customer Name" name="customer_name" id="customer_name" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Email Address" name="email_address" id="email_address" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Mobile" name="mobile" id="mobile" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Comments" name="comments" id="comments" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Nationality" name="nationality" id="nationality" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <select class="form-control" name="furniture" id="furniture" >
                            <option value="">Furniture</option>
                            <option value="none">None</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <select class="form-control" name="customer_type" id="customer_type"
                          >
                            <option value="">Customer type</option>
                            <option value="seller">Seller</option>
                            <option value="buyer">Buyer</option>
                            <option value="rent">Rent</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Can Add" name="can_add" id="can_add" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Roi" name="roi" id="roi" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Telephone Number" name="telephone_number" id="telephone_number"
                            required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Telephone Residence" name="telephone_residence"
                            id="telephone_residence" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Telephone Office" name="telephone_office" id="telephone_office"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="General" name="general" id="general" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Property Finder Link" name="property_finder_link"
                            id="property_finder_link" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Buyut Link" name="buyut_link" id="buyut_link" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Dubizzle Link" name="dubizzle_link" id="dubizzle_link" required>
                    </div>
                    <!-- <div class="col-md-4 col-12">
                        <input type="text" placeholder="Wow Propties Link" name="wow_propties_link" id="wow_propties_link"
                            required>
                    </div> -->
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Other Links" name="other_links" id="other_links" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Floors" name="floors" id="floors" required>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Service Charge" name="service_charge" id="service_charge" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Payment Plan" name="payment_plan" id="payment_plan" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Rent" name="rent" id="rent" required>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Ready Off" name="ready_off" id="ready_off" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Handover" name="handover" id="handover" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Bathrooms" name="bathrooms" id="bathrooms" required>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4 col-12">
                        <input type="text" placeholder="Completion" name="completion" id="completion" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <select name="statuss" id="status" class="form-control" >
                            <option value="">Customer status</option>
                            @foreach ($status as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
                <div class="row" style="border-top: 1px solid #dbdada;padding: 10px 0;margin: 0 2px;">
                    <div class="col-md-4 col-6" style="padding: 0">
                        <label class="sub-title" for="floor_plans_view">Floor plan/view</label>
                    </div>
                    <div class="col-md-4 col-6">
                        <label class="sub-title" for="floor_plans_view">Email Address</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <!-- <label class="sub-title" for="floor_plans_view"> Floor plan/view</label> -->
                        <label class="file">
                        <input type="file" id="floor_plans_view" name="file" class=" mb-5" aria-label="File browser example">
                        <span class="file-custom"></span>
                      </label>
                    </div>
                    <div class="col-md-5 text-right">
                         <button id="buttonsubmit" type="button" class="registerbtn ">Create
                         <span id="spinner-create" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
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
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

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

    <!-- Autocomplete -->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
        $('#buttonsubmit').click(function(e) {
            e.preventDefault();
            var formData = new FormData();

            $('#maindata').serializeArray().forEach(function(field) {
                formData.append(field.name, field.value);
            });

            floor_plans_view = $('#floor_plans_view').prop('files')[0];
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("floor_plans_view", floor_plans_view);

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: "{{ route('create_new_inventory') }}",
                beforeSend: function(){
                    $('#buttonsubmit').attr('disabled','disabled');
                    $('#spinner-create').removeAttr('hidden');
                },
                success: function(result) {
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $("#maindata")[0].reset();
                    $('#buttonsubmit').removeAttr('disabled');
                    $('#spinner-create').attr('hidden','hidden');
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
                    $('#spinner-create').attr('hidden','hidden');
                }
            });
        });

        $('#import').click(function(e) {
            $("#alertdata").empty();
            e.preventDefault();
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append('file', file_data);
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: form_data,
                enctype: 'multipart/form-data',
                url: "{{ route('import_inventory') }}",
                beforeSend: function(){
                    $('#import').attr('disabled','disabled');
                    $('#spinner-import').removeAttr('hidden');
                },
                success: function(result) {
                    if (result.success) {
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                        $('#file').val(null);
                        $('#import').removeAttr('disabled');
                        $('#spinner-import').attr('hidden','hidden');
                    } else {
                        console.log(result);
                        $("#alertdata").empty();
                        $("#alertdata").append("<div class= 'alert alert-danger'>" + result.message +
                            "</div>");
                        $("#alertdata").attr('hidden', false);
                        $('#import').removeAttr('disabled');
                        $('#spinner-import').attr('hidden','hidden');
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
                    $('#import').removeAttr('disabled');
                    $('#spinner-import').attr('hidden','hidden');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var developers = @json($developers);
            var locations = @json($locations);
            $("#developer").autocomplete({
                source: developers
            });
            $("#community_location").autocomplete({
                source: locations
            });
        });
    </script>

@endpush
