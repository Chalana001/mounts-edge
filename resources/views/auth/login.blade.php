<x-guest-layout>
    <main class="min-h-screen grid lg:grid-cols-[1.05fr_0.95fr]">
        <section class="relative hidden lg:flex overflow-hidden bg-brand-green p-12 text-brand-light">
            <div class="absolute inset-0 opacity-30" style="background: radial-gradient(circle at 20% 15%, #E67E22 0, transparent 28%), radial-gradient(circle at 85% 80%, #547069 0, transparent 35%);"></div>
            <div class="absolute inset-6 border border-brand-light/15"></div>

            <div class="relative z-10 flex w-full flex-col justify-between">
                <a href="/" class="font-serif text-2xl tracking-wide">Mounts Edge Regency</a>

                <div class="max-w-xl pb-12">
                    <span class="mb-6 block text-[10px] font-bold uppercase tracking-[0.35em] text-brand-light/60">Private Management Portal</span>
                    <h1 class="font-serif text-5xl font-normal leading-[1.08] xl:text-6xl">Where every stay<br>begins behind<br>the scenes.</h1>
                    <div class="mt-10 h-px w-20 bg-brand-orange"></div>
                </div>

                <p class="text-xs tracking-wider text-brand-light/50">Kandy, Sri Lanka</p>
            </div>
        </section>

        <section class="relative flex min-h-screen items-center justify-center px-6 py-16 sm:px-12">
            <a href="/" class="absolute left-6 top-7 font-serif text-xl tracking-wide lg:hidden">Mounts Edge Regency</a>

            <div class="w-full max-w-md">
                <div class="mb-10">
                    <span class="mb-4 block text-[10px] font-bold uppercase tracking-[0.3em] text-brand-orange">Administration</span>
                    <h2 class="font-serif text-4xl font-normal text-brand-green sm:text-5xl">Welcome back</h2>
                    <p class="mt-4 text-sm font-light leading-relaxed text-brand-green/60">Sign in to manage rooms, celebrations and gallery content.</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-brand-green/70">Email address</label>
                        <input id="email" class="block w-full border-0 border-b border-brand-green/25 bg-transparent px-0 py-3 text-sm shadow-none transition focus:border-brand-orange focus:ring-0" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-brand-green/70">Password</label>
                        <input id="password" class="block w-full border-0 border-b border-brand-green/25 bg-transparent px-0 py-3 text-sm shadow-none transition focus:border-brand-orange focus:ring-0" type="password" name="password" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between gap-4 pt-1">
                        <label for="remember_me" class="inline-flex items-center gap-2 text-xs text-brand-green/60">
                            <input id="remember_me" type="checkbox" class="rounded-sm border-brand-green/30 text-brand-orange focus:ring-brand-orange" name="remember">
                            <span>{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs text-brand-green/60 transition hover:text-brand-orange focus:outline-none" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="group mt-2 flex w-full items-center justify-between bg-brand-green px-6 py-4 text-[10px] font-bold uppercase tracking-[0.22em] text-brand-light transition hover:bg-brand-orange focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2">
                        <span>{{ __('Enter dashboard') }}</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14m-6-6 6 6-6 6" /></svg>
                    </button>
                </form>

                <p class="mt-10 text-center text-[10px] uppercase tracking-[0.16em] text-brand-green/35">Authorized personnel only</p>
            </div>
        </section>
    </main>
</x-guest-layout>
