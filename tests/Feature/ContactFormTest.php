<?php

namespace Tests\Feature;

use App\Livewire\Storefront\ContactForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear('contact-request:127.0.0.1');
    }

    public function test_it_stores_a_contact_message(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Олександр')
            ->set('phone', '+38 050 123 45 67')
            ->set('email', 'client@example.com')
            ->set('message', 'Потрібна консультація щодо комплектації вулика.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('contact-submitted');

        $this->assertDatabaseHas('contact_requests', [
            'type' => 'message',
            'name' => 'Олександр',
            'phone' => '+38 050 123 45 67',
            'email' => 'client@example.com',
            'status' => 'new',
        ]);
    }

    public function test_it_stores_a_callback_request_without_message_fields(): void
    {
        Livewire::test(ContactForm::class)
            ->call('changeType', 'callback')
            ->set('name', 'Марія')
            ->set('phone', '+38 050 555 12 12')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('contact-submitted');

        $this->assertDatabaseHas('contact_requests', [
            'type' => 'callback',
            'name' => 'Марія',
            'message' => null,
        ]);
    }

    public function test_it_validates_required_contact_fields(): void
    {
        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name', 'phone', 'message']);
    }
}
