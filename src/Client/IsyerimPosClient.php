<?php

namespace Abdullah\IsyerimPos\Client;

use Abdullah\IsyerimPos\Exceptions\ApiException;
use Abdullah\IsyerimPos\Exceptions\AuthenticationException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IsyerimPosClient
{
    protected string $baseUrl;

    protected string $merchantId;

    protected string $userId;

    protected string $apiKey;

    protected int $timeout;

    protected int $connectTimeout;

    protected int $retryTimes;

    protected int $retrySleep;

    protected bool $loggingEnabled;

    protected string $logChannel;

    protected bool $logRequests;

    protected bool $logResponses;

    public function __construct()
    {
        $this->baseUrl = config('isyerim-pos.base_url');
        $this->merchantId = config('isyerim-pos.merchant_id');
        $this->userId = config('isyerim-pos.user_id');
        $this->apiKey = config('isyerim-pos.api_key');
        $this->timeout = config('isyerim-pos.timeout', 30);
        $this->connectTimeout = config('isyerim-pos.connect_timeout', 10);
        $this->retryTimes = config('isyerim-pos.retry_times', 3);
        $this->retrySleep = config('isyerim-pos.retry_sleep', 100);
        $this->loggingEnabled = config('isyerim-pos.logging.enabled', false);
        $this->logChannel = config('isyerim-pos.logging.channel', 'stack');
        $this->logRequests = config('isyerim-pos.logging.log_requests', true);
        $this->logResponses = config('isyerim-pos.logging.log_responses', true);

        $this->validateCredentials();
    }

    protected function validateCredentials(): void
    {
        if (empty($this->merchantId) || empty($this->userId) || empty($this->apiKey)) {
            throw AuthenticationException::missingCredentials();
        }
    }

    protected function buildRequest(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->connectTimeout($this->connectTimeout)
            ->retry($this->retryTimes, $this->retrySleep)
            ->withHeaders([
                'MerchantId' => $this->merchantId,
                'UserId' => $this->userId,
                'ApiKey' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);
    }

    public function get(string $endpoint, array $params = []): array
    {
        $this->logRequest('GET', $endpoint, ['params' => $params]);

        try {
            $response = $this->buildRequest()->get($endpoint, $params);

            return $this->handleResponse($response, 'GET', $endpoint);
        } catch (\Exception $e) {
            $this->logError('GET', $endpoint, $e);

            throw ApiException::networkError($e->getMessage());
        }
    }

    public function post(string $endpoint, array $data = []): array
    {
        $this->logRequest('POST', $endpoint, $data);

        try {
            $response = $this->buildRequest()->post($endpoint, $data);

            return $this->handleResponse($response, 'POST', $endpoint);
        } catch (\Exception $e) {
            $this->logError('POST', $endpoint, $e);

            throw ApiException::networkError($e->getMessage());
        }
    }

    protected function handleResponse(Response $response, string $method, string $endpoint): array
    {
        $this->logResponse($method, $endpoint, $response);

        if ($response->successful()) {
            return $response->json() ?? [];
        }

        if ($response->status() === 401 || $response->status() === 403) {
            throw AuthenticationException::invalidCredentials();
        }

        throw ApiException::requestFailed($response);
    }

    protected function logRequest(string $method, string $endpoint, array $data): void
    {
        if (! $this->loggingEnabled || ! $this->logRequests) {
            return;
        }

        Log::channel($this->logChannel)->info('IsyerimPOS API Request', [
            'method' => $method,
            'endpoint' => $endpoint,
            'url' => $this->baseUrl.$endpoint,
            'data' => $data,
        ]);
    }

    protected function logResponse(string $method, string $endpoint, Response $response): void
    {
        if (! $this->loggingEnabled || ! $this->logResponses) {
            return;
        }

        Log::channel($this->logChannel)->info('IsyerimPOS API Response', [
            'method' => $method,
            'endpoint' => $endpoint,
            'status' => $response->status(),
            'body' => $response->json(),
        ]);
    }

    protected function logError(string $method, string $endpoint, \Exception $exception): void
    {
        if (! $this->loggingEnabled) {
            return;
        }

        Log::channel($this->logChannel)->error('IsyerimPOS API Error', [
            'method' => $method,
            'endpoint' => $endpoint,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
