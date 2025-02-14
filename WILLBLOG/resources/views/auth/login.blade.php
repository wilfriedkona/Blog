<x-guest-layout>
    
    <x-auth-session-status class="status-message" :status="session('status')" />

    <div>
        <h1>Connectez vous</h1>
    </div>

    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf
     
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="error-message" />
        </div>

       
        <div class="form-group">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="error-message" />
        </div>

       
        <div class="form-group remember-me">
            <label for="remember_me" class="checkbox-label">
                <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
                <span class="checkbox-text">{{ __('Remember me') }}</span>
            </label>
        </div>


        <div class="form-actions">
            @if (Route::has('password.request'))
                <a class="forgot-password-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            
            <x-primary-button class="submit-button">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>