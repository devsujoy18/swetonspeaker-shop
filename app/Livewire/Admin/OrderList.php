<?php

namespace App\Livewire\Admin;

use App\Mail\OrderDispatchedMail;
use App\Mail\OrderModifiedMail;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderReviewMail;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Services\WatiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public $search = '';

    public $orderStatus = '';

    public $paymentStatus = '';

    public $dateFrom = '';

    public $dateTo = '';

    public $perPage = 10;

    public $expandedOrderId = null;

    public $awbModalOpen = false;

    public $awbPartner = null;

    public $awbRefNo = null;

    public $selectedOrderId = null;

    public $orderSlNoModalOpen = false;

    public $selectedOrderSlNoId = null;

    public $orderSlNo = null;

    public $selectedRefundOrderId = null;

    public $selectedRefundOrder = null;

    public $refundAmount = null;

    public $refundModalOpen = false;

    public $deliveryPartner = '';

    public $isModified = '';

    public $userSearch = '';

    public function resetFilters()
    {
        $this->search = '';
        $this->orderStatus = '';
        $this->paymentStatus = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->isModified = '';
        $this->userSearch = '';
        $this->resetPage();
    }

    public function openAwbModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $order = Order::find($orderId);
        $this->awbPartner = $order->awb_partner;
        $this->awbRefNo = $order->awb_number;
        $this->awbModalOpen = true;
    }

    public function saveAwb()
    {
        $this->validate([
            'awbPartner' => 'required|string',
            'awbRefNo' => 'nullable|string',  // optional
        ], [
            'awbPartner.required' => 'Please select a shipping partner.',
        ]);

        $order = Order::find($this->selectedOrderId);

        $order->awb_partner = $this->awbPartner;
        $order->awb_number = $this->awbRefNo ?? null;
        $order->save();

        if (! empty($order->awb_number)) {
            try {
                Mail::to($order->billing_email)
                    ->send(new OrderDispatchedMail($order));
            } catch (\Throwable $e) {
                \Log::error('AWB email failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Send WhatsApp notification
            try {
                $watiService = new WatiService;

                if ($order->awb_partner == 'Delhivery') {
                    $watiService->sendTemplateMessage(
                        mobile: $order->billing_phone,
                        templateName: 'send_awb_delhivery',
                        parameters: [
                            ['name' => 'unique_order_id', 'value' => $order->order_number],
                            ['name' => 'awb_number', 'value' => $order->awb_number],
                        ],
                        broadcastName: 'send_awb_no'
                    );
                } elseif ($order->awb_partner == 'Bluedart') {
                    $watiService->sendTemplateMessage(
                        mobile: $order->billing_phone,
                        templateName: 'send_waybill_bluedart',
                        parameters: [
                            ['name' => 'unique_order_id', 'value' => $order->order_number],
                            ['name' => 'waybill_number', 'value' => $order->awb_number],
                        ],
                        broadcastName: 'send_waybill_no'
                    );
                }

            } catch (\Throwable $e) {
                \Log::error('WhatsApp notification failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // $this->dispatch('notify', message: 'AWB updated successfully!');
        $this->dispatch('notify', [
            'message' => 'AWB updated successfully!',
        ]);
        $this->awbModalOpen = false;
    }

    public function openOrderSlNoModal($orderId)
    {
        $order = Order::find($orderId);

        if (! $order) {
            $this->dispatch('notify', [
                'message' => 'Order not found.',
            ]);

            return;
        }

        if ($order->payment_status !== 'success') {
            $this->dispatch('notify', [
                'message' => 'Order SL No can be updated only for successful payments.',
            ]);

            return;
        }

        $this->selectedOrderSlNoId = $order->id;
        $this->orderSlNo = $order->order_sl_no;
        $this->resetErrorBag('orderSlNo');
        $this->orderSlNoModalOpen = true;
    }

    public function saveOrderSlNo()
    {
        $this->validate([
            'orderSlNo' => 'required|integer|min:1',
        ]);

        $order = Order::find($this->selectedOrderSlNoId);

        if (! $order) {
            $this->dispatch('notify', [
                'message' => 'Order not found.',
            ]);
            $this->orderSlNoModalOpen = false;

            return;
        }

        if ($order->payment_status !== 'success') {
            $this->dispatch('notify', [
                'message' => 'Order SL No can be updated only for successful payments.',
            ]);

            return;
        }

        $date = Carbon::parse($order->created_at)->toDateString();

        $serialAlreadyUsed = Order::whereDate('created_at', $date)
            ->where('payment_status', 'success')
            ->where('id', '!=', $order->id)
            ->where('order_sl_no', $this->orderSlNo)
            ->exists();

        if ($serialAlreadyUsed) {
            $this->addError('orderSlNo', 'This SL No is already used for a successful order on the same date.');

            return;
        }

        $order->update([
            'order_sl_no' => (int) $this->orderSlNo,
        ]);

        $this->dispatch('notify', [
            'message' => 'Order SL No updated successfully!',
        ]);

        $this->orderSlNoModalOpen = false;
    }

    public function openRefundModal($orderId)
    {
        $order = Order::find($orderId);

        if (! $order) {
            $this->dispatch('notify', [
                'message' => 'Order not found.',
            ]);

            return;
        }

        if (! $order->canRefundPayment()) {
            $this->dispatch('notify', [
                'message' => 'Refund is only available for cancelled orders with successful payments.',
            ]);

            return;
        }

        $this->selectedRefundOrderId = $order->id;
        $this->selectedRefundOrder = $order;
        $this->refundAmount = number_format($order->refundableAmountRemaining(), 2, '.', '');
        $this->refundModalOpen = true;
        $this->resetErrorBag('refundAmount');
    }

    public function saveRefund()
    {
        $this->validate([
            'refundAmount' => 'required|numeric|min:0.01',
        ]);

        $order = Order::find($this->selectedRefundOrderId);

        if (! $order) {
            $this->dispatch('notify', [
                'message' => 'Order not found.',
            ]);
            $this->refundModalOpen = false;

            return;
        }

        $this->updatePaymentStatus($order->id, 'refunded', (float) $this->refundAmount);
    }

    public function toggleExpand($orderId)
    {
        $this->expandedOrderId = ($this->expandedOrderId === $orderId) ? null : $orderId;
    }

    public function updatePaymentStatus($orderId, $status, $refundAmount = null)
    {
        $order = Order::findOrFail($orderId);

        if ($status === 'refunded') {
            if (! $order->canRefundPayment()) {
                $this->dispatch('notify', [
                    'message' => 'Refund is only available for cancelled orders with successful payments.',
                ]);

                return;
            }

            $amountToRefund = $refundAmount !== null
                ? round((float) $refundAmount, 2)
                : round($order->refundableAmountRemaining(), 2);

            if ($amountToRefund <= 0) {
                $this->dispatch('notify', [
                    'message' => 'Refund amount must be greater than zero.',
                ]);

                return;
            }

            if ($amountToRefund > $order->refundableAmountRemaining()) {
                $this->addError('refundAmount', 'Refund amount cannot exceed the remaining refundable amount.');

                return;
            }

            $order->refunded_amount = $amountToRefund;
            $order->payment_status = 'refunded';
            $order->save();

            $this->dispatch('notify', [
                'message' => 'Payment refunded successfully!',
            ]);

            $this->refundModalOpen = false;
            $this->selectedRefundOrderId = null;
            $this->selectedRefundOrder = null;
            $this->refundAmount = null;

            return;
        }

        $order->payment_status = $status;
        $order->save();

        /**
         * If payment status is success then order status should be confirmed
         */
        if ($status == 'success' && $order->order_status == 'processing') {
            $order->order_status = 'confirmed';
            $order->save();

            $this->generateOrderslno($order); // Call to update order serial no
        }

        /**
         * If payment status is sucess then send order placed email to user & admin
         */
        if ($status == 'success') {
            try {
                Mail::to($order->billing_email)->send(new OrderPlacedMail($order, false, 'Your order has been placed.'));

                $emails = explode(',', env('ADMIN_EMAILS'));
                // Mail::to('satnam1122@gmail.com')->send(new OrderPlacedMail($order, true));
                Mail::to($emails)->send(new OrderPlacedMail($order, true));
            } catch (\Throwable $e) {
                // Log error or handle it as needed
                dd($e->getMessage());
            }

            // Send WhatsApp notification
            try {
                $watiService = new WatiService;

                $watiService->sendTemplateMessage(
                    mobile: $order->billing_phone,
                    templateName: 'order_success_new',
                    parameters: [
                        ['name' => 'order_id', 'value' => $order->order_number],
                    ],
                    broadcastName: 'order_success'
                );
            } catch (\Throwable $e) {
                \Log::error('WhatsApp notification failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // For a toast message (will show after update)
        $this->dispatch('notify', [
            'message' => 'Payment status updated successfully!',
        ]);
    }

    public function generateOrderslno($order)
    {
        $date = Carbon::parse($order->created_at)->toDateString();

        // Get highest serial number of that date
        $lastSerial = Order::whereDate('created_at', $date)
            ->where('payment_status', 'success')
            ->max('order_sl_no');

        $nextSerial = ($lastSerial ? $lastSerial : 0) + 1;

        // Update serial number
        $order->update([
            'order_sl_no' => $nextSerial,
        ]);

        return $nextSerial;
    }

    public function getAvailableStatuses($current)
    {
        $map = [
            'processing' => ['confirmed', 'cancelled'],
            'confirmed' => ['dispatched', 'cancelled'],
            'dispatched' => ['complete', 'cancelled'],
            'complete' => ['complete'],
            'cancelled' => ['cancelled'],
        ];

        return $map[$current] ?? ['pending'];
    }

    public function getStatusStyle($status)
    {
        return match ($status) {
            'processing' => ['bg' => 'bg-yellow-100 text-yellow-700', 'icon' => '⏳'],
            'confirmed' => ['bg' => 'bg-blue-100 text-blue-700', 'icon' => '✅'],
            'dispatched' => ['bg' => 'bg-purple-100 text-purple-700', 'icon' => '🚚'],
            'complete' => ['bg' => 'bg-green-100 text-green-700', 'icon' => '📦'],
            'cancelled' => ['bg' => 'bg-red-100 text-red-700', 'icon' => '❌'],
            default => ['bg' => 'bg-gray-100 text-gray-700', 'icon' => '❓'],
        };
    }

    public function updateOrderStatus($orderId, $status)
    {
        // dd($status);
        $order = Order::find($orderId);

        if (! $order) {
            return;
        }

        // Prevent invalid changes (security)
        $allowed = $this->getAvailableStatuses($order->order_status);

        if (! in_array($status, $allowed)) {
            $this->dispatch('notify', [
                'message' => 'Invalid status transition!',
            ]);

            return;
        }

        $order->order_status = $status;
        $order->save();

        // Send whatsapp message for order dispatched
        if ($status == 'dispatched') {
            try {
                $watiService = new WatiService;

                $watiService->sendTemplateMessage(
                    mobile: $order->billing_phone,
                    templateName: 'order_packed_new',
                    parameters: [
                        ['name' => 'order_id', 'value' => $order->order_number],
                    ],
                    broadcastName: 'order_packed'
                );

                // Mail::to($order->billing_email)->send(
                //     new OrderStatusUpdatedMail($order, $status)
                // );
            } catch (\Throwable $e) {
                dd($e->getMessage());
            }
        }

        // Send review mail when order is completed
        if ($status === 'complete') {
            try {
                Mail::to("$order->billing_email")
                    ->send(new OrderReviewMail($order));
            } catch (\Throwable $e) {
                \Log::error('Order review mail failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->dispatch('notify', [
            'message' => 'Order status updated!',
        ]);
    }

    /**
     * Resend order email to User
     */
    public function resendUserEmail($orderId)
    {
        $order = Order::find($orderId);

        try {
            if ($order->is_modified == 1) {
                Mail::to($order->billing_email)->send(new OrderModifiedMail($order, false, 'Your order has been modified.'));
            } else {
                Mail::to($order->billing_email)->send(new OrderPlacedMail($order, false, 'Your order has been placed.'));
            }
            // Mail::to($order->billing_email)->send(new OrderPlacedMail($order, false, 'Your order has been placed.'));
            $this->dispatch('notify', [
                'message' => 'Email send successfully!',
            ]);
        } catch (\Throwable $e) {
            $this->dispatch('notify', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Resend order email to Admin
     */
    public function resendAdminEmail($orderId)
    {
        $order = Order::find($orderId);

        try {
            $emails = explode(',', env('ADMIN_EMAILS'));
            if ($order->is_modified == 1) {
                Mail::to(['satnam1122@gmail.com', 'order@swetonspeakers.com'])->send(new OrderModifiedMail($order, true));
            } else {
                Mail::to($emails)->send(new OrderPlacedMail($order, true));
            }

            $this->dispatch('notify', [
                'message' => 'Email send successfully!',
            ]);
        } catch (\Throwable $e) {
            $this->dispatch('notify', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        $orderQuery = Order::with('orderitems', 'orderitems.product', 'user');

        // Restrict Subadmin orders
        if (auth()->user()->can('isSubadmin') && ! auth()->user()->can('isAdmin')) {
            $orderQuery->whereIn('payment_status', ['success', 'refunded']);
        }

        if ($this->search) {
            $orderQuery->where('order_number', 'LIKE', '%'.$this->search.'%');
        }

        if ($this->isModified !== '') {
            $orderQuery->where('is_modified', $this->isModified);
        }

        if ($this->orderStatus) {
            $orderQuery->where('order_status', $this->orderStatus);
        }
        if ($this->paymentStatus) {
            $orderQuery->where('payment_status', $this->paymentStatus);
        }
        if ($this->deliveryPartner) {
            if ($this->deliveryPartner === 'none') {
                $orderQuery->whereNull('awb_partner');
            } else {
                $orderQuery->where('awb_partner', $this->deliveryPartner);
            }
        }

        if ($this->dateFrom && $this->dateTo) {
            $orderQuery->whereBetween('order_date', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay(),
            ]);
        }

        if ($this->userSearch) {
            $orderQuery->whereHas('user', function ($q) {
                $q->where('name', 'LIKE', '%'.$this->userSearch.'%')
                    ->orWhere('email', 'LIKE', '%'.$this->userSearch.'%')
                    ->orWhere('phone_number', 'LIKE', '%'.$this->userSearch.'%');
            });
        }

        $orders = $orderQuery->latest()->paginate($this->perPage);

        return view('livewire.admin.order-list', [
            'orders' => $orders,
        ]);
    }
}
