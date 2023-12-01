<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "horarios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(array('error' => 'Conexión fallida: ' . $conn->connect_error)));
}


$carreraSeleccionada = trim($_GET['carreraSeleccionada']); // Eliminar espacios al inicio y al final

// Validar parámetros
if (empty($carreraSeleccionada) ) {
    die(json_encode(array('error' => 'Parámetros incompletos')));
}

// Determinar la tabla según la carrera seleccionada
$tabla = '';
switch ($carreraSeleccionada) {
    case 'Ing. Ciencias de la computacion':
        $tabla = "icc";
        break;
    case 'Lic. Ciencias de la computacion':
        $tabla = "lcc";
        break;
    case 'Ing. en tecnologias de la informacion':
        $tabla = "iti";
        break;
    default:
        die(json_encode(array('error' => 'Carrera no válida')));
}

// Consulta SQL para obtener datos
$sql = "SELECT NRC, Clave, Materia, Secc, Dias, Hora, Profesor, Salon FROM $tabla";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die(json_encode(array('error' => 'Error en la consulta: ' . $conn->error)));
}

// Almacenar datos en un array
$materias = array();
while ($row = $result->fetch_assoc()) {
    $materias[] = $row;
}

// Devolver los datos en formato JSON
echo json_encode($materias);

// Cerrar conexión
$conn->close();
?>
