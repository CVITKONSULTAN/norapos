<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class VenueBookingPermissionSeeder extends Seeder
{
    /**
     * Seed venue booking permissions.
     */
    public function run()
    {
        $permissions = [
            'venue.view',
            'venue.create',
            'venue.update',
            'venue.delete',
            'venue_booking.view',
            'venue_booking.create',
            'venue_booking.update',
            'venue_booking.delete',
            'venue_booking.payment',
        ];

        $time_stamp = \Carbon\Carbon::now()->toDateTimeString();
        $insert_data = [];

        foreach ($permissions as $perm) {
            // Skip if already exists
            if (Permission::where('name', $perm)->exists()) {
                continue;
            }
            $insert_data[] = [
                'name' => $perm,
                'guard_name' => 'web',
                'created_at' => $time_stamp,
                'updated_at' => $time_stamp,
            ];
        }

        if (!empty($insert_data)) {
            Permission::insert($insert_data);
        }
    }
}
