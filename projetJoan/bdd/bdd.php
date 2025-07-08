<?php
try {
    $users = "user";
    $pass = "motdepasse";
    $bdd = new PDO('mysql:host=localhost;dbname=lampbdd;charset=utf8', $users, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
	die("Erreur PDO : " . $e->getMessage());
    error_log("Erreur PDO : " . $e->getMessage());
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
}
?>
