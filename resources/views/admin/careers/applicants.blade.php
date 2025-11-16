@extends('layouts.app')

@push('head')
<title>Applicants - {{ $career->title }}</title>

<!-- Custom fonts for this template -->
<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template -->
<link href="/css/sb-admin-2.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<!-- Custom styles for this page -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/css/dash.css') }}">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css" />

{{-- Light table/list styling similar to users list --}}
<style>
    .top-title {
        font-family: 'Lato-Semibold';
        font-size: 20px;
        color: #9D865C;
        height: 4rem;
        padding: 14px 35px;
        border-radius: 0 0 55px 0;
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

    #dataTable_filter label {
        font-family: 'Lato-Regular';
    }

    #dataTable_filter label::before {
        font-family: fontAwesome;
        content: "\f002";
        width: 26px;
        height: 20px;
        top: 1px;
        left: 83px;
        border-right: 2px solid #e3e0e0;
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

    .dataTables_scroll {
        border-left: 1px solid #e5d5d5;
        border-right: 1px solid #e5d5d5;
        border-bottom: 1px solid #e5d5d5;
        border-radius: 0 0 8px 8px;
    }

    #parent {
        background: #fff;
    }

    #dataTable_length,
    #dataTable_filter,
    .dataTables_scroll {
        background: #fff;
    }

    #dataTable_filter {
        border-top: 1px solid #e5d5d5;
        border-bottom: 1px solid #e5d5d5;
        border-left: 1px solid #e5d5d5;
        border-right: 1px solid #e5d5d5;
        border-radius: 8px 8px 0 0;
        padding: 1rem;
        height: 5rem;
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

    #dataTable_length {
        position: absolute;
        right: 50%;
        margin-top: 2.1rem;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: .5em;
        display: inline-block;
        width: auto;
    }

    #dataTable_filter label {
        margin-top: 0.5rem;

        span.table-title {
            width: 100%;
            font-size: 12px;
            font-family: 'Lato-Semibold';
            color: #fff;
        }

        #parent {
            background: #fff;
        }

        #dataTable_length,
        #dataTable_filter,
        .dataTables_scroll {
            background: #fff;
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

        #dataTable_filter input {
            padding: 0 36px;
            width: 20rem !important;
            outline: none !important;
            box-shadow: inset 0px 2px 2px 0px rgb(115 115 115 / 75%);
            border-radius: 0 !important;
            border: 1px solid #d8d5cd;
            height: 2.1rem;
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

        .dataTables_scroll {
            border-left: 1px solid #e5d5d5;
            border-right: 1px solid #e5d5d5;
            border-bottom: 1px solid #e5d5d5;
            border-radius: 0 0 8px 8px;
        }

        #wrapper {
            display: flex;
        }
</style>
@endpush

@section('wrapper_content')
<div class="container-fluid" style="padding-left:0!important">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-12">
            <h3 class="top-title">Applicants - {{ $career->title }}</h3>
        </div>
    </div>
</div>
<div id="content-wrapper" class="d-flex flex-column">

    <div id="content">
        <div class="container-fluid">

            <div class="card shadow mb-4" id="parent">
                <div class="card-header py-3">
                    <div class="pb-3 mt-3" role="alert" id="alertdiv" hidden></div>

                    <div class="card-body mt-3">
                        <table class="table table-bordered table-hover table-responsive" id="dataTable"
                            style="max-height:185vh;overflow:scroll;">
                            <thead style="background: #70cacc;color: aliceblue;">
                                <tr>
                                    <th><span class="table-title">Name</span></th>
                                    <th><span class="table-title">Title</span></th>
                                    <th><span class="table-title">CV</span></th>
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
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>

<!-- DataTables -->
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/date-1.1.0/fh-3.1.9/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js">
</script>

<script>
    $(document).ready(function() {
        let table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
            pageLength: 100,
            bPaginate: true,
            ajax: {
                url: "{{ route('career_applicants', $career->id) }}",
                type: 'POST',
                dataType: 'json',
                data: {
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
            columns: [{
                    data: 'name',
                    width: '250px'
                },
                {
                    data: 'title',
                    width: '250px'
                },

                {
                    data: 'cv_link',
                    width: '250px'
                }
            ],
            language: {
                searchPlaceholder: "Type and press Enter"
            },
            dom: 'lftip',
            paging: true
        });

        $("div.dataTables_filter input").unbind();
        $("div.dataTables_filter input").keyup(function(e) {
            if (e.keyCode === 13) {
                table.search(this.value).draw();
            }
        });

        $('#dataTable').on('search.dt', function() {
            $('#alertdiv').attr('hidden', true);
        });
    });
</script>
@endpush