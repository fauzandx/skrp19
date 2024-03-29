@extends('layouts.master')

@section('title', isset($data) ? 'Edit Data Publikasi' : 'Tambah Data Publikasi')

@section('content')
<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        @foreach (Breadcrumbs::generate( isset($data) ? 'publication-edit' : 'publication-add', isset($data) ? $data : '' ) as $breadcrumb)
            @if($breadcrumb->url && !$loop->last)
                <a class="breadcrumb-item" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
            @else
                <span class="breadcrumb-item">{{ $breadcrumb->title }}</span>
            @endif
        @endforeach
    </nav>
</div>

<div class="br-pagetitle">
        <i class="icon fa fa-pen-square"></i>
        @if(isset($data))
        <div>
            <h4>Sunting</h4>
            <p class="mg-b-0">Sunting Data Publikasi</p>
        </div>
        @else
        <div>
            <h4>Tambah</h4>
            <p class="mg-b-0">Tambah Data Publikasi</p>
        </div>
        @endif
    </div>

<div class="br-pagebody">
    @if($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif
    <div class="widget-2">
        <div class="card mb-3">
            <form id="publication_form" action="{{route('publication.store')}}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                <div class="card-body bd bd-y-0 bd-color-gray-lighter">
                    <div class="row">
                        <div class="col-9 mx-auto">
                            @csrf
                            @if(isset($data))
                                @method('put')
                                <input type="hidden" name="id" value="{{encrypt($data->id)}}">
                            @else
                                @method('post')
                            @endif
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Program Studi: <span class="tx-danger">*</span></label>
                                <div class="col-8">
                                    <select id="prodi_dosen" class="form-control" name="kd_prodi" required>
                                        <option value="">- Pilih Prodi -</option>
                                        @foreach($studyProgram as $sp)
                                        <option value="{{$sp->kd_prodi}}" {{ (isset($data) && ($sp->kd_prodi==$data->teacher->kd_prodi) || Request::old('kd_prodi')==$sp->kd_prodi) ? 'selected' : ''}}>{{$sp->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Dosen: <span class="tx-danger">*</span></label>
                                <div class="col-8">
                                    <select id="select-dosen" class="form-control" name="nidn" required>
                                        <option value="">- Pilih Dosen -</option>
                                        @isset($data)
                                        @foreach ($teacher as $t)
                                            <option value="{{$t->nidn}}" {{$data->nidn == $t->nidn ? 'selected':''}}>{{$t->nama}}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Jenis Publikasi: <span class="tx-danger">*</span></label>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-9">
                                            <select class="form-control" name="jenis_publikasi" required>
                                                <option value="">- Pilih Jenis Publikasi -</option>
                                                @foreach ($jenis as $j)
                                                    <option value="{{$j->id}}" {{isset($data) && $data->jenis_publikasi == $j->id ? 'selected':''}}>{{$j->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <a href="{{ route('publication.category') }}" class="btn btn-teal btn-block mg-b-10" style="color:white">Tambah Kategori</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Judul: <span class="tx-danger">*</span></label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="judul" value="{{ isset($data) ? $data->judul : Request::old('judul')}}" placeholder="Contoh: Permasalahan Permukiman Perdesaan Di Indonesia: Kajian geografi Permukiman" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Penerbit: <span class="tx-danger">*</span></label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="penerbit" value="{{ isset($data) ? $data->penerbit : Request::old('penerbit')}}" placeholder="Contoh: Kenangan Press" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Tahun Terbit: <span class="tx-danger">*</span></label>
                                <div class="col-8">
                                    <input class="form-control number" type="text" name="tahun" value="{{ isset($data) ? $data->tahun : Request::old('tahun')}}" placeholder="Masukkan tahun penerbitan" maxlength="4" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Nama Jurnal:</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="jurnal" value="{{ isset($data) ? $data->jurnal : Request::old('jurnal')}}" placeholder="Contoh: Asian Social Science Vol.9, No.12">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Jumlah Sitasi:</label>
                                <div class="col-8">
                                    <input class="form-control number" type="text" name="sitasi" value="{{ isset($data) ? $data->sitasi : Request::old('sitasi')}}" placeholder="Masukkan jumlah sitasi">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Akreditasi:</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="akreditasi" value="{{ isset($data) ? $data->akreditasi : Request::old('akreditasi')}}" placeholder="Jika belum terakreditasi, dikosongkan saja">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-3 form-control-label">Tautan:</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="tautan" value="{{ isset($data) ? $data->tautan : Request::old('tautan')}}" placeholder="Jika belum ada tautan digital, dikosongkan saja">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-9 mx-auto">
                            <h3 class="text-center mb-3">Daftar Mahasiswa</h3>
                            @isset($data)
                            <div id="daftarMahasiswa">
                                @foreach ($data->publicationStudents as $i => $ps)
                                <div class="row mb-3 align-items-center">
                                    <button class="btn btn-danger btn-sm btn-delget" data-dest="{{ route('publication.students.delete',encode_id($data->id)) }}" data-id="{{encrypt($ps->id)}}"><i class="fa fa-times"></i></button>
                                    <div class="col-2">
                                        <input class="form-control number" type="text" name="mahasiswa_nim[]" value="{{ $ps->nim }}" placeholder="NIM" maxlength="9" readonly>
                                    </div>
                                    <div class="col-5">
                                        <input class="form-control" type="text" name="mahasiswa_nama[]" value="{{ $ps->nama }}" placeholder="Nama Mahasiswa" required>
                                    </div>
                                    <div class="col-4">
                                        <div id="prodiMhs{{$i}}" class="parsley-select">
                                            <select class="form-control select-prodi" data-parsley-class-handler="#prodiMhs{{$i}}" data-parsley-errors-container="#errorsProdiMhs{{$i}}" name="mahasiswa_prodi[]" required>
                                                <option value="{{$ps->kd_prodi}}">{{$ps->studyProgram->nama}}</option>
                                            </select>
                                        </div>
                                        <div id="errorsProdiMhs{{$i}}"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endisset
                            <div id="panelMahasiswa" data-jumlah="0"></div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                <a class="add-mahasiswa btn btn-primary" href="javascript:void(0)"><i class="fa fa-plus pd-r-10"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- card-body -->
                <div class="card-footer bd bd-color-gray-lighter rounded-bottom">
                    <div class="row">
                        <div class="col-6 mx-auto">
                            <div class="text-center">
                                <button class="btn btn-info btn-submit">Simpan</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div><!-- card-footer -->
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
