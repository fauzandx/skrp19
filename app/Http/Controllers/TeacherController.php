<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use App\StudyProgram;
use App\AcademicYear;
use App\Ewmp;
use App\Faculty;
use App\CurriculumSchedule;
use App\TeacherAchievement;
use File;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $studyProgram = StudyProgram::where('kd_jurusan',setting('app_department_id'))->get();
        $faculty      = Faculty::all();
        $data         = Teacher::whereHas(
                            'studyProgram', function($query) {
                                $query->where('kd_jurusan',setting('app_department_id'));
                            })
                        ->get();

        return view('teacher/index',compact(['studyProgram','faculty','data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculty = Faculty::all();
        $studyProgram = StudyProgram::where('kd_jurusan',setting('app_department_id'))->get();

        return view('teacher/form',compact(['faculty','studyProgram']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nidn'                  => 'required|numeric|min:8',
            'kd_prodi'              => 'required',
            'nip'                   => 'required|numeric|digits:18',
            'nama'                  => 'required',
            'jk'                    => 'required',
            'agama'                 => 'nullable',
            'tpt_lhr'               => 'nullable',
            'tgl_lhr'               => 'nullable',
            'email'                 => 'email|nullable',
            'pend_terakhir_jenjang' => 'nullable',
            'pend_terakhir_jurusan' => 'nullable',
            'bidang_ahli'           => 'nullable',
            'sesuai_bidang_ps'      => 'nullable',
            'ikatan_kerja'          => 'required',
            'jabatan_akademik'      => 'required',
        ]);

        $bidang_ahli = explode(", ",$request->bidang_ahli);

        $Teacher                            = new Teacher;
        $Teacher->nidn                      = $request->nidn;
        $Teacher->kd_prodi                  = $request->kd_prodi;
        $Teacher->nip                       = $request->nip;
        $Teacher->nama                      = $request->nama;
        $Teacher->jk                        = $request->jk;
        $Teacher->agama                     = $request->agama;
        $Teacher->tpt_lhr                   = $request->tpt_lhr;
        $Teacher->tgl_lhr                   = $request->tgl_lhr;
        $Teacher->alamat                    = $request->alamat;
        $Teacher->no_telp                   = $request->no_telp;
        $Teacher->email                     = $request->email;
        $Teacher->pend_terakhir_jenjang     = $request->pend_terakhir_jenjang;
        $Teacher->pend_terakhir_jurusan     = $request->pend_terakhir_jurusan;
        $Teacher->bidang_ahli               = json_encode($bidang_ahli);
        $Teacher->ikatan_kerja              = $request->ikatan_kerja;
        $Teacher->jabatan_akademik          = $request->jabatan_akademik;
        $Teacher->sertifikat_pendidik       = $request->sertifikat_pendidik;
        $Teacher->sesuai_bidang_ps          = $request->sesuai_bidang_ps;

        if($request->file('foto')) {
            $file = $request->file('foto');
            $tgl_skrg = date('Y_m_d_H_i_s');
            $tujuan_upload = 'upload/teacher';
            $filename = $request->nidn.'_'.str_replace(' ', '', $request->nama).'_'.$tgl_skrg.'.'.$file->getClientOriginalExtension();
            $file->move($tujuan_upload,$filename);
            $Teacher->foto = $filename;
        }

        $Teacher->save();

        return redirect()->route('teacher')->with('flash.message', 'Data berhasil ditambahkan!')->with('flash.class', 'success');
    }

    public function import()
    {
        $studyProgram = StudyProgram::all();
        return view('teacher/import',compact('studyProgram'));
    }

    public function store_import()
    {
        $studyProgram = StudyProgram::all();
        return view('teacher/form',compact('studyProgram'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function profile($nip)
    {
        $nip               = decode_id($nip);
        $data              = Teacher::where('nip',$nip)->first();
        $data->bidang_ahli = json_decode($data->bidang_ahli);

        $academicYear   = AcademicYear::orderBy('tahun_akademik','desc')->orderBy('semester','desc')->get();
        $schedule       = CurriculumSchedule::where('nidn',$data->nidn)->orderBy('kd_matkul','asc')->get();
        $ewmp           = Ewmp::where('nidn',$data->nidn)->orderBy('id_ta','desc')->get();
        $achievement    = TeacherAchievement::where('nidn',$data->nidn)->orderBy('tanggal','desc')->get();

        return view('teacher/profile',compact(['data','academicYear','schedule','ewmp','achievement']));
    }

    public function show_by_prodi(Request $request)
    {
        $data = Teacher::where('kd_prodi',$request->kd_prodi)->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($nip)
    {
        $nip          = decode_id($nip);
        $data         = Teacher::where('nip',$nip)->first();
        $faculty      = Faculty::all();
        $studyProgram = StudyProgram::where('kd_jurusan',$data->studyProgram->kd_jurusan)->get();

        $bidang = json_decode($data->bidang_ahli);
        $data->bidang_ahli   = implode(', ',$bidang);

        return view('teacher/form',compact(['data','faculty','studyProgram']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id  = decrypt($request->_id);

        $request->validate([
            'kd_prodi'              => 'required',
            'nip'                   => 'required|numeric|digits:18',
            'nama'                  => 'required',
            'jk'                    => 'required',
            'agama'                 => 'nullable',
            'tpt_lhr'               => 'nullable',
            'tgl_lhr'               => 'nullable',
            'email'                 => 'email|nullable',
            'pend_terakhir_jenjang' => 'nullable',
            'pend_terakhir_jurusan' => 'nullable',
            'bidang_ahli'           => 'nullable',
            'sesuai_bidang_ps'      => 'nullable',
            'ikatan_kerja'          => 'required',
            'jabatan_akademik'      => 'required',
        ]);

        $bidang_ahli = explode(", ",$request->bidang_ahli);

        $Teacher                            = Teacher::find($id);
        $Teacher->kd_prodi                  = $request->kd_prodi;
        $Teacher->nip                       = $request->nip;
        $Teacher->nama                      = $request->nama;
        $Teacher->jk                        = $request->jk;
        $Teacher->agama                     = $request->agama;
        $Teacher->tpt_lhr                   = $request->tpt_lhr;
        $Teacher->tgl_lhr                   = $request->tgl_lhr;
        $Teacher->alamat                    = $request->alamat;
        $Teacher->no_telp                   = $request->no_telp;
        $Teacher->email                     = $request->email;
        $Teacher->pend_terakhir_jenjang     = $request->pend_terakhir_jenjang;
        $Teacher->pend_terakhir_jurusan     = $request->pend_terakhir_jurusan;
        $Teacher->bidang_ahli               = json_encode($bidang_ahli);
        $Teacher->ikatan_kerja              = $request->ikatan_kerja;
        $Teacher->jabatan_akademik          = $request->jabatan_akademik;
        $Teacher->sertifikat_pendidik       = $request->sertifikat_pendidik;
        $Teacher->sesuai_bidang_ps          = $request->sesuai_bidang_ps;

        $storagePath = 'upload/teacher/'.$Teacher->foto;
        if($request->file('foto')) {
            if(File::exists($storagePath)) {
                File::delete($storagePath);
            }

            $file = $request->file('foto');
            $tgl_skrg = date('Y_m_d_H_i_s');
            $tujuan_upload = 'upload/teacher';
            $filename = $request->nidn.'_'.str_replace(' ', '', $request->nama).'_'.$tgl_skrg.'.'.$file->getClientOriginalExtension();
            $file->move($tujuan_upload,$filename);
            $Teacher->foto = $filename;
        }

        $Teacher->save();


        return redirect()->route('teacher.profile',encode_id($Teacher->nip))->with('flash.message', 'Data berhasil disunting!')->with('flash.class', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(request()->ajax()) {

            $id = decode_id($request->id);
            $q = Teacher::destroy($id);
            if(!$q) {
                return response()->json([
                    'title'   => 'Gagal',
                    'message' => 'Terjadi kesalahan saat menghapus',
                    'type'    => 'error'
                ]);
            } else {
                return response()->json([
                    'title'   => 'Berhasil',
                    'message' => 'Data berhasil dihapus',
                    'type'    => 'success'
                ]);
            }
        } else {
            return redirect()->route('teacher.achievement');
        }
    }

    public function download($filename)
    {
        $file = decrypt($filename);

        $storagePath = 'upload/teacher/'.$file;
        if( ! File::exists($storagePath)) {
            abort(404);
        } else {
            $mimeType = File::mimeType($storagePath);
            $headers = array(
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="'.$file.'"'
            );

            return response(file_get_contents($storagePath), 200, $headers);
        }
    }

    public function get_by_department(Request $request)
    {
        if($request->ajax()) {

            $kd = $request->input('kd_jurusan');

            if($kd == 0){
                $data = Teacher::with(['studyProgram.department.faculty'])->orderBy('created_at','desc')->get();
            } else {
                $data = Teacher::whereHas(
                            'studyProgram', function($query) use ($kd) {
                                $query->where('kd_jurusan',$kd);
                            })
                        ->with(['studyProgram.department.faculty'])
                        ->get();
            }

            return response()->json($data);
        } else {
            abort(404);
        }
    }

    public function get_by_filter(Request $request)
    {
        if($request->ajax()) {

            $q = Teacher::with(['studyProgram.department.faculty']);

            if($request->kd_jurusan) {
                $q->whereHas(
                    'studyProgram', function($query) use($request) {
                        $query->where('kd_jurusan',$request->kd_jurusan);
                    });
            }

            if($request->kd_prodi){
                $q->where('kd_prodi',$request->kd_prodi);
            }

            $data = $q->orderBy('created_at','desc')->get();

            return response()->json($data);
        } else {
            abort(404);
        }
    }

    public function get_by_studyProgram(Request $request)
    {
        if($request->ajax()) {

            $data = Teacher::where('kd_prodi',$request->kd_prodi)->select('nidn','nama')->get();

            return response()->json($data);
        } else {
            abort(404);
        }
    }

    public function loadData(Request $request)
    {
        if($request->has('cari')){
            $cari = $request->cari;
            $data = Teacher::where('nidn', 'LIKE', '%'.$cari.'%')->orWhere('nama', 'LIKE', '%'.$cari.'%')->get();

            $response = array();
            foreach($data as $d){
                $response[] = array(
                    "id"    => $d->nidn,
                    "text"  => $d->nama
                );
            }
            return response()->json($response);
        }
    }
}
