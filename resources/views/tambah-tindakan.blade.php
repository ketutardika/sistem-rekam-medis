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
                  <h6 class="m-0 font-weight-bold text-primary">Formulir Penambahan Tindakan Baru</h6>
                </div>
                <div class="card-body">
                    <form class="user" action="{{route('tindakan.simpan')}}" method="post">
                    {{csrf_field()}}
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " name="no_tindakan" value="{{ $nomertdk }}" placeholder="Nama Pemeriksaan Tindakan" required readonly="">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " name="nama_tindakan" placeholder="Nama Pemeriksaan Tindakan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-bill-wave fa-fw"></i></div>
                                    </div>
                                <input type="text" class="form-control " name="harga"  placeholder="Harga" required>
                            </div></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <a href="{{route('tindakan')}}" class="btn btn-danger btn-block btn">
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