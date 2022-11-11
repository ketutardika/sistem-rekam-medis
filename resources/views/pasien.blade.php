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
     <!-- Modal content-->
     <form action="" id="deleteForm" method="post">
         <div class="modal-content">
             <div class="modal-header bg-danger">
                 <h4 class="modal-title text-center text-white" >Konfirmasi Penghapusan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 {{ csrf_field() }}
                 {{ method_field('DELETE') }}
                 <p class="text-center">Apakah anda yakin untuk menghapus pasien? Data yang sudah dihapus tidak bisa kembali</p>
             </div>
             <div class="modal-footer">
                 <center>
                     <button type="button" class="btn btn-success" data-dismiss="modal">Tidak, Batal</button>
                     <button type="button" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Ya, Hapus</button>
                 </center>
             </div>
         </div>
     </form>
   </div>
  </div>
<!--End Modal-->
    <form action="{{route('pasien.import')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-3 row">
              <div class="col-sm-12 mb-3 mb-sm-0">
              <p>untuk file template Pasien bisa di download disini <a href="{{ url('/storage/public/data-template-import-pasien.xlsx') }}"> Data Pasien CSV Excel Import </a> </p>
              </div>
              <div class="col-sm-11 mb-3 mb-sm-0">
                <input type="file" name="file" class="form-control" placeholder="Masukan File CSV atau Excel" aria-label="Masukan File CSV atau Excel" aria-describedby="button-addon2">
              </div>
              <div class="col-sm-1 mb-3 mb-sm-0">
                <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
              </div>
              <div class="clearfix"></div>
            </div>
        </form>


    <div class="card shadow mb-4">
        <div class="card-header d-sm-flex align-items-center justify-content-between py-3">               
            <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
            <a href="{{route('pasien.export')}}" class="d-sm-inline-block btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Export Data Pasien</a> 
            <a href="{{route('pasien.tambah')}}" class="d-sm-inline-block btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Pasien</a> 
            
        </div>
            <div class="card-body">

              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" data-order='[[ 0, "desc" ]]' width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Lengkap</th>
                      <th>ID Pasien</th>
                      <th>Usia</th>
                      <th>Jenis Kelamin</th>
                      <th>Alamat</th>
                      <th>No. Hp</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nama Lengkap</th>
                      <th>ID Pasien</th>
                      <th>Usia</th>
                      <th>Jenis Kelamin</th>
                      <th>Alamat</th>
                      <th>No. Hp</th>
                      <th>Tindakan</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php $i=1; ?>
                  @foreach ($pasiens as $pasien)
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td>{{ $pasien->nama }}</td>
                      <td>{{ $pasien->no_pasien }}</td>
                      <td>{{ hitung_usia($pasien->tgl_lhr) }}</td>
                      <td>{{ $pasien->jk }}</td>
                      <td class="text-truncate" style="max-width: 150px;">{{ $pasien->alamat }}</td>
                      <td>{{ $pasien->hp }}</td>
                      <td>
                        <a href ="{{route('rm.list', $pasien->id) }}" title="Buka RM" class="btn btn-circle btn-primary">
                            <i class="fas fa-file"></i>
                        </a>
                        <a href ="{{ route('pasien.edit', $pasien->id) }}" title="Edit" class="btn btn-circle btn-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pasien->id}})" data-target="#DeleteModal" class="{{Auth::user()->profesi == "Staff" ? 'disabled': ''}} btn btn-circle btn-danger"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php $i++; ?>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="row align-items-center">

          <div class="col-sm-6">
              <a href="{{route('pasien.print')}}" id="print2" data-id="" class="btn btn-secondary btn-block">
              <span class="icon"><i class="fa  fa-print" ></i></span><span class="text"> Print Data</span></a>
          </div>
          <div class="col-sm-6">                                    
              <a href="{{route('pasien.cetakpdf')}}" class="btn btn-primary btn-block">
              <span class="icon"><i class="fa fa-print"></i></span><span class="text"> Cetak PDF</span></a>
          </div>                                                        
          </div> 
  <script type="text/javascript">
     function deleteData(id)
     {
         var id = id;
         var url = '{{ route("pasien.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
  </script>
    <script type="text/javascript">
    $('#print2').on('click', function() {
    event.preventDefault();
    let CSRF_TOKEN = $('meta[name="csrf-token"').attr('content');
    var ids  = $('#print2').attr('data-id')

  $.ajaxSetup({
    url: "{{route('pasien.print')}}",
    type: 'POST',
    data: {
      id:ids,
      _token: '{{csrf_token()}}'
    },
    beforeSend: function() {
      console.log('printing ...');
    },
    complete: function() {
      console.log('printed!');
    }
  });

  $.ajax({
    success: function(viewContent) {
      $.print(viewContent); // This is where the script calls the printer to print the viwe's content.
    }
  });
});
</script>
@endsection