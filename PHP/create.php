<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documentName = htmlspecialchars($_POST['documentName']);
    $selectedFolder = $_POST['mainfolder'];

    // Pfade für die HTML-Dateien und das Medienverzeichnis festlegen
    $baseDir = '../HTML';
    $mediaDir = '../HTML/uploads';
    $fullPath = $baseDir . '/' . $selectedFolder;

    // Verzeichnisse erstellen, falls sie nicht existieren
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0777, true);
    }
    if (!is_dir($mediaDir)) {
        mkdir($mediaDir, 0777, true);
    }

    // Dateinamen erstellen
    $filename = preg_replace('/[^a-zA-Z0-9-_]/', '_', $documentName);
    $filePath = $fullPath . '/' . $filename . '.html';

    // Überprüfen, ob die Datei bereits existiert
    if (file_exists($filePath)) {
        echo "Die Datei existiert bereits: " . htmlspecialchars($filePath);
    } else {
        $htmlContent = "<!DOCTYPE html>
<html lang=\"de\">
<head>
    <meta charset=\"UTF-8\">
    <title>$documentName</title>
    <link rel=\"stylesheet\" href=\"../../../../CSS/style.css\">
</head>
<body>
    <div class=\"div_body\">";

        foreach ($_POST['contentType'] as $index => $contentType) {
            $title = htmlspecialchars($_POST['title'][$index]);

            if ($contentType === 'paragraph') {
                $htmlContent .= "<h2>$title</h2><p>" . htmlspecialchars($_POST['content'][$index]) . "</p>";
            } elseif ($contentType === 'list') {
                $htmlContent .= "<h2>$title</h2><ul>";
                if (isset($_POST['content'][$index]) && is_array($_POST['content'][$index])) {
                    foreach ($_POST['content'][$index] as $listItem) {
                        if (!empty($listItem)) {
                            $htmlContent .= "<li>" . htmlspecialchars($listItem) . "</li>";
                        }
                    }
                }
                $htmlContent .= "</ul>";
            } elseif ($contentType === 'image' || $contentType === 'video') {
                if (isset($_FILES['fileContent']['name'][$index]) && $_FILES['fileContent']['error'][$index] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['fileContent']['tmp_name'][$index];
                    $fileName = basename($_FILES['fileContent']['name'][$index]);
                    $fileType = $_FILES['fileContent']['type'][$index];
                    $destination = $mediaDir . '/' . $fileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        if ($contentType === 'image') {
                            $htmlContent .= "<h2>$title</h2><img src=\"../../uploads/$fileName\" alt=\"$title\" style=\"width:100%;height:auto;\">";
                        } elseif ($contentType === 'video') {
                            $htmlContent .= "<h2>$title</h2><video controls style=\"width:100%;height:auto;\"><source src=\"../../uploads/$fileName\" type=\"$fileType\">Dein Browser unterstützt dieses Videoformat nicht.</video>";
                        }
                    } else {
                        echo "Fehler beim Hochladen der Datei $fileName.";
                    }
                }
            } elseif ($contentType === 'title') {
                $htmlContent .= "<h2>$title</h2>";
            }
        }

        $htmlContent .= "</div>
    <footer></footer>
</body>
</html>";

        file_put_contents($filePath, $htmlContent);
        echo "Dokument erfolgreich erstellt: " . htmlspecialchars($filePath);
    }

    echo "Speicherort: " . htmlspecialchars($fullPath);
} else {
    echo "Ungültige Anfrage.";
}
?>
