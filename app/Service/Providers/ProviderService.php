<?php

namespace App\Service\Providers;

use App\Service\ProviderServiceInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;

class ProviderService implements ProviderServiceInterface
{
    public function getProviderData(): array
    {
        $client = HttpClient::create();
        $providers = include base_path('config/providers.php');
        $allData = [];

        foreach ($providers as $provider) {
            try {
                $response = $client->request('GET', $provider);

                if ($response->getStatusCode() !== 200) {
                    throw new \Exception("HTTP isteği başarısız oldu: " . $response->getStatusCode());
                }

                $content = $response->toArray();

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception("JSON parsing hatası: " . json_last_error_msg());
                }

                $allData[] = $content;

            }catch (ClientException $e) {
                throw new \Exception("HTTP istemcisi hatası: " . $e->getMessage());
            } catch (\Exception $e) {
                throw new \Exception("Bir hata oluştu: " . $e->getMessage());
            }
        }

        return $allData;
    }

}
