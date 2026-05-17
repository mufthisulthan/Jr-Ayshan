<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

new class extends Component
{
    public string $username = '';
    public string $password = '';
    public bool $remember = false;
    public bool $showPassword = false;

    public function login()
    {
        $this->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->where('email', trim($this->username))
            ->orWhere('name', trim($this->username))
            ->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            $this->addError('login', 'Invalid username or password. Please try again.');
            $this->reset('password');
            return null;
        }

        session()->regenerate();
        session([
            'jr_user' => [
                'id' => $user->id,
                'username' => $user->email,
                'name' => $user->name,
                'role' => 'Administrator',
            ],
        ]);

        return $this->redirect('/dashboard', navigate: true);
    }
};

?>

<div class="login-card" role="region" aria-label="Login Form">
    <div class="login-card-header">
        <h1 class="login-title">Welcome Back</h1>
        <p class="login-subtitle">Login to your JR Marketing (Pvt) Ltd</p>
    </div>

    @error('login')
        <div class="alert alert-error" role="alert" aria-live="polite">
            <span class="alert-icon">&#9888;</span>
            <span>{{ $message }}</span>
        </div>
    @enderror

    <form wire:submit="login" autocomplete="off">
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <div class="input-icon-wrap">
                <input
                    type="text"
                    id="username"
                    wire:model="username"
                    class="form-control @error('username') is-error @enderror"
                    placeholder="Username"
                    autocomplete="username"
                    aria-required="true"
                    spellcheck="false"
                >
                <span class="input-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
            </div>
            @error('username') <span class="form-error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="password-wrap">
                <input
                    type="{{ $showPassword ? 'text' : 'password' }}"
                    id="password"
                    wire:model="password"
                    class="form-control @error('password') is-error @enderror"
                    placeholder="Password"
                    autocomplete="current-password"
                    aria-required="true"
                >
                <button type="button" class="password-toggle" wire:click="$toggle('showPassword')"
                        aria-label="Show password" title="Toggle password visibility">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        @if ($showPassword)
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        @else
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        @endif
                    </svg>
                </button>
            </div>
            @error('password') <span class="form-error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="login-forgot-row">
            <a href="{{ url('/forgot-password') }}" class="login-forgot-link">Forgot Your Password?</a>
        </div>

        <div class="login-remember-row">
            <label class="checkbox-wrap">
                <input type="checkbox" wire:model="remember">
                <span class="checkbox-label">Remember Me</span>
            </label>
        </div>

        <div class="login-btn-group">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span class="btn-text" wire:loading.remove>Login</span>
                <span class="btn-text" wire:loading>Login...</span>
                <div class="spinner" aria-hidden="true" wire:loading></div>
            </button>
        </div>
    </form>
</div>
