<?php
// Connexion à la base de données
require_once(__DIR__ . '/../bdd/bdd.php');

/**
 * Récupère toutes les signatures du livre d'or.
 */
function recupererSignatures() {
    global $bdd;

    $sql = "SELECT Nom_Auteur, Sexe, Email, Telephone, Message, Date_Signature 
            FROM Signatures 
            ORDER BY Date_Signature DESC";

    $stmt = $bdd->query($sql);
    return $stmt->fetchAll();
}


function ajouterSignature($nom_auteur, $message, $email, $telephone, $sexe) {
    global $bdd;

    $sql = "INSERT INTO Signatures (Nom_Auteur, Message, Email, Telephone, Sexe, Date_Signature)
            VALUES (:nom, :message, :email, :telephone, :sexe, NOW())";

    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ':nom'       => $nom_auteur,
        ':message'   => $message,
        ':email'     => $email,
        ':telephone' => $telephone,
        ':sexe'      => $sexe
    ]);
}
?>
