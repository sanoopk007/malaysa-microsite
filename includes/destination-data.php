<?php
/**
 * Central list of the 10 Attractions destinations. Used by the mega-menu,
 * the homepage destination showcase, /attractions/index.php and the mobile
 * drawer. Edit here once and it updates everywhere.
 *
 * 'attractions' is placeholder content — well-known sights for each area —
 * shown on the destination detail page until Khimji Travel supplies the
 * official curated list.
 */

$destinations = [
    [
        'slug'         => 'kuala-lumpur',
        'title_en'     => 'Kuala Lumpur',
        'title_ar'     => 'كوالالمبور',
        'tagline_en'   => 'Urban energy & iconic landmarks',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-kuala-lumpur',
        'attractions'  => [
            ['name' => 'Petronas Twin Towers', 'desc' => 'The city\'s glittering skyline icon, with a sky bridge and observation deck.'],
            ['name' => 'Batu Caves', 'desc' => 'A limestone hill temple reached by a colourful 272-step staircase.'],
            ['name' => 'Merdeka Square', 'desc' => 'The historic heart of the city, framed by colonial-era architecture.'],
            ['name' => 'Bukit Bintang', 'desc' => 'The buzzing shopping and nightlife district in the city centre.'],
        ],
    ],
    [
        'slug'         => 'penang',
        'title_en'     => 'Penang',
        'title_ar'     => 'بينانج',
        'tagline_en'   => 'Heritage, culture & cuisine',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-penang',
        'attractions'  => [
            ['name' => 'George Town', 'desc' => 'A UNESCO World Heritage old town famous for street art and shophouses.'],
            ['name' => 'Kek Lok Si Temple', 'desc' => 'One of Southeast Asia\'s largest Buddhist temple complexes.'],
            ['name' => 'Penang Hill', 'desc' => 'A funicular ride up to cool viewpoints over the island.'],
            ['name' => 'Gurney Drive Hawker Centre', 'desc' => 'A legendary seafront food destination for local specialities.'],
        ],
    ],
    [
        'slug'         => 'langkawi',
        'title_en'     => 'Langkawi',
        'title_ar'     => 'لنكاوي',
        'tagline_en'   => 'Island escapes & tropical adventure',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-langkawi',
        'attractions'  => [
            ['name' => 'Langkawi Sky Bridge', 'desc' => 'A curved pedestrian bridge suspended above the rainforest canopy.'],
            ['name' => 'Langkawi Cable Car', 'desc' => 'A dramatic ride to the summit of Gunung Mat Cincang.'],
            ['name' => 'Pulau Dayang Bunting', 'desc' => 'Home to the Lake of the Pregnant Maiden, a popular island-hopping stop.'],
            ['name' => 'Pantai Cenang', 'desc' => 'The island\'s liveliest beach strip for sunsets and water sports.'],
        ],
    ],
    [
        'slug'         => 'malacca',
        'title_en'     => 'Malacca',
        'title_ar'     => 'ملقا',
        'tagline_en'   => 'Colours of old Malaysia',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-malacca',
        'attractions'  => [
            ['name' => 'Jonker Street', 'desc' => 'A lively heritage street known for antiques, food stalls and night markets.'],
            ['name' => 'A Famosa', 'desc' => 'The remains of a 16th-century Portuguese fortress.'],
            ['name' => 'Malacca River Cruise', 'desc' => 'A relaxed evening cruise past murals and riverside architecture.'],
            ['name' => 'Christ Church Malacca', 'desc' => 'The iconic red Dutch-era church anchoring the city square.'],
        ],
    ],
    [
        'slug'         => 'kota-kinabalu',
        'title_en'     => 'Kota Kinabalu',
        'title_ar'     => 'كوتا كينابالو',
        'tagline_en'   => 'Where mountains meet the sea',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-kota-kinabalu',
        'attractions'  => [
            ['name' => 'Mount Kinabalu', 'desc' => 'Southeast Asia\'s highest peak and a UNESCO World Heritage Site.'],
            ['name' => 'Tunku Abdul Rahman Marine Park', 'desc' => 'Five islands just offshore, perfect for snorkelling and day trips.'],
            ['name' => 'Kota Kinabalu Waterfront', 'desc' => 'A lively promenade known for sunset views and seafood markets.'],
            ['name' => 'Mari Mari Cultural Village', 'desc' => 'A living showcase of Sabah\'s indigenous tribal cultures.'],
        ],
    ],
    [
        'slug'         => 'perhentian-islands',
        'title_en'     => 'Perhentian Islands',
        'title_ar'     => 'جزر برهنتيان',
        'tagline_en'   => 'Turquoise waters & coral reefs',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-perhentian-islands',
        'attractions'  => [
            ['name' => 'Long Beach (Pasir Panjang)', 'desc' => 'Powder-white sand and the island\'s liveliest beachfront.'],
            ['name' => 'Turtle Beach', 'desc' => 'A protected cove where green turtles nest.'],
            ['name' => 'Coral Bay Snorkelling', 'desc' => 'Shallow reefs teeming with colourful marine life just off the shore.'],
            ['name' => 'Pulau Susu Dara', 'desc' => 'A quiet islet cove ideal for snorkelling day trips.'],
        ],
    ],
    [
        'slug'         => 'cameron-highlands',
        'title_en'     => 'Cameron Highlands',
        'title_ar'     => 'مرتفعات كاميرون',
        'tagline_en'   => 'Tea plantations & cool mountain air',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-cameron-highlands',
        'attractions'  => [
            ['name' => 'BOH Tea Plantation', 'desc' => 'Rolling green tea estates with tours and a hilltop teahouse.'],
            ['name' => 'Mossy Forest', 'desc' => 'A cool, cloud-draped montane forest reached by boardwalk.'],
            ['name' => 'Cameron Valley Strawberry Farm', 'desc' => 'A pick-your-own farm popular with families.'],
            ['name' => 'Boh Sungai Palas Tea Centre', 'desc' => 'Panoramic terrace views over the plantation slopes.'],
        ],
    ],
    [
        'slug'         => 'kuching-bako-national-park',
        'title_en'     => 'Kuching & Bako National Park',
        'title_ar'     => 'كوتشينج وحديقة باكو الوطنية',
        'tagline_en'   => 'Rainforest trails & Borneo wildlife',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-kuching-bako',
        'attractions'  => [
            ['name' => 'Bako National Park', 'desc' => 'Ancient rainforest trails home to proboscis monkeys and rare flora.'],
            ['name' => 'Kuching Waterfront', 'desc' => 'A scenic riverside promenade lined with cafes and heritage buildings.'],
            ['name' => 'Semenggoh Wildlife Centre', 'desc' => 'A rehabilitation sanctuary for semi-wild orangutans.'],
            ['name' => 'Sarawak Cultural Village', 'desc' => 'A living museum of Borneo\'s indigenous longhouses and traditions.'],
        ],
    ],
    [
        'slug'         => 'taman-negara',
        'title_en'     => 'Taman Negara',
        'title_ar'     => 'تامان نيجارا',
        'tagline_en'   => 'One of the world\'s oldest rainforests',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-taman-negara',
        'attractions'  => [
            ['name' => 'Canopy Walkway', 'desc' => 'One of the world\'s longest rainforest canopy walkways.'],
            ['name' => 'Kuala Tahan', 'desc' => 'The gateway village for river crossings and jungle treks.'],
            ['name' => 'Gua Telinga Cave', 'desc' => 'A guided cave trek home to bats and cave-dwelling wildlife.'],
            ['name' => 'Tahan River Cruise', 'desc' => 'A boat journey through dense rainforest along the Tembeling River.'],
        ],
    ],
    [
        'slug'         => 'sabah',
        'title_en'     => 'Sabah',
        'title_ar'     => 'صباح',
        'tagline_en'   => 'Land below the wind',
        'tagline_ar'   => ar_pending(),
        'image'        => 'assets/images/optimized/dest-sabah',
        'attractions'  => [
            ['name' => 'Sepilok Orangutan Rehabilitation Centre', 'desc' => 'A renowned sanctuary caring for orphaned orangutans.'],
            ['name' => 'Kinabatangan River', 'desc' => 'A wildlife-rich river cruise through Borneo\'s rainforest.'],
            ['name' => 'Sipadan Island', 'desc' => 'World-class diving among turtles and coral walls.'],
            ['name' => 'Klias Wetlands', 'desc' => 'Mangrove river cruises known for proboscis monkeys and fireflies.'],
        ],
    ],
];
