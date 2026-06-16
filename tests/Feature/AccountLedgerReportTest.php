<?php

use App\Http\Requests\AccountLedgerRequest;
use App\Models\Order;
use Illuminate\Validation\ValidationException;

test('refund calculations keep the retained amount clear', function (): void {
    $refundedOrder = new Order([
        'total' => 1200,
        'refunded_amount' => 200,
        'payment_status' => 'refunded',
        'order_status' => 'cancelled',
    ]);

    expect($refundedOrder->refundableAmountRemaining())->toBe(1000.0);
    expect($refundedOrder->netAmount())->toBe(1000.0);
});

test('account ledger request rejects a reversed date range', function (): void {
    $request = AccountLedgerRequest::create('/admin/orders/account-ledger', 'GET', [
        'from_date' => '2099-06-30',
        'to_date' => '2099-06-01',
    ]);

    $request->setContainer(app());
    $request->setRedirector(app('redirect'));

    expect(function () use ($request): void {
        $request->validateResolved();
    })
        ->toThrow(ValidationException::class);
});
