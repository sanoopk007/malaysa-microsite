<?php
/**
 * Experience categories. The homepage shows a curated teaser subset
 * (see $experience_teasers); the full list powers /experiences.php.
 * 'destinations' cross-links to slugs in destination-data.php.
 */

$experiences = [
    [
        'slug' => 'nature-wildlife', 'title_en' => 'Nature & Wildlife', 'title_ar' => ar_pending(),
        'desc_en' => 'From orangutan sanctuaries in Sabah to ancient rainforest in Taman Negara, Malaysia is one of the most biodiverse places on Earth.',
        'image' => 'assets/images/optimized/exp-nature-wildlife', 'destinations' => ['sabah', 'taman-negara'],
    ],
    [
        'slug' => 'beaches-islands', 'title_en' => 'Beaches & Islands', 'title_ar' => ar_pending(),
        'desc_en' => 'Turquoise water, coral reefs and postcard sunsets — Langkawi and the Perhentians are only the beginning.',
        'image' => 'assets/images/optimized/exp-beaches-islands', 'destinations' => ['langkawi', 'perhentian-islands'],
    ],
    [
        'slug' => 'culture-heritage', 'title_en' => 'Culture & Heritage', 'title_ar' => ar_pending(),
        'desc_en' => 'Walk through centuries of history in the UNESCO-listed streets of George Town and Malacca.',
        'image' => 'assets/images/optimized/exp-culture-heritage', 'destinations' => ['penang', 'malacca'],
    ],
    [
        'slug' => 'food-gastronomy', 'title_en' => 'Food & Gastronomy', 'title_ar' => ar_pending(),
        'desc_en' => 'A multicultural table of Malay, Chinese and Indian flavours, from hawker stalls to fine dining.',
        'image' => 'assets/images/optimized/exp-food-gastronomy', 'destinations' => ['penang', 'kuala-lumpur'],
    ],
    [
        'slug' => 'adventure', 'title_en' => 'Adventure', 'title_ar' => ar_pending(),
        'desc_en' => 'Canopy walkways, cave treks and cable cars over the rainforest — Malaysia rewards the adventurous.',
        'image' => 'assets/images/optimized/exp-adventure', 'destinations' => ['taman-negara', 'langkawi'],
    ],
    [
        'slug' => 'family', 'title_en' => 'Family', 'title_ar' => ar_pending(),
        'desc_en' => 'Theme parks, wildlife encounters and easy island days make Malaysia an effortless family trip.',
        'image' => 'assets/images/optimized/exp-family', 'destinations' => ['kuala-lumpur', 'langkawi'],
    ],
    [
        'slug' => 'shopping', 'title_en' => 'Shopping', 'title_ar' => ar_pending(),
        'desc_en' => 'From duty-free Langkawi to Kuala Lumpur\'s mega-malls and Jonker Street\'s night market.',
        'image' => 'assets/images/optimized/exp-shopping', 'destinations' => ['kuala-lumpur', 'langkawi'],
    ],
    [
        'slug' => 'city-experiences', 'title_en' => 'City Experiences', 'title_ar' => ar_pending(),
        'desc_en' => 'Skyline towers, street art and buzzing night markets across Malaysia\'s most dynamic cities.',
        'image' => 'assets/images/optimized/exp-city-experiences', 'destinations' => ['kuala-lumpur', 'penang'],
    ],
    [
        'slug' => 'wellness', 'title_en' => 'Wellness', 'title_ar' => ar_pending(),
        'desc_en' => 'Cool mountain air, tea plantations and spa retreats for a slower kind of travel.',
        'image' => 'assets/images/optimized/exp-wellness', 'destinations' => ['cameron-highlands'],
    ],
    [
        'slug' => 'luxury', 'title_en' => 'Luxury', 'title_ar' => ar_pending(),
        'desc_en' => 'Private island resorts and five-star city stays, curated with Khimji\'s House of Travel.',
        'image' => 'assets/images/optimized/exp-luxury', 'destinations' => ['langkawi', 'kota-kinabalu'],
    ],
    [
        'slug' => 'romantic-escapes', 'title_en' => 'Romantic Escapes', 'title_ar' => ar_pending(),
        'desc_en' => 'Overwater villas, hillside teahouses and sunset cruises made for two.',
        'image' => 'assets/images/optimized/exp-romantic-escapes', 'destinations' => ['langkawi', 'cameron-highlands'],
    ],
];

// Homepage teaser: a curated subset for the staggered mosaic section.
$experience_teasers = ['nature-wildlife', 'beaches-islands', 'culture-heritage', 'food-gastronomy', 'adventure'];
