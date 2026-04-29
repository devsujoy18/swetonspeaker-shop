<div>
    @if(count($proloudSpeakers) > 0)
        <div class="container mx-auto px-4 py-2">
            <h2 class="text-3xl font-bold mb-6">Pro Loudspeakers</h2>
            <div class="grid grid-cols-1 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                @foreach($proloudSpeakers as $category)
                    <div class="group bg-white border border-gray-300 shadow-sm rounded overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl hover:border-red-600">
                        <div class="bg-red-600 text-white text-center py-2 font-semibold text-sm">{{ $category->name }}</div>
                        <h4 class="text-center text-red-600 uppercase font-semibold px-3">Buy Online</h4>
                        <a href="{{ route('category.products', ['pro-loudspeaker', $category->slug]) }}">
                            @if($category->image)
                                <img src="{{ env('IMG_HOST') }}/uploads/thumbnails/{{ $category->image }}" class="w-full p-2" />
                            @else
                                <img src="{{ asset('images/buy.jpg') }}" class="w-full p-2" />  
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(count($homeloudSpeakers) > 0)
        <div class="container mx-auto px-4 py-2">
            <h2 class="text-3xl font-bold md:mb-6">Home Loudspeakers</h2>
            <div class="flex flex-wrap -mx-3">
                
                @foreach($homeloudSpeakers as $category)
                <div class="w-1/2 sm:w-1/2 md:w-1/4 px-3 mb-6">
                    <div class="group bg-white border border-gray-300 shadow-sm rounded overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl hover:border-red-600">
                        <div class="bg-red-600 text-white text-center py-2 font-semibold text-sm">{{ $category->name }}</div>
                        <h4 class="text-center text-red-600 uppercase font-semibold px-3">Buy Online</h4>
                        <a href="{{ route('category.products', ['home-loudspeaker', $category->slug]) }}">
                            @if($category->image)
                                <img src="{{ env('IMG_HOST') }}/uploads/thumbnails/{{ $category->image }}" class="w-full p-2" />
                            @else
                                <img src="{{ asset('images/buy.jpg') }}" class="w-full p-2" />  
                            @endif
                        </a>
                    </div>
                    </div>
                @endforeach
                
            </div>
        </div>
    @endif
</div>
