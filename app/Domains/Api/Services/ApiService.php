<?php

namespace App\Domains\Api\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiService
{
    /**
     * Oddiy GET so'rov (server-to-server, umumiy token bilan)
     * Maslahat: bu admin/ umumiy token uchun ishlaydi (config('api.token'))
     */
    public static function getFromApi(string $endpoint): array
    {
        $base = rtrim(config('api.base_url', ''), '/');
        $full = "{$base}/api/{$endpoint}";

        try {
            $resp = Http::withToken(config('api.token'))
                        ->acceptJson()
                        ->get($full);

            // Agar HTTP levelda muammo bo'lsa, log qilamiz va strukturalangan array qaytaramiz
            if ($resp->failed()) {
                Log::warning('GET API failed', [
                    'url' => $full,
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                ]);
            }

            return $resp->json() ?? ['success' => false, 'message' => 'Empty response from API', 'status' => $resp->status()];
        } catch (\Throwable $e) {
            Log::error('GET API Error: '.$e->getMessage(), [
                'url' => $full,
                'code' => $e->getCode(),
            ]);
            return ['success' => false, 'message' => $e->getMessage(), 'status' => 500];
        }
    }

    /**
     * Foydalanuvchi tokeni bilan GET so'rov
     * Tokenni session('auth_token') dan oladi.
     */
    public static function getFromApiForUser(string $endpoint): array
    {
        $base = rtrim(config('api.base_url', ''), '/');
        $full = "{$base}/api/{$endpoint}";

        $token = session('auth_token');

        if (empty($token)) {
            Log::warning('getFromApiForUser called without session token', ['endpoint' => $endpoint]);
            return ['success' => false, 'message' => 'Not authenticated', 'status' => 401];
        }

        try {
            $resp = Http::withToken($token)
                        ->acceptJson()
                        ->get($full);

            if ($resp->failed()) {
                Log::warning('GET API (User) failed', [
                    'url' => $full,
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                    'endpoint' => $endpoint,
                ]);
            }

            return $resp->json() ?? ['success' => false, 'message' => 'Empty response from API', 'status' => $resp->status()];
        } catch (\Throwable $e) {
            Log::error('GET API (User) Error: '.$e->getMessage(), [
                'url' => $full,
                'token_present' => !empty($token),
            ]);
            return ['success' => false, 'message' => $e->getMessage(), 'status' => 500];
        }
    }

    public static function postApiForUser(string $endpoint, array $data = []): array
    {
        $base = rtrim(config('api.base_url', ''), '/');
        $full = "{$base}/api/{$endpoint}";

        $token = session('auth_token');

        if (empty($token)) {
            Log::warning('postApiForUser called without session token', ['endpoint' => $endpoint]);
            return ['success' => false, 'message' => 'Not authenticated', 'status' => 401];
        }

        try {
            $resp = Http::withToken($token)
                        ->acceptJson()
                        ->post($full, $data);

            if ($resp->failed()) {
                Log::warning('POST API (User) failed', [
                    'url' => $full,
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                    'endpoint' => $endpoint,
                    'data' => $data,
                ]);
            }

            return $resp->json() ?? ['success' => false, 'message' => 'Empty response from API', 'status' => $resp->status()];
        } catch (\Throwable $e) {
            Log::error('POST API (User) Error: '.$e->getMessage(), [
                'url' => $full,
                'token_present' => !empty($token),
                'data' => $data,
            ]);
            return ['success' => false, 'message' => $e->getMessage(), 'status' => 500];
        }
    }

    /**
     * POST so'rov (umumiy token)
     */
    public static function postToApi(string $endpoint, array $data = []): array
    {
        $base = rtrim(config('api.base_url', ''), '/');
        $full = "{$base}/api/{$endpoint}";

        try {
            $resp = Http::withToken(config('api.token'))
                        ->acceptJson()
                        ->post($full, $data);

            if ($resp->failed()) {
                Log::warning('POST API failed', [
                    'url' => $full,
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                ]);
            }

            return $resp->json() ?? ['success' => false, 'message' => 'Empty response from API', 'status' => $resp->status()];
        } catch (\Throwable $e) {
            Log::error('POST API Error: '.$e->getMessage(), [
                'url' => $full,
                'data' => $data,
                'code' => $e->getCode(),
            ]);
            return ['success' => false, 'message' => $e->getMessage(), 'status' => 500];
        }
    }

    /**
     * Profilni olish uchun yordamchi (agar kerak bo'lsa)
     * Bu endpoiint bazening /profile/me kabi route-ga to'g'ri keladi.
     */
    // public static function getProfileMe(): array
    // {
    //     $base = rtrim(config('api.base_url', ''), '/');
    //     $token = session('auth_token');

    //     if (empty($token)) {
    //         Log::warning('getProfileMe called without token');
    //         return ['success' => false, 'message' => 'Not authenticated', 'status' => 401];
    //     }

    //     try {
    //         $resp = Http::withToken($token)
    //                     ->acceptJson()
    //                     ->get("{$base}/profile/me");

    //         if ($resp->failed()) {
    //             Log::warning('getProfileMe failed', [
    //                 'status' => $resp->status(),
    //                 'body' => $resp->body(),
    //             ]);
    //         }

    //         return $resp->json() ?? ['success' => false, 'message' => 'Empty response from API', 'status' => $resp->status()];
    //     } catch (\Throwable $e) {
    //         Log::error('getProfileMe Error: '.$e->getMessage());
    //         return ['success' => false, 'message' => $e->getMessage(), 'status' => 500];
    //     }
    // }

    public static function getToApi(string $endpoint, array $headers = []): array
    {
        $base = rtrim(config('api.base_url', ''), '/');
        $full = "{$base}/api/{$endpoint}";

        try {
            $resp = Http::withHeaders($headers)
                        ->acceptJson()
                        ->get($full);

            if ($resp->failed()) {
                Log::warning('GET API failed', [
                    'url' => $full,
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                ]);
                return ['success' => false, 'message' => 'API request failed', 'status' => $resp->status()];
            }

            return $resp->json() ?? ['success' => false, 'message' => 'Empty response from API', 'status' => $resp->status()];
        } catch (\Throwable $e) {
            Log::error('GET API Error: '.$e->getMessage(), [
                'url' => $full,
                'code' => $e->getCode(),
            ]);
            return ['success' => false, 'message' => $e->getMessage(), 'status' => 500];
        }
    }
}
