<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registered</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="background-color: #ffffff; padding: 20px;">
                <!-- Logo -->
                <img src="<?php echo e(asset('image/logonew1.png')); ?>" alt="Company Logo" style="max-width: 150px;">
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    <tr>
                        <td>
                            <h2 style="color: #333;">🚨 New User Registered</h2>
                            <p style="color: #555; font-size: 16px;">A new user has just signed up:</p>

                            <table cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; margin-top: 15px;">
                                <tr>
                                    <td style="border-bottom: 1px solid #eee;"><strong>Name:</strong></td>
                                    <td style="border-bottom: 1px solid #eee;"><?php echo e($user->name); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #eee;"><strong>Email:</strong></td>
                                    <td style="border-bottom: 1px solid #eee;"><?php echo e($user->email); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #eee;"><strong>Phone:</strong></td>
                                    <td style="border-bottom: 1px solid #eee;"><?php echo e($user->phone_number); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #eee;"><strong>City:</strong></td>
                                    <td style="border-bottom: 1px solid #eee;"><?php echo e($user->city_district_town); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>State:</strong></td>
                                    <td><?php echo e($user->state); ?></td>
                                </tr>
                            </table>

                            <p style="color: #888; font-size: 14px; margin-top: 30px;">
                                — Automated System
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH /home/ace85084/public_html/shop.ace.sminfomedia.com/resources/views/emails/admin_new_user.blade.php ENDPATH**/ ?>