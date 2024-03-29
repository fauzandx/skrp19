<div id="modal-teach-acv" class="modal fade effect-slide-in-right">
    <form method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content bd-0 tx-14 modal-form">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-16 mg-b-0 tx-uppercase tx-inverse tx-bold"><span class="title-action"></span> Prestasi/Pengakuan Dosen</h6>
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
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label"><span class="tx-danger">*</span> Prestasi/Pengakuan:</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="_id">
                            <input type="hidden" name="nidn" value="{{$data->nidn}}">
                            <input type="text" class="form-control" name="prestasi" placeholder="Tuliskan prestasi yang diraih" required>
                        </div>
                    </div>
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label"><span class="tx-danger">*</span> Tingkat Prestasi:</label>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4 mg-t-15">
                                    <label class="rdiobox">
                                        <input name="tingkat_prestasi" type="radio" value="Wilayah" required>
                                        <span>Wilayah</span>
                                    </label>
                                </div>
                                <div class="col-lg-4 mg-t-15">
                                    <label class="rdiobox">
                                        <input name="tingkat_prestasi" type="radio" value="Nasional" required>
                                        <span>Nasional</span>
                                    </label>
                                </div>
                                <div class="col-lg-4 mg-t-15">
                                    <label class="rdiobox">
                                        <input name="tingkat_prestasi" type="radio" value="Internasional" required>
                                        <span>Internasional</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label"><span class="tx-danger">*</span> Tanggal dicapai:</label>
                        <div class="col-sm-8">
                            <input class="form-control datepicker" type="text" name="tanggal_dicapai" value="{{Request::old('tanggal')}}" placeholder="Tuliskan tanggal prestasi dicapai" required>
                        </div>
                    </div>
                    <div class="form-group row mg-t-20">
                        <label class="col-sm-3 form-control-label"><span class="tx-danger">*</span> Bukti Prestasi:</label>
                        <div class="col-sm-8">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="bukti_pendukung" id="bukti_pendukung" {{ isset($data) ? '' : 'required'}}>
                                <label class="custom-file-label custom-file-label-primary" for="bukti_pendukung">Pilih fail</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium btn-save" value="post" data-dest="{{route('teacher.achievement.store')}}">
                        Simpan
                    </button>
                    <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </form>
</div><!-- modal -->
