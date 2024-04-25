<?php
header("Access-Control-Allow-Origin: *");
// Establecer los parámetros de conexión
$servername = "gestocar.mx"; 
$username = "gestocar_wp373"; 
$password = "dS--Opm@]e]8F10g"; 
$dbname = "gestocar_wp373"; 

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Realizar consulta
$sql = "SELECT DISTINCT SUBSTRING_INDEX(wpta_vxcf_leads_detail.value, ' ', -1) AS email
FROM wpta_vxcf_leads_detail
JOIN wpta_vxcf_leads ON wpta_vxcf_leads_detail.lead_id = wpta_vxcf_leads.id
WHERE
    wpta_vxcf_leads.form_id = 'wp_351'
    AND wpta_vxcf_leads_detail.name = 2
    AND EXISTS (
        SELECT 1
        FROM wpta_vxcf_leads_detail AS wxld
        WHERE
            wxld.lead_id = wpta_vxcf_leads.id
            AND wxld.name = 4
            AND wxld.value LIKE '%Susc%'
    )"; 
    
$resultado = mysqli_query($conn, $sql);
$array = array();
// Procesar resultados
if ($resultado->num_rows > 0) {
    $rows = $resultado->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {
        $array[] = $row["email"]; 
        //echo "Email: " . $row["email"] . "<br>";
    }
  } else {
    $array[] = "No se encontraron resultados"; 
    //echo "No se encontraron resultados";
  }

// Cerrar la conexión
mysqli_close($conn);
echo json_encode($array)
?>
