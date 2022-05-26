<?php

namespace Database\Seeders;

use App\Models\TanggalLibur;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class TanggalLiburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return TanggalLibur::insert([
            [
                'tgl_libur' => '2022-01-01',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Tahun Baru 2022 Masehi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-02-01',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Tahun Baru Imlek 2573',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-02-28',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Isra Mi\'raj Nabi Muhammad SAW',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-03-03',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Suci Nyepi Tahun Baru Saka 1944',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-04-15',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Wafat Isa Al Masih',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-05-01',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Buruh Internasional',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-05-02',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Raya Idul Fitri 1443 Hijriah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-05-03',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Raya Idul Fitri 1443 Hijriah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-05-16',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Raya Waisak 2566 BE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-05-26',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Kenaikan Isa Al Masih',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-06-01',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Lahir Pancasila',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-07-09',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Raya Idul Adha 1443 Hijriah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-07-30',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Tahun Baru Islam 1444 Hijriah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-08-17',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Kemerdekaan Republik Indonesia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-10-08',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Maulid Nabi Muhammad SAW',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tgl_libur' => '2022-12-25',
                'dasar_hukum' => 'SURAT EDARAN No. 003/7173/B.Org-TL TENTANG HARI LIBUR NASIONAL DAN CUTI BERSAMA TAHUN 2022',
                'keterangan' => 'Hari Raya Natal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
