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
<?php
function hitung_umur($tanggal_lahir){
  if (!empty($tanggal_lahir)){
    $birthDate = new DateTime($tanggal_lahir);
  }
  else{
    $birthDate = new DateTime("today");
  }
  $today = new DateTime("today");
  if ($birthDate > $today) { 
      exit("0 tahun 0 bulan 0 hari");
  }
  $y = $today->diff($birthDate)->y;
  $m = $today->diff($birthDate)->m;
  $d = $today->diff($birthDate)->d;
  return $y." tahun ";
}
$sd = strval($_GET['start_date']);
$ed = strval($_GET['end_date']);
?>
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
        
    <div class="card shadow mb-4" id="print">                  
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Laporan Rekam Medis</h6>
                  <a href="{{ route('rm.cetaklaporan') }}?start_date=<?php echo $sd; ?>&end_date=<?php echo $ed; ?>" target="_blank" class="d-sm-inline-block btn btn-primary btn-sm shadow-sm">
                  <i class="fas fa-plus fa-sm"></i> Cetak Laporan</a> 
                </div>
 <!-- Card Content - Collapse -->
                <div class="collapse show" id="ListRM" style="">
                  <div class="card-body">

                    <form action="{{ route('rm.laporan') }}" method="GET">
                        <div class="input-group mb-3">
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="date" class="form-control" name="start_date" value="<?php echo $sd; ?>">
                            </div>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="date" class="form-control" name="end_date" value="<?php echo $ed; ?>">
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <button class="btn btn-primary" type="submit" style="width: 100%;">Filter</button>
                            </div>
                        </div>
                    </form>
                  
                   <div class="table-responsive">
                <table class="table table-bordered table-striped" id="pasien" width="100%" cellspacing="0" data-order='[[ 0, "desc" ]]'>
                  <thead>
                    <tr>
                      <th>#</th>                     
                      <th>Tanggal</th>
                      <th>Nama Pasien</th>
                      <th>Jenis kelamin</th>
                      <th>Umur</th>
                      <th>Tanggungan</th>
                      <th>Diagnosa</th>
                      <th>Terapi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $j=1; ?>
                  @foreach ($rms as $rm)
                    <tr>
                      <td><?php echo $j; ?></td>
                      <!-- <td>{{str_pad($rm->idpasien, 4, '0', STR_PAD_LEFT)  }}</td> -->
                      <td>{{ format_date($rm->created_time) }}</td>
                      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'nama')}}@endif</td>
                      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'jk')}}@endif</td>
                      <td>@if ($rm->idpasien != NULL)
                        {{hitung_umur(get_value('pasien',$rm->idpasien,'tgl_lhr'))}}                    
                      @endif
                      </td>
                      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'jenis_asuransi')}}@endif</td>
                      <td>
                      @if ($rm->diagnosa != NULL)
                        @for ($i=0;$i<sizeof($diagnosa=encode($rm->diagnosa));$i++)
                                <ul class="dash"><li>{{ get_value('diagnosa',$diagnosa[$i],'kode_diagnosa')}} {{ get_value('diagnosa',$diagnosa[$i],'nama_diagnosa')}}</li></ul>
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
     function print() {
        $('#print').printThis();
    }
  </script>
@endsection