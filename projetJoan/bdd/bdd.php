<?php
try {
    $users = "user-bdd";
    $pass = "?JtyM6MS4RE$8dmb";
    $bdd = new PDO('mysql:host=localhost;dbname=projetJoan;charset=utf8', $users, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
	die("Erreur PDO : " . $e->getMessage());
    error_log("Erreur PDO : " . $e->getMessage());
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
}
?>
