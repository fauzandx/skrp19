@extends('layouts.master')

@section('title', 'Data Penelitian')

@section('style')
<link href="{{ asset ('assets/lib') }}/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="{{ asset ('assets/lib') }}/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        @foreach (Breadcrumbs::generate('research') as $breadcrumb)
            @if($breadcrumb->url && !$loop->last)
                <a class="breadcrumb-item" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
            @else
                <span class="breadcrumb-item">{{ $breadcrumb->title }}</span>
            @endif
        @endforeach
    </nav>
</div>
<div class="br-pagetitle">
    <i class="icon fa fa-book-reader"></i>
    <div>
        <h4>Data Penelitian</h4>
        <p class="mg-b-0">Olah Data Penelitian</p>
    </div>
    <div class="ml-auto">
        <a href="{{ route('research.add') }}" class="btn btn-teal btn-block mg-b-10" style="color:white"><i class="fa fa-plus mg-r-10"></i> Penelitian</a>
    </div>
</div>

<div class="br-pagebody">
    @if (session()->has('flash.message'))
        <div class="alert alert-{{ session('flash.class') }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('flash.message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <form action="{{route('ajax.research.filter')}}" id="filter-research" method="POST">
                <div class="filter-box d-flex flex-row bd-highlight mg-b-10">
                    <div class="mg-r-10">
                        <input id="nm_jurusan" type="hidden" value="{{setting('app_department_name')}}">
                        <select class="form-control" name="kd_prodi">
                            <option value="">- Pilih Program Studi -</option>
                            @foreach($studyProgram as $sp)
                            <option value="{{$sp->kd_prodi}}">{{$sp->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-purple btn-block " style="color:white">Cari</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="widget-2">
        <div class="card shadow-base mb-3">
            <div class="card-header nm_jurusan">
                <h6 class="card-title">{{ setting('app_department_name') }}</h6>
            </div>
            <div class="card-body bd-color-gray-lighter">
                <table id="table_research" class="table display responsive datatable" data-sort="desc" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center all">ID Penelitian</th>
                            <th class="text-center all" width="600">Judul Penelitian</th>
                            <th class="text-center defaultSort all" width="100">Tahun Penelitian</th>
                            <th class="text-center all" width="250">Penanggung Jawab</th>
                            <th class="text-center none">Tema Penelitian</th>
                            <th class="text-center none">Dosen Terlibat</th>
                            <th class="text-center none">Mahasiswa Terlibat</th>
                            <th class="text-center none">Sumber Biaya</th>
                            <th class="text-center none">Nominal Biaya</th>
                            <th class="text-center no-sort all" width="50">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penelitian as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->judul_penelitian }}</td>
                            <td class="text-center">{{ $p->academicYear->tahun_akademik.' - '.$p->academicYear->semester }}</td>
                            <td>
                                {{ $p->researchKetua->teacher->nama }}<br>
                                <small>NIDN.{{ $p->researchKetua->teacher->nidn }} / {{ $p->researchKetua->teacher->studyProgram->singkatan }}</small>
                            </td>
                            <td>{{ $p->tema_penelitian }}</td>
                            <td>
                                @if($p->researchAnggota->count())
                                <ol>
                                    @foreach ($p->researchAnggota as $ap)
                                    <li>{{$ap->teacher->nama}} - NIDN.{{$ap->teacher->nidn}} ({{$ap->teacher->studyProgram->department->nama }} - {{$ap->teacher->studyProgram->nama }})</li>
                                    @endforeach
                                </ol>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($p->researchStudent->count())
                                <ol>
                                    @foreach ($p->researchStudent as $rs)
                                    <li>{{$rs->student->nama}} - NIM.{{$rs->student->nim}} ({{$rs->student->studyProgram->department->nama }} - {{$rs->student->studyProgram->nama }})</li>
                                    @endforeach
                                </ol>
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ $p->sumber_biaya }} {{ $p->sumber_biaya_nama!='' ? '('.$p->sumber_biaya_nama.')' : ''}}</td>
                            <td>{{rupiah($p->jumlah_biaya)}}</td>
                            <td class="text-center" width="50">
                                <div class="btn-group" role="group">
                                    <button id="btn-action" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div><span class="fa fa-caret-down"></span></div>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-action">
                                        <a class="dropdown-item" href="{{ route('research.edit',encode_id($p->id)) }}">Sunting</a>
                                        <form method="POST">
                                            <input type="hidden" value="{{encode_id($p->id)}}" name="id">
                                            <button class="dropdown-item btn-delete" data-dest="{{ route('research.delete') }}">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- card-body -->
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/lib')}}/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/lib')}}/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets/lib')}}/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
@endsection
