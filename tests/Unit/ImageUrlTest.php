<?php

use App\Support\ImageUrl;
use Tests\TestCase;

uses(TestCase::class);

test('upload urls are built from configured image host', function (): void {
    config()->set('app.img_host', 'https://swetonspeakers.com/');

    expect(ImageUrl::upload('speakers/woofer.jpg'))
        ->toBe('https://swetonspeakers.com/uploads/speakers/woofer.jpg');
});

test('thumbnail urls are built without duplicate slashes', function (): void {
    config()->set('app.img_host', 'https://swetonspeakers.com/');

    expect(ImageUrl::thumbnail('/category.jpg'))
        ->toBe('https://swetonspeakers.com/uploads/thumbnails/category.jpg');
});

test('missing upload paths use the local placeholder', function (): void {
    expect(ImageUrl::upload(null))
        ->toBe(asset('image/buy.jpg'));
});
