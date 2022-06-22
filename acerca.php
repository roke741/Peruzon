<?php
session_start();
// Si se cerro la sesión por otro lado
$definido=isset($_SESSION['usuario']);
// No está definido la variable
if ($definido==false){
    header("Location:error1.php");
  exit();      
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peruzon-Acerca</title>

    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--style - ventas -->
    <link rel="stylesheet" href="css/stylepanel.css">
    <link rel="stylesheet" href="css/stylevender.css">
    <!--fontawesome-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <!--iconos-->
    <link rel="shortcut icon" href="imagenes/icon.png">
    <!--jquery online-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--jquery local-->
    <!--script src="jquery-1.3.2.min.js" type="text/javascript"></script-->
    
    <!--jquery confirm-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="col-3  align-self-center menu">
                <div class="menu_bar">
                    <a href="#" class="bt-menu"><span class="icon-menu"><i class="bi bi-list"></i></span>PERUZON</a>
                </div>
                <nav class="nav-menu py-4">
                    <ul class="nav flex-column text-center fw-bold text-light" >
                        <li>
                            <h2 class="title fw-bold fst-italic pb-2">PERUZON</h2>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#"><i class="bi bi-gear"></i> ACERCA</a> 
                        </li>
                            
                        <li class="nav-item">
                            <a class="nav-link" href="panel.php"><i class="bi bi-arrow-left-square"></i> IR AL PANEL</a> 
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="col-9 panel">
                <h2 class="fw-bold fst-italic text-center text-light pt-3">ACERCA</h2>
                <br>
                <h3 class="text-light fw-bold fst-italic pb-2 text-center" style="font-size:8em;text-transform:uppercase;padding:30px;">PERUZON</h3>
                <script>
                    jQuery(document).ready(function(){
                        $('h3').mousemove(function(e){
                            var rXP = (e.pageX - this.offsetLeft-$(this).width()/2);
                            var rYP = (e.pageY - this.offsetTop-$(this).height()/2);
                            $('h3').css('text-shadow', +rYP/10+'px '+rXP/80+'px rgba(227,6,19,.8), '+rYP/8+'px '+rXP/60+'px rgba(255,237,0,1), '+rXP/70+'px '+rYP/12+'px rgba(0,159,227,.7)');
                        });
                    });
                </script>
                <div class="text-center">
                    <p class="text-light fw-bold">
                        Gracias por descargar y usar la aplicación. <br>
                        Puedes apoyarmenos en nuestras redes sociales. <br>
                    </p>
                    <div class="row justify-content-center my-4 fs-2 ">
                        <div class="col-1">
                            <a class="link-light" href="https://www.facebook.com/peruzon/" target="_blank"><i class="bi bi-facebook"></i></a>
                        </div>
                        <div class="col-1">
                            <a class="link-light" href="https://twitter.com/peruzon" target="_blank"><i class="bi bi-twitter"></i></a>
                        </div>
                        <div class="col-1">
                            <a class="link-light" href="https://www.instagram.com/peruzon/" target="_blank"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                    <p class="text-light fw-bold">Si quieres apoyarme economicamente :) </p>
                    <p class="fs-1 text-light p-0"><i class="bi bi-arrow-down"></i> </p>	
                    <div class="row justify-content-center my-4 fs-2 ">
                        <div class="col-2">
                            <a class="link-light" href="https://paypal.me/Jhordie?country.x=PE&locale.x=es_XC" target="_blank"><i class="bi bi-paypal"></i></a>
                        </div>
                    </div>

                </div>
                <p class="text-center fs-5 fw-bold fst-italic text-light" style="text-shadow: 3px 1px black">Desarrollado x Roke</p>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(main);
        var contador = 1;
        function main(){
            $('.menu_bar').click(function(){
            // $('nav').toggle(); 
            if(contador == 1){
            $('nav').animate({
                left: '0'
            });
                contador = 0;
            } else {
                contador = 1;
                $('nav').animate({
                left: '-100%'
                });
                }
            });
        }; 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    
</body>
</html>