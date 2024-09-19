<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTUtil {
    private static $secret_key = 'your_secret_key_here';
    private static $algorithm = 'HS256';

    public static function generateToken($user_id) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // válido por 1 hora

        $payload = array(
            'user_id' => $user_id,
            'iat' => $issuedAt,
            'exp' => $expirationTime
        );

        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
            return $decoded->user_id;
        } catch (Exception $e) {
            return false;
        }
    }
}
