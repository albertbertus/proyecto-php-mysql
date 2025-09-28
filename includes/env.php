<?php
// Cargador simple de variables desde .env (solo para desarrollo)
function load_env($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_ENV) && getenv($name) === false) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

// Buscar en el directorio del proyecto
$projectRoot = dirname(__DIR__);
$envPath = $projectRoot . DIRECTORY_SEPARATOR . '.env';
load_env($envPath);

?>
