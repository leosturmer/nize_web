<?php
$applicationPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
$basePath = '/';

if ($applicationPath !== false && $documentRoot !== false) {
	$applicationPath = str_replace('\\', '/', $applicationPath);
	$documentRoot = str_replace('\\', '/', $documentRoot);

	if (stripos($applicationPath, $documentRoot) === 0) {
		$basePath = substr($applicationPath, strlen($documentRoot));
	}
}

define('BASE_URL', rtrim($basePath, '/') . '/');

// Preencha estes valores com os dados exibidos no painel do InfinityFree.
define('DB_HOST', 'localhost');
define('DB_NAME', 'nize_database');
define('DB_USER', 'root');
define('DB_PASS', '');