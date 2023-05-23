<x-guest-layout>

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

                                    <form method="post" action="{{ route('register') }}">
                                        @csrf

                                        <!-- Name -->
                                        <div class="form-outline mb-4">
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input
                                                id="name"
                                                class="form-control"
                                                type="text"
                                                name="name"
                                                :value="old('name')"
                                                required
                                                autofocus
                                                autocomplete="name"
                                            />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>

                                        <!-- Email Address -->
                                        <div class="form-outline mb-4">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input
                                                id="email"
                                                class="form-control"
                                                type="email"
                                                name="email"
                                                :value="old('email')"
                                                required
                                                autocomplete="username"
                                            />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <!-- Password -->
                                        <div class="form-outline mb-4">
                                            <x-input-label for="password" :value="__('Password')" />
                                            <x-text-input id="password"
                                                          class="form-control"
                                                          type="password"
                                                          name="password"
                                                          required
                                                          autocomplete="new-password"
                                            />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="form-outline mb-4">
                                            <x-input-label
                                                for="password_confirmation"
                                                :value="__('Confirm Password')"
                                            />
                                            <x-text-input id="password_confirmation"
                                                          class="form-control"
                                                          type="password"
                                                          name="password_confirmation"
                                                          required
                                                          autocomplete="new-password"
                                            />
                                            <x-input-error :messages="$errors->get('password_confirmation')"
                                                           class="mt-2"
                                            />
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button
                                                class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3 me-4 px-5"
                                                type="submit"
                                            >{{ __('Register') }}</button>

                                            <a class="text-muted" href="{{ route('login') }}">
                                                {{ __('Already registered?') }}
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
