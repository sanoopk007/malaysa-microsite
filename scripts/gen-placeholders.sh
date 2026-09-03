#!/bin/bash
# Generates local SVG placeholder "photos" (gradient + a plain generic-photo
# icon, no baked-in text) so the site renders fully before real photography
# is supplied. Deliberately textless — earlier versions had a label baked
# into the image itself, which visually collided with real page copy
# overlaid on top of it (hero titles, CTA headings, etc). Safe to delete
# once assets/images/** are replaced with real WebP/AVIF files.
set -e
cd "$(dirname "$0")/.."

make_svg () {
  path="$1"; label="$2"; sub="$3"; c1="$4"; c2="$5"; w="${6:-1600}"; h="${7:-1000}"
  id="g$(echo "$path" | md5sum | cut -c1-8)"
  icon_w=$((w/6)); icon_h=$((icon_w*3/4))
  icon_x=$(((w-icon_w)/2)); icon_y=$(((h-icon_h)/2))
  cat > "$path" <<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="$w" height="$h" viewBox="0 0 $w $h">
  <defs>
    <linearGradient id="$id" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="$c1"/>
      <stop offset="100%" stop-color="$c2"/>
    </linearGradient>
  </defs>
  <rect width="$w" height="$h" fill="url(#$id)"/>
  <circle cx="$((w*85/100))" cy="$((h*15/100))" r="$((w*22/100))" fill="#ffffff" opacity="0.06"/>
  <circle cx="$((w*10/100))" cy="$((h*90/100))" r="$((w*16/100))" fill="#ffffff" opacity="0.08"/>
  <g opacity="0.16" fill="none" stroke="#ffffff" stroke-width="$((w/300+2))">
    <rect x="$icon_x" y="$icon_y" width="$icon_w" height="$icon_h" rx="$((icon_w/24))"/>
    <circle cx="$((icon_x+icon_w*22/100))" cy="$((icon_y+icon_h*30/100))" r="$((icon_w/14))"/>
    <path d="M $icon_x $((icon_y+icon_h*88/100)) L $((icon_x+icon_w*32/100)) $((icon_y+icon_h*46/100)) L $((icon_x+icon_w*58/100)) $((icon_y+icon_h*70/100)) L $((icon_x+icon_w*78/100)) $((icon_y+icon_h*40/100)) L $((icon_x+icon_w)) $((icon_y+icon_h*88/100))" stroke-linejoin="round" stroke-linecap="round"/>
  </g>
</svg>
SVG
}

# Destinations — colours drawn from the approved VM2026-27 brand palette
make_svg assets/images/destinations/kuala-lumpur.svg "Kuala Lumpur" "" "#223F99" "#213E7C"
make_svg assets/images/destinations/penang.svg "Penang" "" "#E21F26" "#CA2029"
make_svg assets/images/destinations/langkawi.svg "Langkawi" "" "#03B1A8" "#087D77"
make_svg assets/images/destinations/malacca.svg "Malacca" "" "#FBBE14" "#B8850D"
make_svg assets/images/destinations/kota-kinabalu.svg "Kota Kinabalu" "" "#087D77" "#213E7C"
make_svg assets/images/destinations/perhentian-islands.svg "Perhentian Islands" "" "#03B1A8" "#213E7C"
make_svg assets/images/destinations/cameron-highlands.svg "Cameron Highlands" "" "#8EC440" "#638B2E"
make_svg assets/images/destinations/kuching-bako.svg "Kuching & Bako" "" "#638B2E" "#4D256B"
make_svg assets/images/destinations/taman-negara.svg "Taman Negara" "" "#8EC440" "#213E7C"
make_svg assets/images/destinations/sabah.svg "Sabah" "" "#4D256B" "#087D77"

# Packages (reuse destination themes)
make_svg assets/images/packages/kuala-lumpur-city-escape.svg "KL City Escape" "" "#223F99" "#213E7C"
make_svg assets/images/packages/langkawi-island-retreat.svg "Langkawi Retreat" "" "#03B1A8" "#087D77"
make_svg assets/images/packages/malaysia-highlights.svg "Malaysia Highlights" "" "#FBBE14" "#B8850D"
make_svg assets/images/packages/kl-langkawi.svg "KL + Langkawi" "" "#E21F26" "#223F99"
make_svg assets/images/packages/family-malaysia.svg "Family Malaysia" "" "#8EC440" "#638B2E"

# Experiences
make_svg assets/images/experiences/nature.svg "Nature & Wildlife" "" "#8EC440" "#638B2E"
make_svg assets/images/experiences/islands.svg "Beaches & Islands" "" "#03B1A8" "#087D77"
make_svg assets/images/experiences/culture.svg "Culture & Heritage" "" "#E21F26" "#CA2029"
make_svg assets/images/experiences/food.svg "Food & Gastronomy" "" "#FBBE14" "#B8850D"
make_svg assets/images/experiences/adventure.svg "Adventure" "" "#223F99" "#213E7C"
make_svg assets/images/experiences/city.svg "City Experiences" "" "#66308D" "#4D256B"

# Offers
make_svg assets/images/offers/offer-1.svg "Langkawi Beach Resort" "" "#03B1A8" "#087D77" 1000 700
make_svg assets/images/offers/offer-2.svg "KL Luxury Suites" "" "#223F99" "#213E7C" 1000 700
make_svg assets/images/offers/offer-3.svg "Penang Heritage Hotel" "" "#E21F26" "#CA2029" 1000 700
make_svg assets/images/offers/offer-4.svg "Cameron Highlands Lodge" "" "#8EC440" "#638B2E" 1000 700

# Hero / misc
make_svg assets/images/misc/hero-poster.svg "Truly Asia" "" "#213E7C" "#E21F26" 1920 1080
make_svg assets/images/misc/hero-poster-mobile.svg "Truly Asia" "" "#213E7C" "#E21F26" 800 1400
make_svg assets/images/misc/intro-collage-1.svg "Rainforest Canopy" "" "#8EC440" "#638B2E" 900 1100
make_svg assets/images/misc/intro-collage-2.svg "Petronas Towers" "" "#223F99" "#213E7C" 900 700
make_svg assets/images/misc/intro-collage-3.svg "Island Coastline" "" "#03B1A8" "#087D77" 700 900
make_svg assets/images/misc/why-malaysia.svg "Malaysia is Calling" "" "#CA2029" "#213E7C" 1920 1000
make_svg assets/images/misc/final-cta.svg "Start Your Journey" "" "#213E7C" "#B8850D" 1920 1000
make_svg assets/images/misc/contact-hero.svg "Plan Your Trip" "" "#223F99" "#213E7C" 1920 800
make_svg assets/images/misc/experiences-hero.svg "Experience Malaysia" "" "#03B1A8" "#4D256B" 1920 800
make_svg assets/images/misc/attractions-hero.svg "Explore Malaysia" "" "#638B2E" "#213E7C" 1920 800
make_svg assets/images/misc/packages-hero.svg "Curated Journeys" "" "#FBBE14" "#CA2029" 1920 800

echo "Placeholders generated."
