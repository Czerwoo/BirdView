<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset='utf-8'>
    <title>BirdView</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<?php
session_start();
if (isset($_POST["pass"]) && isset($_POST["login"])) {
    $login = $_POST["login"];
    $pass = $_POST["pass"];
    $pass = md5($pass);

    $conn = new mysqli('https://s128.cyber-folks.pl/phpmyadmin/', 'yzfebcinxx_kacprus', 'yPoy)@1.RQ1zmz--', 'yzfebcinxx_kacprus');

    if ($conn->connect_errno) {
        echo "Wywaliło błąd ;')";
        exit();
    }


    $query = "SELECT * FROM users WHERE user = '$login' AND password = '$pass'";
    $result = mysqli_query($conn, $query);


    if (mysqli_num_rows($result) == 1) {
        $zapytanie = "SELECT rola FROM users WHERE user = ?";
        $wartosc_podana_bezpieczna = mysqli_real_escape_string($conn, $login);

        if ($polecenie = $conn->prepare($zapytanie)) {
            $polecenie->bind_param('s', $wartosc_podana_bezpieczna);
            $polecenie->execute();
            $polecenie->bind_result($role);
            $polecenie->store_result();
            $polecenie->fetch();
            $_SESSION['role'] = $role;
        }
        $_SESSION['username'] = $login;
        header('Location: index.php');
        exit;
    } else {
        echo 'Nieprawidłowe dane logowania! <br> Nie masz konta? <a href="register.php">Zarejestruj się</a><br> ';
    }


}
?>
<body>
    <a href="http://localhost/BirdView/register.php">zarejestruj</a><br>
    <a href="http://localhost/BirdView/forgot.php">zresetuj haslo</a><br>

    <form method="POST">
        Login:
        <input type="text" name="login" required> <br>
        Haslo:
        <input type="password" name="pass" required><br>
        <input type="submit" value="zaloguj">

    </form>
</body>
</html>