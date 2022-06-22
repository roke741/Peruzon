<!DOCTYPE html>
<html lang="es">
<head>
	  <title>Peruzon-Cargando...</title>
	  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--fontawesome-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,800&display=swap" rel="stylesheet">

    <style>
        h1{
            font-family: 'Open Sans', sans-serif;
            position: absolute;
            top: 55%;
            color: white;
            width: 5.5em;
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #FF6161;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: 1s all;
            opacity: 0;
        }

        .loading.show {
            opacity: 1;
        }

        .loading .spin {
            border: 12px solid white;
            border-top-color: red;
            border-radius: 50%;
            width: 4em;
            height: 4em;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
          to {
            transform: rotate(360deg);
          }
        }  
    </style>
    <script>
    /*texto en movimiento jquery*/
    var i = 0;
    var msg = '...';

    setTimeout(typeWriter, 150);
    function typeWriter() {
      if (i < msg.length) {
        document.getElementById("punto").innerHTML += msg.charAt(i);
        i++;
        setTimeout(typeWriter, 150);
      }else{
        document.getElementById("punto").innerHTML = "";
        i = 0;
        clearTimeout(typeWriter);
        setTimeout(typeWriter, 150);
      }
    }
    setTimeout(myFunction, 5000)
    function myFunction() {
      location.href = "panel.php";
    }
    
    </script>
</head>
<body>

<div class="loading show">
    <div class="spin"></div>
    <h1>Cargando<span id="punto"></span></h1>
</div>
</body>
</html>