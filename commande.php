<?php
// header("Access-Control-Allow-Origin: http://localhost/build");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Access-Control-Allow-Methods: POST");


// Chemin vers le fichier JSON
$jsonFilePath = './commandes.json';

// Vérifie si le fichier JSON existe
if (file_exists($jsonFilePath)) {
    // Récupère les données JSON actuelles
    $jsonData = file_get_contents($jsonFilePath);
    $data = json_decode($jsonData, true);

    // Vérifie si les données JSON ont été correctement décodées
    if ($data !== null) {
        // Récupère les données JSON envoyées via POST
        $postData = file_get_contents('php://input');
        $postData = json_decode($postData, true);

        if ($postData !== null) {
            // Ajoute les nouvelles données à celles existantes
            $data[] = $postData;

            // Encode les données mises à jour en JSON
            $newJsonData = json_encode($data, JSON_PRETTY_PRINT);

            // Écrit les données dans le fichier JSON
            if (file_put_contents($jsonFilePath, $newJsonData)) {
                http_response_code(200);
                echo 'Fichier JSON mis à jour avec succès.';
            } else {
                http_response_code(500);
                echo 'Erreur lors de l\'écriture dans le fichier JSON.';
            }
        } else {
            http_response_code(400);
            echo 'Données JSON invalides.';
        }
    } else {
        http_response_code(500);
        echo 'Erreur lors de la lecture des données JSON.';
    }
} else {
    http_response_code(500);
    echo 'Le fichier JSON n\'existe pas.';
}
?>
