<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['folder'])) {
    $folder = htmlspecialchars($_GET['folder']);
    $baseDir = '../HTML/' . $folder; // Setze den richtigen Pfad zu den Unterordnern

    if (is_dir($baseDir)) {
        $subfolders = array_filter(scandir($baseDir), function($item) use ($baseDir) {
            return $item !== '.' && $item !== '..' && is_dir($baseDir . '/' . $item);
        });

        echo json_encode(array_values($subfolders));
    } else {
        echo json_encode([]); // Leeres Array zurückgeben, wenn der Ordner nicht existiert
    }
} else {
    echo json_encode([]); // Leeres Array zurückgeben, wenn kein Ordner angegeben ist
}
?>
