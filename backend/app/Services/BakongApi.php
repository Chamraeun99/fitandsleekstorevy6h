<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class BakongApi
{
    public function checkByMd5(string $md5): array
    {
        $baseUrl = rtrim(config('services.bakong.base_url'), '/');
        $token = config('services.bakong.token');

        if (! $token) {
            throw new RuntimeException('Bakong token is not configured.');
        }

        if (empty($md5)) {
            throw new RuntimeException('Payment MD5 is missing.');
        }

        $http = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

        $verifyOption = $this->resolveVerifyOption();
        $http = $http->withOptions(['verify' => $verifyOption]);

        $response = $http->post($baseUrl . '/v1/check_transaction_by_md5', [
            'md5' => $md5,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Bakong HTTP ' . $response->status() . ': ' . $response->body());
        }

        return $response->json();
    }

    private function resolveVerifyOption(): bool|string
    {
        $verify = config('services.bakong.verify', true);
        $caBundle = (string) config('services.bakong.ca_bundle', '');

        if (is_string($verify)) {
            $parsed = filter_var($verify, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $verify = $parsed ?? true;
        }

        if ($verify === false) {
            return false;
        }

        $caBundle = trim($caBundle);
        if ($caBundle !== '') {
            if (is_readable($caBundle)) {
                return $caBundle;
            }

            Log::warning('Bakong CA bundle path is not readable, using system trust store.', [
                'path' => $caBundle,
            ]);
        }

        return true;
    }
}
