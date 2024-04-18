<?php
require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
$dia = $_GET['dia'] ?? '';

$conn = Aplicacion::getInstance()->getConexionBd();
$sql = "SELECT id_cliente FROM Citas WHERE dia = '$dia' AND id_cliente = {$_SESSION['id']}";
$result = $conn->query($sql);

$unavailableHours = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql = "SELECT hora FROM Citas WHERE dia = '$dia' AND id_cliente = {$row['id_cliente']}";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $unavailableHours[] = $row['hora'];
            }
        }
    }
}

$availableHours = range(9, 17);
$availableHours = array_diff($availableHours, $unavailableHours);

echo "<label for='Hora'>Hora:</label>";
echo "<select id='hora' name='hora'>";
echo "<option value=''>Selecciona una hora</option>";
foreach ($availableHours as $hora) {
    echo "<option value='$hora'>$hora</option>";
}
echo "</select>";