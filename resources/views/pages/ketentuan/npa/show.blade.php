@php
if (is_null($item->volume_min)) {
$volume = '< ' . $item->volume_max; 
} 
else {
                if (is_null($item->volume_max)) {
                    if ($item->volume_min != 0){ 
                        $volume = '> ' . ($item->volume_min - 1);
    } else {
    $volume= 'Semua';
    }
    } else {
    $volume= $item->volume_min . ' - ' . $item->volume_max;
    }
    }
    @endphp

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="1%">Jenis Usaha</th>
                <td>{{ $item->jenis_usaha->nama }}</td>
            </tr>
            <tr>
                <th width="1%">Volume</th>
                <td>{{ $volume }}</td>
            </tr>
            <tr>
                <th width="1%">NPA</th>
                <td>{{ number_format($item->nilai, 2, ',', '.'); }}</td>
            </tr>
            <tr>
                <th width="1%">Berlaku mulai tanggal:</th>
                <td>{{ $item->tgl_berlaku }}</td>
            </tr>
            <tr>
                <th width="1%">Keterangan</th>
                <td>{{ $item->keterangan }}</td>
            </tr>
        </tbody>
    </table>

    <div class="form-group row text-right">
        <div class="col-12">
            <button href="{{ route('npa.destroy', $item->id) }}" class="btn btn-danger delete"
                data-target-table="tableDokumen"><i class="fa fa-trash"></i>
                Hapus</button>
        </div>
    </div>

    <script type="text/javascript">
        // script delete
    $('body').on("click", ".delete", function(event){
        event.preventDefault();
        var href = $(this).attr("href");
        var dataTargetTable = $(this).data('target-table');

        Swal.fire({
            title: 'Anda yakin akan menghapus data ini?',
            text: "Periksa kembali data anda sebelum menghapus!",
            icon: 'warning',
            showCancelButton: true,
            allowEscapeKey: false,
            allowOutsideClick: false,
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: href,
                    type: 'DELETE',
                    success: function(response) {
                        if(response.status == 'success'){
                            $("#modalContainer").modal('hide');
                            showAlert(response.message, 'success');
                            window[dataTargetTable].ajax.reload(null, false);
                        }else{
                            showAlert(response.message, response.status);
                        }
                    }
                });
            }
        })
    });
    </script>