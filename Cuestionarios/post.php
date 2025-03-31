<!DOCTYPE html>


<html>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $email = htmlspecialchars($_POST["email"]);

        echo "Nombre: " . $nombre . "<br>";
        echo "Email: " . $email;
    } else {
        echo "Acceso no permitido.";
    }
    ?>
</html>