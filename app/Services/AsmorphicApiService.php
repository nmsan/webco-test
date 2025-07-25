<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AsmorphicApiService
{
    protected string $baseUrl = 'https://extranet.asmorphic.com';
    protected ?string $token = null;

    public function login(string $username, string $password): bool
    {
        $response = Http::post($this->baseUrl . '/api/login', [
            'email' => $username,
            'password' => $password
        ]);

        if ($response->successful()) {
            $this->token = $response->json('token');
            Cache::put('asmorphic_api_token', $this->token, now()->addHours(23));
            return true;
        }

        return false;
    }

    public function findAddress(array $addressData, string $username, string $password)
    {
        $token = Cache::get('asmorphic_api_token');
        if (!$token) {
            $this->login($username, $password);
            $token = Cache::get('asmorphic_api_token');
        }
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post($this->baseUrl . '/api/orders/findaddress', array_merge([
            'company_id' => 17
        ], $addressData));
    }

    public function qualifyService(string $locationId)
    {
        $token = Cache::get('asmorphic_api_token');

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post($this->baseUrl . '/api/orders/qualify', [
            'company_id' => 17,
            'qualification_identifier' => $locationId,
            'service_type_id' => 3
        ]);
    }
}
