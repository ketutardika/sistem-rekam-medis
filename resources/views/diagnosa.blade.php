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
                <button type="button" class="close" data-dismiss="modal" aria-diagnosael="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 {{ csrf_field() }}
                 {{ method_field('DELETE') }}
                 <p class="text-center">Apakah anda yakin untuk menghapus diagnosa? Data yang sudah dihapus tidak bisa kembali</p>
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

    <form action="{{route('diagnosa.import')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-3 row">
              <div class="col-sm-12 mb-3 mb-sm-0">
              <p>untuk file template Diagnosa bisa di download disini <a href="{{ url('/storage/public/data-template-import-diagnosa.xlsx') }}"> Data Diagnosa CSV Excel Import </a> </p>
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Diagnosa</h6>
            <a href="{{route('diagnosa.export')}}" class="d-sm-inline-block btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Export Data Diagnosa</a> 
            <a href="{{route('diagnosa.tambah')}}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah diagnosa</a> 
        </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="diagnosas" data-order='[[ 0, "desc" ]]' width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Kode Diagnosa</th>
                      <th>Nama Diagnosa</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>                  
            </div>
          </div>
          <div class="row align-items-center">
          <div class="col-sm-6">
             <a href="{{route('diagnosa.cetakpdf')}}" id="print2" data-id="" class="btn btn-secondary btn-block disabled">
              <span class="icon"><i class="fa  fa-print" ></i></span><span class="text"> Print Data</span></a>
          </div>
          <div class="col-sm-6">                                    
              <a href="{{route('diagnosa.cetakpdf')}}" class="btn btn-primary btn-block disabled">
              <span class="icon"><i class="fa fa-print"></i></span><span class="text"> Cetak PDF</span></a>
          </div>                                                        
          </div>
  <script type="text/javascript">
        $(document).ready( function () {
          
          var table = $('#diagnosas').DataTable({
              processing: true,
              serverSide: true,
              cache: false,
              ajax: "{{ route('diagnosa.json') }}",
              columns: [
                  {
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false,
                  },
                  {data: 'kode_diagnosa', name: 'kode_diagnosa'},
                  {data: 'nama_diagnosa', name: 'nama_diagnosa'},
                  {
                      data: 'tindakan', 
                      name: 'tindakan', 
                      orderable: true, 
                      searchable: true,
                  },
              ]
          });
  });
  </script>
  <script type="text/javascript">
     function deleteData(id)
     {
         var id = id;
         var url = '{{ route("diagnosa.destroy", ":id") }}';
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
    url: "{{route('diagnosa.print')}}",
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