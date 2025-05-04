<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        // Membuat instance client Guzzle
        $this->client = new Client();
        // Mendapatkan API key dari file .env
        $this->apiKey = env('FONNTE_API_KEY');
    }

    public function sendFile($to, $filePath)
{
    $url = "https://api.fonnte.com/v1/messages"; // Endpoint Fonnte API untuk mengirim file

    try {
        $response = $this->client->post($url, [
            'multipart' => [
                [
                    'name'     => 'to',        // Nomor tujuan WhatsApp
                    'contents' => $to,         // Nomor WhatsApp tujuan
                ],
                [
                    'name'     => 'file',      // File yang dikirim
                    'contents' => fopen($filePath, 'r'),
                    'filename' => basename($filePath),   // Nama file
                ],
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,  // API Key untuk autentikasi
            ]
        ]);

        $body = $response->getBody();
        $responseData = json_decode($body);

        // Log respons untuk pengecekan error
        Log::info('Fonnte API Response:', ['response' => $responseData]);

        // Mengecek status pengiriman
        if (isset($responseData->status) && $responseData->status == 'success') {
            return true;
        } else {
            Log::error('Pengiriman file gagal', ['response' => $responseData]);
            return false;
        }
    } catch (\Exception $e) {
        // Log error untuk pengecekan lebih lanjut
        Log::error("Fonnte API error: " . $e->getMessage());
        return false;
    }
}

}
