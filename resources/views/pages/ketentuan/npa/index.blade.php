@extends('layouts.app')

@section('title', 'Nilai Perolehan Air')

@section('content')
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nilai Perolehan Air</h6>
    </div>
    <div class="card-body">
        <a class="btn btn-outline-primary btn-sm" title="Tambah Nilai Perolehan Air" data-toggle="modal"
            data-target="#modalContainer" data-title="Tambah Nilai Perolehan Air" href="{{ route('npa.create') }}"><i
                class="fa fa-plus fa-fw"></i>
            Tambah
            Nilai Perolehan Air</a>
        <div class="table-responsive mt-3">
            <table id="npaTable" class="table table-sm table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>No.</th>
                        <th>Jenis Usaha</th>
                        <th>Volume</th>
                        <th>NPA</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalContainer" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modalContainer" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Title</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-white">
                ...
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    function initSelect2() {
        $('select.select2:not(.select2-hidden-accessible)').select2({
            allowClear: false,
            width: '100%'
        });
    }
    function showLoading() {
        $('.preloader').fadeIn();
    }

    function hideLoading() {
        $('.preloader').fadeOut();
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ajaxError(function(event, xhr, settings, thrownError) {
        if (xhr.status == 422) {
            message = '';
            type = 'warning';

            $('.form.needs-validation').find('input, select, textarea').removeClass('is-invalid');
            $('.form.needs-validation').find('.select2').removeClass('border border-danger');
            $('.invalid-feedback').remove();
            $.each(xhr.responseJSON.errors, function(name, message) {
                $('[name="' + name + '"]').addClass('is-invalid').after('<div class="invalid-feedback">' + message  + '</div>');
                $('.select2[name="' + name + '"]').next('.select2').addClass(
                    'border border-danger').after('<div class="invalid-feedback">' + message  + '</div>');
            });
        } else if (xhr.status == 401 || xhr.status == 419) {
            message = 'Sesi login habis, silakan muat ulang browser Anda dan login kembali.';
            type = 'warning';
            $('.modal').modal('hide');
            showAlert(message, type);
        } else if (xhr.status == 500) {
            message = 'Terjadi kesalahan, silakan muat ulang browser Anda dan hubungi Admin.';
            type = 'danger';
            $('.modal').modal('hide');
            showAlert(message, type);
        }
        hideLoading();
    });
</script>
@endpush

@push('scripts')
<script type="text/javascript">
    tableDokumen = $('#npaTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '{!! route('npa.index') !!}',
        columns: [
            { data: 'action', name: 'action', className: 'text-nowrap text-center', width: '1%', orderable: false, searchable: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '1%' , searchable: false, orderable: false},
            { data: 'jenis_usaha', name: 'jenis_usaha' },
            { data: 'volume', name: 'volume' },
            { data: 'nilai', name: 'nilai', className: 'text-right' },
        ],
        pageLength: 25
    });

    // Global Settings DataTables Search
    $(document).on('init.dt', function (e, settings) {
        var api = new $.fn.dataTable.Api(settings);
        var inputs = $(settings.nTable).closest('.dataTables_wrapper').find('.dataTables_filter input');

        inputs.unbind();
        inputs.each(function (e) {
            var input = this;

            function disableSubmitOnEnter(form) {
                if (form.length) {
                    form.on('keyup keypress', function (e) {
                        var keyCode = e.keyCode || e.which;

                        if (keyCode == 13) {
                            e.preventDefault();
                            return false;
                        }
                    });
                }
            }
            disableSubmitOnEnter($(input).closest('form'));

            $(input).bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    api.search(this.value).draw();
                }
            });

            $(input).bind('input', function (e) {
                if (this.value == '') {
                    api.search(this.value).draw();
                }
            });
        });
    });

    function setLoader() {
        return '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>';
    }

    $('#modalContainer').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title')
        var href = button.attr('href')
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html(setLoader())
        $.get(href).done(function( data ) {
            modal.find('.modal-body').html(data)
        });
    });

    function showAlert(message, type = 'success', reload = false) {
        if (type == 'success') {
            Swal.fire({
                icon: 'success',
                title: message,
                allowEscapeKey: false,
                allowOutsideClick: false,
                allowEnterKey: false
            })
        } else {
            if (type == 'danger') {
                type = 'error';
            }

            Swal.fire({
                title: type.toUpperCase()+'!',
                html: message,
                icon: type
            }).then((result) => {
                if (result.isConfirmed) {
                    if (reload) {
                        showLoading();
                        window.location.reload();
                    }
                }
            });
        }
    }
</script>
@endpush