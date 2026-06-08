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

// Récupérer le projet pour supprimer l'image
$stmt = $pdo->prepare('SELECT * FROM projets WHERE id = ?');
$stmt->execute([$id]);
$projet = $stmt->fetch();

if ($projet) {
    // Supprimer l'image si elle existe
    if (!empty($projet['image']) && file_exists('../../' . $projet['image'])) {
        unlink('../../' . $projet['image']);
    }
    // Supprimer le projet
    $pdo->prepare('DELETE FROM projets WHERE id = ?')->execute([$id]);
}

header('Location: index.php?succes=2');
exit;