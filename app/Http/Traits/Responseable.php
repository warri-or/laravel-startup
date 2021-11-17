<?php

namespace App\Http\Traits;

trait Responseable
{
    /**
     * @param string $message
     * @param string $alertType
     *
     * @return array [type]
     */
    public function webResponse(string $message, string $alertType) : array {
        return [
            $alertType => $message
        ];
    }

    public function response(bool $success, string $message='', array $data = []) : array {
        return [
            'success' => $success,
            'message' => $message,
            'data' => $data
        ];
    }
}
