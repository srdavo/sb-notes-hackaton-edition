<?php
$months = array(
  '01' => 'ene', '02' => 'feb', '03' => 'mar', '04' => 'abr',
  '05' => 'may', '06' => 'jun', '07' => 'jul', '08' => 'ago',
  '09' => 'sep', '10' => 'oct', '11' => 'nov', '12' => 'dic'
);

function displayMonths(){
  date_default_timezone_set('America/Mazatlan');
  $meses = array(
    1 => "Enero",
    2 => "Febrero",
    3 => "Marzo",
    4 => "Abril",
    5 => "Mayo",
    6 => "Junio",
    7 => "Julio",
    8 => "Agosto",
    9 => "Septiembre",
    10 => "Octubre",
    11 => "Noviembre",
    12 => "Diciembre"
  );

  $mesActual = date("n"); // Obtiene el número del mes actual (sin ceros iniciales)

  foreach ($meses as $numeroMes => $nombreMes) {
      $selected = ($numeroMes == $mesActual) ? "selected" : "";
      echo "<option value='$numeroMes' $selected>$nombreMes</option>";
  }
}

function displayYears(){
  date_default_timezone_set('America/Mazatlan');
  $currentYear = date('Y');

  $startYear = 2023;
  $endYear = $currentYear + 2;

  

  for ($year = $endYear; $year >= $startYear; $year--) {
    $selected = ($year == $currentYear) ? "selected" : "";
    echo "<option value='$year' $selected>Año $year</option>";
  }

}


function currencySymbol() {
  $ip = $_SERVER['REMOTE_ADDR'];
  $details = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
  // $details = "";

  if (!empty($details->countryCode)) {
      switch ($details->countryCode) {
          case 'US': // Estados Unidos
          case 'CA': // Canadá
          case 'MX': // México
              echo '$';
              break;
          case 'GB': // Reino Unido
              echo '£';
              break;
          case 'BE': // Bélgica
          case 'FR': // Francia
          case 'DE': // Alemania
          case 'ES': // España
          case 'IT': // Italia
          case 'NL': // Países Bajos
          case 'EU': // Unión Europea (general)
              echo '€';
              break;
          default:
              echo '$';
      }
  } else {
      echo '$'; 
  }
}



?>