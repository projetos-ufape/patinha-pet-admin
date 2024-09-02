<div id="sidebar" class="shadow-lg border-gray-200 p-4 hidden transition-opacity opacity-0" style="background: var(--Container, #F2F6F7); width: 250px;">
    <ul class="space-y-6">

        @if(auth()->user()->hasPermissionTo('manage customers'))
        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('customers.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/sidebar/customer.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Clientes</span>
            </a>
        </li>
        @endcan

        @if(auth()->user()->hasPermissionTo('manage products'))
        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/sidebar/products.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Produtos</span>
            </a>
        </li>

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('stocks.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/sidebar/stock.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Estoque</span>
            </a>
        </li>
        
        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('comercial.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/sidebar/comercial.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Comercial</span>
            </a>
        </li>  

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('employees.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/sidebar/employees.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Funcionários</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasPermissionTo('manage services'))
        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/sidebar/services.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Serviços</span>
            </a>
        </li>
        @endif
    </ul>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        setTimeout(() => {
            sidebar.classList.toggle('opacity-0');
        }, 20);
    });
</script>