<?php

namespace Database\Seeders;

use App\Models\StaticElement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaticElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaticElement::create([
            'element' => 'profil',
            'contents' => "SEKAWAN’s TBC adalah lembaga sosial yang bergerak didalam memberikan dukungan pengobatan kepada pasien TBC Resisten Obat/Kebal Obat di wilayah Kabupaten Jember, Lumajang, Bondowoso, dan Situbondo. SEKAWAN’s TBC merupakan lembaga resmi yang berbadan hukum berdasarkan Surat Keputusan Menteri Hukum dan Hak Asasi Manusia Republik Indonesia Nomor: AHU-0016828.AH.01.07.TAHUN 2017 tentang Pengesahan Pendirian Badan Hukum Perkumpulan SEKAWAN’s TBC Jember.
SEKAWANS’s TBC terbentuk sejak 14 Juli 2016, disebut sebagai sekumpulan pendidik sebaya yang terdiri dari para mantan penderita TBC Resisten Obat/Kebal Obat yang telah sembuh, praktisi, dan pemerhati TBC lainnya. Pendidik sebaya tersebut telah turut berperan serta dalam memotivasi pasien agar berobat sampai tuntas, dengan memberikan dukungan psikosoisal kepada pasien TB RO. Dengan cara melaksanakan kunjungan ke fasyankes dan kunjungan rumah. Adanya diskriminasi dan stigma terhadap pasien TB RO di masyarakat, juga akan memberikan dampak psikososial terhadap pasien yang menjalani pengobatan, sehingga adanya pendidik sebaya akan sangat membantu menguatkan pasien TB RO.",
        ]);

        StaticElement::create([
            'element' => 'visimisi',
            'contents' => "Visi SEKAWAN’s TBC adalah mewujudkan Jember dan kabupaten sekitarnya terbebas dari TBC Resisten Obat menuju Indonesia Bebas Tuberculosis. Sedangkan misi SEKAWAN’s TBC adalah: (1) berperan aktif dalam upaya penanggulangan TB Resistan Obat di Kabupaten Jember, Lumajang, Situbondo, dan Bondowoso; (2) meningkatkan motivasi penderita TB Resisten Obat untuk berobat sampai tuntas; (3) menurunkan stigma dan diskriminasi terhadap pasien TB Resisten Obat; (4) memberikan dukungan nutrisi dan alat kesehatan pengobatan pasien; (5) membangun jejaring lintas sektor dalam upaya penguatan penanggulangan TB Resisten Obat; (6) meningkatkan pengetahuan masyarakat tentang penyakit TB Resisten Obat.",
        ]);

        StaticElement::create([
            'element' => 'struktur',
            'contents' => "",
        ]);

        // StaticElement::create([
        //     'element' => 'whatsapp',
        //     'contents' => fake()->phoneNumber(),
        // ]);

        StaticElement::create([
            'element' => 'instagram',
            'contents' => 'https://www.instagram.com/sekawanstbc_jember?igsh=ejl6d2dzbGJybTc2',
        ]);

        StaticElement::create([
            'element' => 'tiktok',
            'contents' => 'https://www.tiktok.com/@sekawanstbc_jember?_t=8mLNIY9xR4b&_r=1',
        ]);

        StaticElement::create([
            'element' => 'youtube',
            'contents' => 'https://youtube.com/@sekawanstb5619?si=hkK643-fxsbTqY7v',
        ]);
    }
}