<?php
/**
 * Promotional hotel offer cards for the homepage Special Offers section.
 * These are display-only (no detail page) and CTA to the enquiry form.
 *
 * 'stars' is omitted (left unset) for hotels where no star rating was
 * supplied — the card simply doesn't show a rating badge in that case.
 * 'rate_unit_en'/'rate_unit_ar' intentionally varies per hotel (most are
 * "night", Frangipani Langkawi is specifically "person" — do not
 * normalise these to the same unit). Rendered on the homepage as
 * "From OMR {amount} / {unit}".
 */

$offers = [
    [
        'hotel_en'     => 'Ascott Kuala Lumpur',
        'hotel_ar'     => ar_pending(),
        'location_en'  => 'Kuala Lumpur',
        'location_ar'  => 'كوالالمبور',
        'stars'        => 5,
        'rate_amount'  => '49',
        'rate_unit_en' => 'night',
        'rate_unit_ar' => 'ليلة',
        'meal_plan_en' => 'Bed & Breakfast',
        'meal_plan_ar' => 'إفطار',
        'image'        => 'assets/images/optimized/offer-kl-suites',
    ],
    [
        'hotel_en'     => 'DoubleTree by Hilton',
        'hotel_ar'     => ar_pending(),
        'location_en'  => 'Melaka',
        'location_ar'  => 'ملقا',
        'stars'        => 4,
        'rate_amount'  => '38',
        'rate_unit_en' => 'night',
        'rate_unit_ar' => 'ليلة',
        'meal_plan_en' => 'Bed & Breakfast',
        'meal_plan_ar' => 'إفطار',
        'image'        => 'assets/images/optimized/dest-malacca',
    ],
    [
        'hotel_en'     => 'The Upper House Penang',
        'hotel_ar'     => ar_pending(),
        'location_en'  => 'Penang',
        'location_ar'  => 'بينانج',
        'rate_amount'  => '19',
        'rate_unit_en' => 'night',
        'rate_unit_ar' => 'ليلة',
        'meal_plan_en' => 'Bed & Breakfast',
        'meal_plan_ar' => 'إفطار',
        'image'        => 'assets/images/optimized/offer-penang-hotel',
    ],
    [
        'hotel_en'     => 'Frangipani Langkawi',
        'hotel_ar'     => ar_pending(),
        'location_en'  => 'Langkawi',
        'location_ar'  => 'لنكاوي',
        'rate_amount'  => '40',
        'rate_unit_en' => 'person',
        'rate_unit_ar' => 'شخص',
        'meal_plan_en' => 'Bed & Breakfast',
        'meal_plan_ar' => 'إفطار',
        'image'        => 'assets/images/optimized/offer-langkawi-resort',
    ],
];
