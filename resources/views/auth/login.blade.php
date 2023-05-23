<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-6">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <h4 class="mt-1 mb-5 pb-1">Salary Parser</h4>
                                    </div>

                                    <form method="post" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-outline mb-4">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input
                                                id="email"
                                                class="form-control"
                                                type="email"
                                                name="email"
                                                :value="old('email')"
                                                required
                                                autofocus
                                                autocomplete="username"
                                            />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>


                                        <div class="form-outline mb-4">
                                            <x-input-label for="password" :value="__('Password')" />
                                            <x-text-input id="password"
                                                          class="form-control"
                                                          type="password"
                                                          name="password"
                                                          required
                                                          autocomplete="current-password"
                                            />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <div class="pt-1 mb-2 pb-1">
                                            <label
                                                for="remember_me"
                                                class="form-check-label"
                                            >
                                                <input
                                                    id="remember_me"
                                                    type="checkbox"
                                                    class="form-check-input me-2"
                                                    name="remember"
                                                >
                                                <span class="ml-2 text-sm text-gray-600">
                                                    {{ __('Remember me') }}
                                                </span>
                                            </label>
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button
                                                class="btn btn-primary btn-block fa-lg gradient-custom-2
                                                mb-3 me-4 px-5"
                                                type="submit"
                                            >Login</button>

                                            @if (Route::has('password.request'))
                                                <a class="text-muted" href="{{ route('password.request') }}">
                                                    Forgot password?
                                                </a>
                                            @endif
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Don't have an account?</p>
                                            <a href="{{ route('register') }}" class="btn btn-outline-danger">
                                                Create new
                                            </a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
