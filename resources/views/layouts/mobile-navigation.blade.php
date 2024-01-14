<nav x-data="{ open: false }" class="sm:hidden">
    <div class="flex items-center sm:hidden justify-center bg-blue-200 py-2">
        <button @click="open = !open"
            class="inline-flex items-center justify-center p-2 bg-blue-300 text-white
            rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 
            focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-10 w-10" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div :class="open ? 'block absolute w-full bg-blue-200' : 'hidden'" class="sm:hidden">
        <div class="flex flex-col pt-2 pb-3 space-y-1">

            @if (auth()->user()->is_admin)
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Overview') }}
                </x-nav-link>
            @else
                <x-nav-link :href="route('staff.show', auth()->user()->staff->staff_id)" :active="request()->routeIs('dashboard')">
                    {{ __('Overview') }}
                </x-nav-link>
            @endif


            @if (auth()->user()->is_admin)
                <x-nav-link :href="route('companies.show')" :active="request()->routeIs('companies.show')">
                    {{ __('Companies') }}
                </x-nav-link>

                <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
                    {{ __('Company Hours') }}
                </x-nav-link>

                <x-nav-link :href="route('staff.index')" :active="request()->routeIs('staff.index')">
                    {{ __('Staff Hours') }}
                </x-nav-link>
            @endif

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                {{ __('Profile') }}
            </x-nav-link>

            <form
                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium 
                    leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 
                    focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                method="POST" action="{{ route('logout') }}">
                @csrf
                <button>Log out</button>
            </form>

            {{-- <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form> --}}
        </div>

        <!-- Responsive Settings Options -->
        {{-- <div class="pt-4 pb-1 border-t border-gray-200">
            {{-- <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div> 

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div> --}}
    </div>
</nav>
