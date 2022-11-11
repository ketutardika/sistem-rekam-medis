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
        <div class="card shadow mb-4" id="print1">
                <a href="#Identitas" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="Identitas">
                  <h6 class="m-0 font-weight-bold text-primary">Identitas Pasien</h6></a>
                <div class="collapse show" id="Identitas">
                <div class="card-body">
                    @foreach ($idens as $iden)
                    <form class="user" action="">
                          <div class="form-group row">                          
                          <div class="@if ($iden->jenis_asuransi == 'BPJS') col-sm-4 @else col-sm-6 @endif mb-3 mb-sm-0">
                                <label for="no_bpjs">Jenis Tanggungan</label>
                                <input type="text" class="form-control " name="jenis_asuransi" value="{{$iden->jenis_asuransi}}" readonly>
                          </div>
                          @if ($iden->jenis_asuransi == 'BPJS')
                          <div class="col-sm-4">
                            <label for="no_handphone">No BPJS</label>
                            <input type="text" class="form-control " name="no_handphone"  value="{{$iden->no_bpjs}}" readonly>
                          </div>
                          @endif
                          <div class="@if ($iden->jenis_asuransi == 'BPJS') col-sm-4 @else col-sm-6 @endif ">
                            <label for="no_handphone">ID Pasien</label>
                            <input type="text" class="form-control " name="no_handphone"  value="{{$iden->no_pasien}}" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control " name="Nama_Lengkap" value="{{$iden->nama}}" readonly>
                            </div>
                             <div class="col-sm-6">
                                <label for="jk">Jenis Kelamin</label>
                                <input type="text" class="form-control " name="jk" value="{{$iden->jk}}" readonly> 
                              </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <label for="Tanggal_Lahir">Tanggal lahir :</label>
                            <input type="date" class="form-control " id="Tanggal_Lahir" name="Tanggal_Lahir"  value="{{$iden->tgl_lhr}}" readonly>
                          </div>
                           <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="jk">Umur</label>
                                <input type="text" class="form-control " id="umur" name="umur" value="" readonly> 
                              </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="Alamat">Alamat</label>
                                <input type="text" class="form-control " name="Alamat"  value="{{$iden->alamat}}" readonly>   
                            </div>
                            <div class="col-sm-6">
                            <label for="no_handphone">No. Handphone</label>
                            <input type="text" class="form-control " name="no_handphone"  value="{{$iden->hp}}" readonly>
                          </div>

                            </div>
                        

                    </form>
                    @endforeach
                
                </div>
                </div>
    </div>
    <div id="print" class="card shadow mb-4">
                <a href="#tambahrm" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="tambahrm">
                  <h6 class="m-0 font-weight-bold text-primary">Tagihan Kunjungan Pasien </h6></a>                  
                <div class="collapse show" id="tambahrm">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                            @foreach ($idens as $iden)
                                <h6 class="mb-3">Kepada:</h6>
                            <div>
                                <strong>{{$iden->nama}} - {{$iden->no_pasien}}</strong>
                            </div>
                                <div>Usia : {{hitung_usia($iden->tgl_lhr)}}</div>
                                <div>Alamat : {{$iden->alamat}}</div>
                                <div>No. Hp: {{$iden->hp}}</div>
                            @endforeach
                        </div>
                        <div class="col-sm-6" align="right">
                        <h6 class="mb-3">No RM : {{$no_rm}}</h6>
                        </div>
        
                    </div>
                            <div class="table-responsive-sm">
                            <table class="table table-striped">
                            <thead>
                            
                            <tr>
                            <th class="center">#</th>
                            <th>Item</th>
                            <th class="right">Harga Satuan</th>
                              <th class="center">Kuantitas</th>
                            <th class="right">Sub Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @for ($n=0;$n<sizeof($items);$n++)
                            <tr>
                            <td class="center">{{$n + 1}}</td>
                            <td class="left strong">{{$item=array_keys($items)[$n]}}</td>
                                @for ($i=0;$i<3;$i++)
                                    @if ($i != 1)
                                        <td class="center">{{formatrupiah($items[$item][$i])}}</td>
                                    @else
                                        <td class="center">{{$items[$item][$i]}}</td>
                                    @endif
                                @endfor
                            </tr>
                            @endfor
                            <tr>
                            <th class="center"></th>
                            <th>Jumlah Harga</th>
                            <th class="right"></th>
                              <th class="center"></th>
                            <th class="right">{{formatrupiah(jumlah_harga($items))}}
                            </th>
                            </tr>
                            </tbody>
                            </table>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <a href="{{route('rm')}}"  class="btn btn-block btn-danger">
                                    <span class="icon"><i class="fa  fa-arrow-left" ></i></span><span class="text"> Kembali</span></a>
                                </div>
                               <!--  <div class="col-sm-3">                                    
                                    <a href="#" class="btn btn-success btn-block">
                                    <span class="icon"><i class="fas fa-cash-register"></i></span><span class="text"> Bayar Tagihan</span></a>
                                </div> -->
                                @foreach ($datas as $data)
                                <div class="col-sm-4">                                    
                                    <a href="{{route('tagihan.print')}}" id="print2" data-id="{{$data->id}}" class="btn btn-primary btn-block">
                                    <span class="icon"><i class="fa  fa-print" ></i></span><span class="text"> Cetak</span></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{route('tagihan.cetak', $data->id)}}" class="btn btn-primary btn-block">
                                    <span class="icon"><i class="fa  fa-print" ></i></span><span class="text"> Cetak PDF</span></a>
                                </div>
                                @endforeach

                                                            
                     </div>   
                </div>
                    </div>
                </div>
                   
    <script>
    $(document).ready( function () {
  var table = $('#pasien').DataTable( {
    pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
  } )
} );

    </script>
<script type="text/javascript">
    $('#print2').on('click', function() {
    event.preventDefault();
    let CSRF_TOKEN = $('meta[name="csrf-token"').attr('content');
    var ids  = $('#print2').attr('data-id')

  $.ajaxSetup({
    url: "{{route('tagihan.print')}}",
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
  <script type="text/javascript">
    $(document).ready(function(){
        var mdate = $("#Tanggal_Lahir").val().toString();
        var yearThen = parseInt(mdate.substring(0,4), 10);
        var monthThen = parseInt(mdate.substring(5,7), 10);
        var dayThen = parseInt(mdate.substring(8,10), 10);
        
        var today = new Date();
        var birthday = new Date(yearThen, monthThen-1, dayThen);
        
        var differenceInMilisecond = today.valueOf() - birthday.valueOf();
        
        var year_age = Math.floor(differenceInMilisecond / 31536000000);
        var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
        
      
        var month_age = Math.floor(day_age/30);
        
        day_age = day_age % 30;
        
        if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
            $("#umur").val("Tanggal Lahir Salah");
        }
        else {
            $("#umur").val(year_age + " Tahun " + month_age + " Bulan ");
        }
});
</script>
@endsection