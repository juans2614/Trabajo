<?php

// Se hace la conexion a la base de datos
require_once "../conexionDB.php";

// Se procesan los datos ingresados por el usuario
$cedulaUsuario = $_POST["cedula"];
$nombresUsuario = explode(" ", $_POST["nombres"]);
$apellidosUsuario = explode(" ", $_POST["apellidos"]);

// Se revisa cuantos nombres y apellidos tiene el usuario y, en dado caso de solo tener uno se le asigna un segundo
// vacio con el fin de añadirlo a la base de datos.
if (count($nombresUsuario) === 1) {
    $nombresUsuario[1] = "";
}

if (count($apellidosUsuario) === 1) {
    $apellidosUsuario[1] = "";
}


$correoUsuario = $_POST["correo"];
$password = $_POST["password"];
$passwordConfirmation = $_POST["password-confirmacion"];



// Se  valida que la contraseña y la confirmacion de la contraseña sea igual
if ($password !== $passwordConfirmation) {
    echo "<script>
            alert('La contraseña y su confirmacion no coinciden');
            location.href = '../templates/registroUsuarios.html'
        </script>";
    die;
}
// En caso contrario se encripta la contraseña
$password = password_hash($password, PASSWORD_DEFAULT);





// Se crea la consulta para ingresar el usuario y este se registra en la base de datos.
$query = "insert into usuarios
          (id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, nombre_usuario, contraseña_usuario)
          values
          ('$cedulaUsuario', '$nombresUsuario[0]', '$nombresUsuario[1]', '$apellidosUsuario[0]', '$apellidosUsuario[1]',
            '$correoUsuario', '$password');";

mysqli_query($conexion, $query);

echo "<script>
        alert('Usuario Registrado de Manera Exitosa');
        location.href = '../templates/loginUsuarios.html';
    </script>";

mysqli_close($conexion);
