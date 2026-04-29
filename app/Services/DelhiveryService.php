<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DelhiveryService
{
    protected string $apiToken;

    public function __construct()
    {
        $this->apiToken = env('DELHIVERY_API_TOKEN');
    }

    /**
     * Check whether a postcode is serviceable for pre-paid delivery.
     */
    public function checkPostcode(string $pin): bool
    {
        if (empty($pin)) {
            return false;
        }

        $url = "https://track.delhivery.com/c/api/pin-codes/json/";

        try {
            $response = Http::timeout(10)
                ->get($url, [
                    'token' => $this->apiToken,
                    'filter_codes' => $pin,
                ]);

            if (!$response->successful()) {
                return false;
            }

            $data = $response->json();
            return $data['delivery_codes'][0]['postal_code']['pre_paid'] ?? false;
        } catch (\Exception $e) {
            \Log::error("Delhivery postcode check failed: " . $e->getMessage());
            return false;
        }
    }
}
