@extends('master')
@foreach ($metadatas as $metadata)
    @section('judul_halaman')
        {{ $metadata->Judul }}
    @endsection
    @section('deskripsi_halaman')
        {{ $metadata->Deskripsi }}
    @endsection
@endforeach
@section('konten')

    <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Formulir Penambahan Diagnosa Baru</h6>
                </div>
                <div class="card-body">
                    <form class="user" action="{{route('diagnosa.simpan')}}" method="post">
                    {{csrf_field()}}
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " name="kode_diagnosa" placeholder="Kode Pemeriksaan Diagnosa" required>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " name="nama_diagnosa"  placeholder="Nama Pemeriksaan Diagnosa" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave fa-fw"></i></div>
                                    </div>
                                <textarea class="form-control " name="keterangan"  placeholder="Keterangan"></textarea>
                            </div></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <a href="{{route('diagnosa')}}" class="btn btn-danger btn-block btn">
                                    <i class="fas fa-arrow-left fa-fw"></i> Kembali
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-block" name="simpan" value="simpan" >
                                    <i class="fas fa-save fa-fw"></i> Simpan
                                </button>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-warning btn-block" name ="simpan" value="simpan_baru">
                                    <i class="fas fa-plus fa-fw"></i> Simpan Dan Buat Baru
                                </button>
                            </div>    
                            </div>                      
                    </form>
                </div>
    </div>
@endsection