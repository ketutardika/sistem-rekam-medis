<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tagihan Kunjungan Pasien</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
    body{font-size: 9pt;}
    table tr td,
    table tr th{
      font-size: 9pt;
      border: 1px solid;
    }
    p{font-size: 9pt;}
    ul {
    list-style: none;
    margin-left: 0;
    padding-left: 1em;
    }
    ul > li:before {
    display: inline-block;
    content: "-";
    width: 1em;
    margin-left: -1em;
    }
  </style>
</head>
<body>
 
 <div class="col-sm-12 row">
    <div class="col-md-6"><span class="float-left">{{get_setting('n_Klinik')}}</span></div>
    <div class="col-md-6"><span class="float-right">Sistem Rekam Medis</span></div>
  </div>
  <div class="clearfix"></div>
  @foreach ($idens as $iden)
  <center>
    <h5>Tagihan Kunjungan Pasien</h5>
    <span>{{$no_rm_cetak}}</span>
  </center>

  <div class="row mb-4">
  <div class="col-sm-6">
    
    <h6 class="mb-3">Kepada:</h6>
    <div><strong>{{$iden->nama}}  - {{$iden->no_pasien}}</strong></div>
          <div>Usia : {{hitung_usia($iden->tgl_lhr)}}</div>
          <div>Alamat : {{$iden->alamat}}</div>
          <div>No. Hp: {{$iden->hp}}</div>
      
  </div>
  </div>
  @endforeach
 <table class="table table-bordered">
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
<p>
  <?php
    $users = Auth::user()->username; 
    echo "Dibuat Oleh : ".$users."<br> Pada Tanggal: " . date("d F Y") . "<br>";
  ?>
</p>
</body>
</html>