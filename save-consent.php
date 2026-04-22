<?php
// save-consent.php
// Ce fichier reçoit le choix de l'utilisateur et l'enregistre dans consent-log.csv

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupère les données envoyées
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Prépare les informations à enregistrer
    $consent = isset($input['consent']) && $input['consent'] === true ? 'Accepté' : 'Refusé';
    $date = date('d/m/Y H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP inconnue';
    $page = isset($input['page']) ? $input['page'] : '/';
    
    // Ligne à écrire dans le CSV
    $ligne = array($date, $ip, $consent, $page);
    
    // Ouvre le fichier CSV en mode ajout (le crée s'il n'existe pas)
    $fichier = fopen('consent-log.csv', 'a');
    
    // Si le fichier vient d'être créé, ajoute l'en-tête
    if (filesize('consent-log.csv') == 0) {
        fputcsv($fichier, array('Date', 'IP', 'Choix', 'Page'), ';');
    }
    
    // Écrit la ligne (point-virgule comme séparateur pour Excel français)
    fputcsv($fichier, $ligne, ';');
    fclose($fichier);
    
    // Réponse au navigateur
    echo json_encode(['status' => 'ok']);
    exit;
}

// Si quelqu'un accède directement à ce fichier sans POST
header('HTTP/1.1 405 Method Not Allowed');
echo 'Accès direct non autorisé.';
?>