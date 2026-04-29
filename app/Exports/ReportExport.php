<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $from;
    protected $to;
    protected $partner;

    public function __construct($from, $to, $partner)
    {
        $this->from = $from;
        $this->to = $to;
        $this->partner = $partner;
    }

    public function collection()
    {
        return Order::when($this->partner, function ($q) {
                $q->where('awb_partner', $this->partner);
            })
            ->whereBetween('order_date', [
                Carbon::parse($this->from)->startOfDay(),
                Carbon::parse($this->to)->endOfDay(),
            ])
            ->where('payment_status', 'success')
            ->where('order_status', '!=', 'cancelled')
            ->orderBy('order_date', 'desc')
            ->get()
            ->flatMap(function ($order) {      // FLATTEN TO ITEM ROWS
                return $order->orderitems->map(function ($item) use ($order) {
                    return [
                        'order' => $order,
                        'item'  => $item,
                    ];
                });
            });
    }

    public function headings(): array
    {
        if ($this->partner == 'Delhivery') {

            return [
                'Waybill',
                'Reference No',
                'Consignee Name',
                'City',
                'State',
                'Country',
                'Address',
                'Pincode',
                'Phone',
                'Mobile',
                'Weight',
                'Shipment Length',
                'Shipment Breadth',
                'Shipment Height',
                'Payment Mode',
                'Package Amount',
                'COD Amount',
                'Product to be Shipped',
                'Vendor Pickup Location',
                'Return Address',
                'Return Pin',
                'Shipping Mode',
                'fragile_shipment',
                'alternate_phone',
                'shipment_type',
                'master_id',
                'mps_children',
                'mps_amount',
                'Seller Name',
                'Seller Address',
                'Seller CST No',
                'Seller TIN',
                'Invoice No',
                'Invoice Date',
                'Quantity',
                'Commodity Value',
                'Tax Value',
                'Category of Goods',
                'Seller GST TIN',
                'HSN Code',
                'Return Reason',
                'EWBN',
            ];
        }

        if ($this->partner == 'Bluedart') {
            return [
                'Shipping_Method','Customer_ref','Pickup_Warehouse_id','Delivery_Warehouse_id',
                'RTO_Warehouse_id','Waybill','Invoice_number','Courier_purpose','Parcel_content',
                'Shipment_type','Payment_type','Payment_mode','Favourable_name','COD_amount',
                'COD_currency','Length','Width','Height','Box_count','Value','Shipment_value_currency',
                'Weight','eWaybill_number','Receiver_name','Receiver_company_name','Receiver_address1',
                'Receiver_address2','Receiver_address3','Receiver_city','Receiver_pincode',
                'Receiver_state','Receiver_country','Receiver_phone','Receiver_email',
                'Receiver_address_type','Sender_name','Sender_company_name','Sender_address1',
                'Sender_address2','Sender_address3','Sender_city','Sender_pincode','Sender_state',
                'Sender_country','Sender_phone','Sender_email','Sender_address_type','RTO_name',
                'RTO_company_name','RTO_address1','RTO_address2','RTO_address3','RTO_city',
                'RTO_pincode','RTO_state','RTO_country','RTO_phone','RTO_email','RTO_address_type',
            ];
        }

        //Default
        return [
            'Order Number',
            'Customer Name',
            'Phone',
            'Subtotal',
            'Total',
            'Delivery Partner',
            'AWB Number',
            'Order Date'
        ];
    }

    public function map($row): array
    {
        $order = $row['order'];
        $item  = $row['item'];

        /*$fullAddress = trim(
                $order->shipping_street . ', ' .
                $order->shipping_locality . ', ' .
                $order->shipping_landmark . ' , '.
                $order->shipping_city . ' , '.
                $order->shipping_zip . ' , '.
                $order->shipping_state . ' , '.
                'India'
            );
            */
            
        $fullAddress = trim(
                $order->shipping_street . ', ' .
                $order->shipping_locality . ', ' .
                $order->shipping_landmark . ' , '
            );

        if ($this->partner == 'Delhivery') {
            return [
                '',
                $order->order_number,
                $order->shipping_name,
                $order->shipping_city,
                $order->shipping_state,
                'India',
                $fullAddress,
                $order->shipping_zip,
                '',
                $order->shipping_phone,
                '', 
                '', 
                '', 
                '',
                'Prepaid',
                $item->price,
                '',
                'SPEAKERS',
                'OCTUNEELECTRONICS SURFACE',
                '85, N S Road, PO-Kodalia, Kolkata - 700146',
                '700146',
                'surface',
                'true',
                $order->shipping_alternate_phone,
                '', 
                '', 
                '', 
                '', 
                '',
                '85, N S Road, PO-Kodalia, Kolkata - 700146',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'ELECTRONICS GOODS',
                '19AADFO7085N1ZI',
                '85182990',
                '',
                ''
            ];
        }

        if ($this->partner == 'Bluedart') {
            
            return [
                'Forward',                               // Shipping_Method
                $order->order_number,                    // Customer_ref
                'WH-KOL-700146-uX8',                     // Pickup_Warehouse_id
                '',                                      // Delivery_Warehouse_id
                '',                                      // RTO_Warehouse_id
                '',                                      // Waybill
                'ECOM/0791/25-26',                       // Invoice_number
                'Commercial',                            // Courier_purpose
                'LOUDSPEAKER',                           // Parcel_content
                'Parcel',                                // Shipment_type
                'Prepaid',                               // Payment_type
                '',                                      // Payment_mode
                '',                                      // Favourable_name
                '',                                      // COD_amount
                '',                                      // COD_currency
                '', '', '',                              // Length, Width, Height
                1,                                       // Box_count
                '',                                      // Value
                'INR',                                   // Shipment_value_currency
                '',                                      // Weight
                true,                                    // eWaybill_number
                $order->shipping_name,                   // Receiver_name
                '',                                      // Receiver_company_name
                $fullAddress,                   // Receiver_address1
                '',                             // Receiver_address2
                '',                                      // Receiver_address3
                $order->shipping_city,                   // Receiver_city
                $order->shipping_zip,                    // Receiver_pincode
                $order->shipping_state,                  // Receiver_state
                'India',                                 // Receiver_country
                $order->shipping_phone,                  // Receiver_phone
                '',                                      // Receiver_email
                'Residential',                           // Receiver_address_type

                // SENDER DETAILS (EMPTY)
                '', '', '', '', '', '', '', '', '', '', '',

                // RTO DETAILS (EMPTY)
                '', '', '', '', '', '', '', '', '', '', '',
            ];
        }
    }
}
