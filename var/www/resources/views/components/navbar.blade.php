<nav x-data="{ open: false }" class="bg-white border-b shadow px-4 py-3 flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <span class="text-xl font-bold text-gray-800">TaskFlow</span>
    </div>

    <!-- Menu desktop -->
    <ul class="hidden md:flex space-x-6">
        <li><a href="{{ route('boards.index' )}}" class="text-gray-700 hover:text-blue-600">Boards</a></li>
        <!-- Adicione mais links aqui -->
    </ul>


    <!-- Botão hamburguer para mobile -->
    <button @click="open = !open" class="md:hidden text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" class="absolute top-16 left-0 w-full bg-white shadow-md md:hidden z-50">
        <ul class="flex flex-col space-y-2 px-4 py-2">
            <li><a href="{{ route('boards.index' )}}" class="block text-gray-700 hover:text-blue-600">Boards</a></li>
            <!-- Outros links -->
        </ul>
    </div>
</nav>
