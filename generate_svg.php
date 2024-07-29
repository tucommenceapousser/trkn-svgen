<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $job = htmlspecialchars($_POST['job']);
    $image_url = !empty($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : 'https://i.top4top.io/p_31226h15s0.jpg';
    $anonymous = htmlspecialchars($_POST['anonymous']);

    // Charger le contenu du fichier SVG existant
    $svgTemplate = file_get_contents('trknfinblck.svg');

    // Remplacer les valeurs par défaut par les données fournies (insensible à la casse)
    $svgContent = str_ireplace(['TRHACKNON', 'Writer &#38; web Developer', 'sz'], [$name, $job, $name], $svgTemplate);

    // Remplacer chaque caractère de TRHACKNON dans la section vertical-text
    $defaultChars = ['T', 'R', 'H', 'A', 'C', 'K', 'N', 'O', 'N', '!'];
    $nameChars = str_split($name . str_repeat(' ', 10)); // Assurez-vous qu'il y ait assez de caractères ou d'espaces

    foreach ($defaultChars as $index => $char) {
        $replacementChar = $nameChars[$index] ?? ' '; // Utiliser un espace si le nom est plus court
        $svgContent = preg_replace("/<span><em>$char<\/em><\/span>/i", "<span><em>$replacementChar</em></span>", $svgContent, 1);
    }

    // Remplacer l'URL de l'image si fournie
    $svgContent = str_ireplace('https://i.top4top.io/p_31226h15s0.jpg', $image_url, $svgContent);

    // Remplacer "AnOnYmOuS" par le mot fourni
    $anonymousText = !empty($anonymous) ? $anonymous : 'AnOnYmOuS'; // Utiliser "AnOnYmOuS" si aucun mot n'est fourni
    $svgContent = str_ireplace('AnOnYmOuS', $anonymousText, $svgContent);

    // Enregistrer le SVG dans un fichier temporaire
    $tempFile = 'temp_personalized_logo.svg';
    file_put_contents($tempFile, $svgContent);

    // Rediriger vers le même fichier pour le téléchargement automatique
    header('Content-Type: image/svg+xml');
    header('Content-Disposition: attachment; filename="personalized_logo.svg"');
    readfile($tempFile);

    // Supprimer le fichier temporaire après le téléchargement
    unlink($tempFile);

    exit();
}
?>