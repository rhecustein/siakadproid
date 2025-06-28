<div id="sidebar" class="bg-gray-900 text-white flex flex-col items-center py-4 space-y-6 hidden-mobile w-[70px]">
  {{-- Logo --}}
  <a href="{{ route('core.dashboard.index') }}" class="w-10 h-10">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain" />
  </a>

  {{-- Menu Utama --}}
  <nav class="flex flex-col items-center gap-6 mt-4 text-lg">
    <a href="{{ route('canteen.pos.index') }}" title="Transaksi" class="hover:text-blue-400 @if(Route::is('canteen.pos')) text-blue-500 @endif">
      🛒
    </a>
    <a href="{{ route('canteen.products.index') }}" title="Produk" class="hover:text-blue-400">
      📦
    </a>
    <a href="{{ route('canteen.stock-opnames.index') }}" title="Stok Opname" class="hover:text-blue-400">
      📊
    </a>
    <a href="{{ route('canteen.shopping-lists.index') }}" title="Belanja" class="hover:text-blue-400">
      🧾
    </a>
    <a href="{{ route('canteen.purchase-requests.index') }}" title="Request Wali" class="hover:text-blue-400">
      📝
    </a>
    <a href="{{ route('canteen.cash-shifts.index') }}" title="Shift Kasir" class="hover:text-blue-400">
      ⏱️
    </a>
  </nav>

  {{-- Logout --}}
  <div class="mt-auto">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" title="Logout" class="text-red-400 hover:text-red-600 text-lg">
        🚪
      </button>
    </form>
  </div>
</div>
