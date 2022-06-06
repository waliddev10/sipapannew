<div class="table-responsive mt-3">
    <table id="penetapan-showTable" class="table table-sm table-bordered table-hover table-striped" width="100%"
        cellspacing="0">
        <thead class="bg-secondary text-white">
            <tr>
                <th></th>
                <th>No.</th>
                <th>Tanggal Penetapan</th>
                <th>No. SKPD</th>
            </tr>
        </thead>
    </table>
</div>
<form action="{{ route('penetapan.store', ['pelaporan_id' => $pelaporan_id]) }}" accept-charset="UTF-8"
    class="mt-5 form needs-validation" id="createForm" autocomplete="off">
    @csrf
    <div class="form-group">
        <label class="font-weight-semibold">Nomor SKPD</label>
        <div class="input-group inline-block">
            <div class="input-group-prepend">
                <span class="input-group-text text-xs">973/</span>
            </div>
            <input type="text" name="no_penetapan" class="form-control" @if($penetapan_auto)
                value="{{ $penetapan_auto->no_penetapan + 1 }}" @endif />
            <div class="input-group-append">
                <span class="input-group-text text-xs">/AP-PPRD.PPU/<strong>BULAN</strong>/2022</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Tanggal Penetapan Ulang Manual</label>
        <input type="date" name="tgl_penetapan" class="form-control" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success" />
    </div>
</form>

<script type="text/javascript">
    tablePenetapan = $('#penetapan-showTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '{!! route('penetapan.list', $pelaporan_id) !!}',
        columns: [
            { data: 'action', name: 'action', className: 'text-nowrap text-center', width: '1%', orderable: false, searchable: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '1%' , searchable: false, orderable: false},
            { data: 'tgl_penetapan', name: 'tgl_penetapan', className: 'text-center', orderable: false },
            { data: 'no_penetapan', name: 'no_penetapan', className: 'text-center', orderable: false },
        ],
        pageLength: 10
    });

    $("#createForm").on('submit', function(event) {
        event.preventDefault();
        var form = $(this);
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == 'success')
                {
                    $("#createForm")[0].reset();
                    tablePenetapan.ajax.reload(null, false);
                    showAlert(response.message, 'success')
                }else{
                    showAlert(response.message, 'warning')
                }
            }
        });
        return false;
    });
</script>