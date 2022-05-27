<table class="table table-bordered">
    <tbody>
        <tr>
            <th width="1%">Tanggal Pelaporan</th>
            <td>{{ $item->tgl_pelaporan }}</td>
        </tr>
        <tr>
            <th width="1%">Nama Perusahaan</th>
            <td>{{ $item->perusahaan->nama }}</td>
        </tr>
        <tr>
            <th width="1%">Masa Pajak</th>
            <td>{{ $item->masa_pajak->bulan }} - {{ $item->masa_pajak->tahun }}</td>
        </tr>
        <tr>
            <th width="1%">Volume Meter</th>
            <td class="text-right">{{ number_format($item->volume, 0, ',', '.') }} m<sup>3</sup></td>
        </tr>
        <tr>
            <th width="1%">Cara Pelaporan</th>
            <td>{{ $item->cara_pelaporan->nama }}</td>
        </tr>
        <tr>
            <th width="1%">Penandatangan</th>
            <td>{{ $item->penandatangan->nama }}</td>
        </tr>
        <tr>
            <th width="1%">Kota Penandatangan</th>
            <td>{{ $item->kota_penandatangan->nama }}</td>
        </tr>
        <tr>
            <th width="1%">Berkas Pendukung</th>
            <td><a class="btn btn-success" title="Lihat Berkas Pendukung" data-title="Lihat Berkas Pendukung"
                    onclick="return !window.open(this.href, 'Berkas Pendukung', 'resizable=no,width=1024,height=768')"
                    href="{{ route('pelaporan.berkas', $item->file) }}">
                    <i class="fas fa-file fa-fw"></i> {{ $item->file }}
                </a> </td>
        </tr>
    </tbody>
</table>

<div class="form-group row text-right">
    <div class="col-12">
        <button href="{{ route('pelaporan.destroy', $item->id) }}" class="btn btn-danger delete"
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