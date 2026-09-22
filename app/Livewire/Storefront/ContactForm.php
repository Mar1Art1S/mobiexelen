<?php

namespace App\Livewire\Storefront;

use App\Models\ContactRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    public string $type = 'message';

    public string $name = '';

    public string $phone = '';

    public string $email = '';

    public string $message = '';

    public string $website = '';

    public function changeType(string $type): void
    {
        $this->type = in_array($type, ['message', 'callback'], true) ? $type : 'message';
        $this->resetValidation();
    }

    public function submit(): void
    {
        if ($this->website !== '') {
            $this->resetForm();
            $this->dispatch('contact-submitted', message: 'Дякуємо! Ми зв’яжемося з вами найближчим часом.');

            return;
        }

        $rateLimitKey = 'contact-request:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $this->addError('phone', 'Забагато спроб. Будь ласка, повторіть трохи пізніше.');

            return;
        }

        $validated = $this->validate();

        ContactRequest::query()->create([
            'type' => $this->type,
            'name' => trim($validated['name']),
            'phone' => trim($validated['phone']),
            'email' => $this->type === 'message' && filled($validated['email'] ?? null)
                ? trim($validated['email'])
                : null,
            'message' => $this->type === 'message' ? trim($validated['message']) : null,
        ]);

        RateLimiter::hit($rateLimitKey, 60);

        $successMessage = $this->type === 'callback'
            ? 'Заявку прийнято! Менеджер зателефонує вам.'
            : 'Повідомлення надіслано! Ми скоро відповімо.';

        $this->resetForm();
        $this->dispatch('contact-submitted', message: $successMessage);
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'phone', 'email', 'message', 'website']);
        $this->resetValidation();
    }

    protected function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['message', 'callback'])],
            'name' => ['required', 'string', 'min:2', 'max:80'],
            'phone' => ['required', 'string', 'min:10', 'max:30', 'regex:/^[0-9+()\-\s]+$/'],
            'email' => $this->type === 'message'
                ? ['nullable', 'email:rfc', 'max:160']
                : ['nullable'],
            'message' => $this->type === 'message'
                ? ['required', 'string', 'min:5', 'max:1500']
                : ['nullable'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Вкажіть ваше ім’я.',
            'name.min' => 'Ім’я має містити щонайменше 2 символи.',
            'phone.required' => 'Вкажіть номер телефону.',
            'phone.min' => 'Перевірте номер телефону.',
            'phone.regex' => 'Використовуйте лише цифри та символи + ( ) -.',
            'email.email' => 'Вкажіть коректну електронну адресу.',
            'message.required' => 'Напишіть ваше запитання або повідомлення.',
            'message.min' => 'Повідомлення має містити щонайменше 5 символів.',
        ];
    }

    public function render()
    {
        return view('livewire.storefront.contact-form');
    }
}
