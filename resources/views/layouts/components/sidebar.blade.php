<div id="sidebar" class="shadow-lg border-gray-200 p-4 hidden transition-opacity opacity-0" style="background: var(--Container, #F2F6F7);  width: 250px ;">
    <ul class="space-y-6">

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <img src="{{ asset('icons/sidebar/customer.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
            <a href="{{ route('customers.index') }}" class="text-gray-700 hover:text-gray-900 block ml-2">Clientes</a>
        </li>

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <img src="{{ asset('icons/sidebar/pets.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
            <a href="{{ route('pets.index') }}" class="text-gray-700 hover:text-gray-900 block ml-2">Pets</a>
        </li>

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <img src="{{ asset('icons/sidebar/products.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
            <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-gray-900 block ml-2">Produtos</a>
        </li>

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <img src="{{ asset('icons/sidebar/stock.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
            <a href="{{ route('stocks.index') }}" class="text-gray-700 hover:text-gray-900 block ml-2">Estoque</a>
        </li>        

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <img src="{{ asset('icons/sidebar/employees.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
            <a href="{{ route('employees.index') }}" class="text-gray-700 hover:text-gray-900 block ml-2">Funcionários</a>
        </li>

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <img src="{{ asset('icons/sidebar/services.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
            <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-gray-900 block ml-2">Serviços</a>
        </li>
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