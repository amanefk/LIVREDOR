<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once(__DIR__ . '/../modele/signatureModele.php');
$signatures = recupererSignatures();
?>
<main class="livre">
    <h2>💬 Livre d'Or</h2>

    <form method="POST" action="./controller/livreDorController.php" class="form-signature">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <label for="nom">Votre nom :</label>
        <input type="text" name="nom" id="nom" required>

        <label for="email">Votre email :</label>
        <input type="email" name="email" id="email" required>

        <label for="telephone">Votre téléphone :</label>
        <input type="text" name="telephone" id="telephone">

        <label for="sexe">Sexe :</label>
        <select name="sexe" id="sexe">
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre" selected>Autre</option>
        </select>

        <label for="message">Votre message :</label>
        <textarea name="message" id="message" rows="4" required></textarea>

        <button type="submit">🖊️ Signer</button>
    </form>

    <h3>🗒️ Messages :</h3>
    <?php foreach ($signatures as $sig): ?>
        <div class="message">
            <p><strong><?= htmlspecialchars($sig["Nom_Auteur"] ?? "Invité", ENT_QUOTES, 'UTF-8') ?> :</strong></p>
            <p><?= nl2br(htmlspecialchars($sig["Message"] ?? "", ENT_QUOTES, 'UTF-8')) ?></p>
            <em>Posté le <?= date("d/m/Y à H:i", strtotime($sig["Date_Signature"])) ?></em>
        </div>
    <?php endforeach; ?>
</main>
