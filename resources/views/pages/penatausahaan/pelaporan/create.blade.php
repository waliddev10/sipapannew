<form enctype="multipart/form-data" action="{{ route('pelaporan.store', [
    'masa_pajak_id' => $masa_pajak_id,
    'perusahaan_id' => $perusahaan_id
]) }}" accept-charset="UTF-8" class="form needs-validation" id="createForm" autocomplete="off">
    @csrf
    <div class="row">
        <div class="col">
            <div class="p-3 mb-3 shadow">
                <div class="form-group">
                    <strong>Data Pelaporan Utama</strong>
                </div>
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
            </div>
        </div>
        <div class="col">
            <div class="p-3 mb-3 shadow">
                <div class="form-group">
                    <strong>Untuk Surat Penetapan</strong>
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
            </div>
            <div class="p-3 mb-3 shadow">
                <div class="form-group">
                    <strong>Untuk SKPD Pertama</strong>
                </div>
                {{-- <div class="form-group">
                    <label class="font-weight-semibold">Tanggal Penetapan</label>
                    <input type="date" name="tgl_penetapan" class="form-control" />
                </div> --}}
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
                    <label class="font-weight-semibold">Penandatangan</label>
                    <select class="form-control select2" id="penandatangan_id_penetapan-field"
                        name="penandatangan_id_penetapan">
                        <option selected="selected" disabled>Pilih Penandatangan</option>
                        @foreach ($penandatangan as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->jabatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="font-weight-semibold">Kota Penandatangan</label>
                    <select class="form-control select2" id="kota_penandatangan_id_penetapan-field"
                        name="kota_penandatangan_id_penetapan">
                        <option selected="selected" disabled>Pilih Kota Penandatangan</option>
                        @foreach ($kota_penandatangan as $kp)
                        <option value="{{ $kp->id }}">{{ $kp->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row text-right">
                <div class="col-12">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
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