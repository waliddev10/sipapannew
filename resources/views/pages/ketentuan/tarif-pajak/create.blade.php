<form action="{{ route('tarif-pajak.store') }}" accept-charset="UTF-8" class="form needs-validation" id="createForm"
    autocomplete="off">
    @csrf

    <div class="form-group">
        <label class="font-weight-semibold">Tarif Pajak (%)</label>
        <div class="input-group">
            <input type="number" name="nilai" class="form-control" />
            <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-fw fa-percent"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Berlaku Mulai dari Tanggal:</label>
        <input type="date" name="tgl_berlaku" class="form-control" />
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Keterangan</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>

    <div class="form-group row text-right">
        <div class="col-12">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>

</form>

<script type="text/javascript">
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