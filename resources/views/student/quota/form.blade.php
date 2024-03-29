<div id="modal-student-quota" class="modal fade effect-slide-in-right">
    <form method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content bd-0 tx-14 modal-form">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-16 mg-b-0 tx-uppercase tx-inverse tx-bold"><span class="title-action"></span> Kuota Mahasiswa</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20">
                    <div class="alert alert-danger" style="display:none">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 form-control-label">Jurusan: <span class="tx-danger">*</span></label>
                        <div class="col-8">
                            <select class="form-control" name="kd_jurusan" data-type="form" disabled>
                                <option value="">- Pilih Jurusan -</option>
                                @foreach($faculty as $f)
                                    @if($f->department->count())
                                    <optgroup label="{{$f->nama}}">
                                        @foreach($f->department as $d)
                                        <option value="{{$d->kd_jurusan}}" {{ $d->kd_jurusan==setting('app_department_id') ? 'selected': ''}}>{{$d->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 form-control-label">Program Studi: <span class="tx-danger">*</span></label>
                        <div class="col-8">
                            <select class="form-control" name="kd_prodi" required>
                                <option value="">- Pilih Prodi -</option>
                                @foreach($studyProgram as $sp)
                                <option value="{{$sp->kd_prodi}}" {{ (Request::old('kd_prodi')==$sp->kd_prodi) ? 'selected' : ''}}>{{$sp->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label">Tahun Akademik: <span class="tx-danger">*</span> </label>
                        <div class="col-sm-8">
                            <input type="hidden" name="_id">
                            <select class="form-control" name="id_ta">
                                <option value="">= Pilih Tahun Akademik =</option>
                                @foreach ($academicYear as $ay)
                                    <option value="{{$ay->id}}">{{$ay->tahun_akademik.' - '.$ay->semester}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label">Daya Tampung: <span class="tx-danger">*</span> </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="daya_tampung" placeholder="Daya tampung mahasiswa per tahun akademik" value="0" required>
                        </div>
                    </div>
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label">Calon Pendaftar:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="calon_pendaftar" placeholder="Jumlah calon mahasiswa yang mendaftar ke Program Studi" value="0">
                        </div>
                    </div>
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label">Calon Lulus:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="calon_lulus" placeholder="Jumlah calon mahasiswa yang lulus di Program Studi" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium btn-save" value="post" data-dest="{{route('student.quota.store')}}">
                        Simpan
                    </button>
                    <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </form>
</div><!-- modal -->
