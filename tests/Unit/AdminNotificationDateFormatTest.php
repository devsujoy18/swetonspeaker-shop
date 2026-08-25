<?php

use Carbon\Carbon;

it('formats notification dates as an absolute date and time', function () {
    $createdAt = Carbon::create(2026, 8, 25, 18, 27);

    expect($createdAt->format('d F, Y h:i A'))
        ->toBe('25 August, 2026 06:27 PM');

    $notificationListView = file_get_contents(
        dirname(__DIR__, 2).'/resources/views/admin/notifications/index.blade.php'
    );

    expect($notificationListView)
        ->toContain('$notification->created_at->format(\'d F, Y h:i A\')')
        ->not->toContain('$notification->created_at->diffForHumans()');
});
