@extends('layouts.app')

@push('head')
    <title>Update Blog</title>

    <!-- Custom fonts & styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.semanticui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('images/css/dash.css') }}">

    <style>
        body { font-family: Arial, Helvetica, sans-serif; background-color: white; }
        * { box-sizing: border-box; }
        .container { padding: 16px; }
        input[type=text], textarea { width: 100%; padding: 15px; margin: 5px 0 22px 0; border: none; background: #f1f1f1; }
        input[type=text]:focus, textarea:focus { background-color: #ddd; outline: none; }
        .registerbtn { background-color: #70cacc; color: white; padding: 16px 20px; margin: 8px 0; border-radius: 20px; border: none; cursor: pointer; width: 10%; opacity: 0.9; }
        .registerbtn:hover { opacity: 1; }
        .input_off_plan { font-family: 'Lato-Regular' !important; font-size: 12px !important; width: 100%; height: calc(2.25rem + 2px); padding: 0.375rem 1.75rem 0.375rem 0.75rem; line-height: 1.5; color: #878b8f; background: #fff !important; box-shadow: 0 4px 2px -2px #d9d1d1; border-radius: 0 !important; }
        .top-title { font-size: 16px; font-family: 'Lato-Semibold'; color: #9D865C; height: 4rem; padding: 14px 35px; border-radius: 0 0 55px 0; }
        #maindata { border-radius: 5px; padding: 20px 51px; width: 50rem; margin: 5rem auto; }
        #img-top { position: absolute; top: -4px; right: 20px; width: 16rem; }
    </style>
@endpush

@section('wrapper_content')
    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-8">
                <h3 class="top-title">Update Blog</h3>
            </div>
        </div>
    </div>

    <div id="content-wrapper" class="d-flex flex-column">
        <img id="img-top" src="{{asset('/storage/img/bg-top.png')}}">

        <form id="maindata" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <span id="alertdata"></span>

                <!-- Title -->
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Title</label></div>
                    <div class="col-md-8"><input type="text" value="{{ $blog->title }}" name="title" class="input_off_plan" required></div>
                </div>

                <div class="row mt-4 mb-4" style="align-items: center;">
                    <div class="col-md-3">
                        <label class="title-input" for="title_details">Title in Details Page</label>
                    </div>
                    <div class="col-md-8">
                        <textarea class="ckeditor input-form" name="title_details" id="title_details" style="background: #fff!important">
                            {{ $blog->title_details }}
                        </textarea>
                    </div>
                </div>

                <!-- Slug -->
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Slug</label></div>
                    <div class="col-md-8"><input type="text" value="{{ $blog->slug }}" name="slug" id="slug" class="input_off_plan" required></div>
                </div>

                <!-- Posted By -->
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Posted By</label></div>
                    <div class="col-md-8"><input type="text" value="{{ $blog->posted_by }}" name="posted_by" class="input_off_plan" required></div>
                </div>

                <!-- Date -->
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Date</label></div>
                    <div class="col-md-8"><input type="date" value="{{ $blog->date }}" name="date" class="input_off_plan" required></div>
                </div>

                <!-- Main Image -->
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Main Image</label></div>
                    <div class="col-md-8">
                        <input type="file" name="image" id="image" style="background: #fff!important">
                        <div class="holder mt-4">
                            <img id="imgPreview" src="{{ $blog_image->url }}" width="100" height="100"/>
                        </div>
                    </div>
                </div>

                <!-- Descriptions -->
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
                                   value="{{ $blog->{'description_'.$desc.'_title'} }}"
                                   class="input_off_plan">
                        </div>
                    </div>

                    <div class="row mt-4 mb-4 align-items-center">
                        <div class="col-md-3">
                            <label class="title-input">Description {{ ucfirst($desc) }}</label>
                        </div>
                        <div class="col-md-8">
            <textarea name="description_{{ $desc }}"
                      class="ckeditor input_off_plan">{{ $blog->{'description_'.$desc} }}</textarea>
                        </div>
                    </div>
                @endforeach

                <!-- Additional Images -->
                @foreach(['first_image', 'second_image', 'third_image'] as $img)
                    <div class="row mt-4 mb-4 align-items-center">
                        <div class="col-md-3"><label class="title-input">{{ ucfirst(str_replace('_',' ',$img)) }}</label></div>
                        <div class="col-md-8">
                            <input type="file" name="{{ $img }}" id="{{ $img }}" style="background: #fff!important">
                            <div class="holder mt-4">
                                <img id="imgPreview_{{ $img }}" src="{{ $blog->$img }}" width="100" height="100"/>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Facebook</label></div>
                    <div class="col-md-8"><input type="text" value="{{ $blog->facebook }}" name="facebook" class="input_off_plan" required></div>
                </div>
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">LinkedIn</label></div>
                    <div class="col-md-8"><input type="text" value="{{ $blog->linkedin }}" name="linkedin" class="input_off_plan" required></div>
                </div>
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Instagram</label></div>
                    <div class="col-md-8"><input type="text" value="{{ $blog->instagram }}" name="instagram" class="input_off_plan" required></div>
                </div>
                <div class="row mt-4 mb-4 align-items-center">
                    <div class="col-md-3"><label class="title-input">Shares</label></div>
                    <div class="col-md-8"><input type="text" value="{{ $blog->shares }}" name="shares" class="input_off_plan" required></div>
                </div>




                <!-- Update Button -->
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <button id="buttonsubmit" class="btn btn-primary" type="button">Update
                            <span class="spinner-border spinner-border-sm" role="status" hidden></span>
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


            // Generate slug from title
            $('#title').change(function (){
                let title = $(this).val();
                $('#slug').val(title.toLowerCase().replace(/ /g, '-'));
            });

            // Preview main image
            $('#image').change(function() {
                const file = this.files[0];
                if(file){
                    let reader = new FileReader();
                    reader.onload = function(e){ $('#imgPreview').attr('src', e.target.result); }
                    reader.readAsDataURL(file);
                }
            });

            // Preview additional images
            @foreach(['first_image','second_image','third_image'] as $img)
            $('#{{ $img }}').change(function() {
                const file = this.files[0];
                if(file){
                    let reader = new FileReader();
                    reader.onload = function(e){ $('#imgPreview_{{ $img }}').attr('src', e.target.result); }
                    reader.readAsDataURL(file);
                }
            });
            @endforeach

            // Handle update AJAX
            $('#buttonsubmit').click(function(e){
                e.preventDefault();
                let formData = new FormData($('#maindata')[0]);
                formData.append('_token', '{{ csrf_token() }}');


                ['title_details'].forEach(id=>{
                    formData.set(id, CKEDITOR.instances[id].getData());
                });

                // Add CKEditor data
                let descriptions = ['one', 'two', 'three', 'four'];
                descriptions.forEach(function(desc) {
                    if (CKEDITOR.instances['description_' + desc]) {
                        formData.append('description_' + desc, CKEDITOR.instances['description_' + desc].getData());
                    }
                });


                $.ajax({
                    url: "{{ route('update_blog', $blog->id) }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
                    beforeSend: function() {
                        $('#buttonsubmit').attr('disabled', true);
                        $('.spinner-border').removeAttr('hidden');
                    },
                    success: function(result) {
                        $("#alertdata").empty();
                        if (result.success) {
                            $("#alertdata").append("<div class='alert alert-success'>" + result.message + "</div>");
                            $('#buttonsubmit').removeAttr('disabled');
                            $('.spinner-border').attr('hidden', 'hidden');
                            window.location.href = "{{ route('listblogindex') }}";
                        } else {
                            $("#alertdata").append("<div class='alert alert-danger'>" + result.message + "</div>");
                            $('#buttonsubmit').removeAttr('disabled');
                            $('.spinner-border').attr('hidden', 'hidden');
                        }
                    },
                    error: function(err) {
                        $("#alertdata").empty();
                        if (err.responseJSON && err.responseJSON.errors) {
                            $.each(err.responseJSON.errors, function(field, messages) {
                                $.each(messages, function(i, message) {
                                    $("#alertdata").append("<div class='alert alert-danger'>" + field + ": " + message + "</div>");
                                });
                            });
                        } else {
                            $("#alertdata").append("<div class='alert alert-danger'>An unexpected error occurred.</div>");
                        }
                        $('#buttonsubmit').removeAttr('disabled');
                        $('.spinner-border').attr('hidden', 'hidden');
                    }
                });

            });
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
