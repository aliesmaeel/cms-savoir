@extends('layouts.app')

@push('head')
<title>Update agent</title>

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
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

    #name,
    #email,
    #phone,
    #password,
    #password_confirm,
    #websiteId,
    #brn,
    #Job_Description,
    #bio,
    #image,
    #slug,
    #order,
    #language {
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
            <h3 class="top-title">Update agent</h3>
        </div>
    </div>
</div>
<div id="content-wrapper" class="d-flex flex-column">

    <!-- <h3 style="margin: auto" class="mt-4 mb-4">Update agent</h3> -->
    <form id="maindata">
        <div class="container">
            <span id="alertdata"></span>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Name</label>
                </div>
                <div class="col-md-8">
                    <input type="text" placeholder="Enter Agent Name" name="name" value="{{ $username }}"
                        id="name" required>
                </div>
            </div>

            <div class="col-md-8" hidden-input>
                <input hidden type="text" name="user_id" value="{{ $user_id }}"
                    id="user_id" required>
            </div>

            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Type</label>
                </div>
                <div class="col-md-8">
                    @if (Auth::user()->isadmin())
                    <select name="type" id="name" onclick="showCompanyName(value)">
                        <option {{ $role == '3' ? 'selected' : '' }} value="3">Agent</option>
                        <option {{ $role == '6' ? 'selected' : '' }} value="6">photographer</option>
                    </select>
                    @elseif(Auth::user()->issuperAdmin())
                    <select name="type" id="name" onclick="showCompanyName(value)">
                        <option @if ($role=='1' ) selected @endif value="1">Admin</option>
                        <option @if ($role=='3' ) selected @endif value="3">Agent</option>
                        <option @if ($role=='6' ) selected @endif value="6">photographer
                        </option>
                    </select>
                    @endif
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Email</label>
                </div>
                <div class="col-md-8">
                    <input type="text" placeholder="Enter Email" name="email" value="{{ $useremail }}"
                        id="email" required>
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Phone</label>
                </div>
                <div class="col-md-8">
                    <input type="text" placeholder="Enter Phone" name="phone" value="{{ $userphone }}"
                        id="phone" required>
                </div>
            </div>
            <div class="row mt-4 mb-4" style="align-items: center;">
                <div class="col-md-3">
                    <label class="title-input" for="property">Language</label>
                </div>
                <div class="col-md-8">
                    {{-- <div class="dropdown"> --}}
                    @php
                    $userLanguages = $userlang ? explode(',', $userlang) : [];
                    @endphp
                    <select name="language[]" id="language" class="form-control" multiple required>
                        <option value="Afrikaans" {{ in_array('Afrikaans', $userLanguages) ? 'selected' : '' }}>Afrikaans</option>
                        <option value="Albanian" {{ in_array('Albanian', $userLanguages) ? 'selected' : '' }}>Albanian</option>
                        <option value="Amharic" {{ in_array('Amharic', $userLanguages) ? 'selected' : '' }}>Amharic</option>
                        <option value="Arabic" {{ in_array('Arabic', $userLanguages) ? 'selected' : '' }}>Arabic</option>
                        <option value="Aragonese" {{ in_array('Aragonese', $userLanguages) ? 'selected' : '' }}>Aragonese</option>
                        <option value="Armenian" {{ in_array('Armenian', $userLanguages) ? 'selected' : '' }}>Armenian</option>
                        <option value="Asturian" {{ in_array('Asturian', $userLanguages) ? 'selected' : '' }}>Asturian</option>
                        <option value="Azerbaijani" {{ in_array('Azerbaijani', $userLanguages) ? 'selected' : '' }}>Azerbaijani</option>
                        <option value="Basque" {{ in_array('Basque', $userLanguages) ? 'selected' : '' }}>Basque</option>
                        <option value="Belarusian" {{ in_array('Belarusian', $userLanguages) ? 'selected' : '' }}>Belarusian</option>
                        <option value="Bengali" {{ in_array('Bengali', $userLanguages) ? 'selected' : '' }}>Bengali</option>
                        <option value="Bosnian" {{ in_array('Bosnian', $userLanguages) ? 'selected' : '' }}>Bosnian</option>
                        <option value="Breton" {{ in_array('Breton', $userLanguages) ? 'selected' : '' }}>Breton</option>
                        <option value="Bulgarian" {{ in_array('Bulgarian', $userLanguages) ? 'selected' : '' }}>Bulgarian</option>
                        <option value="Catalan" {{ in_array('Catalan', $userLanguages) ? 'selected' : '' }}>Catalan</option>
                        <option value="Central Kurdish" {{ in_array('Central Kurdish', $userLanguages) ? 'selected' : '' }}>Central Kurdish</option>
                        <option value="Chinese" {{ in_array('Chinese', $userLanguages) ? 'selected' : '' }}>Chinese</option>
                        <option value="Chinese (Hong Kong)" {{ in_array('Chinese (Hong Kong)', $userLanguages) ? 'selected' : '' }}>Chinese (Hong Kong)</option>
                        <option value="Chinese (Simplified)" {{ in_array('Chinese (Simplified)', $userLanguages) ? 'selected' : '' }}>Chinese (Simplified)</option>
                        <option value="Chinese (Traditional)" {{ in_array('Chinese (Traditional)', $userLanguages) ? 'selected' : '' }}>Chinese (Traditional)</option>
                        <option value="Corsican" {{ in_array('Corsican', $userLanguages) ? 'selected' : '' }}>Corsican</option>
                        <option value="Croatian" {{ in_array('Croatian', $userLanguages) ? 'selected' : '' }}>Croatian</option>
                        <option value="Czech" {{ in_array('Czech', $userLanguages) ? 'selected' : '' }}>Czech</option>
                        <option value="Danish" {{ in_array('Danish', $userLanguages) ? 'selected' : '' }}>Danish</option>
                        <option value="Dutch" {{ in_array('Dutch', $userLanguages) ? 'selected' : '' }}>Dutch</option>
                        <option value="English" {{ in_array('English', $userLanguages) ? 'selected' : '' }}>English</option>
                        <option value="English (Australia)" {{ in_array('English (Australia)', $userLanguages) ? 'selected' : '' }}>English (Australia)</option>
                        <option value="English (Canada)" {{ in_array('English (Canada)', $userLanguages) ? 'selected' : '' }}>English (Canada)</option>
                        <option value="English (India)" {{ in_array('English (India)', $userLanguages) ? 'selected' : '' }}>English (India)</option>
                        <option value="English (New Zealand)" {{ in_array('English (New Zealand)', $userLanguages) ? 'selected' : '' }}>English (New Zealand)</option>
                        <option value="English (South Africa)" {{ in_array('English (South Africa)', $userLanguages) ? 'selected' : '' }}>English (South Africa)</option>
                        <option value="English (United Kingdom)" {{ in_array('English (United Kingdom)', $userLanguages) ? 'selected' : '' }}>English (United Kingdom)</option>
                        <option value="English (United States)" {{ in_array('English (United States)', $userLanguages) ? 'selected' : '' }}>English (United States)</option>
                        <option value="Esperanto" {{ in_array('Esperanto', $userLanguages) ? 'selected' : '' }}>Esperanto</option>
                        <option value="Estonian" {{ in_array('Estonian', $userLanguages) ? 'selected' : '' }}>Estonian</option>
                        <option value="Faroese" {{ in_array('Faroese', $userLanguages) ? 'selected' : '' }}>Faroese</option>
                        <option value="Filipino" {{ in_array('Filipino', $userLanguages) ? 'selected' : '' }}>Filipino</option>
                        <option value="Finnish" {{ in_array('Finnish', $userLanguages) ? 'selected' : '' }}>Finnish</option>
                        <option value="French" {{ in_array('French', $userLanguages) ? 'selected' : '' }}>French</option>
                        <option value="French (Canada)" {{ in_array('French (Canada)', $userLanguages) ? 'selected' : '' }}>French (Canada)</option>
                        <option value="French (France)" {{ in_array('French (France)', $userLanguages) ? 'selected' : '' }}>French (France)</option>
                        <option value="French (Switzerland)" {{ in_array('French (Switzerland)', $userLanguages) ? 'selected' : '' }}>French (Switzerland)</option>
                        <option value="Galician" {{ in_array('Galician', $userLanguages) ? 'selected' : '' }}>Galician</option>
                        <option value="Georgian" {{ in_array('Georgian', $userLanguages) ? 'selected' : '' }}>Georgian</option>
                        <option value="German" {{ in_array('German', $userLanguages) ? 'selected' : '' }}>German</option>
                        <option value="German (Austria)" {{ in_array('German (Austria)', $userLanguages) ? 'selected' : '' }}>German (Austria)</option>
                        <option value="German (Germany)" {{ in_array('German (Germany)', $userLanguages) ? 'selected' : '' }}>German (Germany)</option>
                        <option value="German (Liechtenstein)" {{ in_array('German (Liechtenstein)', $userLanguages) ? 'selected' : '' }}>German (Liechtenstein)</option>
                        <option value="German (Switzerland)" {{ in_array('German (Switzerland)', $userLanguages) ? 'selected' : '' }}>German (Switzerland)</option>
                        <option value="Greek" {{ in_array('Greek', $userLanguages) ? 'selected' : '' }}>Greek</option>
                        <option value="Guarani" {{ in_array('Guarani', $userLanguages) ? 'selected' : '' }}>Guarani</option>
                        <option value="Gujarati" {{ in_array('Gujarati', $userLanguages) ? 'selected' : '' }}>Gujarati</option>
                        <option value="Hausa" {{ in_array('Hausa', $userLanguages) ? 'selected' : '' }}>Hausa</option>
                        <option value="Hawaiian" {{ in_array('Hawaiian', $userLanguages) ? 'selected' : '' }}>Hawaiian</option>
                        <option value="Hebrew" {{ in_array('Hebrew', $userLanguages) ? 'selected' : '' }}>Hebrew</option>
                        <option value="Hindi" {{ in_array('Hindi', $userLanguages) ? 'selected' : '' }}>Hindi</option>
                        <option value="Hungarian" {{ in_array('Hungarian', $userLanguages) ? 'selected' : '' }}>Hungarian</option>
                        <option value="Icelandic" {{ in_array('Icelandic', $userLanguages) ? 'selected' : '' }}>Icelandic</option>
                        <option value="Indonesian" {{ in_array('Indonesian', $userLanguages) ? 'selected' : '' }}>Indonesian</option>
                        <option value="Interlingua" {{ in_array('Interlingua', $userLanguages) ? 'selected' : '' }}>Interlingua</option>
                        <option value="Irish" {{ in_array('Irish', $userLanguages) ? 'selected' : '' }}>Irish</option>
                        <option value="Italian" {{ in_array('Italian', $userLanguages) ? 'selected' : '' }}>Italian</option>
                        <option value="Italian (Italy)" {{ in_array('Italian (Italy)', $userLanguages) ? 'selected' : '' }}>Italian (Italy)</option>
                        <option value="Italian (Switzerland)" {{ in_array('Italian (Switzerland)', $userLanguages) ? 'selected' : '' }}>Italian (Switzerland)</option>
                        <option value="Japanese" {{ in_array('Japanese', $userLanguages) ? 'selected' : '' }}>Japanese</option>
                        <option value="Kannada" {{ in_array('Kannada', $userLanguages) ? 'selected' : '' }}>Kannada</option>
                        <option value="Kazakh" {{ in_array('Kazakh', $userLanguages) ? 'selected' : '' }}>Kazakh</option>
                        <option value="Khmer" {{ in_array('Khmer', $userLanguages) ? 'selected' : '' }}>Khmer</option>
                        <option value="Korean" {{ in_array('Korean', $userLanguages) ? 'selected' : '' }}>Korean</option>
                        <option value="Kurdish" {{ in_array('Kurdish', $userLanguages) ? 'selected' : '' }}>Kurdish</option>
                        <option value="Kyrgyz" {{ in_array('Kyrgyz', $userLanguages) ? 'selected' : '' }}>Kyrgyz</option>
                        <option value="Lao" {{ in_array('Lao', $userLanguages) ? 'selected' : '' }}>Lao</option>
                        <option value="Latin" {{ in_array('Latin', $userLanguages) ? 'selected' : '' }}>Latin</option>
                        <option value="Latvian" {{ in_array('Latvian', $userLanguages) ? 'selected' : '' }}>Latvian</option>
                        <option value="Lingala" {{ in_array('Lingala', $userLanguages) ? 'selected' : '' }}>Lingala</option>
                        <option value="Lithuanian" {{ in_array('Lithuanian', $userLanguages) ? 'selected' : '' }}>Lithuanian</option>
                        <option value="Macedonian" {{ in_array('Macedonian', $userLanguages) ? 'selected' : '' }}>Macedonian</option>
                        <option value="Malay" {{ in_array('Malay', $userLanguages) ? 'selected' : '' }}>Malay</option>
                        <option value="Malayalam" {{ in_array('Malayalam', $userLanguages) ? 'selected' : '' }}>Malayalam</option>
                        <option value="Maltese" {{ in_array('Maltese', $userLanguages) ? 'selected' : '' }}>Maltese</option>
                        <option value="Marathi" {{ in_array('Marathi', $userLanguages) ? 'selected' : '' }}>Marathi</option>
                        <option value="Mongolian" {{ in_array('Mongolian', $userLanguages) ? 'selected' : '' }}>Mongolian</option>
                        <option value="Nepali" {{ in_array('Nepali', $userLanguages) ? 'selected' : '' }}>Nepali</option>
                        <option value="Norwegian" {{ in_array('Norwegian', $userLanguages) ? 'selected' : '' }}>Norwegian</option>
                        <option value="Norwegian Bokmål" {{ in_array('Norwegian Bokmål', $userLanguages) ? 'selected' : '' }}>Norwegian Bokmål</option>
                        <option value="Norwegian Nynorsk" {{ in_array('Norwegian Nynorsk', $userLanguages) ? 'selected' : '' }}>Norwegian Nynorsk</option>
                        <option value="Occitan" {{ in_array('Occitan', $userLanguages) ? 'selected' : '' }}>Occitan</option>
                        <option value="Oriya" {{ in_array('Oriya', $userLanguages) ? 'selected' : '' }}>Oriya</option>
                        <option value="Oromo" {{ in_array('Oromo', $userLanguages) ? 'selected' : '' }}>Oromo</option>
                        <option value="Pashto" {{ in_array('Pashto', $userLanguages) ? 'selected' : '' }}>Pashto</option>
                        <option value="Persian" {{ in_array('Persian', $userLanguages) ? 'selected' : '' }}>Persian</option>
                        <option value="Polish" {{ in_array('Polish', $userLanguages) ? 'selected' : '' }}>Polish</option>
                        <option value="Portuguese" {{ in_array('Portuguese', $userLanguages) ? 'selected' : '' }}>Portuguese</option>
                        <option value="Portuguese (Brazil)" {{ in_array('Portuguese (Brazil)', $userLanguages) ? 'selected' : '' }}>Portuguese (Brazil)</option>
                        <option value="Portuguese (Portugal)" {{ in_array('Portuguese (Portugal)', $userLanguages) ? 'selected' : '' }}>Portuguese (Portugal)</option>
                        <option value="Punjabi" {{ in_array('Punjabi', $userLanguages) ? 'selected' : '' }}>Punjabi</option>
                        <option value="Quechua" {{ in_array('Quechua', $userLanguages) ? 'selected' : '' }}>Quechua</option>
                        <option value="Romanian" {{ in_array('Romanian', $userLanguages) ? 'selected' : '' }}>Romanian</option>
                        <option value="Romanian (Moldova)" {{ in_array('Romanian (Moldova)', $userLanguages) ? 'selected' : '' }}>Romanian (Moldova)</option>
                        <option value="Romansh" {{ in_array('Romansh', $userLanguages) ? 'selected' : '' }}>Romansh</option>
                        <option value="Russian" {{ in_array('Russian', $userLanguages) ? 'selected' : '' }}>Russian</option>
                        <option value="Scottish Gaelic" {{ in_array('Scottish Gaelic', $userLanguages) ? 'selected' : '' }}>Scottish Gaelic</option>
                        <option value="Serbian" {{ in_array('Serbian', $userLanguages) ? 'selected' : '' }}>Serbian</option>
                        <option value="Serbo" {{ in_array('Serbo', $userLanguages) ? 'selected' : '' }}>Serbo</option>
                        <option value="Shona" {{ in_array('Shona', $userLanguages) ? 'selected' : '' }}>Shona</option>
                        <option value="Sindhi" {{ in_array('Sindhi', $userLanguages) ? 'selected' : '' }}>Sindhi</option>
                        <option value="Sinhala" {{ in_array('Sinhala', $userLanguages) ? 'selected' : '' }}>Sinhala</option>
                        <option value="Slovak" {{ in_array('Slovak', $userLanguages) ? 'selected' : '' }}>Slovak</option>
                        <option value="Slovenian" {{ in_array('Slovenian', $userLanguages) ? 'selected' : '' }}>Slovenian</option>
                        <option value="Somali" {{ in_array('Somali', $userLanguages) ? 'selected' : '' }}>Somali</option>
                        <option value="Southern Sotho" {{ in_array('Southern Sotho', $userLanguages) ? 'selected' : '' }}>Southern Sotho</option>
                        <option value="Spanish" {{ in_array('Spanish', $userLanguages) ? 'selected' : '' }}>Spanish</option>
                        <option value="Spanish (Argentina)" {{ in_array('Spanish (Argentina)', $userLanguages) ? 'selected' : '' }}>Spanish (Argentina)</option>
                        <option value="Spanish (Latin America)" {{ in_array('Spanish (Latin America)', $userLanguages) ? 'selected' : '' }}>Spanish (Latin America)</option>
                        <option value="Spanish (Mexico)" {{ in_array('Spanish (Mexico)', $userLanguages) ? 'selected' : '' }}>Spanish (Mexico)</option>
                        <option value="Spanish (Spain)" {{ in_array('Spanish (Spain)', $userLanguages) ? 'selected' : '' }}>Spanish (Spain)</option>
                        <option value="Spanish (United States)" {{ in_array('Spanish (United States)', $userLanguages) ? 'selected' : '' }}>Spanish (United States)</option>
                        <option value="Sundanese" {{ in_array('Sundanese', $userLanguages) ? 'selected' : '' }}>Sundanese</option>
                        <option value="Swahili" {{ in_array('Swahili', $userLanguages) ? 'selected' : '' }}>Swahili</option>
                        <option value="Swedish" {{ in_array('Swedish', $userLanguages) ? 'selected' : '' }}>Swedish</option>
                        <option value="Tajik" {{ in_array('Tajik', $userLanguages) ? 'selected' : '' }}>Tajik</option>
                        <option value="Tamil" {{ in_array('Tamil', $userLanguages) ? 'selected' : '' }}>Tamil</option>
                        <option value="Tatartt" {{ in_array('Tatartt', $userLanguages) ? 'selected' : '' }}>Tatar</option>
                        <option value="Telugu" {{ in_array('Telugu', $userLanguages) ? 'selected' : '' }}>Telugu</option>
                        <option value="Thai" {{ in_array('Thai', $userLanguages) ? 'selected' : '' }}>Thai</option>
                        <option value="Tigrinya" {{ in_array('Tigrinya', $userLanguages) ? 'selected' : '' }}>Tigrinya</option>
                        <option value="Tongan" {{ in_array('Tongan', $userLanguages) ? 'selected' : '' }}>Tongan</option>
                        <option value="Turkish" {{ in_array('Turkish', $userLanguages) ? 'selected' : '' }}>Turkish</option>
                        <option value="Turkmen" {{ in_array('Turkmen', $userLanguages) ? 'selected' : '' }}>Turkmen</option>
                        <option value="Twi" {{ in_array('Twi', $userLanguages) ? 'selected' : '' }}>Twi</option>
                        <option value="Ukrainian" {{ in_array('Ukrainian', $userLanguages) ? 'selected' : '' }}>Ukrainian</option>
                        <option value="Urdu" {{ in_array('Urdu', $userLanguages) ? 'selected' : '' }}>Urdu</option>
                        <option value="Uyghur" {{ in_array('Uyghur', $userLanguages) ? 'selected' : '' }}>Uyghur</option>
                        <option value="Uzbek" {{ in_array('Uzbek', $userLanguages) ? 'selected' : '' }}>Uzbek</option>
                        <option value="Vietnamese" {{ in_array('Vietnamese', $userLanguages) ? 'selected' : '' }}>Vietnamese</option>
                        <option value="Walloon" {{ in_array('Walloon', $userLanguages) ? 'selected' : '' }}>Walloon</option>
                        <option value="Welsh" {{ in_array('Welsh', $userLanguages) ? 'selected' : '' }}>Welsh</option>
                        <option value="Western Frisian" {{ in_array('Western Frisian', $userLanguages) ? 'selected' : '' }}>Western Frisian</option>
                        <option value="Xhosa" {{ in_array('Xhosa', $userLanguages) ? 'selected' : '' }}>Xhosa</option>
                        <option value="Yiddish" {{ in_array('Yiddish', $userLanguages) ? 'selected' : '' }}>Yiddish</option>
                        <option value="Yoruba" {{ in_array('Yoruba', $userLanguages) ? 'selected' : '' }}>Yoruba</option>
                        <option value="Zulu" {{ in_array('Zulu', $userLanguages) ? 'selected' : '' }}>Zulu</option>
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
                        <input type="text" placeholder="Enter Website Id" name="websiteId" id="websiteId"
                            value="{{ $websiteId }}" required>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">BRN#</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter BRN" name="brn" value="{{ $brn }}"
                            id="brn" style="background: #fff!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Job Description</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Job Description" name="Job_Description"
                            value="{{ $Job_Description }}" id="Job_Description" required
                            style="background: #fff!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Slug</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Slug" name="slug"
                            value="{{ $slug }}" id="slug" required
                            style="background: #fff!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Order</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter Order" name="order"
                            value="{{ $order }}" id="order"
                            style="background: #fff!important">
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">BIO</label>
                    </div>
                    <div class="col-md-8">
                        <textarea type="text" class="ckeditor input-form" placeholder="Enter BIO" name="bio" id="bio"
                            style="background: #fff!important">{!! $bio !!}</textarea>
                    </div>
                </div>
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" placeholder="Enter Image" name="image" id="image"
                            style="background: #fff!important">

                        <img src="{{$image}}" alt="" width="75px"
                            height="75px">

                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Without border Image</label>
                    </div>
                    <div class="col-md-8 " style="display: flex;flex-direction: column">
                        <input type="file" placeholder="Enter Image" name="image_border" id="image_border"
                            style="background: #fff!important">
                        @if($image_border)
                        <img src="{{$image_border}}" alt="" width="75px"
                            height="75px">
                        @endif
                    </div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="property">Publish TO Website</label>
                    </div>
                    <div class="col-md-8">
                        <input type="checkbox" name="publish_to_web_site" <?php if ($publish_to_web_site == "1") { ?>
                            checked="checked" <?php } ?> value=1 id="publish_to_web_site">
                        <label class="title-input" for="publish_to_web_site"> </label>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <button id="buttonsubmit" type="button" class="registerbtn">Update
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            hidden></span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- <form id="maindata">
                                    <div class="container">
                                        <span id="alertdata"></span>

                                        <input type="text" id="userid" name="userid" value="{{ $userid }}" hidden>

                                        <label for="name"><b>Name</b></label>
                                        <input type="text" placeholder="Enter Agent Name" name="name" value="{{ $username }}" id="name" required>

                                        <label for="email"><b>Email</b></label>
                                        <input type="text" placeholder="Enter Email" name="email" readonly value="{{ $useremail }}" id="email" required>

                                        <label for="phone"><b>Phone</b></label>
                                        <input type="text" placeholder="Enter Phone" name="phone" value="{{ $userphone }}" id="phone" required>

                                        <label for="password"><b>Password</b></label>
                                        <input type="password" placeholder="Enter Password" name="password" id="password" required>

                                        <label for="password_confirm"><b>Repeat Password</b></label>
                                        <input type="password" placeholder="Repeat Password" name="password_confirm" id="password_confirm" required>
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

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
</script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#language').select2({
            placeholder: 'Select Language(s)',

            allowClear: true,
            width: '100%'
        });

        $('.ckeditor').ckeditor();


    });
</script>
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
        for (let i = 0; i < FloorPlan; i++) {
            formData.append('floorplans' + i, floorplans.files[i]);
        }

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
            url: "{{ route('update_user') }}",
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
                    $('#buttonsubmit').removeAttr('disabled');
                    $('.spinner-border').attr('hidden', 'hidden');
                    window.location.href = "{{ route('list_users_index') }}";
                } else {
                    console.log(result);
                    $("#alertdata").empty();
                    $("#alertdata").append("<div class= 'alert alert-danger'>" + result.message +
                        "</div>");
                    $("#alertdata").attr('hidden', false);
                    $('#buttonsubmit').removeAttr('disabled');
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
                $('#buttonsubmit').removeAttr('disabled');
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
<script>
    $(document).ready(function() {
        showCompanyName({
            {
                $role
            }
        });
    });
</script>
@endpush