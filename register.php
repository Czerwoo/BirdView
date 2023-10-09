<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset='utf-8'>
    <title>BirdView</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<?php
if (isset($_POST["pass2"]) && isset($_POST["pass"]) && isset($_POST["login"])) {
    $login = $_POST["login"];
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $date = $_POST["date"];
    $pass = $_POST["pass"];
    $pass2 = $_POST["pass2"];
    $convertedDate = date("Y-m-d", strtotime($date));

    $conn = new mysqli('s128.cyber-folks.pl', 'yzfebcinxx_kacprus', 'yPoy)@1.RQ1zmz--', 'yzfebcinxx_kacprus');

    if ($conn->connect_errno) {
        echo "wywaliło błąd ;')";
        exit();
    }

    if ($pass == $pass2) {
        $pass = md5($pass);
        $role = 'gość';
        $query = "SELECT * FROM uzytkownik WHERE login = '$login' AND haslo = '$pass'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0) {

            $query = "INSERT INTO uzytkownik (id_uzytkownika, imie, nazwisko, data_urodzenia, login, haslo, rola) VALUES (NULL,?,?,?, ?, ?, ?);";
            $polecenie = $conn->prepare($query);
            $polecenie->bind_param("ssdsss", $name, $lastname, $convertedDate, $login, $haslo, $role);
            $polecenie->execute();
            header('Location: http://localhost/BirdView/login.php');
            $polecenie->free_result();
            exit;
        } else {
            echo 'Takie konto już istnieje! <br>';
        }

    } else {
        echo "Hasła nie są zgodne";
    }

    $conn->close();
}
?>
<body>
    <a href="http://localhost/BirdView//login.php">masz konto? zaloguj sie</a>
    <form action=# method="POST">
        Login:
        <input type="text" name=login> <br>
        imie
        <input type="text" name=name> <br>
        nazwisko
        <input type="text" name=lastname> <br>
        data:
        <input type="date" name=date> <br>

        Haslo:
        <input type="password" name="pass"><br>
        Potwierdz haslo:
        <input type="password" name="pass2"><br>
        <input type="submit">

    </form>
</body>
</html>