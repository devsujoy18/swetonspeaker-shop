<div class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 mobilemenu">
  <div class="w-80 max-w-full h-full bg-white shadow-lg p-4 mobilemenu__body overflow-y-auto">
    <div class="flex justify-between items-center border-b pb-3 mb-4 mobilemenu__header">
      <h2 class="text-lg font-semibold">Menu</h2>
      <button type="button" class="text-gray-600 hover:text-black text-2xl mobilemenu__close">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="mobilemenu__content">
      <ul class="space-y-2">
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Home</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">About</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Events</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Product</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Videos</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Blog</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Contact</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Application for Dealership</a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="pswp fixed inset-0 z-50 hidden" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="pswp__bg absolute inset-0 bg-black opacity-75"></div>
  <div class="pswp__scroll-wrap relative w-full h-full flex items-center justify-center">
    <div class="pswp__container flex w-full h-full overflow-hidden">
      <div class="pswp__item flex-1"></div>
      <div class="pswp__item flex-1"></div>
      <div class="pswp__item flex-1"></div>
    </div>
    <div class="pswp__ui absolute inset-0 hidden">
      <div class="pswp__top-bar flex justify-between items-center p-2">
        <div class="pswp__counter text-white"></div>
        <div class="flex space-x-2">
          <button class="pswp__button pswp__button--close text-white" title="Close (Esc)"></button>
          <button class="pswp__button pswp__button--fs text-white" title="Toggle fullscreen"></button>
          <button class="pswp__button pswp__button--zoom text-white" title="Zoom in/out"></button>
        </div>
      </div>
      <div class="pswp__preloader absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <div class="pswp__preloader__icn animate-spin">
          <div class="pswp__preloader__cut">
            <div class="pswp__preloader__donut border-4 border-t-transparent border-white rounded-full w-8 h-8"></div>
          </div>
        </div>
      </div>
      <button class="pswp__button pswp__button--arrow--left absolute left-0 top-1/2 transform -translate-y-1/2 text-white" title="Previous (arrow left)"></button>
      <button class="pswp__button pswp__button--arrow--right absolute right-0 top-1/2 transform -translate-y-1/2 text-white" title="Next (arrow right)"></button>
      <div class="pswp__caption absolute bottom-0 w-full text-center text-white">
        <div class="pswp__caption__center"></div>
      </div>
    </div>
  </div>
</div>

<div id="searchModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 hidden">
  <div id="modalContent" class="bg-white rounded-lg shadow-lg w-full max-w-3xl mx-3 px-6 py-6 relative opacity-0 scale-95 transition-all duration-300 ease-out">

    <!-- Close Button -->
    <button onclick="closeModal()" class="absolute top-1 right-1 text-gray-600 hover:text-black">
      <i class="fas fa-times text-xl"></i>
    </button>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('search.autocomplete', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3473579591-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
  </div>
</div><?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/components/frontend/external.blade.php ENDPATH**/ ?>