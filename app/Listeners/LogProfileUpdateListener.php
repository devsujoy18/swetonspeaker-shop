<?php

namespace App\Listeners;

use App\Events\ProfileUpdated;
use App\Models\Notification;

class LogProfileUpdateListener
{
    public function __construct() {}

    public function handle(ProfileUpdated $event): void
    {
        $existingNotification = Notification::where('type', 'profile_updated')
            ->where('notifiable_id', $event->user->id)
            ->where('notifiable_type', $event->user::class)
            ->where('data->update_type', $event->updateType)
            ->where('created_at', '>=', now()->subSeconds(30))
            ->first();

        if ($existingNotification) {
            return;
        }

        $fieldLabels = [
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'zip_postal_code' => 'ZIP/Postal Code',
            'locality_house_no' => 'House No/Locality',
            'street_address' => 'Street Address',
            'landmark' => 'Landmark',
            'city_district_town' => 'City/District/Town',
            'state' => 'State',
            'company_name' => 'Company Name',
            'gst_no' => 'GST Number',
            'email' => 'Email',
        ];

        $changedLabels = [];
        foreach ($event->changedFields as $field) {
            $changedLabels[] = $fieldLabels[$field] ?? $field;
        }

        $fieldsText = implode(', ', $changedLabels);
        $updateTypeLabel = match ($event->updateType) {
            'profile' => 'Profile Information',
            'address' => 'Address Information',
            default => 'Profile',
        };

        Notification::create([
            'type' => 'profile_updated',
            'notifiable_id' => $event->user->id,
            'notifiable_type' => $event->user::class,
            'title' => 'User Profile Updated',
            'message' => "{$event->user->name} ({$event->user->email}) updated their {$updateTypeLabel}: {$fieldsText}",
            'data' => [
                'user_id' => $event->user->id,
                'user_name' => $event->user->name,
                'user_email' => $event->user->email,
                'changed_fields' => $event->changedFields,
                'update_type' => $event->updateType,
            ],
        ]);
    }
}
