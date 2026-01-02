@extends('layouts.app')
@push('head')
<title>Homepage Sliders List</title>

<!-- Custom fonts for this template -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template -->
<link href="css/sb-admin-2.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />


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

    .top-title {
        font-family: 'Lato-Semibold';
        font-size: 20px;
        color: #9D865C;
        height: 4rem;
        padding: 14px 35px;

        border-radius: 0 0px 55px 0;
    }

    nav ul li:last-child {
        border-bottom: 0 !important;
    }

    .content-input {
        display: flex;
        align-items: center;
    }

    .label {
        width: auto;
        padding-right: 12px;
    }

    .dropdown {
        width: 55%;
    }

    .label h4 {
        color: #241907;
        font-family: 'Lato-Semibold';
        font-size: 17px;
    }

    .dropdown select {
        box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
        border-right: 2px solid #db9d33;
        color: #db9d33;
        font-family: 'Lato-Regular';
        font-size: 15px;
    }

    #dataTable_filter label::after {
        content: "";
        width: 70px;
        height: 28px;
        top: 10px;
        right: 71px;
        position: relative;
        display: inline-block;
        background-size: cover;
    }

    #dataTable_filter label::before {
        font-family: fontAwesome;
        content: "\f002";
        width: 26px;
        height: 20px;
        top: 1px;
        left: 83px;
        border-right: 2px solid #e3e0e0;
        position: relative;
        display: inline-block;
    }

    #dataTable_filter input {
        padding: 0 36px;
        width: 20rem !important;
        outline: none !important;
        box-shadow: inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
        border-radius: 0 !important;
        border: 1px solid #d8d5cd;
        height: 2.1rem;
    }

    label {
        font-family: 'Lato-Regular';
    }

    #tablebuttonexcel button,
    #tablebuttoncsv button {
        background: #6d4e18;
        border: #6d4e18;
        font-family: 'Lato-Regular';
        font-size: 15px;
        color: #fff;
        width: 6rem;
        border-radius: 9px;
        box-shadow: 0 8px 7px -7px rgb(115 115 115 / 21%), -6px 0 7px -3px rgb(115 115 115 / 34%);
    }

    #dataTable_length select {
        box-shadow: inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
        border-radius: 0 !important;
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

    th {}

    span.table-title {
        width: 100%;
        font-size: 12px;
        font-family: 'Lato-Semibold';
        color: #fff;
    }

    #dataTable_length,
    #dataTable_filter,
    .dataTables_scroll {
        background: #fff;
    }

    #dataTable_length {
        position: absolute;
        right: 50%;
        margin-top: 2.1rem;
    }

    #dataTable_filter {
        border-top: 1px solid #e5d5d5;
        border-left: 1px solid #e5d5d5;
        border-right: 1px solid #e5d5d5;
        border-radius: 8px 8px 0 0;
        padding: 1rem;
        height: 5rem;
    }

    #dataTable_filter label {
        margin-top: 0.5rem;
    }

    .dataTables_scroll {
        border-left: 1px solid #e5d5d5;
        border-right: 1px solid #e5d5d5;
        border-bottom: 1px solid #e5d5d5;
        border-radius: 0px 0px 8px 8px;
    }

    .group-button {
        position: relative;
        margin-top: 1.5rem;
        top: 0px;
        left: 18px;
    }

    .first a {
        background-position: center;
        background-size: cover;
        width: 5rem;
        text-align: left;
        color: #fff !important;
        font-size: 13px !important;
        font-family: 'Lato-Regular' !important;

    }

    .last a {
        background-position: center;
        background-size: cover;
        width: 5rem;
        text-align: right;
        color: #fff !important;
        font-size: 13px !important;
        font-family: 'Lato-Regular' !important;
    }

    #bookslist_info {
        color: #000 !important;
        font-size: 13px !important;
        font-family: 'Lato-Regular' !important;
        position: absolute;
        margin-top: 1rem;
    }

    #bookslist_paginate {
        margin-top: 2rem;
    }

    .pagination li a {
        box-shadow: inset 0px 2px 0px 0px rgb(115 115 115 / 75%);
    }

    .odd td {
        background: #e9eaeeb5;
    }

    select::-ms-expand {
        display: none;
    }

    .custom-select {
        background-size: contain;
        background-repeat: no-repeat;
        background-position: right;
    }

    @media(max-width:768px) {
        .top-title {
            font-size: 15px;
            color: #9D865C;
            height: 3rem;
            padding: 11px 30px;

        }

        #tablebuttonexcel button,
        #tablebuttoncsv button {
            font-size: 10px;
            color: #fff;
            width: 4rem;
            padding: 2px;
        }

        #dataTable_filter input {
            width: 14rem !important;
        }

        #dataTable_filter label::before {
            top: 126px;
            right: 192px;
        }

        #dataTable_filter label::after {
            width: 61px;
            top: 121px;
            right: 27px;
        }

        .label h4 {
            font-size: 13px;
        }
    }

    @media(max-width:500px) {
        .content-input {
            margin-bottom: 10px;
        }

        .label {
            width: 8rem;
        }

        .group-button {
            position: initial;
            justify-content: center !important;
        }

        #dataTable_length {
            position: inherit;
        }

        #dataTable_filter input {
            width: 13rem !important;
        }

        #dataTable_filter label::after {
            top: 281px !important;
            right: 30px !important;
        }

        #dataTable_filter label::before {
            top: 283px;
            right: 179px;
        }

        #bookslist_info {
            position: inherit;
        }

        #wrapper {
            background-size: cover !important;

        }

        .top-title {}
    }

    #bg-top {
        width: 157%;
        margin-left: -5rem;
        margin-top: -9rem;
    }

    #dataTable_length,
    #dataTable_filter,
    .dataTables_scroll {
        background: #fff;
    }

    .card-body {
        margin-top: -5rem !important;
    }

    #wrapper {
        height: 100% !important;
    }

    div.dataTables_scrollBody::-webkit-scrollbar {
        width: 5px;
    }

    div.dataTables_scrollBody::-webkit-scrollbar {
        width: 3px !important;

    }

    div.dataTables_scrollBody::-webkit-scrollbar-track {
        background: #c5c5c5 !important;
    }

    div.dataTables_scrollBody::-webkit-scrollbar-thumb {
        background: #6d4e18;
        border-radius: 0px;
        border-radius: 8px;
    }

    div.dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
        background: #6d4e18;
        border-radius: 8px;
    }

    .justify-content-start {
        left: 20px;
        top: 6px;
    }

    #dataTable_next a::after {
        content: "";
        width: 70px;
        height: 30px;
        top: 0px;
        right: -65px;
        position: absolute;
        display: inline-block;
        background-size: contain;
    }

    #dataTable_previous a::before {
        content: "";
        width: 70px;
        height: 30px;
        top: 0px;
        left: -49px;
        position: absolute;
        display: inline-block;
        background-size: contain;
    }

    #tablepaginate {
        padding-right: 4rem;
    }

    .page-item.active .page-link {
        z-index: 3;
        font-family: 'Lato-Semibold' !important;
        background-color: #ffffff !important;
        top: 0px !important;
    }

    .page-link:focus {
        box-shadow: inset 0px 2px 0px 0px rgb(115 115 115 / 75%) !important;
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
        background-color: #e9edec87 !important;
        color: #114c45 !important;
    }

    .page-link:hover {
        z-index: 2;
        color: #9D865C;
        text-decoration: none;
        background-color: #e9edec87 !important;
        color: #bec7c6 !important;
    }

    .swal-button {
        background-color: #0d2825 !important;
        color: #fff !important;
    }

    .swal-button:not([disabled]):hover {
        background-color: #899297 !important;
    }
</style>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->

<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
</script>

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

<!--  datetime range -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


{{-- swal alert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@section('wrapper_content')
<!-- Content Wrapper -->
<div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-4 col-md-5 col-8">
            <h3 class="top-title">Homepage Sliders List</h3>
        </div>

    </div>
</div>
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid" style="margin-top:1.5rem">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"></h1>

            <!-- DataTales Example -->
            <div id="parent" class="card shadow mb-4">
                <div class="card-header py-3">

                    <div id="alertdata" class=" pb-3 mt-3 mb-4"></div>

                    <input value="" type="text" name="search" id="filter" hidden />

                    <div class="row mt-4">
                        @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                        <div class="col-md-3 d-flex justify-content-start">
                            <div id="tablebuttoncsv" class="mr-1 ml-3"></div>
                            <div id="tablebuttonexcel" class="mr-1"></div>
                            <div id="tablebuttonpdf" class="mr-1"></div>
                        </div>
                        @endif
                    </div>

                    <div class="card-body mt-3">

                        <table class="table table-bordered table-hover table-responsive " id="dataTable"
                            style="max-height:185vh;overflow:scroll;">

                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th><span class="table-title">Image</span></th>
                                    <th><span class="table-title">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <input id="startdate" type="text" hidden>
                                <input id="enddate" type="text" hidden>
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

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">

            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <div class="row img-row">
        <div class="col-md-8"></div>
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
        $(document).ready(function() {

            let table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "retrieve": true,
                "destroy": true,
                "autoWidth": false,
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
                "pageLength": 100,
                'bPaginate': false,
                "ajax": {
                    "url": "{{ route('homepage_slider_list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
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
                "columns": [{
                        data: "image",
                        width: '500px'
                    },
                    {
                        data: "action",
                        width: '50%'
                    }
                ],
                "lengthMenu": [
                    [100, 500, 1000, 2000, 5000, 10000],
                    [100, 500, 1000, 2000, 5000, 10000]
                ],
                "language": {
                    searchPlaceholder: "Type and press Enter"
                },
                dom: 'lftipB',
                "paging": true,
                "buttons": [{
                        "extend": 'excel',
                        "action": newexportaction
                    },
                    {
                        "extend": 'csv',
                        "action": newexportaction
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
            $("div.dataTables_filter input").keyup(function(
                e) {
                console.log(e.keyCode);
                if (e.keyCode == 13) {
                    table.search(this.value).draw();
                }
            });

            $('#dataTable').DataTable();

            function newexportaction(e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function(e, s, data) {
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function(e, settings) {
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
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        setTimeout(dt.ajax.reload, 0);
                        return false;
                    });
                });
                dt.ajax.reload();
            }

            $('#dataTable').on('search.dt', function() {
                var value = $('.dataTables_filter input').val();
                var s = $('#filter:text').val(value);
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
                            url: "{{ route('homepage_slider_delete') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(result) {
                                if (result.success) {
                                    $('#alertdata').empty();
                                    $('#alertdata').append(
                                        "<div class= 'alert alert-success'>" +
                                        result
                                        .message +
                                        "</div>");
                                    $('#alertdata').attr('hidden', false);
                                    table.clear().draw();
                                } else {
                                    $('#alertdata').empty();
                                    $('#alertdata').append(
                                        "<div class= 'alert alert-danger'>" +
                                        result
                                        .message +
                                        "</div>");
                                    $('#alertdata').attr('hidden', false);
                                }
                            },
                            error: function(erorr) {
                                console.log(erorr);
                            }
                        });
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
    @endpush