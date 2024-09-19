<?php
require_once __DIR__ . '/../utils/JWT.php';
require_once __DIR__ . '/../utils/Response.php';

class AuthMiddleware {
    public static function authenticate() {
        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            echo Response::json(401, "Token de autenticação não fornecido");
            exit();
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $user_id = JWTUtil::validateToken($token);

        if (!$user_id) {
            echo Response::json(401, "Token inválido ou expirado");
            exit();
        }

        return $user_id;
    }
}
