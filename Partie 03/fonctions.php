<?php
if (!defined('ACCES_AUTORISE')) {
    http_response_code(403);
    die('Accès interdit.');
}

ini_set('display_errors', 0);
error_reporting(0);

function nettoyer(string $valeur): string {
    return htmlspecialchars(trim($valeur));
}


function champ_requis(string $valeur): bool {
    return !empty(trim($valeur));
}


function email_valide(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function generer_token(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifier_token(string $token): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
function enregistrer_visite(PDO $pdo, string $page): void {
    try {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $stmt = $pdo->prepare('INSERT INTO visites (adresse_ip, page) VALUES (?, ?)');
        $stmt->execute([$ip, $page]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
}
?>