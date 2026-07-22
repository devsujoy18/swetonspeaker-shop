<?php

use App\Models\Productcombination;

test('product combination display name normalizes ohm symbols', function (string $name): void {
    expect((string) Productcombination::formattedName($name))->toBe('4 &ohm;');
})->with([
    'omega' => ["4 \u{03A9}"],
    'ohm sign' => ["4 \u{2126}"],
    'mojibake omega' => ["4 \u{00CE}\u{00A9}"],
    'mojibake ohm sign' => ["4 \u{00E2}\u{201E}\u{00A6}"],
]);
