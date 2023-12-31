<nav x-data="{ open: false }" class="h-screen hidden sm:flex">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <div class="flex flex-col">
                <!-- Logo -->
                <div class="shrink-0 flex items-center justify-center py-3">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex flex-col space-y-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Overview') }}
                    </x-nav-link>

                    @if (auth()->user()->is_admin)
                        <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
                            {{ __('Company Hours') }}
                        </x-nav-link>

                        <x-nav-link :href="route('staff.index')" :active="request()->routeIs('staff.index')">
                            {{ __('Staff') }}
                        </x-nav-link>

                        <x-nav-link :href="route('companies.show')" :active="request()->routeIs('companies.show')">
                            {{ __('Companies') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    {{-- <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden"> --}}
</nav>
