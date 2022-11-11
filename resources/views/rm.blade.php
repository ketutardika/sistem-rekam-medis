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
<style>
    ul.dash {
    list-style: none;
    margin-left: 0;
    padding-left: 1em;
    }
    ul.dash > li:before {
    display: inline-block;
    content: "-";
    width: 1em;
    margin-left: -1em;
    }
  </style>
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
                 <p class="text-center">Apakah anda yakin untuk menghapus Rekam Medis? Data yang sudah dihapus tidak bisa kembali</p>
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
    <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
            <div class="card-header d-sm-flex align-items-center justify-content-between py-3">               
            <h6 class="m-0 font-weight-bold text-primary">Jejak Rekam Medis</h6>
            <a href="{{ route('rm.tambah') }}" class="d-sm-inline-block btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah RM</a>             
            </div>
                
                
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="ListRM" style="">
                  <div class="card-body">
                   <div class="table-responsive">
                <table class="table table-bordered table-striped" id="pasien" data-order='[[ 0, "desc" ]]' width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Pasien</th>
                      <th>Tanggal Periksa</th>
                      <th>Tanggungan</th>
                      <th>Keluhan Utama</th>
                      <th>Diagnosa</th>
                      <th>Tindakan</th>
                      <th>Terapi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nama Pasien</th>
                      <th>Tanggal Periksa</th>
                      <th>Tanggungan</th>
                      <th>Keluhan Utama</th>
                      <th>Diagnosa</th>
                      <th>Tindakan</th>
                      <th>Terapi</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php $j=1; ?>
                  @foreach ($rms as $rm)
                    <tr>
                      <td><?php echo $j; ?></td>
                      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'nama')}}@endif</td>
                      <td>{{ format_date($rm->created_time) }}</td>                      
                      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'jenis_asuransi')}}@endif</td>
                      <td>{{ $rm->ku }}</td>
                      <td>
                      @if ($rm->diagnosa != NULL)
                        @for ($i=0;$i<sizeof($diagnosa=encode($rm->diagnosa));$i++)
                                <ul class="dash"><li>{{ get_value('diagnosa',$diagnosa[$i],'kode_diagnosa')}} {{ get_value('diagnosa',$diagnosa[$i],'nama_diagnosa')}}</li></ul>
                        @endfor
                      @endif
                      </td>
                      <td>
                      @if ($rm->tindakan != NULL)
                        @for ($i=0;$i<sizeof($tindakan=encode($rm->tindakan));$i++)
                                <ul class="dash"><li>{{ get_value('tindakan',$tindakan[$i],'nama')}}</li></ul>
                        @endfor
                      @endif
                      </td>
                      <td>
                      @if ($rm->resep != NULL)
                        @for ($i=0;$i<sizeof($resep=encode($rm->resep));$i++)
                            @if ($aturan=encode($rm->aturan))
                                <ul class="dash"><li>{{ get_value('obat',$resep[$i],'nama_obat')}} {{ get_value('obat',$resep[$i],'sediaan')}} {{ get_value('obat',$resep[$i],'dosis')}} {{ get_value('obat',$resep[$i],'satuan')}} : {{$aturan[$i]}}</li></ul>
                            @endif
                        @endfor
                      @endif
                      </td>
                      <td width="150px">
                        <a href="{{route('rm.edit', $rm->id)}}" class="btn btn-warning btn-sm btn-icon-split">
                        <span class="icon">
                        <i style="padding-top:4px"class="fas fa-pen"></i>
                        </span>
                        </a>
                        <a href="{{route('rm.lihat', $rm->id)}}" class="btn btn-success btn-sm btn-icon-split">
                        <span class="icon">
                        <i style="padding-top:4px"class="fas fa-eye"></i>
                        </span>
                        </a>
                        <a href="{{route('tagihan', $rm->id)}}" class="btn btn-secondary btn-sm btn-icon-split">
                        <span class="icon">
                        <i style="padding-top:4px"class="fas fa-cart-plus"></i>
                        </span>
                        </a>
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$rm->id}})" data-target="#DeleteModal" class="{{Auth::user()->profesi == "Staff" ? 'disabled': ''}} btn btn-sm btn-icon-split btn-danger">
                        <span class="icon"><i class="fa  fa-trash" style="padding-top: 4px;"></i></span></a>
                      </td>
                    </tr>
                  <?php $j++; ?>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
                  </div>
                </div>
    <script>
    $(document).ready( function () {
  var table = $('#pasien').DataTable( {
    pageLength : 10,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
  } )
} );
    </script>
<script type="text/javascript">
    var i = 0;
    var a = 0;
    function addpenunjang() {
        ++i;
        var pen= $("#penunjang option:selected").html();
        var penid= $("#penunjang").val();
        if (penid !== null) {
            //code
            $("#dynamicTable").append('<tr><td><input type="hidden" name="lab['+i+'][id]" value="'+penid+'" class="form-control" readonly></td><td><input type="text" name="lab['+i+'][nama]" value="'+pen+'" class="form-control" readonly></td><td><input type="text" name="lab['+i+'][hasil]" placeholder="Hasil" class="form-control" required></td><td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td></tr>');
        }    
    };
     function addresep() {
        ++a;
        var res= $("#reseplist option:selected").html();
        var resid= $("#reseplist").val();
        if (resid !== null) {
            //code
            $("#reseps").append('<tr><td><input type="hidden" name="resep['+a+'][id]" value="'+resid+'" class="form-control" readonly></td><td><input type="text" name="resep['+a+'][nama]" value="'+res+'" class="form-control" readonly></td><td><input type="text" name="resep['+a+'][jumlah]" placeholder="Jumlah" class="form-control" required><td><input type="text" name="resep['+a+'][aturan]" placeholder="Aturan pakai" class="form-control" required></td><td><button type="button" class="btn btn-danger remove-res">Hapus</button></td></tr>');
        }    
    };
    $(document).on('click', '.remove-pen', function(){  
         $(this).parents('tr').remove();
    });
    $(document).on('click', '.remove-res', function(){  
         $(this).parents('tr').remove();
    });  
</script>
    <script>
         function deleteData(id)
     {
         var id = id;
         var url = '{{ route("rm.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }
     function formSubmit()
     {
         $("#deleteForm").submit();
     }
  </script>
@endsection