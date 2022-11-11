<!DOCTYPE html>
<html>
<head>
    <title>{{ $body }}</title>
</head>
<body>
	<?php $users = Auth::user()->username;  
	date_default_timezone_set("Asia/Makassar");	?>

    <p>Hai <?php echo $users; ?>,</p>

    <p>Berikut Terlampir {{ $body }}
    <br>Harap Disimpan agar bisa di restore kembali </p>

    <p>Email ini Dikirim Dari Aplikasi Rekam Medis Pada Tanggal <?php echo date("d F Y"); ?> Pada Jam <?php echo date("H:i:s"); ?></p>
    <p>Terima Kasih<br>
    	Salam<br>
        <?php echo "Aplikasi Rekam Medis"; ?></p>

</body>
</html>