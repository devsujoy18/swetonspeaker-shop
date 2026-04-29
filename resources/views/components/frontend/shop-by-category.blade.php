<!-- Shop By Category Button -->
<div class="relative bg-red-700" style="width: 256px;">
    <input type="checkbox" id="toggleCategory" class="peer hidden">
    <label for="toggleCategory" class="flex items-center justify-between w-full px-4 py-3 bg-red-700 text-white font-semibold cursor-pointer transition duration-300 hover:bg-red-800">
        <div class="flex items-center gap-2">
            <i class="fas fa-align-justify"></i>Shop By Category
        </div>
        <i class="fas fa-angle-down transform transition-transform duration-300 peer-checked:rotate-180"></i>
    </label>
    <!-- Dropdown Menu (Visible when checkbox is checked) -->
    <div id="categoryDropdown" class="absolute left-0 w-64 bg-red-600 text-white font-semibold shadow-lg z-50 hidden peer-checked:block transition-all duration-300 ease-in-out">
        <ul class="divide-y divide-red-500">
            @if(isset($homeCategories) && $homeCategories->isNotEmpty())
                <li class="group relative">
                    <a href="#" class="flex justify-between items-center px-4 py-3 hover:bg-red-700 transition-colors duration-200 hover:text-white-800">
                        Home Loudspeakers <i class="fas fa-angle-right transition-transform duration-200 group-hover:translate-x-1"></i>
                    </a>
                    <div class="absolute top-0 left-full w-[1000px] bg-white text-black shadow-lg border border-gray-300 rounded-md hidden group-hover:grid grid-cols-4 gap-4 p-4 z-50">
                        @foreach($homeCategories as $category)
                            <div class="border border-red-600 rounded-sm bg-white">
                                <div class="bg-red-600 text-white font-bold text-[15px] px-3 py-2 border-b border-white rounded-t-sm">
                                    {{ $category->name }}
                                </div>
                                <ul class="text-sm text-gray-800 px-3 py-2 space-y-1">
                                    <li><a href="#" class="block hover:bg-gray-100 px-2 py-1 rounded">4" 20 WT WOOFER</a></li>
                                    <li><a href="#" class="block hover:bg-gray-100 px-2 py-1 rounded">6" 40 WT WOOFER</a></li>
                                    <li><a href="#" class="block hover:bg-gray-100 px-2 py-1 rounded">8" 100 WT WOOFER</a></li>
                                    <li><a href="#" class="block hover:bg-gray-100 px-2 py-1 rounded">10" 150 WT WOOFER</a></li>
                                    <li><a href="#" class="block hover:bg-gray-100 px-2 py-1 rounded">12" 200 WT WOOFER</a></li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>