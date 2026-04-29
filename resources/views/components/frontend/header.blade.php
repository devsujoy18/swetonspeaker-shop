<header class="lg:hidden fixed top-0 left-0 right-0 z-50" x-data="{ open: false }">
  <div class="sticky top-0 z-50 shadow bg-black text-white">
    <div class="flex items-center justify-between px-4 py-4">
      <div class="flex items-center space-x-4">
        <button @click="open = true" class="text-white text-xl">
          <i class="fas fa-align-justify"></i>
        </button>
        <!-- Logo -->
        <a href="{{ route('home') }}">
          <img src="{{ asset('image/logonew1.png') }}" alt="Sweton Logo" class="w-[100px]">
        </a>
      </div>
      <!-- Icons -->
      <div class="flex items-center space-x-4">
        <a href="#" class="text-white text-xl" onclick="openModal()"><i class="fas fa-search"></i></a>

        {{--Cart Mobile Icon--}}
        <livewire:cart.mobile-icon-component/>

        <a href="{{ route('login') }}" class="text-white text-xl">
          <i class="far fa-user"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- Side Menu Overlay -->
  <div 
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black bg-opacity-60 z-40"
    @click="open = false"
  ></div>

  <!-- Side Menu Panel -->
  <div 
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 w-64 h-full bg-white z-50 shadow-lg"
  >
    <!-- Menu Header -->
    <div class="flex items-center justify-between px-4 py-3 border-b">
      <span class="font-bold text-lg">Menu</span>
      <button @click="open = false" class="text-black text-xl">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Menu Items -->
    <nav class="flex flex-col space-y-2 px-4 py-2 text-gray-800 text-base">
      <a href="{{ route('home') }}" class="py-2 border-b">Home</a>
      <a href="https://www.swetonspeakers.com/about-us" class="py-2 border-b">About</a>
      <a href="https://www.swetonspeakers.com/events-and-blogs" class="py-2 border-b">Events & Blog</a>
      <!-- Product with Dropdown -->
      <div x-data="{ openProduct: false }" class="border-b">
        <button @click="openProduct = !openProduct" class="flex items-center justify-between w-full py-2">
          <span>Product</span>
          <i :class="openProduct ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-sm"></i>
        </button>
        <div x-show="openProduct" x-transition class="pl-4 pb-2">
          @if($proCategories->isNotEmpty())
          <div x-data="{ openSub: false }" class="mt-2">
            <button @click="openSub = !openSub" class="flex items-center justify-between w-full py-1 text-sm">
              <span>Pro Loudspeakers</span>
              <i :class="openSub ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-xs"></i>
            </button>
            <div x-show="openSub" x-transition class="pl-4 pt-1">
              @foreach($proCategories as $category)
                  <a href="{{ route('category.products', ['pro-loudspeaker', $category->slug]) }}" class="block py-1 text-xs border-b">{{ $category->name }}</a>
              @endforeach
            </div>
          </div>
          @endif

          @if($homeCategories->isNotEmpty())
          <div x-data="{ openSub2: false }" class="mt-2">
            <button @click="openSub2 = !openSub2" class="flex items-center justify-between w-full py-1 text-sm">
              <span>Home Loudspeakers</span>
              <i :class="openSub2 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-xs"></i>
            </button>
            <div x-show="openSub2" x-transition class="pl-4 pt-1">
              @foreach($homeCategories as $category)
                <a href="{{ route('category.products', ['home-loudspeaker', $category->slug]) }}" class="block py-1 text-xs border-b">{{ $category->name }}</a>
              @endforeach
            </div>
          </div>
          @endif
        </div>
      </div>
      <a href="https://www.swetonspeakers.com/videos" class="py-2 border-b">Videos</a>
      
      <a href="https://www.swetonspeakers.com/contact-us" class="py-2 border-b">Contact</a>
      <a href="https://www.swetonspeakers.com/application-for-dealership" class="py-2 border-b">Application for Dealership</a>
    </nav>
  </div>
</header>