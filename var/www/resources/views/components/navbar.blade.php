@auth
    <nav x-data="{ open: false }" class="bg-white border-b shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center space-x-3">
                <span class="text-2xl font-bold text-blue-600">TaskFlow</span>
            </div>

            {{-- Menu Desktop --}}
            <ul class="hidden md:flex space-x-6 items-center">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('boards.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        Boards
                    </a>
                </li>
                <li>
                    <a class="text-red-600 hover:text-red-500 cursor-pointer font-medium"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" hidden>
                        @csrf
                    </form>
                </li>
            </ul>

            {{-- Botão hamburguer para mobile --}}
            <button @click="open = !open" class="md:hidden text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Menu Mobile --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden px-4 pb-4">
            <ul class="flex flex-col space-y-3">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="block text-gray-700 hover:text-blue-600 font-medium">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('boards.index') }}" class="block text-gray-700 hover:text-blue-600 font-medium">
                        Boards
                    </a>
                </li>
                <li>
                    <a class="text-red-600 hover:underline font-medium"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" hidden>
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
@endauth
