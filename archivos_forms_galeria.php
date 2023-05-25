<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de imagenes</title>
    <link rel="icon" href="https://kinsta.com/es/wp-content/uploads/sites/8/2018/07/plugins-galeria-fotos-wordpress.jpg" type="image/jpg">
    <link rel="stylesheet" href="./style.css"><!--linkea el archivo php con uno css para darle diseño-->
</head>
<body>
    <form id=formulario action="./archivos_forms_galeria.php" method="post" enctype="multipart/form-data" target="_self" > <!--necesario poner multipart/form-data para que te permita poner archivos binarios-->
        <fieldset class=marco>
            <legend class=tituloF><strong>Sube tu imagen</strong></legend>
            <label class=letras for="nom">Nombre:</label><br>
            <input class=letras type="text" id="nom" name="nombre" required/><br><br>
          
            <label class=letras for="arch">Imagen:</label><br>
            <input class=letras type="file" id="arch" accept="image/*" name="arch"/><br><br>
           
            <button class=boton type="reset">Borrar</button>
            <button class=boton type="submit">Enviar</button>
        </fieldset>
    </form>
    <?php
        //RECIBIR IMAGEN
        $nombre=(isset($_POST['nombre']) && $_POST["nombre"] != "")? $_POST['nombre'] : false;
        if (isset($_FILES["arch"]))
        {
            $arch = $_FILES["arch"];//recive archivo
            $name= $arch["name"];//obtiene el nombre del archivo : imagen.jpg
            $ruta_temporal = $arch["tmp_name"]; //$arch es un arreglo que tiene la ruta temporal de la imagen
            $ext = pathinfo($name, PATHINFO_EXTENSION); //saca la extencion del nombre : .jpg
            if (!file_exists("./img"))//si la carpeta no existe, la crea
            {
                if (mkdir("./img"));//mkdir crea ina carpeta
            }
            $ruta_final = "./img/$nombre.$ext";//ruta en la que se va a guardar
            rename($ruta_temporal, $ruta_final);//cambia la ruta temporal por la ruta final
        }
        //DESPLIEGUE DE IMAGEN
        $dir = opendir("./img");//abre el directorio img, como fopen en c++
        $hay_arch = true; 
        $archivos=[];
        while($hay_arch)
        {
            $archivo = readdir($dir);//es para leer el directorio
            if ($archivo)
            {
                array_push($archivos, $archivo);
            }else{
                $hay_arch = false;
            }
        }
            echo '
            <h1 align ="center">Galeria</h1>
            <table id=tabla border="1" cellpadding="10px" align="center">
                <thead>
                    <tr> 
                        <th class=tituloT>Nombre</th>
                        <th class=tituloT>Imagen</th>
                    </tr> 
                </thead>
                <tbody>';
                foreach($archivos as $img)
                {
                    $nombreArch = pathinfo($img, PATHINFO_BASENAME);//recive la ruta de la imagen
                    if($img !="." && $img != "..")
                    {
                        echo "  <tr>
                                    <td>
                                        $nombreArch;
                                    </td>
                                    <td>
                                        <img src='./img/$img' height ='200px'>
                                    </td>
                                </tr> 
                        ";
                    }
                }
                echo "
                </tbody>
            </table>";
            
    ?>
</body>
</html>
