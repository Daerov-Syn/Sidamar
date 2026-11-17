<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DeploymentTest extends TestCase
{
    public function test_health_endpoint_does_not_require_a_database(): void
    {
        config(['database.default' => 'unavailable']);

        $this->get('/up')->assertOk();
    }

    public function test_trusted_proxy_preserves_https_and_client_ip_without_overriding_host(): void
    {
        config(['trustedproxy.proxies' => '*']);
        $this->registerProxyProbe();

        $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.2'])
            ->withHeaders([
                'X-Forwarded-Proto' => 'https',
                'X-Forwarded-Port' => '443',
                'X-Forwarded-For' => '203.0.113.10',
                'X-Forwarded-Host' => 'untrusted.example',
            ])
            ->get('http://sidamar.example/deployment-probe')
            ->assertOk()
            ->assertJson([
                'url' => 'https://sidamar.example/admin/login',
                'client_ip' => '203.0.113.10',
            ]);
    }

    public function test_forwarded_headers_are_ignored_without_a_trusted_proxy(): void
    {
        config(['trustedproxy.proxies' => null]);
        $this->registerProxyProbe();

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.20'])
            ->withHeaders([
                'X-Forwarded-Proto' => 'https',
                'X-Forwarded-For' => '203.0.113.10',
            ])
            ->get('http://sidamar.example/deployment-probe')
            ->assertOk()
            ->assertJson([
                'url' => 'http://sidamar.example/admin/login',
                'client_ip' => '203.0.113.20',
            ]);
    }

    private function registerProxyProbe(): void
    {
        Route::get('/deployment-probe', fn (Request $request): array => [
            'url' => route('admin.login'),
            'client_ip' => $request->ip(),
        ]);
    }
}
