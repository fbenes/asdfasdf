<?php
// Inicializace proměnných
$name = $surname = $email = $message = $reason = "";
$nameErr = $surnameErr = $emailErr = $messageErr = $reasonErr = "";

// Zpracování formuláře, když je odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validace jména
    if (empty($_POST["name"])) {
        $nameErr = "Jméno je povinné";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validace příjmení
    if (empty($_POST["surname"])) {
        $surnameErr = "Příjmení je povinné";
    } else {
        $surname = test_input($_POST["surname"]);
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

    // Validace důvodu kontaktu
    if (empty($_POST["reason"])) {
        $reasonErr = "Je třeba vybrat důvod kontaktu";
    } else {
        $reason = test_input($_POST["reason"]);
    }

    // Pokud není žádná chyba, zpracujeme formulář
    if (empty($nameErr) && empty($surnameErr) && empty($emailErr) && empty($messageErr) && empty($reasonErr)) {
        // Odeslat email nebo provést jinou akci (např. uložit do databáze)
        echo "<h3>Formulář byl úspěšně odeslán!</h3>";
        echo "<strong>Jméno:</strong> $name $surname<br>";
        echo "<strong>Email:</strong> $email<br>";
        echo "<strong>Důvod kontaktu:</strong> $reason<br>";
        echo "<strong>Zpráva:</strong> $message<br>";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        .radio-group {
            margin-bottom: 10px;
        }

        .radio-group label {
            margin-right: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Kontaktujte nás</h2>
<p><span class="error">* Povinná pole</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- Jméno -->
    <label for="name">Jméno:</label>
    <input type="text" id="name" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $nameErr;?></span><br>

    <!-- Příjmení -->
    <label for="surname">Příjmení:</label>
    <input type="text" id="surname" name="surname" value="<?php echo $surname;?>">
    <span class="error">* <?php echo $surnameErr;?></span><br>

    <!-- Email -->
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span><br>

    <!-- Důvod kontaktu -->
    <div class="radio-group">
        <label for="reason">Důvod kontaktu:</label>
        <input type="radio" id="question" name="reason" value="Otázka" <?php echo ($reason == "Otázka") ? "checked" : ""; ?>>
        <label for="question">Otázka</label>
        <input type="radio" id="offer" name="reason" value="Nabídka spolupráce" <?php echo ($reason == "Nabídka spolupráce") ? "checked" : ""; ?>>
        <label for="offer">Nabídka spolupráce</label>
        <input type="radio" id="other" name="reason" value="Jiné" <?php echo ($reason == "Jiné") ? "checked" : ""; ?>>
        <label for="other">Jiné</label>
        <span class="error">* <?php echo $reasonErr;?></span>
    </div><br>

    <!-- Zpráva -->
    <label for="message">Zpráva:</label><br>
    <textarea id="message" name="message" rows="5"><?php echo $message;?></textarea>
    <span class="error">* <?php echo $messageErr;?></span><br><br>

    <input type="submit" value="Odeslat">
</form>

</body>
</html>