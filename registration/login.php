<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/config/serverConnect.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Екадаші - Благословенні пости</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light py-2">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                        <a class="navbar-brand" href="/" >
                            <img src="/picture/logo.jpg" alt="logo" height="50" width="50">
                        </a>

                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Піст</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Єкадаши</a></li>
                                    <li><a class="dropdown-item" href="#">Місячні дні</a></li>
                                    <li><a class="dropdown-item" href="#">Благословення</a></li>
                                    <li><a class="dropdown-item" href="#">Історії</a></li>
                                    <li><a class="dropdown-item" href="#">Умови</a></li>
                                    <li><a class="dropdown-item" href="#">Правила</a></li>
                                    <li><a class="dropdown-item" href="#">Список допомоги</a></li>
                                    <li><a class="dropdown-item" href="#">Календар</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Молитва</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Святі імена</a></li>
                                    <li><a class="dropdown-item" href="#">Сила звуку</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Турбота</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Захист корів</a></li>
                                    <li><a class="dropdown-item" href="#">Здоров'я</a></li>
                                    <li><a class="dropdown-item" href="#">Харчування</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Істина</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Культура</a></li>
                                    <li><a class="dropdown-item" href="#">Бібліотека</a></li>
                                    <li><a class="dropdown-item" href="#">Лекції онлайн</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Підтримка</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Допомога</a></li>
                                    <li><a class="dropdown-item" href="#">Послуги</a></li>
                                    <li><a class="dropdown-item" href="#">Послідовники</a></li>
                                    <li><a class="dropdown-item" href="#">Партнери</a></li>
                                    <li><a class="dropdown-item" href="#">Автор проекту</a></li>
                                    <li><a class="dropdown-item" href="#">Лікар аюрведи</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php" >Реєстрація</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Увійти</a>
                            </li>
                        </ul>
                    </div>
                </div>
        </nav>

        <?php if ($is_invalid): ?>
            <em>Невірний логін</em>
        <?php endif; ?>

        <form method="POST" action="login.php" class="row lg-3">
            <div class="col-auto ">
                <label class="control-label ml-5" for="email"> Email </label>
                <input id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" name="email" type="email"  autofocus="autofocus" class="form-control mb-3 ml-5" placeholder="name@example.com">
            </div>
            <div class="col-auto">
                <label class="control-label  ml-5" for="password"> Пароль </label>
                <input id="password" name="password" class="form-control  ml-5" autofocus="autofocus" type="password" placeholder="Пароль" aria-label="default input example">
            </div>
            <div class="col-auto">

            </div>
            <button type="submit" name="login_btn" class="btn btn-primary btn-lg mt-3 ml-5"" >Увійти</button>
        </form>

        

            <div class="mt-4 ml-5">
                <span >Ще не зареєстрований? <a href="register.php">Зареєструватись</a></span>
            </div>

        <hr class="bg-danger border-2 border-top border-danger" >

        <p class="fs-6 text-center">Навіщо постити? Читайте
        <a href="/">ekadashischool.com.ua</a>
        </p>

        <p class="fs-6 text-center">Друзі: Пігмент, що світиться в темряві
            <a href="https://lumi-light.com/pigmenty/lyuminofor">люмінофор</a>
        </p>

</body>
</html>