<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h2>date_format() y date_create()</h2>
    <?php
        $date=date_create("2013-03-15");
        var_dump($date);
        echo date_format($date, "Y/m/d H:i:s")."<br>";
        
        
    ?>

    <h2>date_parse() y date_add()</h2>
    
    <?php 
    $x="2013-05-01 12:30:45.5";
    echo($x)."<br>";
    var_dump(date_parse($x));

    $date=date_create("2013-03-15");
    date_add($date, date_interval_create_from_date_string("4 moths"));
    date_add($date, date_interval_create_from_date_string("4 days"));
    echo date_format($date, "Y-m-d")."<br>";
    
    ?>

    <hr>
    <h2>Encriptar contraseña</h2>

  

    <?php
    // Paso 1: Definir la contraseña original
    $contraseña = "MiSuperClave123";
    echo "Contraseña original: " . $contraseña . "\n";

    // Paso 2: Encriptar la contraseña
    $hash = password_hash($contraseña, PASSWORD_DEFAULT);
    echo "Contraseña encriptada (hash): " . $hash . "\n";

    // Simulación de ingreso de usuario
    $contraseñaIngresada = "MiSuperClave123";
    echo "Contraseña ingresada: " . $contraseñaIngresada . "\n";

    // Paso 3: Verificar si la contraseña ingresada es correcta
    if (password_verify($contraseñaIngresada, $hash)) {
        echo "✅ Contraseña correcta\n";
    } else {
        echo "❌ Contraseña incorrecta\n";
    }
    ?>




</body>
</html>