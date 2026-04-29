<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WatiService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $channelNumber;

    public function __construct()
    {
        $this->baseUrl       = config('services.wati.base_url');
        $this->apiKey        = config('services.wati.api_key');
        $this->channelNumber = config('services.wati.channel_number');
    }

    public function sendTemplateMessage(
        string $mobile,
        string $templateName,
        array $parameters,
        string $broadcastName = 'default_broadcast'
    ): array {
        $to = '91' . $mobile;

        $payload = [
            'template_name'  => $templateName,
            'channel_number' => $this->channelNumber,
            'broadcast_name' => $broadcastName,
            'parameters'     => $parameters,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->post(
                "{$this->baseUrl}/api/v1/sendTemplateMessage?whatsappNumber={$to}",
                $payload
            );

            return [
                'success' => $response->successful(),
                'data'    => $response->json(),
            ];

        } catch (\Exception $e) {
            Log::error('WATI Exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
