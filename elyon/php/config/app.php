<?php

/**
 * ======================================================
 *  CONFIGURAÇÕES GERAIS DA APLICAÇÃO
 * ======================================================
 */

// Nome da aplicação
define('APP_NAME', 'elyon');

// URL base do projeto
define('BASE_URL', 'http://localhost/elyon');

// Ambiente da aplicação
define('APP_ENV', 'development'); // development | production

// Fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Charset
header('Content-Type: text/html; charset=UTF-8');

// Exibição de erros
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Inicia a sessão caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}