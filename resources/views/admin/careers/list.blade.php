@extends('layouts.app')

@push('head')

    <title>Careers List</title>

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
@endpush

@section('wrapper_content')

    <div class="container-fluid" style="padding-left:0!important">
        <div class="row">
            <div class="col-lg-3 col-md-5 col-8">
                <h3 class="top-title">Careers List</h3>
            </div>
        </div>
    </div>
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            <div class="container-fluid" style="margin-top:1.5rem">

                <div class="card shadow mb-4" id="parent">
                    <div class="card-header py-3">
                        <div class="pb-3 mt-3" role="alert" id="alertdiv" hidden></div>

                        <div class="row mt-4">
                            <div class="col-md-3 d-flex justify-content-start">
                                <a href="{{ route('career_create') }}" class="btn btn-primary btn-sm ml-3">Create Career</a>
                            </div>
                        </div>

                        <div class="card-body mt-3">
                            <table class="table table-bordered table-hover table-responsive" id="dataTable"
                                   style="max-height:185vh;overflow:scroll;">
                                <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th><span class="table-title">Title</span></th>
                                    <th><span class="table-title">Location</span></th>
                                    <th><span class="table-title">Applicants</span></th>
                                    <th><span class="table-title">Action</span></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <div class="row mt-2">
                                <div id="tableinfo" class="col-md-6 d-flex justify-content-start"></div>
                                <div id="tablepaginate" class="col-md-6 d-flex justify-content-end"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
@endsection

@push('scripts')
    <!-- jQuery and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <!-- DataTables -->
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
                pageLength: 100,
                bPaginate: true,
                ajax: {
                    url: "{{ route('career_list') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $("#parent").LoadingOverlay("show", {
                            background: "rgba(78, 115, 223, 0.5)"
                        });
                    },
                    complete: function () {
                        $("#parent").LoadingOverlay("hide", true);
                    }
                },
                columns: [
                    {data: 'title', width: '250px'},
                    {data: 'location', width: '200px'},
                    {data: 'applicants_count', width: '150px'},
                    {data: 'action', width: '250px'}
                ],
                language: {
                    searchPlaceholder: "Type and press Enter"
                },
                dom: 'lftip',
                paging: true
            });

            $("div.dataTables_filter input").unbind();
            $("div.dataTables_filter input").keyup(function (e) {
                if (e.keyCode === 13) {
                    table.search(this.value).draw();
                }
            });

            $('#dataTable').on('search.dt', function () {
                $('#alertdiv').attr('hidden', true);
            });

            // Delete career
            $('body').on('click', '.delete', function () {
                var id = table.row(this.closest('tr')).data()['id'];

                if (!id) {
                    return;
                }

                if (!confirm('Are you sure you want to delete this career?')) {
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('career_delete') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#alertdiv').empty();
                        if (result.success) {
                            $('#alertdiv').append("<div class='alert alert-success'>" + result.message + "</div>");
                            table.ajax.reload();
                        } else {
                            $('#alertdiv').append("<div class='alert alert-danger'>" + result.message + "</div>");
                        }
                        $('#alertdiv').attr('hidden', false);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush


