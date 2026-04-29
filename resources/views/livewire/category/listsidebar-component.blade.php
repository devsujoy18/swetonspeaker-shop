<aside class="w-full lg:w-1/4 hidden md:block">
    <div class="bg-white shadow rounded-lg">
        <div class="border-b p-4 flex justify-between items-center">
            <h2 class="font-semibold">Categories</h2>
        </div>
        <div class="p-4">
            {{-- Pro Loudspeakers Section --}}
            @if($proloudSpeakers->isNotEmpty())
            <div class="mb-4">
                <button class="w-full flex justify-between items-center text-left font-medium text-gray-700 hover:text-blue-600" onclick="toggleSubMenu('proLoudspeakersMenu')">
                    Pro Loudspeakers <i class="fas fa-angle-down"></i>
                </button>
                <ul class="ml-4 mt-2 space-y-1 {{ $proloudSpeakers->pluck('slug')->contains($currentCategorySlug) || $typeSlug === 'pro-loudspeaker' ? '' : 'hidden' }}" id="proLoudspeakersMenu">
                    @foreach($proloudSpeakers as $proCategory)
                    <li>
                        <a href="{{ route('category.products', ['pro-loudspeaker', $proCategory->slug]) }}" 
                            class="text-gray-600 hover:underline {{ $proCategory->slug === $currentCategorySlug ? 'text-red-600 font-bold' : '' }}">
                            {{ $proCategory->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Home Loudspeakers Section --}}
            @if($homeloudSpeakers->isNotEmpty())
            <div class="mb-4">
                <button class="w-full flex justify-between items-center text-left font-medium text-gray-700 hover:text-blue-600" onclick="toggleSubMenu('homeLoudspeakersMenu')">
                    Home Loudspeakers <i class="fas fa-angle-down"></i>
                </button>
                <ul class="ml-4 mt-2 space-y-1 {{ $homeloudSpeakers->pluck('slug')->contains($currentCategorySlug) || $typeSlug === 'home-loudspeaker' ? '' : 'hidden' }}" id="homeLoudspeakersMenu">
                    @foreach($homeloudSpeakers as $homeCategory)
                    <li>
                        <a href="{{ route('category.products', ['home-loudspeaker', $homeCategory->slug]) }}" 
                            class="text-gray-600 hover:underline {{ $homeCategory->slug === $currentCategorySlug ? 'text-red-600 font-bold' : '' }}">
                            {{ $homeCategory->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    <script>
        function toggleSubMenu(menuId) {
            const menu = document.getElementById(menuId);
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        // Auto-open current category's submenu on page load
        document.addEventListener('livewire:initialized', () => {
            const currentCategoryLink = document.querySelector('.left-sidebar a.text-red-600');
            if (currentCategoryLink) {
                let parentUl = currentCategoryLink.closest('ul');
                if (parentUl && parentUl.id && (parentUl.id === 'homeLoudspeakersMenu' || parentUl.id === 'proLoudspeakersMenu')) {
                    parentUl.classList.remove('hidden');
                }
            }
        });
    </script>
</aside>
