<?php
    // Se importa la conexion a la base de datos
    require_once ("../conexionDB.php");

    //  Se traen los datos ingresados por el usuario en el formulario de login
     $email = $_POST["correo"];
     $password = $_POST["password"];

    //  Se define una consulta a la base de datos que nos traiga la password del usuario
     $query = "select nombre_usuario, contraseña_usuario, estado, solicitud_registro from usuarios where nombre_usuario = '$email'";
     $result = mysqli_query($conexion, $query);
     
     //  Se abstrae el usuario en un array asociativo
     $usuario = mysqli_fetch_assoc($result);

     
     // Definimos el mensaje que le queremos mostrar al usuario en base a una serie de verificaciones.
     $mensaje = match(true){
        $usuario === null                                                       => "El usuario ingresado no se encuentra registrado",
        $usuario["solicitud_registro"] !== "aceptada"                           => "La solictud de registro de este usuario esta en revision.",
        $usuario["estado"] !== "activo"                                         => "El usuario ingresado no tiene permisos para ingresar",
        password_verify($password, $usuario["contraseña_usuario"]) === false    => "El usuario o la contraseña son incorrectos",
        default => null
     };
    //  Se verifica que si se genera un mensaje y en caso de que no redirigimos al usuario a su respectivo dashboard.

    if($mensaje !== null){     
        echo "<script>
                location.href = '../templates/loginUsuarios.html';
                alert('$mensaje');
            </script>";
    }

    echo "<script>
            location.href = '../templates/dashboard.php';
        </script>";

    mysqli_close($conexion);
    