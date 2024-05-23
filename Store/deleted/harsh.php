<?php

function getMarkdownFilePaths($directory, $rootDirectory) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    $markdownFolders = [];

    foreach ($iterator as $file) {
        if ($file->isFile() && strtolower($file->getBasename()) === 'readme.md') {
            $folderPath = str_replace($rootDirectory, '', $file->getPathname());
            $folderPath = str_replace('\\', '/', $folderPath);
            $markdownFolders[] = ["path" => '/' . ltrim($folderPath, '/\\')];
        }
    }
    return $markdownFolders;
}

$rootDirectory = __DIR__;   
$markdownFolders = getMarkdownFilePaths($rootDirectory, $rootDirectory);
$jsonData = json_encode($markdownFolders, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

$jsonFilePath = 'C:/Users/Administrator/Downloads/path.json';
file_put_contents($jsonFilePath, $jsonData);

echo 'JSON file generated successfully.';

?>