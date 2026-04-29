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
    
     <!-- ====== 404 PAGE STYLES ====== -->
        <style>
            /* ---------- Reset & base ---------- */
            .err-page {
                font-family: 'Roboto', sans-serif;
                background: #f8f8f8;
                min-height: 70vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 60px 20px;
                overflow: hidden;
                position: relative;
            }

            /* Soft diagonal red stripe in background */
            .err-page::before {
                content: '';
                position: absolute;
                top: -80px;
                right: -120px;
                width: 520px;
                height: 520px;
                background: radial-gradient(circle, rgba(220,38,38,0.12) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
            }
            .err-page::after {
                content: '';
                position: absolute;
                bottom: -80px;
                left: -120px;
                width: 420px;
                height: 420px;
                background: radial-gradient(circle, rgba(220,38,38,0.08) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
            }

            /* ---------- Card ---------- */
            .err-card {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.10), 0 4px 16px rgba(220,38,38,0.08);
                max-width: 680px;
                width: 100%;
                text-align: center;
                padding: 60px 40px 50px;
                position: relative;
                z-index: 1;
                border-top: 5px solid #dc2626;
                animation: err-fadein 0.7s ease both;
            }
            @keyframes err-fadein {
                from { opacity: 0; transform: translateY(30px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* ---------- Big 404 ---------- */
            .err-number {
                font-size: clamp(90px, 18vw, 160px);
                font-weight: 700;
                line-height: 1;
                color: #dc2626;
                letter-spacing: -4px;
                position: relative;
                display: inline-block;
                text-shadow: 0 4px 18px rgba(220,38,38,0.18);
                animation: err-pulse 2.5s ease-in-out infinite;
            }
            @keyframes err-pulse {
                0%, 100% { text-shadow: 0 4px 18px rgba(220,38,38,0.18); }
                50%       { text-shadow: 0 4px 40px rgba(220,38,38,0.45); }
            }

            /* decorative underline bar */
            .err-number::after {
                content: '';
                display: block;
                width: 70px;
                height: 4px;
                background: #111;
                border-radius: 2px;
                margin: 10px auto 0;
            }

            /* ---------- Sound-wave SVG ---------- */
            .err-wave {
                margin: 18px auto 28px;
                display: flex;
                align-items: flex-end;
                justify-content: center;
                gap: 5px;
                height: 40px;
            }
            .err-wave span {
                display: inline-block;
                width: 6px;
                border-radius: 3px;
                background: #dc2626;
                animation: err-wave-anim 1s ease-in-out infinite;
            }
            .err-wave span:nth-child(1)  { height: 14px; animation-delay: 0s; }
            .err-wave span:nth-child(2)  { height: 26px; animation-delay: .1s; }
            .err-wave span:nth-child(3)  { height: 36px; animation-delay: .2s; }
            .err-wave span:nth-child(4)  { height: 24px; animation-delay: .3s; }
            .err-wave span:nth-child(5)  { height: 40px; animation-delay: .4s; }
            .err-wave span:nth-child(6)  { height: 24px; animation-delay: .3s; }
            .err-wave span:nth-child(7)  { height: 36px; animation-delay: .2s; }
            .err-wave span:nth-child(8)  { height: 26px; animation-delay: .1s; }
            .err-wave span:nth-child(9)  { height: 14px; animation-delay: 0s; }
            @keyframes err-wave-anim {
                0%, 100% { transform: scaleY(1);   opacity: 1; }
                50%       { transform: scaleY(0.3); opacity: 0.5; }
            }

            /* ---------- Badge ---------- */
            .err-badge {
                display: inline-block;
                background: #111;
                color: #fff;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 3px;
                text-transform: uppercase;
                padding: 5px 14px;
                border-radius: 30px;
                margin-bottom: 18px;
            }

            /* ---------- Text ---------- */
            .err-title {
                font-size: clamp(22px, 5vw, 32px);
                font-weight: 700;
                color: #111;
                margin: 0 0 12px;
            }
            .err-desc {
                color: #666;
                font-size: 16px;
                line-height: 1.6;
                margin: 0 auto 32px;
                max-width: 440px;
            }

            /* ---------- Buttons ---------- */
            .err-actions {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 14px;
                flex-wrap: wrap;
            }
            .err-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 13px 30px;
                border-radius: 8px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                transition: transform 0.18s, box-shadow 0.18s, background 0.18s;
                border: none;
            }
            .err-btn-primary {
                background: #dc2626;
                color: #fff;
                box-shadow: 0 4px 16px rgba(220,38,38,0.30);
            }
            .err-btn-primary:hover {
                background: #b91c1c;
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(220,38,38,0.40);
                color: #fff;
            }
            .err-btn-outline {
                background: transparent;
                color: #111;
                border: 2px solid #111;
            }
            .err-btn-outline:hover {
                background: #111;
                color: #fff;
                transform: translateY(-2px);
            }

            /* ---------- Divider ---------- */
            .err-divider {
                border: none;
                border-top: 1px solid #e5e7eb;
                margin: 38px 0 24px;
            }

            /* ---------- Quick links row ---------- */
            .err-links {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                flex-wrap: wrap;
            }
            .err-links span {
                color: #888;
                font-size: 13px;
            }
            .err-links a {
                font-size: 13px;
                color: #dc2626;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.15s;
            }
            .err-links a:hover {
                color: #b91c1c;
                text-decoration: underline;
            }
            .err-links .sep { color: #ccc; }

            /* ---------- Mobile ---------- */
            @media (max-width: 500px) {
                .err-card { padding: 40px 22px 36px; }
                .err-actions { flex-direction: column; }
                .err-btn { width: 100%; justify-content: center; }
                
                .err-page {
    min-height: auto;
    padding: 34px 20px;

}
.min-h-screen {
    min-height: 86vh;
}
            }
        </style>
	<div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="<?php echo e(route('home')); ?>" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">404 Error</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="container mx-auto px-4">
         <!-- ====== 404 SECTION ====== -->
        <section class="err-page" aria-label="404 Error Page">
            <div class="err-card">

                <!-- Brand badge -->
                <div class="err-badge">Sweton Speakers</div>

                <!-- Big 404 -->
                <div class="err-number" aria-hidden="true">404</div>

                <!-- Animated sound-wave (brand touch) -->
                <div class="err-wave" aria-hidden="true">
                    <span></span><span></span><span></span>
                    <span></span><span></span><span></span>
                    <span></span><span></span><span></span>
                </div>

                <!-- Headline -->
                <h1 class="err-title">Oops! Page Not Found</h1>
                <p class="err-desc">
                    The page you're looking for has been moved, deleted, or never existed.
                    Let's get you back on track.
                </p>

                <!-- CTA buttons -->
                <div class="err-actions">
                    <a href="<?php echo e(url('/')); ?>" class="err-btn err-btn-primary" id="err-home-btn">
                        <i class="fas fa-home"></i> Go to Homepage
                    </a>
                   
                </div>

                <!-- Divider -->
                <hr class="err-divider">

                <!-- Quick links -->
                <div class="err-links">
                    <span>Quick links:</span>
                    
                    <span class="sep">·</span>
                    <a href="https://shop.swetonspeakers.com/home-loudspeaker/woofer-series">Woofer</a>
                    <span class="sep">·</span>
                    <a href="https://shop.swetonspeakers.com/home-loudspeaker/subwoofer-series">Subwoofer</a>
                    <span class="sep">·</span>
                    <a href="https://shop.swetonspeakers.com/home-loudspeaker/full-range-speaker-series">Full Range Speakers</a>
                    <span class="sep">·</span>
                    <a href="https://shop.swetonspeakers.com/home-loudspeaker/tweeter-series">Tweeter</a>
                     <span class="sep">·</span>
                    <a href="https://shop.swetonspeakers.com/home-loudspeaker/dividing-cross-over-network">Dividing Cross Over Network</a>
                     <span class="sep">·</span>
                    <a href="https://shop.swetonspeakers.com/home-loudspeaker/satellite-series">Satellite</a>
                </div>

            </div>
        </section>
        <!--<div style="text-align:center; padding:50px;">-->
        <!--    <h1 style="font-size:80px;">404</h1>-->
        <!--    <h2>Oops! Page Not Found</h2>-->
        <!--    <p>The page you are looking for doesn't exist.</p>-->
        
        <!--    <a href="<?php echo e(url('/')); ?>" style="padding:10px 20px; background:#3490dc; color:#fff; text-decoration:none;">-->
        <!--        Go Home-->
        <!--    </a>-->
        <!--</div>-->
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
<?php endif; ?><?php /**PATH /home/ace85084/public_html/shop.swetonspeakers.com/resources/views/errors/404.blade.php ENDPATH**/ ?>