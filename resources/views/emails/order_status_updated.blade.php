<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Updated</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f7f7f7; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background:white; padding:20px; border-radius:10px;">
        <tr>
            <td style="text-align:center; padding-bottom:20px;">
                <img src="{{ asset('image/logonew1.png') }}" alt="Sweton Logo" width="150" style="display:block; margin:auto;">
            </td>
        </tr>

        <tr>
            <td>
                <h2 style="font-size:20px; color:#333;">Hello {{ $order->billing_name }},</h2>

                <p style="font-size:15px; color:#555;">
                    Your order <strong>#{{ $order->order_number }}</strong> has been updated.
                </p>

                <p style="font-size:16px; color:#000; margin-top:15px;">
                    <strong>New Order Status: {{ $status }}</strong>
                </p>

                <p style="font-size:15px; color:#555; margin-top:15px;">
                    We will keep you updated with the next steps.  
                    Thank you for shopping with us!
                </p>

                <p style="margin-top:30px; font-size:14px; color:#333;">
                    Warm Regards,<br>
                    <strong>Sweton Team</strong>
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
