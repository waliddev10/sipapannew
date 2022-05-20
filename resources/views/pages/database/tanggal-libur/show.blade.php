<table class="table table-bordered">
    <tbody>
        <tr>
            <th width="1%">Tanggal Libur</th>
            <td>{{ $item->tgl_libur }}
            </td>
        </tr>
        <tr>
            <th width="1%">Hari</th>
            <td>{{ \Carbon\Carbon::parse($item->tgl_libur)->format('l') }}
                @if(\Carbon\Carbon::parse($item->tgl_libur)->dayOfWeek == 0 ||
                \Carbon\Carbon::parse($item->tgl_libur)->dayOfWeek == 6) (Weekend) @endif</td>
        </tr>
        <tr>
            <th width="1%">Keterangan</th>
            <td>{{ $item->keterangan }}
            </td>
        </tr>
        <tr>
            <th width="1%">Dasar Hukum</th>
            <td>{{ $item->dasar_hukum }}
            </td>
        </tr>
    </tbody>
</table>

<div class="form-group row text-right">
    <div class="col-12">
        <a href="{{ route('tanggal-libur.destroy', $item->id) }}" class="btn btn-danger delete"
            data-target-table="tableDokumen"><i class="fa fa-trash"></i>
            Hapus</a>
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