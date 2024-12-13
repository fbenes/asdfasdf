<?php
// Inicializace proměnných
$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";

// Zpracování formuláře, když je odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validace jména
    if (empty($_POST["name"])) {
        $nameErr = "Jméno je povinné";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validace emailu
    if (empty($_POST["email"])) {
        $emailErr = "Email je povinný";
    } else {
        $email = test_input($_POST["email"]);
        // Kontrola platnosti emailu
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Neplatný formát emailu";
        }
    }

    // Validace zprávy
    if (empty($_POST["message"])) {
        $messageErr = "Zpráva je povinná";
    } else {
        $message = test_input($_POST["message"]);
    }

    // Pokud není žádná chyba, zpracujeme formulář
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        // Odeslat email nebo provést jinou akci (např. uložit do databáze)
        echo "Formulář byl úspěšně odeslán!<br>";
        echo "Jméno: $name<br>";
        echo "Email: $email<br>";
        echo "Zpráva: $message<br>";
    }
}

// Funkce pro čištění vstupu
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulář s validací</title>
</head>
<body>

<h2>Kontaktujte nás</h2>
<p><span style="color:red;">* Povinná pole</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="name">Jméno:</label>
    <input type="text" id="name" name="name" value="<?php echo $name;?>">
    <span style="color:red;">* <?php echo $nameErr;?></span><br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?php echo $email;?>">
    <span style="color:red;">* <?php echo $emailErr;?></span><br><br>

    <label for="message">Zpráva:</label><br>
    <textarea id="message" name="message" rows="5" cols="40"><?php echo $message;?></textarea>
    <span style="color:red;">* <?php echo $messageErr;?></span><br><br>

    <input type="submit" value="Odeslat">
</form>

</body>
</html>