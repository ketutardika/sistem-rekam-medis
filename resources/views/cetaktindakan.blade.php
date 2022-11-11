<html>
<head>
  <title>Rekap Data Tindakan</title>
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
  <center>
    <h5>Data Rekap Tindakan</h5>
    <p>Tanggal <?php echo date("Y-m-d H:i:s"); ?><p>
  </center>
 
  <table class='table table-bordered' id="pasien" data-order='[[ 0, "desc" ]]'>
  <thead>
    <tr>
      <th>#</th>                     
      <th>No Tindakan</th>
      <th>Nama Tindakan</th>
      <th>Harga</th>
    </tr>
  </thead>
  <tbody>
  <?php $j=1; ?>
  @foreach ($tindakans as $tindakan)
    <tr>
      <td><?php echo $j; ?></td>
      <td>{{ $tindakan->no_tindakan}}</td>
      <td>{{ $tindakan->nama}}</td>
       <td>{{ formatrupiah($tindakan->harga)}}</td>
    </tr>
   <?php $j++; ?>
  @endforeach
  </tbody>
</table>
<p>
  <?php
    $users = Auth::user()->username; 
    echo "Dibuat Oleh : ".$users."<br> Pada Tanggal: " . date("Y-m-d H:i:s"). "<br>";
?>
</p>
</body>
</html>