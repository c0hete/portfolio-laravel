<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HubEventReporter
{
    private ?string $baseUrl;
    private ?string $token;
    private bool $enabled;
    private string $source;
    private string $env;

    public function __construct()
    {
        $this->baseUrl = config('services.hub.url');
        $this->token = config('services.hub.token');
        $this->enabled = config('services.hub.enabled', false);
        $this->source = config('services.hub.source', 'portfolio');
        $this->env = config('services.hub.env', 'production');
    }

    /**
     * Send event to Hub API
     */
    private function sendEvent(string $eventType, array $payload, ?string $occurredAt = null): void
    {
        // Log mode: only log the event, don't send
        if (!$this->enabled) {
            Log::info("[HUB] Would send: {$eventType}", $payload);
            return;
        }

        // Validate configuration
        if (!$this->baseUrl || !$this->token) {
            Log::error('[HUB] Error: Missing HUB_API_URL or HUB_API_TOKEN');
            return;
        }

        // Build event payload
        $event = [
            'type' => $eventType,
            'source' => $this->source,
            'occurred_at' => $occurredAt ?? Carbon::now()->toIso8601String(),
            'payload' => $payload,
        ];

        // Send to Hub API
        try {
            $response = Http::timeout(5)
                ->withToken($this->token)
                ->post("{$this->baseUrl}/events", $event);

            if ($response->successful()) {
                Log::info("[HUB] ✅ Event sent: {$eventType}");
            } else {
                Log::error("[HUB] ❌ Event failed: {$eventType}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("[HUB] ❌ Error sending event: {$e->getMessage()}", [
                'event_type' => $eventType,
                'exception' => get_class($e),
            ]);
        }
    }

    /**
     * Report application registration/startup
     */
    public function reportAppRegistered(string $version, string $env): void
    {
        $this->sendEvent('AppRegistered', [
            'version' => $version,
            'env' => $env,
        ]);
    }

    /**
     * Report page view
     */
    public function reportPageView(string $path, ?string $userAgent = null, ?string $referer = null): void
    {
        $payload = ['path' => $path];

        if ($userAgent) {
            $payload['user_agent'] = $userAgent;
        }

        if ($referer) {
            $payload['referer'] = $referer;
        }

        $this->sendEvent('PageView', $payload);
    }

    /**
     * Report contact form submission
     */
    public function reportContactFormSubmitted(string $email, ?string $subject = null): void
    {
        $payload = ['email' => $email];

        if ($subject) {
            $payload['subject'] = $subject;
        }

        $this->sendEvent('ContactFormSubmitted', $payload);
    }

    /**
     * Report generic interaction
     */
    public function reportInteraction(string $action, array $metadata = []): void
    {
        $payload = array_merge(['action' => $action], $metadata);
        $this->sendEvent('InteractionDetected', $payload);
    }

    /**
     * Report error
     */
    public function reportError(string $severity, string $message, ?string $trace = null): void
    {
        $payload = [
            'severity' => $severity,
            'message' => $message,
        ];

        if ($trace) {
            $payload['trace'] = $trace;
        }

        $this->sendEvent('ErrorReported', $payload);
    }
}
