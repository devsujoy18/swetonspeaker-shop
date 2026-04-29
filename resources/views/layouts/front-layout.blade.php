<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sweton Speaker') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i" />
    {{--<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
      [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
    <!-- Web Application Manifest -->
<link rel="manifest" href="{{ url('/manifest.json') }}">
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="#000000">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="application-name" content="PWA">
<link rel="icon" sizes="512x512" href="/images/icons/icon-512x512.png">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="PWA">
<link rel="apple-touch-icon" href="/images/icons/icon-512x512.png">


<link href="/images/icons/splash-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-750x1334.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1242x2208.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-828x1792.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1242x2688.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1536x2048.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1668x2224.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1668x2388.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-2048x2732.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/images/icons/icon-512x512.png">

<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>
</head>
<body>
    <div class="site">
        <x-frontend.header />
        <x-frontend.navbar />
        <div class="min-h-screen bg-white">
            {{ $slot }} 
        </div>
        <x-frontend.footer />
        
        <!--Install pwa button-->
        <button id="installPwaBtn" style="display: none;">
            <i class="fa fa-download"></i> Install App
        </button>
        
        <div id="ios-install-banner" class="ios-banner hidden">
            <div class="ios-banner-content">
                <div class="ios-banner-header">
                    <img src="/images/icons/icon-192x192.png" alt="App Icon" class="app-icon-mini">
                    <div class="text-group">
                        <span class="app-title">Install Sweton Speaker</span>
                        <span class="app-subtitle">Add to your home screen</span>
                    </div>
                    <button id="close-ios-banner" class="close-btn">&times;</button>
                </div>
                <div class="ios-banner-body">
                    <p>1. Tap the <strong>Share</strong> button <img src="https://img.icons8.com" class="inline-icon"> in the browser bar.</p>
                    <p>2. Scroll down and select <strong>"Add to Home Screen"</strong> <img src="https://img.icons8.com" class="inline-icon">.</p>
                </div>
            </div>
        </div>

        <style>
            #installPwaBtn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                padding: 8px 20px;
                border-radius: 10px;
                background: rgb(220, 38, 38);
                color: white;
                border: none;
                box-shadow: 0 3px 8px rgba(0,0,0,0.3);
                font-weight: 500;
            }
            @media (max-width: 768px) {
                #installPwaBtn {
                    bottom: 15px;
                    right: 15px;
                    font-size: 14px;
                    padding: 10px 16px;
                }
            }
        </style>
        <style>
            /* Global Install Button */
            #installPwaBtn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                padding: 12px 24px;
                border-radius: 50px;
                background: #dc2626; /* Your brand color */
                color: white;
                border: none;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                font-weight: 600;
            }
        
            /* iOS Instructions Banner */
            .ios-banner {
                position: fixed;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                width: 90%;
                max-width: 400px;
                background: #ffffff;
                border-radius: 18px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                z-index: 9999;
                padding: 16px;
                border: 1px solid #e5e7eb;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica;
            }
            .ios-banner.hidden { display: none; }
            .ios-banner-header { display: flex; align-items: center; margin-bottom: 12px; position: relative; }
            .app-icon-mini { width: 45px; height: 45px; border-radius: 10px; margin-right: 12px; }
            .app-title { display: block; font-weight: 700; color: #111; font-size: 16px; }
            .app-subtitle { display: block; font-size: 13px; color: #6b7280; }
            .close-btn { position: absolute; right: 0; top: 0; background: none; border: none; font-size: 24px; color: #9ca3af; cursor: pointer; }
            .ios-banner-body p { font-size: 14px; color: #374151; margin: 8px 0; display: flex; align-items: center; }
            .inline-icon { width: 20px; height: 20px; margin: 0 4px; vertical-align: middle; }
            
            /* Arrow pointing to Safari share button */
            .ios-banner::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                border-width: 10px 10px 0;
                border-style: solid;
                border-color: #ffffff transparent transparent;
            }
        </style>

    </div>
    <x-frontend.external />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @livewireScripts
    <script>
        // Toggle category dropdown
        document.getElementById('shopByCategoryBtn').addEventListener('click', function () {
            const dropdown = document.getElementById('categoryDropdown');
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            const btn = document.getElementById('shopByCategoryBtn');
            const dropdown = document.getElementById('categoryDropdown');
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    <script>
        function openModal() {
            const modal = document.getElementById("searchModal");
            const content = document.getElementById("modalContent");
            modal.classList.remove("hidden");
            setTimeout(() => {
            content.classList.remove("opacity-0", "scale-95");
            content.classList.add("opacity-100", "scale-100");
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById("searchModal");
            const content = document.getElementById("modalContent");
            content.classList.remove("opacity-100", "scale-100");
            content.classList.add("opacity-0", "scale-95");
            setTimeout(() => {
            modal.classList.add("hidden");
            }, 300);
        }

        // Optional: Close modal on clicking outside
        document.getElementById("searchModal").addEventListener("click", function (e) {
            if (e.target === this) {
            closeModal();
            }
        });
    </script>
    <script>
        document.getElementById("totop__button").addEventListener("click", function () {
            window.scrollTo({
            top: 0,
            behavior: "smooth"
            });
        });
    </script>
    <script>
        const cartButton = document.getElementById('cart-button');
        const cartDropdown = document.getElementById('cart-dropdown');

        cartButton.addEventListener('click', () => {
            cartDropdown.classList.toggle('hidden');
        });

        // Optional: click outside to close
        document.addEventListener('click', (event) => {
            if (!cartButton.contains(event.target) && !cartDropdown.contains(event.target)) {
              cartDropdown.classList.add('hidden');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.swiper', {
              slidesPerView: 1,
              spaceBetween: 10,
              navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
              },
              breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
              }
            });
        });
    </script>
    <script>
        // Select all tab buttons and tab panes
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        // Add a click event listener to each tab button
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Get the target pane's ID from the data-tab-target attribute
                const targetPaneId = button.dataset.tabTarget;
                const targetPane = document.querySelector(targetPaneId);

                // Deactivate all tab buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-white', 'text-red-700');
                    btn.classList.add('text-white', 'hover:bg-red-500');
                });

                // Deactivate all tab panes
                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                    pane.classList.add('hidden');
                });

                // Activate the clicked tab button
                button.classList.add('active', 'bg-red', 'text-red-700');
                button.classList.remove('text-white', 'hover:bg-red-500');

                // Activate the corresponding tab pane
                if (targetPane) {
                    targetPane.classList.add('active');
                    targetPane.classList.remove('hidden');
                }
            });
        });
    </script>
    
    <!--Install PWA Script-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const installBtn = document.getElementById('installPwaBtn');
            const iosBanner = document.getElementById('ios-install-banner');
            const closeIosBtn = document.getElementById('close-ios-banner');
            let deferredPrompt;
    
            // 1. Detection Functions
            const isIos = () => {
                const userAgent = window.navigator.userAgent.toLowerCase();
                // Detect iPhone, iPad, or iPod
                return /iphone|ipad|ipod/.test(userAgent);
            };
            
            const isStandalone = () => {
                // Check if the app is already running as an installed PWA
                return ('standalone' in window.navigator && window.navigator.standalone) 
                       || window.matchMedia('(display-mode: standalone)').matches;
            };
    
            // 2. iOS Logic
            // This will show EVERY TIME the page loads if it's an iPhone and not installed
            if (isIos() && !isStandalone()) {
                iosBanner.classList.remove('hidden');
            }
    
            // Close button just hides it for this specific page view
            closeIosBtn.onclick = () => {
                iosBanner.classList.add('hidden');
            };
    
            // 3. Android/Chrome Logic (beforeinstallprompt)
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                // Only show the Android button if we aren't on iOS
                if(!isIos()) {
                    installBtn.style.display = 'block';
                }
    
                installBtn.addEventListener('click', async () => {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        const { outcome } = await deferredPrompt.userChoice;
                        deferredPrompt = null;
                        installBtn.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script>
  function openModal() {
    const modal = document.getElementById("searchModal");
    const content = document.getElementById("modalContent");
    modal.classList.remove("hidden");
    setTimeout(() => {
      content.classList.remove("opacity-0", "scale-95");
      content.classList.add("opacity-100", "scale-100");
    }, 10);
  }

  function closeModal() {
    const modal = document.getElementById("searchModal");
    const content = document.getElementById("modalContent");
    content.classList.remove("opacity-100", "scale-100");
    content.classList.add("opacity-0", "scale-95");
    setTimeout(() => {
      modal.classList.add("hidden");
    }, 300);
  }

  // Optional: Close modal on clicking outside
  document.getElementById("searchModal").addEventListener("click", function (e) {
    if (e.target === this) {
      closeModal();
    }
  });

  function openCertiModal() {
    const modal = document.getElementById("certiModal");
    const content = document.getElementById("certiModalContent");
    modal.classList.remove("hidden");
    setTimeout(() => {
      modal.classList.remove("opacity-0");
      content.classList.remove("scale-95");
      content.classList.add("scale-100");
    }, 10);
  }

  function closeCertiModal() {
    const modal = document.getElementById("certiModal");
    const content = document.getElementById("certiModalContent");
    modal.classList.add("opacity-0");
    content.classList.remove("scale-100");
    content.classList.add("scale-95");
    setTimeout(() => {
      modal.classList.add("hidden");
    }, 300);
  }

  // Close Certificate Modal on clicking outside
  document.getElementById("certiModal").addEventListener("click", function (e) {
    if (e.target === this) {
      closeCertiModal();
    }
  });
</script>

</body>
</html>