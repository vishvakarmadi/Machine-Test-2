<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\PropertyType;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create default Admin User
        AdminUser::create([
            'name' => 'Administrator',
            'email' => 'admin@realestate.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Create Property Types
        $types = [
            'Apartment',
            'Villa',
            'House',
            'Land',
        ];

        $propertyTypes = [];
        foreach ($types as $type) {
            $propertyTypes[$type] = PropertyType::create(['name' => $type]);
        }

        // 3. Create initial properties
        Property::create([
            'property_type_id' => $propertyTypes['Villa']->id,
            'title' => 'Luxury Ocean View Villa',
            'description' => 'Experience the epitome of luxury with this stunning ocean view villa. Featuring 5 bedrooms, infinity pool, and state-of-the-art smart home features.',
            'price' => 2500000.00,
            'city' => 'Miami',
            'is_featured' => true,
        ]);

        Property::create([
            'property_type_id' => $propertyTypes['Apartment']->id,
            'title' => 'Modern Downtown Loft',
            'description' => 'A beautifully designed loft in the heart of the city. Walking distance to major corporate hubs, dining, and entertainment.',
            'price' => 750000.00,
            'city' => 'New York',
            'is_featured' => false,
        ]);

        Property::create([
            'property_type_id' => $propertyTypes['House']->id,
            'title' => 'Cozy Suburb Family Home',
            'description' => 'Perfect family home with a large backyard, newly renovated kitchen, and located in a top-rated school district.',
            'price' => 520000.00,
            'city' => 'Austin',
            'is_featured' => true,
        ]);
        
        Property::create([
            'property_type_id' => $propertyTypes['Land']->id,
            'title' => 'Prime Commercial Plot',
            'description' => '5 acres of prime commercial land ready for development. Excellent road frontage and high traffic visibility.',
            'price' => 1200000.00,
            'city' => 'Dallas',
            'is_featured' => false,
        ]);
    }
}
