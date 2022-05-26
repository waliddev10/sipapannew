<style>
    @page {
        size: legal;
        margin: 2cm;
    }

    body {
        font-size: 11pt;
    }

    table td,
    table td * {
        vertical-align: top;
    }

    .tabel-perhitungan tr,
    .tabel-perhitungan th,
    .tabel-perhitungan td {
        padding: 5pt;
    }
</style>

<body>
    <p style="margin-top: 4cm; text-indent: 1cm; text-align: justify; line-height: 16pt;">Berdasarkan laporan pemakaian
        Air permukaan {{ $pelaporan->perusahaan->nama }}
        yang telah disampaikan lewat {{ $pelaporan->cara_pelaporan->nama }} pada tanggal {{
        \Carbon\Carbon::parse($pelaporan->tgl_pelaporan)->isoFormat('D MMMM Y') }}, maka dengan ini ditetapkan
        pajak atas
        pemakaian Air Permukaan perusahaan saudara sebagai berikut :
    </p>
    <div style="margin: 0 0 20pt 0;">
        <table style="width: 90%; margin-left: 1cm">
            <tr>
                <td style="width: 20%;">Nama</td>
                <td style="width: 3%">:</td>
                <td style="font-weight: bold">{{ Str::upper($pelaporan->perusahaan->nama) }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $pelaporan->perusahaan->alamat }}</td>
            </tr>
            <tr>
                <td>Jenis Usaha</td>
                <td>:</td>
                <td>{{ $pelaporan->perusahaan->jenis_usaha->nama }}</td>
            </tr>
            <tr>
                <td>Periode Bulan</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse(mktime(0, 0, 0, $pelaporan->masa_pajak->bulan))->monthName}} {{
                    $pelaporan->masa_pajak->tahun }}</td>
            </tr>
            <tr>
                <td>Pemakaian</td>
                <td>:</td>
                <td>{{ number_format($pelaporan->volume, 0, ',', '.') }} m<sup>3</sup></td>
            </tr>
            <tr>
                <td>Dasar NPA</td>
                <td>:</td>
                <td>{{ $npa->first()->keterangan }}</td>
            </tr>
        </table>
    </div>

    <div style="margin: 20pt 0 40pt 0; font-size: 10pt">
        <table class="tabel-perhitungan" style="width: 100%; border-collapse: collapse; margin-bottom: 5pt; ">
            <tr style="border: 0.5pt solid black;">
                <th style="border: 0.5pt solid black;">JENIS<br />PUNGUTAN</th>
                @if (collect($npa_dokumen)->count() > 1)
                <th style="border: 0.5pt solid black;">VOLUME<br />STANDAR</th>
                @endif
                <th style="border: 0.5pt solid black;">VOLUME<br />PEMAKAIAN</th>
                <th style="border: 0.5pt solid black;">NPA<br />{{ Str::upper($npa->first()->jenis_usaha->nama) }}</th>
                <th style="border: 0.5pt solid black;">JUMLAH<br />(NPA x V)</th>
                <th style="border: 0.5pt solid black;">TARIF<br />PAJAK</th>
                <th style="border: 0.5pt solid black;">PAJAK TERUTANG<br />(Rp)</th>
            </tr>
            @foreach ($npa_dokumen as $npad)
            <tr>
                @if ($loop->first)
                <td rowspan="{{ count($npa_dokumen) }}" style="text-align: center; border: 0.5pt solid black;">PAP</td>
                @endif
                @if (collect($npa_dokumen)->count() > 1)
                <td style="text-align: center; border: 0.5pt solid black;">{{ $npad->volume_standar }}</td>
                @endif
                <td style="text-align: right; border: 0.5pt solid black;">{{ number_format($npad->volume_pemakaian, 0,
                    ',', '.') }}</td>
                <td style="text-align: right; border: 0.5pt solid black;">{{ number_format($npad->npa, 0, ',', '.') }}
                </td>
                <td style="text-align: right; border: 0.5pt solid black;">{{ number_format($npad->jumlah, 0, ',', '.')
                    }}</td>
                @if ($loop->first)
                <td rowspan="{{ count($npa_dokumen) }}" style="text-align: center; border: 0.5pt solid black;">{{
                    $tarif_pajak->nilai * 100 }}%
                </td>
                @endif
                <td style="text-align: right; border: 0.5pt solid black;">{{ number_format($npad->pajak_terutang, 0,
                    ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                @if (collect($npa_dokumen)->count() > 1)
                <td colspan="2" style="border: 0.5pt solid black;">
                    Jumlah
                    Pemakaian</td>
                <td style="text-align: right; border: 0.5pt solid black;">{{ number_format($jumlah_volume_pemakaian, 0,
                    ',', '.') }}</td>
                @endif
                <td colspan="@if (collect($npa_dokumen)->count() > 1) 3 @else 5 @endif"
                    style="font-weight: bold; border: 0.5pt solid black;">JUMLAH PAJAK TERUTANG</td>
                <td style="text-align: right; border: 0.5pt solid black;">{{ number_format($jumlah_pajak_terutang, 0,
                    ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="@if (collect($npa_dokumen)->count() > 1) 6 @else 5 @endif" style="padding-left: 4.75cm;">
                    Sanksi Bunga/Denda <span style="margin-left: 1.5cm">0%</span>
                </td>
                <td style="text-align: right; border: 0.5pt solid black;">-</td>
            </tr>
            <tr>
                <td colspan="@if (collect($npa_dokumen)->count() > 1) 6 @else 5 @endif" style="padding-left: 4.75cm;">
                    Sanksi Administrasi <span style="margin-left: 1.5cm"></span>
                </td>
                <td style="text-align: right; border: 0.5pt solid black;">{{
                    $nilai_sanksi_administrasi ? number_format($nilai_sanksi_administrasi, 0, ',', '.') : '-' }}</td>
            </tr>
            <tr>
                <td colspan="@if (collect($npa_dokumen)->count() > 1) 6 @else 5 @endif"
                    style="padding-left: 4.75cm; font-weight: bold">Jumlah Pajak, Denda, dan Sanksi Air
                    Permukaan
                    sebesar
                </td>
                <td style="text-align: right; font-weight: bold; border: 0.5pt solid black;">{{
                    number_format($jumlah_pajak_dan_sanksi, 0, ',', '.')
                    }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-left: 65%; text-align: center;">
        <span>{{ $pelaporan->kota_penandatangan->nama }}, {{
            \Carbon\Carbon::parse($pelaporan->tgl_pelaporan)->isoFormat('D MMMM Y') }}</span>

        <h4 style="font-size: 11pt; margin: 10pt 0 60pt;">{{ $pelaporan->penandatangan->jabatan }}</h4>

        <h4 style="font-size: 11pt; margin: 0 0 3pt 0;">{{ $pelaporan->penandatangan->nama }}</h4>
        <h5 style="font-size: 11pt; font-weight: 10pt; margin: 0;">NIP. {{ $pelaporan->penandatangan->nip }}</h5>
    </div>
</body>