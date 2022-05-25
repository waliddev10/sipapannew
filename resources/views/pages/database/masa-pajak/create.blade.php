<form action="{{ route('masa-pajak.store') }}" accept-charset="UTF-8" class="form needs-validation" id="createForm"
    autocomplete="off">
    @csrf

    <div class="form-group">
        <label class="font-weight-semibold">Periode</label>
        <select class="form-control select2" id="bulan-field" name="bulan">
            <option selected="selected" disabled>Pilih Bulan</option>
            @php
            $bulan = 1;
            @endphp
            @while ($bulan <= 12) <option value="{{ $bulan }}">{{ str_pad($bulan, 2, '0', STR_PAD_LEFT) . ' - ' .
                \Carbon\Carbon::parse(mktime(0, 0, 0, $bulan))->monthName }}</option>
                @php
                $bulan++;
                @endphp
                @endwhile
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-semibold">Tahun</label>
        <input type="number" name="tahun" class="form-control" />
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