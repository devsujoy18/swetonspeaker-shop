<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuccessOrderExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $from;

    protected string $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return Collection<int, Order>
     */
    public function collection(): Collection
    {
        return Order::query()
            ->select([
                'shipping_name',
                'shipping_phone',
                'shipping_state',
                'billing_name',
                'billing_phone',
                'billing_state',
                'order_date',
                'total',
            ])
            ->whereBetween('order_date', [
                Carbon::parse($this->from)->startOfDay(),
                Carbon::parse($this->to)->endOfDay(),
            ])
            ->where('payment_status', 'success')
            ->where('order_status', '!=', 'cancelled')
            ->orderByDesc('order_date')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'State',
            'Order Date & Time',
            'Order Amount',
        ];
    }

    public function map($order): array
    {
        $customerName = $order->shipping_name ?: $order->billing_name;
        $customerPhone = $order->shipping_phone ?: $order->billing_phone;
        $customerState = $order->shipping_state ?: $order->billing_state;

        $orderDateTime = $order->order_date
            ? Carbon::parse($order->order_date)->format('d-m-Y h:i A')
            : '';

        return [
            $customerName,
            $customerPhone,
            $customerState,
            $orderDateTime,
            $order->total,
        ];
    }
}
