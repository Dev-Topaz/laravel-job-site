<?php

namespace Database\Seeders;

use App\Models\Countries;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Countries::create(["name" => 'Australia', "currency" => "AUD"]);
    Countries::create(["name" => 'Austria', "currency" => "EUR"]);
    Countries::create(["name" => 'Belgium', "currency" => "EUR"]);
    Countries::create(["name" => 'Bulgaria', "currency" => "BGN"]);
    Countries::create(["name" => 'Canada', "currency" => "CAD"]);
    Countries::create(["name" => 'Cyprus', "currency" => "EUR"]);
    Countries::create(["name" => 'Czech Republic', "currency" => "CZK"]);
    Countries::create(["name" => 'Denmark', "currency" => "DKK"]);
    Countries::create(["name" => 'Estonia', "currency" => "EUR"]);
    Countries::create(["name" => 'Finland', "currency" => "EUR"]);
    Countries::create(["name" => 'France', "currency" => "EUR"]);
    Countries::create(["name" => 'Germany', "currency" => "EUR"]);
    Countries::create(["name" => 'Greece', "currency" => "EUR"]);
    Countries::create(["name" => 'Hong Kong', "currency" => "HKD"]);
    Countries::create(["name" => 'Hungary', "currency" => "HUF"]);
    Countries::create(["name" => 'Ireland', "currency" => "EUR"]);
    Countries::create(["name" => 'Italy', "currency" => "EUR"]);
    Countries::create(["name" => 'Japan', "currency" => "JPY"]);
    Countries::create(["name" => 'Latvia', "currency" => "EUR"]);
    Countries::create(["name" => 'Lithuania', "currency" => "EUR"]);
    Countries::create(["name" => 'Luxembourg', "currency" => "EUR"]);
    Countries::create(["name" => 'Malta', "currency" => "EUR"]);
    Countries::create(["name" => 'Netherlands', "currency" => "EUR"]);
    Countries::create(["name" => 'New Zealand', "currency" => "NZD"]);
    Countries::create(["name" => 'Norway', "currency" => "NOK"]);
    Countries::create(["name" => 'Poland', "currency" => "PLN"]);
    Countries::create(["name" => 'Portugal', "currency" => "EUR"]);
    Countries::create(["name" => 'Romania', "currency" => "RON"]);
    Countries::create(["name" => 'Singapore', "currency" => "SGD"]);
    Countries::create(["name" => 'Slovakia', "currency" => "EUR"]);
    Countries::create(["name" => 'Slovenia', "currency" => "EUR"]);
    Countries::create(["name" => 'Spain', "currency" => "EUR"]);
    Countries::create(["name" => 'Sweden', "currency" => "SEK"]);
    Countries::create(["name" => 'Switzerland', "currency" => "CHF"]);
    Countries::create(["name" => 'United Kingdom', "currency" => "GBP"]);
    Countries::create(["name" => 'United States', "currency" => "USD"]);
  }
}
