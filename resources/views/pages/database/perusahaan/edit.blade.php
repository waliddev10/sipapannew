<form action="{{ route('perusahaan.update', $item->id) }}" accept-charset="UTF-8" class="form needs-validation"
    id="editForm" autocomplete="off">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label class="font-weight-semibold">Nama Perusahaan</label>
        <input type="text" name="nama" class="form-control" value="{{ $item->nama }}" />
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Jenis Usaha</label>
        <select class="form-control select2" id="jenis_usaha-field" name="jenis_usaha_id">
            <option selected="selected" disabled>Pilih Jenis Usaha</option>
            @foreach ($jenis_usaha as $ju)
            <option value="{{ $ju->id }}" @if($item->jenis_usaha_id == $ju->id) selected @endif>{{ $ju->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Alamat Perusahaan</label>
        <textarea name="alamat" class="form-control">{{ $item->alamat }}</textarea>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Tanggal Penetapan PKP</label>
        <input type="date" name="tgl_penetapan" class="form-control" value="{{ $item->tgl_penetapan }}" />
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">No. HP</label>
        <input type="text" name="hp_pj" class="form-control" value="{{ $item->hp_pj }}" />
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Nama Kontak</label>
        <input type="text" name="nama_pj" class="form-control" value="{{ $item->nama_pj }}" />
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Email Perusahaan</label>
        <input type="email" name="email" class="form-control" value="{{ $item->email }}" />
    </div>

    <div class="form-group row text-right">
        <div class="col-12">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>

</form>

<script type="text/javascript">
    initSelect2();

    $("#editForm").on('submit', function(event) {
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
                    $("#modalContainer").modal('hide');
                    tableDokumen.ajax.reload(null, false);
                    showAlert(response.message, 'success')
                } else {
                    showAlert(response.message, 'warning')
                }
            }
        });
        return false;
    });
</script>