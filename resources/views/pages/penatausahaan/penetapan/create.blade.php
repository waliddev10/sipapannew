<form enctype="multipart/form-data" action="{{ route('pelaporan.store', [
    'masa_pajak_id' => $masa_pajak_id,
    'perusahaan_id' => $perusahaan_id
]) }}" accept-charset="UTF-8" class="form needs-validation" id="createForm" autocomplete="off">
    @csrf

    <div class="form-group">
        <label class="font-weight-semibold">Tanggal Pelaporan Meter</label>
        <input type="date" name="tgl_pelaporan" class="form-control" />
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Volume Meter</label>
        <div class="input-group">
            <input type="text" name="volume" class="form-control" />
            <div class="input-group-append">
                <span class="input-group-text"><small>m<sup>3</sup></small></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Cara Pelaporan</label>
        <select class="form-control select2" id="cara_pelaporan-field" name="cara_pelaporan_id">
            <option selected="selected" disabled>Pilih Cara Pelaporan</option>
            @foreach ($cara_pelaporan as $cp)
            <option value="{{ $cp->id }}">{{ $cp->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Berkas Pendukung</label>
        <input type="file" name="file" class="form-control" accept="image/png,image/jpeg,application/pdf" />
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Penandatangan</label>
        <select class="form-control select2" id="penandatangan-field" name="penandatangan_id">
            <option selected="selected" disabled>Pilih Penandatangan</option>
            @foreach ($penandatangan as $p)
            <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->jabatan }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Kota Penandatangan</label>
        <select class="form-control select2" id="kota_penandatangan-field" name="kota_penandatangan_id">
            <option selected="selected" disabled>Pilih Kota Penandatangan</option>
            @foreach ($kota_penandatangan as $kp)
            <option value="{{ $kp->id }}">{{ $kp->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group row text-right">
        <div class="col-12">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>

</form>

<script type="text/javascript">
    initSelect2();

    $("#createForm").on('submit', function(event) {
        event.preventDefault();
        var form = $(this);
        var formData = new FormData($(this)[0]);
        formData.append('file', $('input[type=file]')[0].files[0]); 

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == 'success')
                {
                    $("#modalContainer").modal('hide');
                    tableDokumen.ajax.reload(null, false);
                    showAlert(response.message, 'success')
                }else{
                    showAlert(response.message, 'warning')
                }
            }
        });
        return false;
    });
</script>