<?php

use Illuminate\Database\Seeder;
use App\StudyProgram;
use App\AcademicYear;

class CollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collaborations')->insert([
            [
                'kd_prodi' => StudyProgram::all()->random()->kd_prodi,
                'id_ta' => AcademicYear::all()->random()->id,
                'nama_lembaga' => 'RRI',
                'tingkat' => 'lokal',
                'judul_kegiatan' => 'Kerja Praktek',
                'manfaat_kegiatan' => 'Pengalaman kerja',
                'waktu' => '2018/12/15',
                'durasi' => '45 hari',
                'bukti' => 'bukti-1.pdf',
                'created_at' => now()
            ],
            [
                'kd_prodi' => StudyProgram::all()->random()->kd_prodi,
                'id_ta' => AcademicYear::all()->random()->id,
                'nama_lembaga' => 'Digital Printing',
                'tingkat' => 'lokal',
                'judul_kegiatan' => 'Magang',
                'manfaat_kegiatan' => 'Pengalaman kerja',
                'waktu' => '2018/07/07',
                'durasi' => '45 hari',
                'bukti' => 'bukti-2.pdf',
                'created_at' => now()
            ],
        ]);
    }
}
