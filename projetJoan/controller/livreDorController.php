<?php
session_start();
require_once(__DIR__ . '/../modele/signatureModele.php');

// ✅ Activation d'en-têtes de sécurité basique (peut être renforcé)
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");

// Clé secrète reCAPTCHA (NE PAS METTRE LA CLÉ PUBLIQUE ICI)
$secretKey = '6LdEJX0rAAAAACMHwD26n8ht7AuFbp-Xv9GWDzcU';

// Récupération de la réponse reCAPTCHA envoyée par le formulaire
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

// IP de l’utilisateur
$remoteIp = $_SERVER['REMOTE_ADDR'];

// Vérification auprès des serveurs de Google
$verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
$data = [
    'secret' => $secretKey,
    'response' => $recaptchaResponse,
    'remoteip' => $remoteIp
];

// Requête POST vers Google
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($data)
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents($verifyUrl, false, $context);

// Analyse de la réponse
$verification = json_decode($result);

if (!$verification || !$verification->success) {
    // Si la vérification échoue : bloquer l’envoi
    die("❌ Échec de la vérification CAPTCHA. Veuillez réessayer.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ Vérification du CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur CSRF détectée !");
    }

    // ✅ Récupération et nettoyage des données
    $nom_auteur = trim(strip_tags($_POST['nom'] ?? ''));
    $email      = trim(strip_tags($_POST['email'] ?? ''));
    $telephone  = trim(strip_tags($_POST['telephone'] ?? ''));
    $sexe       = in_array($_POST['sexe'] ?? 'Autre', ['Homme', 'Femme', 'Autre']) ? $_POST['sexe'] : 'Autre';
    $message    = trim(strip_tags($_POST['message'] ?? ''));

    // ✅ Validation
    if (empty($nom_auteur) || empty($email) || empty($message)) {
        die("Tous les champs requis doivent être remplis.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalide !");
    }

    // ✅ Ajout sécurisé (requête préparée dans signatureModele.php)
    ajouterSignature($nom_auteur, $message, $email, $telephone, $sexe);

    // ✅ On regénère le token pour la prochaine soumission
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // ✅ Redirection vers la consultation
   header('Location: ../index.php?page=consultation');
    exit();

}
?>
