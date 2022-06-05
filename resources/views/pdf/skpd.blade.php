<style>
    @page {
        size: legal;
        margin: 1.5cm;
    }

    body {
        font-size: 10pt;
    }

    table td,
    table td * {
        vertical-align: top;
    }

    .tabel-perhitungan tr,
    .tabel-perhitungan th,
    .tabel-perhitungan td {
        border: 0.5pt solid black;
        padding: 5pt;
    }
</style>

<body>
    <div style="text-align: center; margin-top: 4cm;">
        <h2 style="font-size: 13pt; margin: 0;">SURAT KETETAPAN PAJAK DAERAH (SKPD)</h2>
        <h2 style="font-size: 13pt; margin: 0 0 40pt 0;">PAJAK AIR PERMUKAAN</h2>
    </div>
    <div style="margin: 0 0 20pt 0;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 36%;">Nomor</td>
                            <td style="width: 1%">:</td>
                            <td>973/{{ str_pad($penetapan->no_penetapan,3,"0",STR_PAD_LEFT) }}/AP-PPRD.PPU/III/2022</td>
                        </tr>
                        <tr>
                            <td>Nama Wajib Pajak</td>
                            <td>:</td>
                            <td>{{ Str::upper($pelaporan->perusahaan->nama) }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Wajib Pajak</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Nama Perusahaan</td>
                            <td>:</td>
                            <td>{{ $pelaporan->perusahaan->nama }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; padding-left: 10pt">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 36%;">Alamat Perusahaan</td>
                            <td style="width: 1%">:</td>
                            <td>{{ Str::upper($pelaporan->perusahaan->alamat) }}</td>
                        </tr>
                        <tr>
                            <td>Peruntukan</td>
                            <td>:</td>
                            <td>{{ $pelaporan->perusahaan->jenis_usaha->nama }}</td>
                        </tr>
                        <tr>
                            <td>Bulan</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::create()->month($pelaporan->masa_pajak->bulan)->monthName }}</td>
                        </tr>
                        <tr>
                            <td>Tahun</td>
                            <td>:</td>
                            <td>{{ $pelaporan->masa_pajak->tahun }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>


    <hr style="border: solid 0.4pt black;" />

    <div style="margin: 20pt 0 40pt 0;">
        <h3 style="text-align: center; font-size: 12pt; font-weight: normal;">PERHITUNGAN PAJAK</h3>

        <table class="tabel-perhitungan"
            style="width: 100%; border-collapse: collapse; margin-bottom: 5pt; font-size: 10pt;">
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

        {{-- <table class="tabel-perhitungan" style="width: 100%; border-collapse: collapse; margin-bottom: 5pt;">
            <tr>
                <th>JENIS<br />PUNGUTAN</th>
                <th>VOLUME<br />(m<sup>3</sup>)</th>
                <th>NPA<br />(Rp)</th>
                <th>TARIF<br />PAJAK</th>
                <th>PAJAK TERUTANG<br />(Rp)</th>
            </tr>
            <tr>
                <td style="text-align: center;">PAP</td>
                <td style="text-align: right;">15.011</td>
                <td style="text-align: right;">1.290</td>
                <td style="text-align: center;">10%</td>
                <td style="text-align: right;">1.916.219</td>
            </tr>
            <tr>
                <td colspan="4">Sanksi Bunga/Denda <span style="margin-left: 1.5cm">0%</span></td>
                <td style="text-align: right;">-</td>
            </tr>
            <tr>
                <td colspan="4">Sanksi Administrasi <span style="margin-left: 1.5cm"></span></td>
                <td style="text-align: right;">-</td>
            </tr>
            <tr>
                <th colspan="4">JUMLAH PAJAK TERUTANG</th>
                <td style="text-align: right; font-weight: bold;">1.916.219</td>
            </tr>
        </table> --}}

        <span style="font-style: italic;">*Jumlah ketetapan pajak di atas sewaktu-waktu dapat
            berubah</span>
    </div>

    <div style="margin-left: 65%">
        <table style="width: 100%">
            <tr>
                <td style="width: 39%">Ditetapkan</td>
                <td style="width: 1%">:</td>
                <td style="width: 60%">{{ $penetapan->kota_penandatangan->nama }},</td>
            </tr>
            <tr>
                <td>Pada tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($penetapan->tgl_penetapan)->isoFormat('D MMMM Y') }}</td>
            </tr>
        </table>

        <h4 style="font-size: 11pt; margin: 30pt 0 60pt; text-align: center;">{{ $penetapan->penandatangan->jabatan }}
        </h4>

        <h4 style="font-size: 11pt; margin: 0; text-align: center;">{{ $penetapan->penandatangan->nama }}</h4>
        <h5 style="font-size: 11pt; font-weight: normal; margin: 3pt 0 0 0; text-align: center;">NIP. {{
            $penetapan->penandatangan->nip }}</h5>
    </div>
</body>