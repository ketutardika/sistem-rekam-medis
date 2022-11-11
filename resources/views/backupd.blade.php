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
            <!-- <a href="{{ url('backup/seluruh') }}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
              <i class="fas fa-plus fa-sm"></i> Backup Sistem & Database</a>   -->       
            <a href="{{ url('backup/create') }}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
              <i class="fas fa-plus fa-sm"></i> Backup Database</a> 
            
        </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama File</th>
                      <th>Ukuran File</th>
                      <th>Di Buat Tanggal</th>
                      <th>Di Buat</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($backups as $backup)
                    
                    <tr>
                      <td>{{ $backup['file_name'] }}</td>
                      <td>{{ \App\Http\Controllers\BackupController::humanFilesize($backup['file_size']) }}</td>
                      <td>
                          <?php
                          date_default_timezone_set('Asia/Makassar');
                          ?>
                          {{ date('F jS, Y, H:i',$backup['last_modified']) }}
                      </td>
                      <td>
                          {{ \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans() }}
                      </td>
                      <td>
                        <a href ="{{ url('backup/download/'.$backup['file_name']) }}" class="btn btn-sm btn-icon-split btn-success">
                            <span class="icon"><i class="fa fa-cloud-download" style="padding-top: 4px;"></i></span><span class="text">Download</span>
                        </a>
                        <a onclick="return confirm('Apakah anda ingin menghapus data backup ini??')"  data-button-type="delete" class="btn btn-sm btn-icon-split btn-danger" href="{{ url('backup/delete/'.$backup['file_name']) }}">
                            <span class="icon"><i class="fa  fa-trash" style="padding-top: 4px;"></i></span><span class="text">Hapus</span></a>
                        <a href ="{{route('backup.kirim', $backup['file_name'])}}" class="btn btn-sm btn-icon-split btn-primary">
                            <span class="icon"><i class="fa fa-cloud-download" style="padding-top: 4px;"></i></span><span class="text">Kirim Email</span>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
@endsection