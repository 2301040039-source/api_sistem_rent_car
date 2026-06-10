<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response = [
        'code' => null,
        'message' => null,
        'data' => []
    ];

    public static function createJson($code, $message, $data = [])
    {
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return self::$response;
    }

    public static function filterSensitiveData(array $data = []): array
    {
        $sensitiveKeys = ['password', 'password_confirmation', 'token', 'api_key', 'secret'];

        foreach ($sensitiveKeys as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = '[FILTERED]';
            }
        }

        return $data;
    }
}

