<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Admin
    {
        return Admin::factory()->create();
    }

    public function test_guests_cannot_access_settings(): void
    {
        $this->get(route('admin.settings'))->assertForbidden();
        $this->post(route('admin.settings.update'))->assertForbidden();
    }

    public function test_settings_page_shows_gateway_form(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('admin.settings'));

        $response->assertOk();
        $response->assertSee('Payment Gateway');
        $response->assertSee('stripe');
        $response->assertSee('paypal');
        $response->assertSee('coinbase');
        $response->assertSee('offline');
    }

    public function test_update_saves_selected_gateway_and_details(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update'), [
                'payment_gateway' => 'stripe',
                'settings' => [
                    'stripe' => [
                        'publishable_key' => 'pk_test_123',
                        'secret_key' => 'sk_test_123',
                        'webhook_secret' => 'whsec_123',
                    ],
                    'paypal' => [
                        'client_id' => '',
                        'client_secret' => '',
                        'environment' => 'sandbox',
                    ],
                    'coinbase' => [
                        'api_key' => '',
                        'webhook_secret' => '',
                    ],
                    'offline' => [
                        'instructions' => '',
                    ],
                ],
            ]);

        $response->assertRedirect(route('admin.settings'));
        $response->assertSessionHas('success');

        $this->assertEquals('stripe', Setting::getValue('payment_gateway'));

        $saved = json_decode(Setting::getValue('payment_gateway_settings'), true);
        $this->assertEquals('pk_test_123', $saved['stripe']['publishable_key']);
        $this->assertEquals('sk_test_123', $saved['stripe']['secret_key']);
        $this->assertEquals('whsec_123', $saved['stripe']['webhook_secret']);
    }

    public function test_validation_requires_fields_for_selected_gateway(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update'), [
                'payment_gateway' => 'stripe',
                'settings' => [
                    'stripe' => [
                        'publishable_key' => '',
                        'secret_key' => '',
                        'webhook_secret' => '',
                    ],
                ],
            ]);

        $response->assertSessionHasErrors([
            'settings.stripe.publishable_key',
            'settings.stripe.secret_key',
        ]);
    }

    public function test_update_saves_paypal_configuration(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update'), [
                'payment_gateway' => 'paypal',
                'settings' => [
                    'stripe' => [
                        'publishable_key' => '',
                        'secret_key' => '',
                        'webhook_secret' => '',
                    ],
                    'paypal' => [
                        'client_id' => 'paypal_client',
                        'client_secret' => 'paypal_secret',
                        'environment' => 'live',
                    ],
                    'coinbase' => [
                        'api_key' => '',
                        'webhook_secret' => '',
                    ],
                    'offline' => [
                        'instructions' => '',
                    ],
                ],
            ]);

        $this->assertEquals('paypal', Setting::getValue('payment_gateway'));

        $saved = json_decode(Setting::getValue('payment_gateway_settings'), true);
        $this->assertEquals('paypal_client', $saved['paypal']['client_id']);
        $this->assertEquals('live', $saved['paypal']['environment']);
    }
}
