#!/bin/bash
# Processes real Visit Malaysia campaign photography into optimized web assets.
#
# The supplied "creative batch" JPEGs are finished print ads with the Visit
# Malaysia logo, a location caption and a "Surreal Experiences!" tagline
# baked into the top/bottom of every frame (confirmed by direct inspection).
# Since our own site overlays its own header/hero text on these same images,
# using them un-cropped would show two competing logos and two competing
# taglines stacked on screen. Measured across multiple sample frames, the
# overlay is always confined to the top ~23% and bottom ~19% of the frame
# (whichever corner the logo sits in), so every "creative" image is run
# through a uniform safe-band crop (24% top / 20% bottom removed) before
# resizing — this reliably removes all overlay elements regardless of which
# corner they're in, while keeping the actual photography intact. Images
# from the "original" source folders are clean stock photography with no
# overlay, so they're resized only, no crop.
#
# CMYK -> sRGB conversion is applied to every source (all "creative" batch
# files are print-production CMYK JPEGs; browsers render CMYK JPEGs
# incorrectly or not at all).
set -e
cd "$(dirname "$0")/.."
OUT="assets/images/optimized"
mkdir -p "$OUT"

# proc <src> <out-basename> <mode: creative|clean> <max-width>
proc () {
  src="$1"; name="$2"; mode="$3"; maxw="$4"
  tmp="$OUT/.tmp-$name.miff"
  if [ "$mode" = "creative" ]; then
    dims=$(magick identify -format "%wx%h" "$src")
    w=$(echo "$dims" | cut -dx -f1)
    h=$(echo "$dims" | cut -dx -f2)
    topcut=$(( h * 24 / 100 ))
    botcut=$(( h * 20 / 100 ))
    cropH=$(( h - topcut - botcut ))
    magick "$src" -colorspace sRGB -crop "${w}x${cropH}+0+${topcut}" +repage "$tmp"
  else
    magick "$src" -colorspace sRGB "$tmp"
  fi
  magick "$tmp" -resize "${maxw}x>" -quality 84 "$OUT/$name.webp"
  magick "$tmp" -resize "${maxw}x>" -quality 84 "$OUT/$name.jpg"
  rm -f "$tmp"
  echo "done: $name"
}

SRC_ROOT="/d/1/malaysia/1/images"
B1="$SRC_ROOT/VM 1ST BATCH CREATIVE"
B2="$SRC_ROOT/VM 2nd  BATCH CREATIVE"
B3="$SRC_ROOT/VM 3rd  BATCH CREATIVE"
B4="$SRC_ROOT/VM 4th  BATCH CREATIVE"

# ---------------- Destinations (hero, reused for cards) ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_KLCC_AERIAL DRONE_KL_1_A4_HORIZONTAL.jpg" "dest-kuala-lumpur" creative 1920
proc "$B1/horizontal/JPEG/VM2026_HERITAGE_BECA PENANG_1_A4_HORIZONTAL.jpg" "dest-penang" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_SKYBRIDGE_LANGKAWI_1_A4_HORIZONTAL.jpg" "dest-langkawi" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_MASJID SELAT_MELAKA_1_A4_HORIZONTAL.jpg" "dest-malacca" creative 1920
proc "$B2/horizontal/JPG/VM2026_CITY_ADVENTURE_KOTA KINABALU_SABAH_A4_HORIZONTAL.jpg" "dest-kota-kinabalu" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_PERHENTIAN ISLAND_TERENGGANU_A4_HORIZONTAL.jpg" "dest-perhentian-islands" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_CAMERON HIGHLANDS_PAHANG_1_A4_HORIZONTAL.jpg" "dest-cameron-highlands" creative 1920
proc "$B4/original/Native/MTPB56020_9229-Padawan - Iban Warrior at Peen Waterfalls.jpg" "dest-kuching-bako" clean 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_TAMAN NEGARA_PAHANG_A4_HORIZONTAL.jpg" "dest-taman-negara" creative 1920
proc "$B4/original/Orangutan/DSC_2490.JPG" "dest-sabah" clean 1920

# ---------------- Packages ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_MERDEKA 118_KL_1_A4_HORIZONTAL.jpg" "pkg-kl-city-escape" creative 1600
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_PANTAI KOK_LANGKAWI_A4_HORIZONTAL.jpg" "pkg-langkawi-retreat" creative 1600
proc "$B1/horizontal/JPEG/VM2026_THEMEPARK_GENTING_A4_HORIZONTAL.jpg" "pkg-malaysia-highlights" creative 1600
proc "$B4/original/Saloma Bridge/MTPB41095_3904-Kuala Lumpur Saloma Bridge 5.jpg" "pkg-kl-langkawi" clean 1600
proc "$B2/horizontal/JPG/VM2026_THEMEPARK_SUNWAY LAGOON_A4_HORIZONTAL.jpg" "pkg-family-malaysia" creative 1600

# ---------------- Experiences (11 distinct) ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_PROBOSCIS MONKEY_A4_HORIZONTAL.jpg" "exp-nature-wildlife" creative 1400
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_LANG TENGAH ISLAND_TERENGGANU_1_A4_HORIZONTAL.jpg" "exp-beaches-islands" creative 1400
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_BATU CAVES_SELANGOR_1_A4_HORIZONTAL.jpg" "exp-culture-heritage" creative 1400
proc "$B1/horizontal/JPEG/VM2026_FOOD_NASI LEMAK_A4_HORIZONTAL.jpg" "exp-food-gastronomy" creative 1400
proc "$B1/horizontal/JPEG/VM2026_CITY ADVENTURE_KLTOWER_JUMP_A4_HORIZONTAL.jpg" "exp-adventure" creative 1400
proc "$B2/horizontal/JPG/VM2026_CITY ADVENTURE_AQUARIA_KL_A4_HORIZONTAL.jpg" "exp-family" creative 1400
proc "$B1/horizontal/JPEG/VM2026_SHOPPING_PAVILLION_A4_HORIZONTAL.jpg" "exp-shopping" creative 1400
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_RIVER OF LIFE_KL_A4_HORIZONTAL.jpg" "exp-city-experiences" creative 1400
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_CAMERON HIGHLANDS_PAHANG_2_A4_HORIZONTAL.jpg" "exp-wellness" creative 1400
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_PANTAI CENANG_LANGKAWI_A4_HORIZONTAL.jpg" "exp-luxury" creative 1400
proc "$B4/new creatives/VM2026_KL_SKYLINE_A4_HORIZONTAL.jpg" "exp-romantic-escapes" creative 1400

# ---------------- Offers ----------------
proc "$B2/horizontal/JPG/VM2026_ISLAND&BEACHES_TG RHU_LANGKAWI_A4_HORIZONTAL.jpg" "offer-langkawi-resort" creative 1200
proc "$B2/horizontal/JPG/VM2026_CITY_NIGHT_KUALA LUMPUR_A4_HORIZONTAL.jpg" "offer-kl-suites" creative 1200
proc "$B1/horizontal/JPEG/VM2026_HERITAGE_BECA PENANG_2_A4_HORIZONTAL.jpg" "offer-penang-hotel" creative 1200
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_CAMERON HIGHLANDS_PAHANG_3_A4_HORIZONTAL.jpg" "offer-cameron-lodge" creative 1200

# ---------------- Misc (homepage / inner-page heroes) ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_MOUNT KINABALU_SABAH_1_A4_HORIZONTAL.jpg" "misc-hero-poster" creative 1920
proc "$B4/vertical/JPEG/VM2026_LANGKAWI_A4_VERTICAL.jpg" "misc-hero-poster-mobile" creative 1200
proc "$B4/vertical/JPEG/VM2026_MOSSY FOREST_PAHANG_A4_VERTICAL.jpg" "misc-intro-collage-1" creative 1000
proc "$B4/vertical/JPEG/VM2026_KLCC_KL_1_A4_VERTICAL.jpg" "misc-intro-collage-2" creative 1000
proc "$B4/vertical/JPEG/VM2026_PERHENTIAN ISLAND_TERENGGANU_A4_VERTICAL.jpg" "misc-intro-collage-3" creative 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_DANUM VALLEY_SABAH_1_A4_HORIZONTAL.jpg" "misc-why-malaysia" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_MOUNT KINABALU_SABAH_2_A4_HORIZONTAL.jpg" "misc-final-cta" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_SARAWAK CULTURAL VILLAGE_A4_HORIZONTAL.jpg" "misc-attractions-hero" creative 1920
proc "$B1/horizontal/JPEG/VM2026_ISLAND&BEACHES_REDANG_TERENGGANU_A4_HORIZONTAL.jpg" "misc-packages-hero" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_WAU_KELANTAN_1_A4_HORIZONTAL.jpg" "misc-experiences-hero" creative 1920
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_TITIWANGSA LAKEGARDEN_KL_A4_HORIZONTAL.jpg" "misc-contact-hero" creative 1920

echo "ALL DONE"
