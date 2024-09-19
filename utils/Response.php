<?php
class Response {
    public static function json($status_code, $message, $data = null) {
        http_response_code($status_code);
        $response = [
            "status" => $status_code < 300 ? "success" : "error",
            "message" => $message
        ];
        if ($data !== null) {
            $response["data"] = $data;
        }
        return json_encode($response);
    }
}