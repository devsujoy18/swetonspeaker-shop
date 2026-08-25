<?php

it('always renders stored shipping details in the order view', function (string $view): void {
    $viewContents = file_get_contents(
        dirname(__DIR__, 2).'/resources/views/orders/'.$view
    );

    expect($viewContents)
        ->not->toContain('$order->shipping_same_as_billing')
        ->toContain('$order->shipping_name')
        ->toContain('$order->shipping_email')
        ->toContain('$order->shipping_phone')
        ->toContain('$order->shipping_street')
        ->toContain('$order->shipping_locality')
        ->toContain('$order->shipping_city')
        ->toContain('$order->shipping_state')
        ->toContain('$order->shipping_zip')
        ->toContain('$order->shipping_landmark');
})->with([
    'customer order details' => 'show.blade.php',
    'admin order details' => 'show_details.blade.php',
]);
