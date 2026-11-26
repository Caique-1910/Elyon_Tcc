
<?php

/**
 * ======================================================
 * CONFIGURAÇÕES GERAIS DA APLICAÇÃO
 * ======================================================
 */

// Ambiente da aplicação
define('APP_ENV', 'production'); // development | production

// Fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Charset
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

// Exibição e registro de erros
if (APP_ENV === 'development') {
    ini_set('display_errors', '1');
    ini_set('log_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    error_reporting(E_ALL);
}

// Configurações de segurança da sessão
if (session_status() === PHP_SESSION_NONE) {

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}
