@extends('layouts.app')

@push('head')
<title>Create User</title>

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
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.4.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />

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
        /*  background-color: white;*/
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

    .top-title {
        font-family: 'Lato-Semibold';
        font-size: 20px;
        color: #9D865C;
        height: 4rem;
        padding: 14px 35px;

        border-radius: 0 0px 55px 0;
        /* background-image:linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */
    }

    .sidebar-divider {
        display: none;
    }

    .title-input {
        color: #143e39;
        font-family: 'Lato-Bold';
        font-size: 13px;
    }

    #language {
        border-right: 1px solid #70cacc;
    }

    #name,
    #email,
    #phone,
    #password,
    #password_confirm,
    #websiteId,
    #brn,
    #Job_Description,
    #bio,
    #slug,
    #image,
    #order,
    /* #publish_to_web_site, */
    #language {
        font-family: 'Lato-Regular' !important;
        font-size: 12px !important;
        display: inline-block;
        width: 100%;
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

    /* Better styling for Select2 language field */
    .select2-container--bootstrap4 .select2-selection {
        border-right: 1px solid #70cacc !important;
        border-radius: 0 !important;
        box-shadow: 0 4px 2px -2px #d9d1d1 !important;
        min-height: 38px;
    }

    .select2-container--bootstrap4 .select2-selection__rendered {
        font-family: 'Lato-Regular' !important;
        font-size: 12px !important;
        color: #878b8f !important;
    }

    .select2-container--bootstrap4 .select2-selection__choice {
        background-color: #70cacc !important;
        border-color: #70cacc !important;
        color: white !important;
        font-family: 'Lato-Regular' !important;
        font-size: 12px !important;
    }

    input[type=text],
    input[type=password] {
        margin: 0 !important;
    }

    #img-top {
        position: absolute;
        top: -4px;
        right: 20px;
        width: 16rem;
    }

    #maindata {
        /* box-shadow: 0px 0px 4px 1px #6c4d18; */
        margin: 5px;
        /* border: 1px solid #e4aa47; */
        border-radius: 5px;
        padding: 20px 51px;
        width: 50rem;
        margin: 5rem auto;
    }







    #buttonsubmit {
        width: 10rem;
        /* background: #6c4d18; */
        padding: 5px 32px;
        border-radius: 0;
        font-family: 'Lato-Semibold';
    }

    /*responsive*/
    @media(max-width: 1400px) {
        #bookslist_filter label::before {
            top: 133px;
        }

        #bookslist_filter label::after {
            top: 127px;
        }
    }

    @media(max-width: 1350px) and (min-width: 1200px) {
        .top-title {
            font-size: 16px;

        }
    }

    #bg-top {
        width: 116%;
        margin-left: -2rem;
        margin-top: -4rem;
    }

    #bookslist_filter label::after {
        top: 121px;
        right: 31px;
    }

    #bookslist_filter label::before {
        top: 126px;
        right: 281px;
    }

    .label h4 {
        font-size: 15px;
    }

    .top-title {
        font-size: 16px;
    }

    @media(max-width: 768px) {
        #wrapper {
            height: auto;
        }

        .group-button {
            margin-top: 2rem;
        }


    }

    #wrapper #content-wrapper {
        padding-bottom: 3rem;
    }

    @media(max-width: 500px) {
        .top-title {
            font-size: 15px !important;

        }

        #maindata {
            padding: 20px 0px;
            width: auto;
            margin: 3rem 1rem 2rem 1rem;
        }

        #wrapper {
            height: 100%;
        }

        #bg-top {
            width: 66%;
            margin-left: 0;
            margin-top: 0;
        }

        .group-button {
            margin-top: 0rem !important;
        }

        #bookslist_filter label::before {
            top: 405px !important;
            right: 189px !important;
        }
    }

    @media (max-width: 500px) {
        #bookslist_filter label::after {
            top: 10px !important;
            right: 42px !important;
            position: relative;
        }

        #bookslist_length {
            background: transparent;
        }

        #img-top {
            display: none;
        }
    }

    @media (max-width: 1350px) and (min-width: 1200px) {
        #bookslist_filter label::after {
            top: 127px;
        }
    }

    @media (max-width: 768px) and (min-width: 600px) {
        #bookslist_filter label::after {
            top: 128px;
        }

        #maindata {
            padding: 20px 35px;
            width: auto !important;
            margin: 6rem 1rem !important;
        }
    }

    /*end responsive*/
</style>
@endpush

@section('wrapper_content')
<!-- Content Wrapper -->
<div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-8">
            <h3 class="top-title">Create User</h3>
        </div>
    </div>
</div>
<div id="content-wrapper" class="d-flex flex-column">
    <img id="img-top" src="{{ asset('img/bg-top.png') }}">
    <!-- <h3 style="margin: auto" class="mt-4 mb-4">Create new agent</h3> -->
    <form id="maindata">
        <div class="container">
            <span id="alertdata"></span>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Name</label>
                </div>
                <div class="col-md-8">
                    <input type="text" placeholder="Enter Agent Name" name="name" id="name" required>
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Type</label>
                </div>
                <div class="col-md-8">
                    @if (Auth::user()->isadmin())
                    <select name="type" id="name" onclick="showCompanyName(value)">
                        <option value="">select user Type</option>
                        <option value="3">Agent</option>
                        <option value="6">photographer</option>
                    </select>
                    @elseif(Auth::user()->issuperAdmin())
                    <select name="type" id="name" onclick="showCompanyName(value)">
                        <option value="">select user Type</option>
                        <option value="1">Admin</option>
                        <option value="3">Agent</option>
                        <option value="6">photographer</option>
                    </select>
                    @endif
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Email</label>
                </div>
                <div class="col-md-8">
                    <input type="text" placeholder="Enter Email" name="email" id="email" required>
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Phone</label>
                </div>
                <div class="col-md-8">
                    <input type="text" placeholder="Enter Phone" name="phone" id="phone" required>
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="language">Language</label>
                </div>
                <div class="col-md-8">
                    {{-- <div class="dropdown"> --}}
                    <select name="language[]" id="language" class="form-control" multiple required>
                        <option value="Afrikaans">Afrikaans</option>
                        <option value="Albanian">Albanian</option>
                        <option value="Amharic">Amharic</option>
                        <option value="Arabic">Arabic</option>
                        <option value="Aragonese">Aragonese</option>
                        <option value="Armenian">Armenian</option>
                        <option value="Asturian">Asturian</option>
                        <option value="Azerbaijani">Azerbaijani</option>
                        <option value="Basque">Basque</option>
                        <option value="Belarusian">Belarusian</option>
                        <option value="Bengali">Bengali</option>
                        <option value="Bosnian">Bosnian</option>
                        <option value="Breton">Breton</option>
                        <option value="Bulgarian">Bulgarian</option>
                        <option value="Catalan">Catalan</option>
                        <option value="Central Kurdish">Central Kurdish</option>
                        <option value="Chinese">Chinese</option>
                        <option value="Chinese (Hong Kong)">Chinese (Hong Kong)</option>
                        <option value="Chinese (Simplified)">Chinese (Simplified)</option>
                        <option value="Chinese (Traditional)">Chinese (Traditional)</option>
                        <option value="Corsican">Corsican</option>
                        <option value="Croatian">Croatian</option>
                        <option value="Czech">Czech</option>
                        <option value="Danish">Danish</option>
                        <option value="Dutch">Dutch</option>
                        <option value="English">English</option>
                        <option value="English (Australia)">English (Australia)</option>
                        <option value="English (Canada)">English (Canada)</option>
                        <option value="English (India)">English (India)</option>
                        <option value="English (New Zealand)">English (New Zealand)</option>
                        <option value="English (South Africa)">English (South Africa)</option>
                        <option value="English (United Kingdom)">English (United Kingdom)</option>
                        <option value="English (United States)">English (United States)</option>
                        <option value="Esperanto">Esperanto</option>
                        <option value="Estonian">Estonian</option>
                        <option value="Faroese">Faroese</option>
                        <option value="Filipino">Filipino</option>
                        <option value="Finnish">Finnish</option>
                        <option value="French">French</option>
                        <option value="French (Canada)">French (Canada)</option>
                        <option value="French (France)">French (France)</option>
                        <option value="French (Switzerland)">French (Switzerland)</option>
                        <option value="Galician">Galician</option>
                        <option value="Georgian">Georgian</option>
                        <option value="German">German</option>
                        <option value="German (Austria)">German (Austria)</option>
                        <option value="German (Germany)">German (Germany)</option>
                        <option value="German (Liechtenstein)">German (Liechtenstein)</option>
                        <option value="German (Switzerland)">German (Switzerland)</option>
                        <option value="Greek">Greek</option>
                        <option value="Guarani">Guarani</option>
                        <option value="Gujarati">Gujarati</option>
                        <option value="Hausa">Hausa</option>
                        <option value="Hawaiian">Hawaiian</option>
                        <option value="Hebrew">Hebrew</option>
                        <option value="Hindi">Hindi</option>
                        <option value="Hungarian">Hungarian</option>
                        <option value="Icelandic">Icelandic</option>
                        <option value="Indonesian">Indonesian</option>
                        <option value="Interlingua">Interlingua</option>
                        <option value="Irish">Irish</option>
                        <option value="Italian">Italian</option>
                        <option value="Italian (Italy)">Italian (Italy)</option>
                        <option value="Italian (Switzerland)">Italian (Switzerland)</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Kannada">Kannada</option>
                        <option value="Kazakh">Kazakh</option>
                        <option value="Khmer">Khmer</option>
                        <option value="Korean">Korean</option>
                        <option value="Kurdish">Kurdish</option>
                        <option value="Kyrgyz">Kyrgyz</option>
                        <option value="Lao">Lao</option>
                        <option value="Latin">Latin</option>
                        <option value="Latvian">Latvian</option>
                        <option value="Lingala">Lingala</option>
                        <option value="Lithuanian">Lithuanian</option>
                        <option value="Macedonian">Macedonian</option>
                        <option value="Malay">Malay</option>
                        <option value="Malayalam">Malayalam</option>
                        <option value="Maltese">Maltese</option>
                        <option value="Marathi">Marathi</option>
                        <option value="Mongolian">Mongolian</option>
                        <option value="Nepali">Nepali</option>
                        <option value="Norwegian">Norwegian</option>
                        <option value="Norwegian Bokmål">Norwegian Bokmål</option>
                        <option value="Norwegian Nynorsk">Norwegian Nynorsk</option>
                        <option value="Occitan">Occitan</option>
                        <option value="Oriya">Oriya</option>
                        <option value="Oromo">Oromo</option>
                        <option value="Pashto">Pashto</option>
                        <option value="Persian">Persian</option>
                        <option value="Polish">Polish</option>
                        <option value="Portuguese">Portuguese</option>
                        <option value="Portuguese (Brazil)">Portuguese (Brazil)</option>
                        <option value="Portuguese (Portugal)">Portuguese (Portugal)</option>
                        <option value="Punjabi">Punjabi</option>
                        <option value="Quechua">Quechua</option>
                        <option value="Romanian">Romanian</option>
                        <option value="Romanian (Moldova)">Romanian (Moldova)</option>
                        <option value="Romansh">Romansh</option>
                        <option value="Russian">Russian</option>
                        <option value="Scottish Gaelic">Scottish Gaelic</option>
                        <option value="Serbian">Serbian</option>
                        <option value="Serbo">Serbo</option>
                        <option value="Shona">Shona</option>
                        <option value="Sindhi">Sindhi</option>
                        <option value="Sinhala">Sinhala</option>
                        <option value="Slovak">Slovak</option>
                        <option value="Slovenian">Slovenian</option>
                        <option value="Somali">Somali</option>
                        <option value="Southern Sotho">Southern Sotho</option>
                        <option value="Spanish">Spanish</option>
                        <option value="Spanish (Argentina)">Spanish (Argentina)</option>
                        <option value="Spanish (Latin America)">Spanish (Latin America)</option>
                        <option value="Spanish (Mexico)">Spanish (Mexico)</option>
                        <option value="Spanish (Spain)">Spanish (Spain)</option>
                        <option value="Spanish (United States)">Spanish (United States)</option>
                        <option value="Sundanese">Sundanese</option>
                        <option value="Swahili">Swahili</option>
                        <option value="Swedish">Swedish</option>
                        <option value="Tajik">Tajik</option>
                        <option value="Tamil">Tamil</option>
                        <option value="Tatartt">Tatar</option>
                        <option value="Telugu">Telugu</option>
                        <option value="Thai">Thai</option>
                        <option value="Tigrinya">Tigrinya</option>
                        <option value="Tongan">Tongan</option>
                        <option value="Turkish">Turkish</option>
                        <option value="Turkmen">Turkmen</option>
                        <option value="Twi">Twi</option>
                        <option value="Ukrainian">Ukrainian</option>
                        <option value="Urdu">Urdu</option>
                        <option value="Uyghur">Uyghur</option>
                        <option value="Uzbek">Uzbek</option>
                        <option value="Vietnamese">Vietnamese</option>
                        <option value="Walloon">Walloon</option>
                        <option value="Welsh">Welsh</option>
                        <option value="Western Frisian">Western Frisian</option>
                        <option value="Xhosa">Xhosa</option>
                        <option value="Yiddish">Yiddish</option>
                        <option value="Yoruba">Yoruba</option>
                        <option value="Zulu">Zulu</option>
                    </select>
                    {{-- </div> --}}
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Password</label>
                </div>
                <div class="col-md-8">
                    <input type="password" placeholder="Enter Password" name="password" id="password" required
                        style="background: #fff!important">
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Repeat Password</label>
                </div>
                <div class="col-md-8">
                    <input type="password" placeholder="Repeat Password" name="password_confirm"
                        id="password_confirm" required>
                </div>
            </div>
            <div class="mb-3 form-group" style="" id="company_input">

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Website Id</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Website Id" name="websiteId"
                            id="websiteId" required>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">BRN#</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter BRN" name="brn" id="brn"
                            style="background: #fff!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Job Description</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Job Description" name="Job_Description"
                            id="Job_Description" required
                            style="background: #fff!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Slug</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Slug" name="slug" id="slug" required
                            style="background: #fff!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Order</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Order" name="order" id="order"
                            style="background: #fff!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">BIO</label>
                    </div>
                    <div class="col-md-8">
                        <textarea type="text" class="ckeditor input-form" placeholder="Enter BIO" name="bio" id="bio"
                            style="background: #fff!important"></textarea>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" placeholder="Enter Image" name="image" id="image"
                            style="background: #fff!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Without border Image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" placeholder="Enter Image" name="image_border" id="image_border"
                            style="background: #fff!important">
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Publish TO Website</label>
                    </div>
                    <div class="col-md-8">
                        <input type="checkbox" name="publish_to_web_site" value="1" id="publish_to_web_site">
                        <label class="title-input" for="publish_to_web_site"> </label>
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Is Agent</label>
                    </div>
                    <div class="col-md-8">
                        <input type="checkbox" name="is_external_agent" value="1" id="is_external_agent">
                        <label class="title-input" for="is_external_agent"> </label>
                    </div>
                </div>

            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <button id="buttonsubmit" type="button" class="registerbtn">Create
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            hidden></span>
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

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
</script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $('#buttonsubmit').click(function(e) {
        e.preventDefault();
        var formData = new FormData();

        $('#maindata').serializeArray().forEach(function(field) {
            formData.append(field.name, field.value);
        });

        formData.append("_token", "{{ csrf_token() }}");

        let FloorPlan = $('#image')[0].files.length; //Total image
        let floorplans = $('#image')[0];
        formData.append('floorplans', floorplans.files[0]);

        let FloorPlanBorder = $('#image_border')[0].files.length; //Total image
        let floorplansBorder = $('#image_border')[0];
        formData.append('floorplansBorder', floorplansBorder.files[0]);

        formData.append('FloorPlan', FloorPlan);
        var bio = CKEDITOR.instances.bio.getData();
        formData.append('bio', bio);
        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            enctype: 'multipart/form-data',
            url: "{{ route('create_new_user') }}",
            beforeSend: function() {
                $('#buttonsubmit').attr('disabled', 'disabled');
                $('.spinner-border').removeAttr('hidden');
            },
            success: function(result) {
                if (result.success) {
                    console.log(result);
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-success'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $("#maindata")[0].reset();
                    $("#buttonsubmit").removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
                    window.location.href = "{{ route('list_users_index') }}";
                } else {
                    console.log(result);
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-danger'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $("#buttonsubmit").removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
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
                $("#buttonsubmit").removeAttr('disabled');
                $('.spinner-border').attr('hidden', 'hidden');
            }
        });
    });
</script>
<script>
    function showCompanyName(value) {
        var checkBox = document.getElementById("name");
        var text = document.getElementById("company_input");
        if (value == "3" || value == "6") {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }
</script>

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $('#language').select2({
        placeholder: 'Select Language(s)',
        allowClear: true,
        width: '100%'
    });

    $(document).ready(function() {
        $('.ckeditor').ckeditor();

        // Initialize Select2 on language select

    });
</script>
@endpush
