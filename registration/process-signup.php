<?php
    if (empty($_POST["name"])) 
    {
        die("Необхідно вказати ім'я!");
    }

    if (empty($_POST["surname"])) 
    {
        die("Прізвище обов'язкове!");
    }

    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
    {
        die("Потрібна дійсна електронна адреса!");
    }

    if (strlen($_POST["password"]) < 8) 
    {
        die("Пароль має бути не менше 8 символів!");
    }

    if ( ! preg_match("/[a-z]/i", $_POST["password"])) 
    {
        die("Пароль повинен містити хоча б одну букв!");
    }

    if ( ! preg_match("/[0-9]/", $_POST["password"])) 
    {
        die("Пароль повинен містити хоча б одне число!");
    }

    if ($_POST["password"] !== $_POST["password_confirm"]) 
    {
        die("Паролі мають збігатися!");
    }

    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $mysqli = require __DIR__ . "/config/serverConnect.php";

    $sql = "INSERT INTO user (name, surname, email, password_hash)
        VALUES (?, ?, ?, ?)";
        
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sss",
                    $_POST["name"],
                    $_POST["surname"],
                    $_POST["email"],
                    $password_hash);
                    
    if ($stmt->execute()) 
    {
        header("Location: signup-success.html");
        exit;
        
    }
    else 
    {    
        if ($mysqli->errno === 1062) 
        {
            die("E-mail вже зайнято");
        } 
        else 
        {
            die($mysqli->error . " " . $mysqli->errno);
        }
    }
?>