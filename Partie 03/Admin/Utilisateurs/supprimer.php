<?php
define('ACCES_AUTORISE', true);
require '../../fonctions.php';
require '../../config/connexion.php';
require '../authentique.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!verifier_token($_POST['csrf_token'] ?? '')) {
    die('Requête invalide.');
}

$id = (int)($_POST['id'] ?? 0);
if ($id === 0) {
    header('Location: index.php');
    exit;
}

// Empêcher un admin de supprimer son propre compte
if ($id === (int)$_SESSION['admin_id']) {
    header('Location: index.php?erreur=1');
    exit;
}

$pdo->prepare('DELETE FROM administrateurs WHERE id = ?')->execute([$id]);

header('Location: index.php?succes=1');
exit;