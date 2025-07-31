<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Blog\Database\Seeders\BlogSeeder;
use Modules\Booking\Database\Seeders\BookingSeeder;
use Modules\Documentation\Database\Seeders\DocumentationSeeder;
use Modules\Flight\Database\Seeders\AirlineSeeder;
use Modules\Flight\Database\Seeders\FlightScheduleSeeder;
use Modules\Flight\Database\Seeders\FlightSeeder;
use Modules\Hotel\Database\Seeders\HotelSeeder;
use Modules\Location\Database\Seeders\AirportSeeder;
use Modules\Location\Database\Seeders\CitySeeder;
use Modules\Location\Database\Seeders\CountrySeeder;
use Modules\Option\Database\Seeders\OptionSeeder;
use Modules\Page\Database\Seeders\PageSeeder;
use Modules\Payment\Database\Seeders\PaymentSeeder;
use Modules\Tour\Database\Seeders\TourSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            OptionSeeder::class,
            DocumentationSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,

            // Location Module - Must run first (dependencies)
            CountrySeeder::class,
            CitySeeder::class,
            AirportSeeder::class,

            // Flight Module - Depends on Location
            AirlineSeeder::class,
            FlightSeeder::class,
            FlightScheduleSeeder::class,

            // Hotel Module - Depends on Location
            HotelSeeder::class,

            // Booking Module - Depends on Flight, Hotel
            BookingSeeder::class,

            // Payment Module - Depends on Booking
            PaymentSeeder::class,

            // tour 
            TourSeeder::class,
        ]);
    }
}
