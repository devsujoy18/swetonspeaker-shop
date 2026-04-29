<?php if (isset($component)) { $__componentOriginal9d41032d5dde91ab243771384dacb5df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d41032d5dde91ab243771384dacb5df = $attributes; } ?>
<?php $component = App\View\Components\FrontLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('front-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FrontLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-gray-100 py-2 border-b">
        <div class="container mx-auto px-4">
        <nav class="text-sm text-gray-600" aria-label="breadcrumb">
            <ol class="flex items-center space-x-2">
                <li class="text-black font-semibold">Home</li>
            </ol>
        </nav>
        </div>
    </div>
    <style>
        #myDIV {
    width: 100%;
    text-align: center;
    background: red;
    color: yellow;
    padding: 30px 15px;
    margin: 10px 0px;
    border-radius: 10px;
    animation: mymove 5s infinite;
}
@media(max-width:767px){
    #myDIV {
   
   padding: 10px 15px;
   margin: 0px 0px;
}
}
    </style>
    <div class="container mx-auto px-4 py-4 space-y-4">
       
        
      
            <div class="flex md:hidden gap-4 flex-row gap-6">

            <!-- Left Column: The two stacked text banners (Takes 75% width on desktop) -->
            <div class="flex flex-col gap-1 w-3/4">
                
                <!-- 1. Red Certificate Banner (Prominent Announcement) -->
                <div onclick="openCertiModal()" class="bg-red-600 text-white text-center cursor-pointer md:px-6 px-1 py-2 rounded-md text-xs md:text-sm flex-grow text-[11px] md:text-[14px]">
                    Octune Electronics LLP has received Certificate of Appreciation from The Government of India (Ministry of Finance).
                </div>
                
                <!-- 2. Black Attention Banner -->
                <!--<div class="bg-black text-white px-4 py-2 text-center rounded-md text-xs text-sm">-->
                <!--    <a href="<?php echo e(env('IMG_HOST')); ?>attention-manufacturers" class="px-3 py-1 rounded text-center">Attention Manufacturers</a>-->
                <!--</div>-->
                <div class="bg-black text-white px-4 py-2 text-center rounded-md text-xs text-sm">
                    <a href="https://www.swetonspeakers.com/attention-manufacturers" class="px-3 py-1 rounded text-center">Attention Manufacturers</a>
                </div>

            </div>

            <!-- Right Column: Delivery Image (Takes 25% width on desktop) -->
            <div class="w-1/4 flex justify-center items-center">
                <!-- Placeholder image mimicking the Blue Dart graphic -->
                <div>
                    <img src="<?php echo e(asset('image/bluedart1.jpg')); ?>" alt="Sweton Logo" class="w-[100px]">
                </div>
            </div>
        </div>
        
        
        
        
       
        
        
        
        
        
        
        <div class="bg-white flex justify-between items-center hidden md:flex" style="margin-top: 0;">
        <div class="bg-black text-white px-4 py-2 rounded-md font-semibold text-sm">
            <a href="<?php echo e(env('IMG_HOST')); ?>attention-manufacturers" class="px-3 py-1 rounded text-center">Attention Manufacturers</a>
        </div>
        <div onclick="openCertiModal()" class="bg-red-600 text-white cursor-pointer text-center px-6 py-2 rounded-md text-sm flex-grow mx-4">
            Octune Electronics LLP has received Certificate of Appreciation from The Government of India (Ministry of Finance).
        </div>
        <div class="bg-yellow-400 text-blue-800 font-extrabold rounded-md text-sm">
            <img src="<?php echo e(asset('image/bluedart1.jpg')); ?>" alt="Sweton Logo" class="w-[100px]">
        </div>
    </div>
     <?php
        $setting = \App\Models\SiteSetting::getSettings();
    ?>
        <div class="flex flex-col md:flex-row gap-4" style="margin-top: 10px;">
            <div id="myDIV" class="bg-black text-yellow-400 p-3 py-4 rounded w-full text-center font-medium">
                <?php echo nl2br(e($setting->home_message)); ?>

            </div>
           
        </div>
    </div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('category.home-component', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3389201725-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    
     <div class="container mx-auto px-4 py-4">
         <!-- Important Notice Section --><div class="bg-white shadow-md rounded-md md:p-8">
        <div class="bg-red-600 text-white px-4 py-2 text-md font-semibold mb-6 rounded-md">
            Important Notice
        </div>

        <ul class="list-none space-y-4 text-gray-700 text-sm">
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                We don't despatch on C.O.D. basis. Only after receipt of payment ordered speakers are sent.
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                Please note that from 16.10.2025, we have commenced despatch through Blue Dart Courier to serve you better, in case your address is not serviceable by Blue Dart Courier, we may send your ordered materials through Delhivery Courier.
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                Despatch will normally be done through the Blue Dart courier within the next working day from the date of booking of the Order. In case the order is placed after Saturday afternoon / Sunday or on holidays, it will be normally despatched on next working day.
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                Blue Dart Courier normally delivers the materials within 7-10 days from the date of despatch. But in some rare cases it may take upto 15 days.
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                ONLY after the ordered speakers are delivered to Blue Dart Courier, you will receive the message by SMS & in your registered mail ID given by you at the time of booking of order. Customers are requested to check the messages before making any phone call.
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                In the unlikely event of manufacturing fault, the Company will take remedial measures; provided we are informed within next day of receipt of consignment.
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                The price mentioned in the shopping site includes the Cost of Speaker, taxes & Courier charges.
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                All the required informations and specifications are given in the website, no further informations and specification will be shared later on.
            </li>
        </ul>
    </div>
    </div>
  </div>
  
  <!-- Certificate Modal -->
<div id="certiModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/75 hidden opacity-0 transition-opacity duration-300">
  <div class="relative w-full max-w-4xl mx-4 shadow-2xl scale-95 transition-transform duration-300" id="certiModalContent">
    <button onclick="closeCertiModal()" class="absolute -top-3 -right-3 z-10 bg-white text-black font-bold rounded-full w-8 h-8 flex items-center justify-center shadow-lg hover:bg-gray-200 focus:outline-none">
      <i class="fas fa-times text-sm"></i>
    </button>
    <div class="bg-white flex flex-col">
      <div class="bg-red-600 text-white text-xl font-bold py-3 px-5">
        Certificate of Appreciation
      </div>
      <div class="p-3 sm:p-5 flex justify-center items-center bg-white">
        <img src="<?php echo e(asset('image/certi.jpg')); ?>" alt="Certificate of Appreciation" class="w-full h-auto max-h-[80vh] object-contain">
      </div>
    </div>
  </div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $attributes = $__attributesOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__attributesOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d41032d5dde91ab243771384dacb5df)): ?>
<?php $component = $__componentOriginal9d41032d5dde91ab243771384dacb5df; ?>
<?php unset($__componentOriginal9d41032d5dde91ab243771384dacb5df); ?>
<?php endif; ?><?php /**PATH /home/ace85084/public_html/shop/resources/views/home.blade.php ENDPATH**/ ?>