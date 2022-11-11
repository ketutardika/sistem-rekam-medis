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
          <!-- Content Row -->
          <style type="text/css">
            .mb-12{
                margin-bottom: 1.5rem!important;
            }
            .table-responsive {overflow: hidden;}
          </style>
          <div class="row">
            <!-- Jumlah Pasien Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="{{route('pasien')}}"class="text-decoration-none card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pasien</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlah['pasien']}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-address-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <!-- Jumlah Pasien Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href ="{{route('rm')}}" class="text-decoration-none card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kunjungan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlah['kunjungan']}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-hands-helping fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <!-- Jumlah Pasien Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href ="{{route('lab')}}" class="card border-left-info text-decoration-none shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Fasilitas Lab</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$jumlah['lab']}}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-x-ray fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <!-- Jumlah Obat Terdaftar Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href ="{{route('obat')}}" class="text-decoration-none card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Obat Terdaftar</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlah['obat']}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-briefcase-medical fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <!-- Content Row -->
          <div class="row">
           <div class="col-xl-12">
              <div class="card shadow mb-12">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Pengguna Online : {{$jumlah['login']}}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="usersy" data-order='[[ 1, "desc" ]]' width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Pengguna</th>
                              <th>Status</th>
                              <th>IP</th>
                              <th>User Agent</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($users as $user)
                           @if(Cache::has('is_online' . $user->id))
                            <tr>
                              <td>{{ $user->name }}</td>
                              <td><span class="text-success">Online</span></td>
                              <td>{{$jumlah['ip']}}</td>
                              <td width="30%">{{$jumlah['agent']}}</td>
                            </tr>
                            @endif
                          @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Pasien Terbaru</h6>
                  <a href="{{route('pasien.tambah')}}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
                  <i class="fas fa-plus fa-sm"></i> Tambah Pasien</a> 
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" id="pasien" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No RM</th>
                      <th>Nama Lengkap</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No RM</th>
                      <th>Nama Lengkap</th>
                      <th>Tindakan</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  @foreach ($pasiens as $pasien)
                    <tr>
                      <td>{{$pasien->no_pasien }}</td>
                      <td>{{ $pasien->nama }}</td>
                      <td>
                        <a href ="{{route('rm.list', $pasien->id) }}" title="Buka RM" class="btn btn-circle btn-sm btn-primary">
                            <i class="fas fa-file"></i>
                        </a>
                        <a href ="{{ route('pasien.edit', $pasien->id) }}" title="Edit" class="btn btn-circle  btn-sm btn-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
                </div>
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Fasilitas Lab</h6>
                  <a href="{{route('lab.tambah')}}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
                    <i class="fas fa-plus fa-sm"></i> Tambah Lab</a> 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="lab" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Nama lab</th>
                              <th>Harga</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Nama lab</th>
                              <th>Harga</th>
                            </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($labs as $lab)
                            <tr>
                              <td>{{ $lab->nama }}</td>
                              <td>{{ formatrupiah($lab->harga)}}</td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div> 
          </div>
          <!-- Content Row -->
          <div class="row">
            <!-- Content Column -->
            <div class="col-lg-6 mb-4">
              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Kunjungan Terakhir</h6>
                  <a href="{{route('rm.tambah')}}" class="d-none btn-sm d-sm-inline btn btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm"></i> Tambah Kunjungan</a>
                  </a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" data-order='[[ 0, "desc" ]]' id="rm" width="100%" cellspacing="0">
                  <thead>
                      <th>Nama</th>
                      <th>Tanggal Periksa</th>
                      <th>Keluhan</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama</th>
                      <th>Tanggal Periksa</th>
                      <th>Keluhan</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  @foreach ($rms as $rm)
                    <tr>
                      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'nama')}}@endif</td>
                      <td>{{ format_date($rm->created_time) }}</td>
                      <td>{{ $rm->ku}}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header d-sm-flex align-items-center justify-content-between py-3">               
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Obat</h6>
                    <a href="{{route('obat.tambah')}}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
                    <i class="fas fa-plus fa-sm"></i> Tambah Obat</a> 
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="obat" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Nama Obat</th>
                              <th>Stok</th>
                              <th>Harga</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Nama Obat</th>
                              <th>Stok</th>
                              <th>Harga</th>
                            </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($obats as $obat)
                            <tr>
                              <td>{{ $obat->nama_obat }}</td>
                              <td>{{ $obat->stok }}</td>
                              <td>{{ formatrupiah($obat->harga)}}</td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                </div>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->
<script>
    $(document).ready( function () {
        var table = $('#usersy').DataTable( {
          order : [[ 1, "desc" ]],
          lengthChange : false,
          searching : false,
          bInfo : false,
          paging: false,
          scrollX: true,
        } )
      } );  
    $(document).ready( function () {
        var table = $('#pasien').DataTable( {
          pageLength : 5,
          lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
        } )
      } );
    $(document).ready( function () {
        var table = $('#lab').DataTable( {
          pageLength : 5,
          lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
        } )
      } );
    $(document).ready( function () {
        var table = $('#rm').DataTable( {
          pageLength : 5,
          lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
        } )
      } );
    $(document).ready( function () {
        var table = $('#obat').DataTable( {
          pageLength : 5,
          lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
        } )
      } );
</script>
@endsection