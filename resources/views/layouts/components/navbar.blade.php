<nav style="background: var(--Container, #F2F6F7); border-bottom: 1px solid var(--Outlines, #BCC9CE);">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <div class="hover:bg-gray-200 flex items-center rounded-lg">
                <button id="menu-button" class=" focus:outline-none">
                    <img src="{{ asset('icons/sidemenu.svg') }}" alt="Menu Icon" class="h-4 w-4">
                </button>
            </div>

            <div class="hover:bg-gray-200 flex items-center p-1 rounded-lg">
                <button class="focus:outline-none flex items-center">
                    <img src="{{ asset('icons/profile.svg') }}" alt="Profile Icon" class="h-5 w-5">
                    <img src="{{ asset('icons/downarrow.svg') }}" alt="Down Arrow Icon" class="h-3 w-3 ml-2">
                </button>

                <div class="relative">
                    <div id="profile-dropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                            @csrf
                            <button type="submit" class="w-full text-left">Sair</button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</nav>
<script>
    const profileButton = document.querySelector('.hover\\:bg-gray-200.flex.items-center.p-1.rounded-lg button');
    const dropdownMenu = document.getElementById('profile-dropdown');

    profileButton.addEventListener('click', (event) => {
        dropdownMenu.classList.toggle('hidden');
        event.stopPropagation();
    });

    window.addEventListener('click', () => {
        if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
