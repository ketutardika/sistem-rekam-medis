<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8" />
        <title>Praktek Dokter Gelis - SRM-V1.0.2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sistem Rekam Medis dapat digunakan untuk melakukan proses pengolahan data Rekam Medis Pasien termasuk Data Obat, Data Kategori Tindakan, Data Dokter, Data Pasien, dan Data Rekam Medis Pasien." name="description" />
        <meta content="Amantra Bali Creative" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta property="og:locale" content="id_ID" />
        <meta property="og:title" content="Praktek Dokter Gelis - SRM-V1.0.2" />
        <meta property="og:description" content="Sistem Rekam Medis dapat digunakan untuk melakukan proses pengolahan data Rekam Medis Pasien termasuk Data Obat, Data Kategori Tindakan, Data Dokter, Data Pasien, dan Data Rekam Medis Pasien." />
        <meta property="og:url" content="https://praktikdrgelis.com/" />
        <meta property="og:site_name" content="Praktek Dokter Gelis - SRM-V1.0.2" />
        <meta property="og:image" content="https://praktikdrgelis.com/storage/app/public/logo/logo1587807363.jpg" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ URL::asset('css/jquery-confirm.min.css') }}" rel="stylesheet">
        <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script> 
        <script src="{{ URL::asset('js/jquery-confirm.min.js') }}"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 48px;
                text-transform: uppercase;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .jconfirm-box {
                width: 500px;
            }
            .attention{
                margin-top: 80px;
                padding: 10px;
            }
            .clearfix {
              overflow: auto;
            }
            .clearfix::after {
              content: "";
              clear: both;
              display: table;
            }
            a{
                color: #636b6f;
                text-decoration: none;
            }
            @media screen and (max-width: 766px) {
                .title {
                font-size: 30px;
                }
              .links > a {
                    width: 100%;
                    display: block;
                    padding: 10px 0px;
                }
                .copyright{
                    padding: 0px 40px;
                }
                .jconfirm-box {
                width: 300px;
                }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
<!--             @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->



            <div class="content">
                @if ($message = Session::get('success'))
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p class="mb-0">
                                <strong>{{ $message }}</strong>
                            </p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                @endif

               

                <div class="title m-b-md">
                   Praktek Dokter Gelis
                </div>

               
                @if (Route::has('login'))
                <div class="links">                    
                    @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>                    
                    @else
                    <a href="{{ url('/users/login') }}">Login</a>
                    @endauth                    
                    <a href="{{ url('/cache') }}">Clear Cache</a>
                    <?php
                        $file = public_path('recoverymodes.php');
                        if(file_exists($file)){
                    ?>
                          <a class="reset-db" href="#" >Reset & Update Database</a>
                    <?php
                        }
                    ?>                    
                    <a href="https://amantrabali.com" target="_blank">More Information</a>
                </div>
                @endif 
                
                 <div class="clearfix"></div>
                 <div class="attention">
                <center>
                <span>Copyright &copy; & Develop by <a href="https://amantrabali.com" target="_blank" style="text-decoration: none;">Amantra Creative</a></span>
                </center>
                </div><div class="clearfix"></div>

            </div>
        </div>


            

    <script type="text/javascript">
        $('.reset-db').on('click', function(){
            $.confirm({
                title: 'Perhatian!',
                content: 'Me-Reset Database akan menghapus semua data di database, dan diisi dengan Database yang terbaru apakah anda yakin??',
                columnClass: 'small',
                buttons: {
                    confirm: function(){
                        $.alert('Tunggu Hingga Loading Selesai, bisa login dan menggunakan sistem yang sudah terupdate');
                        window.location.href = "{{ url('/migrate') }}";
                    },
                    cancel: function(){
                        $(this).remove();
                    },
                }
            });
        });
    </script>

    </body>
</html>
