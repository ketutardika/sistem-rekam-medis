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
<!--Modal Konfirmasi Delete-->
    <div id="DeleteModal" class="modal fade text-danger" role="dialog">
   <div class="modal-dialog modal-dialog modal-dialog-centered ">
   </div>
  </div>
<!--End Modal-->
    <div class="card shadow mb-4">
        <div class="card-header d-sm-flex align-items-center justify-content-between py-3"> 
            <a href="{{route('refresh-cache')}}" class="d-sm-inline-block btn btn-primary btn-sm shadow-sm">
              <i class="fas fa-plus fa-sm"></i> Clear Cache</a>         
            <a href="{{route('pengaturan.refreshdatabase')}}" class="disabled d-sm-inline-block btn btn-primary btn-sm shadow-sm">
              <i class="fas fa-plus fa-sm"></i> Refresh & Reset Database</a>             
        </div>
    </div>
@endsection