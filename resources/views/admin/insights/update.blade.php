@extends('layouts.app')

@push('head')
    <title>Update Insight Project</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('images/css/dash.css') }}">

    <style> body { font-family: Arial, Helvetica, sans-serif; background-color: white; } * { box-sizing: border-box; } /* Add padding to containers */ .container { padding: 16px; /* background-color: white;*/ } /* Full-width input fields */ input[type=text], input[type=password] { width: 100%; padding: 15px; margin: 5px 0 22px 0; display: inline-block; border: none; background: #f1f1f1; } input[type=text]:focus, input[type=password]:focus { background-color: #ddd; outline: none; } /* Overwrite default styles of hr */ hr { border: 1px solid #f1f1f1; margin-bottom: 25px; } /* Set a style for the submit button */ .registerbtn { background-color: #70cacc; color: white; padding: 16px 20px; margin: 8px 0; border-radius: 20px; border: none; cursor: pointer; width: 10%; opacity: 0.9; } .center { margin: 0 100 0 0; position: absolute; left: 50%; -ms-transform: translateY(-50%); transform: translateY(-50%); } .registerbtn:hover { opacity: 1; } /* Add a blue text color to links */ a { color: #ef2027; } /* Set a grey background color and center the text of the "sign in" section */ .signin { background-color: #f1f1f1; text-align: center; } .top-title { font-family: 'Lato-Semibold'; font-size: 20px; color: #9D865C; height: 4rem; padding: 14px 35px; border-radius: 0 0px 55px 0; /* background-image:linear-gradient(to right, #211706, #291d0a, #30230c, #39290f, #412f10, #503913, #5f4416, #6e4f19, #88621f, #a37526, #be892c, #db9d33); */ } .sidebar-divider { display: none; } .title-input { color: #143e39; font-family: 'Lato-Bold'; font-size: 13px; } #language{ border-right: 1px solid #70cacc; } #link, #property_name, #image, #details{ font-family: 'Lato-Regular' !important; font-size: 12px !important; display: inline-block; width: 100%; height: calc(2.25rem + 2px); padding: 0.375rem 1.75rem 0.375rem 0.75rem; line-height: 1.5; color: #878b8f; vertical-align: middle; border-radius: 0 !important; background: #fff !important; /* border: 1px solid #fff!important; */ text-align: left; /* border-right: 3px solid #e4aa47!important; */ box-shadow: 0 4px 2px -2px #d9d1d1; } input[type=text], input[type=password] { margin: 0 !important; } #img-top { position: absolute; top: -4px; right: 20px; width: 16rem; } #maindata { /* box-shadow: 0px 0px 4px 1px #6c4d18; */ margin: 5px; /* border: 1px solid #e4aa47; */ border-radius: 5px; padding: 20px 51px; width: 50rem; margin: 5rem auto; } @font-face { font-family: 'Lato-Semibold'; src: url('font/Lato-Semibold.ttf'); } #buttonsubmit { width: 9rem; /* background: #6c4d18; */ padding: 5px 32px; border-radius: 0; font-family: 'Lato-Semibold'; } /*responsive*/ @media(max-width: 1400px) { #bookslist_filter label::before { top: 133px; } #bookslist_filter label::after { top: 127px; } } @media(max-width: 1350px) and (min-width: 1200px) { .top-title { font-size: 16px; } } #bg-top { width: 116%; margin-left: -2rem; margin-top: -4rem; } #bookslist_filter label::after { top: 121px; right: 31px; } #bookslist_filter label::before { top: 126px; right: 281px; } .label h4 { font-size: 15px; } .top-title { font-size: 16px; } @media(max-width: 768px) { #wrapper { height: auto; } .group-button { margin-top: 2rem; } } #wrapper #content-wrapper { padding-bottom: 3rem; } @media(max-width: 500px) { .top-title { font-size: 15px !important; } #maindata { padding: 20px 0px; width: auto; margin: 3rem 1rem 2rem 1rem; } #wrapper { height: 100%; } #bg-top { width: 66%; margin-left: 0; margin-top: 0; } .group-button { margin-top: 0rem !important; } #bookslist_filter label::before { top: 405px !important; right: 189px !important; } } @media (max-width: 500px) { #bookslist_filter label::after { top: 10px !important; right: 42px !important; position: relative; } #bookslist_length { background: transparent; } #img-top { display: none; } } @media (max-width: 1350px) and (min-width: 1200px) { #bookslist_filter label::after { top: 127px; } } @media (max-width: 768px) and (min-width: 600px) { #bookslist_filter label::after { top: 128px; } #maindata { padding: 20px 35px; width: auto !important; margin: 6rem 1rem !important; } } .input_off_plan { border-right: 3px solid #9D865C!important; font-family: 'Lato-Regular' !important; font-size: 12px !important; display: inline-block; width: 100%; height: calc(2.25rem + 2px); padding: 0.375rem 1.75rem 0.375rem 0.75rem; line-height: 1.5; color: #878b8f; vertical-align: middle; border-radius: 0 !important; background: #fff !important; text-align: left; box-shadow: 0 4px 2px -2px #d9d1d1; } /*end responsive*/ </style>
@endpush

@section('wrapper_content')
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-8">
                <h3 class="top-title">Update Insight Project</h3>
            </div>
        </div>
    </div>

    <div id="content-wrapper" class="d-flex flex-column">
        <img id="img-top" src="{{asset('/storage/img/bg-top.png')}}">

        <form id="maindata" enctype="multipart/form-data">
            <div class="container">
                <span id="alertdata"></span>

                {{-- Title --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="title">Title</label></div>
                    <div class="col-md-8">
                        <input type="text" value="{{ $insight->title }}" name="title" id="title" class="input_off_plan" required>
                    </div>
                </div>

                {{-- Slug --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="slug">Slug</label></div>
                    <div class="col-md-8">
                        <input type="text" value="{{ $insight->slug }}" name="slug" id="slug" class="input_off_plan" required>
                    </div>
                </div>

                {{-- Featured --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="feature">Featured</label></div>
                    <div class="col-md-8">
                        <input type="checkbox" name="feature" {{ $insight->isfeatured == 1 ? 'checked' : '' }}>
                    </div>
                </div>

                {{-- Social links --}}
                @foreach(['facebook','instagram','linkedin'] as $social)
                    <div class="row mt-4 mb-4" style="align-items: center;">
                        <div class="col-md-3"><label class="title-input" for="{{ $social }}">{{ ucfirst($social) }}</label></div>
                        <div class="col-md-8">
                            <input type="text" value="{{ $insight->$social }}" name="{{ $social }}" id="{{ $social }}" class="input_off_plan" required>
                        </div>
                    </div>
                @endforeach

                {{-- Shares --}}
                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3"><label class="title-input" for="shares">Shares</label></div>
                    <div class="col-md-8">
                        <input type="number" value="{{ $insight->shares }}" name="shares" id="shares" class="input_off_plan" required>
                    </div>
                </div>

                {{-- Images --}}
                @foreach(['image','first_image','second_image','third_image'] as $i => $field)
                    <div class="row mt-4 mb-4" style="align-items: center;">
                        <div class="col-md-3"><label class="title-input" for="{{ $field }}">{{ ucfirst(str_replace('_',' ',$field)) }}</label></div>
                        <div class="col-md-8">
                            <input type="file" name="{{ $field }}" id="{{ $field }}" style="background: #fff!important">
                            @if($insight->$field)
                                <div class="holder mt-2">
                                    <img src="{{ $insight->$field }}" width="100" height="100" />
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Description Sections --}}
                @php
                    $descriptions = ['one', 'two', 'three', 'four'];
                @endphp

                @foreach($descriptions as $desc)
                    <div class="row mt-4 mb-4 align-items-center">
                        <div class="col-md-3">
                            <label class="title-input">Description {{ ucfirst($desc) }} Title</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text"
                                   name="description_{{ $desc }}_title"
                                   value="{{ $insight->{'description_'.$desc.'_title'} }}"
                                   class="input_off_plan">
                        </div>
                    </div>

                    <div class="row mt-4 mb-4 align-items-center">
                        <div class="col-md-3">
                            <label class="title-input">Description {{ ucfirst($desc) }}</label>
                        </div>
                        <div class="col-md-8">
            <textarea name="description_{{ $desc }}"
                      class="ckeditor input_off_plan">{{ $insight->{'description_'.$desc} }}</textarea>
                        </div>
                    </div>
                @endforeach

                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" class="btn btn-primary" type="button">Update
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            // Slug generation
            $('#title').on('change', function() {
                $('#slug').val($(this).val().toLowerCase().replace(/ /g,'-'));
            });

            // Image previews
            @foreach(['image','first_image','second_image','third_image'] as $field)
            $('#{{ $field }}').change(function() {
                const file = this.files[0];
                if(file){
                    let reader = new FileReader();
                    reader.onload = function(event){
                        $(this).siblings('.holder').find('img').attr('src', event.target.result);
                    }.bind(this);
                    reader.readAsDataURL(file);
                }
            });
            @endforeach

            // Form submit
            $('#buttonsubmit').click(function(e){
                e.preventDefault();
                var formData = new FormData($('#maindata')[0]);

                // Append CKEditor data
                let descriptions = ['one', 'two', 'three', 'four'];
                descriptions.forEach(function(desc) {
                    if (CKEDITOR.instances['description_' + desc]) {
                        formData.append('description_' + desc, CKEDITOR.instances['description_' + desc].getData());
                    }
                });

                $.ajax({
                    url: "{{ route('insight_update', $insight->id) }}",
                    method: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function(){
                        $('#buttonsubmit').attr('disabled', true);
                        $('.spinner-border').removeAttr('hidden');
                    },
                    success: function(result){
                        alert(result.message);
                        window.location.href = "{{ route('insight_list') }}";
                    },
                    error: function(error){
                        console.log(error);
                        alert('Error updating insight!');
                        $('#buttonsubmit').removeAttr('disabled');
                        $('.spinner-border').attr('hidden','hidden');
                    }
                });
            });
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
