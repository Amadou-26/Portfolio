<?php


function nettoyer(string $valeur): string {
    return htmlspecialchars(trim($valeur));
}


function champ_requis(string $valeur): bool {
    return !empty(trim($valeur));
}


function email_valide(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}


function get_projets(): array {
    return [
        [
            'id'           => 'poubelle',
            'titre'        => 'Poubelle Intelligente Connectée',
            'description'  => 'Prototype de gestion intelligente des déchets basé sur un microcontrôleur ESP32. Automatisation de l\'ouverture et monitoring en temps réel via un tableau de bord web.',
            'technologies' => ['C++', 'ESP32', 'IoT', 'DHT11'],
            'categorie'    => 'iot',
            'image'        => '',
            'lien'         => '',
        ],
        [
            'id'           => 'repertoire',
            'titre'        => 'Répertoire Téléphonique',
            'description'  => 'Application de gestion de contacts robuste et structurée. Structures de données personnalisées en C et persistance via MySQL.',
            'technologies' => ['C', 'MySQL', 'SQLite'],
            'categorie'    => 'c',
            'image'        => 'images/projet-repertoire.png',
            'lien'         => '',
        ],
        [
            'id'           => 'capteurs',
            'titre'        => 'Étude des Capteurs en Automobile',
            'description'  => 'Projet de fin d\'études explorant les capteurs du véhicule moderne : inductifs, sondes lambda et capteurs de pression.',
            'technologies' => ['Électronique', 'Carmin', 'Autodata'],
            'categorie'    => 'auto',
            'image'        => '',
            'lien'         => '',
        ],
        [
            'id'           => 'pollution',
            'titre'        => 'Éradication de la Pollution — "ÊTRE LA SOLUTION"',
            'description'  => 'Co-fondateur d\'une initiative de gestion des déchets à Dakar. Poubelles électroniques et économie circulaire (Colobane, Fass, Gueule Tapée).',
            'technologies' => ['IoT', 'Social', 'Innovation'],
            'categorie'    => 'social',
            'image'        => 'images/projet-pollution.png',
            'lien'         => '',
        ],
    ];
}


function filtrer_projets(array $projets, string $mot_cle): array {
    if ($mot_cle === '') {
        return $projets;
    }
    $resultats = [];
    foreach ($projets as $projet) {
        $dans_titre       = stripos($projet['titre'],       $mot_cle) !== false;
        $dans_description = stripos($projet['description'], $mot_cle) !== false;
        $dans_categorie   = stripos($projet['categorie'],   $mot_cle) !== false;
        $dans_tech        = false;
        foreach ($projet['technologies'] as $tech) {
            if (stripos($tech, $mot_cle) !== false) {
                $dans_tech = true;
                break;
            }
        }
        if ($dans_titre || $dans_description || $dans_categorie || $dans_tech) {
            $resultats[] = $projet;
        }
    }
    return $resultats;
}
