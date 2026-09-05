#!/bin/bash
# Processes additional attraction-specific campaign photography into gallery
# images for the destination pages. Same safe-band crop (24% top / 20%
# bottom removed) as process-media.sh, to strip the baked-in Visit Malaysia
# logo/caption overlay present on every "creative batch" source JPEG.
set -e
cd "$(dirname "$0")/.."
OUT="assets/images/optimized"
mkdir -p "$OUT"

proc () {
  src="$1"; name="$2"; maxw="$3"
  tmp="$OUT/.tmp-$name.miff"
  dims=$(magick identify -format "%wx%h" "$src")
  w=$(echo "$dims" | cut -dx -f1)
  h=$(echo "$dims" | cut -dx -f2)
  topcut=$(( h * 27 / 100 ))
  botcut=$(( h * 20 / 100 ))
  cropH=$(( h - topcut - botcut ))
  magick "$src" -colorspace sRGB -crop "${w}x${cropH}+0+${topcut}" +repage "$tmp"
  magick "$tmp" -resize "${maxw}x>" -quality 84 "$OUT/$name.webp"
  magick "$tmp" -resize "${maxw}x>" -quality 84 "$OUT/$name.jpg"
  rm -f "$tmp"
  echo "done: $name"
}

SRC_ROOT="/d/1/malaysia/1/images"
B1="$SRC_ROOT/VM 1ST BATCH CREATIVE"
B2="$SRC_ROOT/VM 2nd  BATCH CREATIVE"
B4="$SRC_ROOT/VM 4th  BATCH CREATIVE"
B3="$SRC_ROOT/VM 3rd  BATCH CREATIVE"

# ---------------- Kuala Lumpur ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_BATU CAVES_SELANGOR_1_A4_HORIZONTAL.jpg" "gal-kuala-lumpur-1" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_RIVER OF LIFE_KL_A4_HORIZONTAL.jpg" "gal-kuala-lumpur-2" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_SALOMA BRIDGE_KL_A4_HORIZONTAL.jpg" "gal-kuala-lumpur-3" 1000

# ---------------- Penang ----------------
proc "$B1/horizontal/JPEG/VM2026_HERITAGE_BECA PENANG_1_A4_HORIZONTAL.jpg" "gal-penang-1" 1000
proc "$B2/horizontal/JPG/VM2026_ADVENTURE_NATURE_THEHABITAT_PENANG_A4_HORIZONTAL.jpg" "gal-penang-2" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_BRIDGE_PENANG_A4_HORIZONTAL.jpg" "gal-penang-3" 1000

# ---------------- Langkawi ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_SKYBRIDGE_LANGKAWI_2_A4_HORIZONTAL.jpg" "gal-langkawi-1" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_PANTAI CENANG_LANGKAWI_A4_HORIZONTAL.jpg" "gal-langkawi-2" 1000
proc "$B2/horizontal/JPG/VM2026_ISLAND&BEACHES_TG RHU_LANGKAWI_A4_HORIZONTAL.jpg" "gal-langkawi-3" 1000

# ---------------- Malacca ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_MASJID SELAT_MELAKA_2_A4_HORIZONTAL.jpg" "gal-malacca-1" 1000
proc "$B1/horizontal/JPEG/VM2026_HERITAGE_MELAKA_RIVERCRUISE_A4_HORIZONTAL.jpg" "gal-malacca-2" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_KAMPUNG PARIT PENGHULU_MELAKA_A4_HORIZONTAL.jpg" "gal-malacca-3" 1000

# ---------------- Kota Kinabalu ----------------
proc "$B3/JPEG/SABAH/VM2026_KOTA KINABALU _SABAH_A4_VERTICAL.jpg" "gal-kota-kinabalu-1" 800

# ---------------- Cameron Highlands ----------------
proc "$B1/horizontal/JPEG/VM2026_HIGHLAND_CAMERON_1_A4_HORIZONTAL.jpg" "gal-cameron-highlands-1" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_MOSSY FOREST_PAHANG_A4_HORIZONTAL.jpg" "gal-cameron-highlands-2" 1000

# ---------------- Kuching & Bako ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_PROBOSCIS MONKEY_2_A4_HORIZONTAL.jpg" "gal-kuching-bako-1" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_SARAWAK CULTURAL VILLAGE_A4_HORIZONTAL.jpg" "gal-kuching-bako-2" 1000

# ---------------- Taman Negara ----------------
proc "$B3/PAHANG/VM2026_TAMAN NEGARA_PAHANG_A4_VERTICAL.jpg" "gal-taman-negara-1" 800

# ---------------- Sabah ----------------
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_MOUNT KINABALU_SABAH_2_A4_HORIZONTAL.jpg" "gal-sabah-1" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_SIPADAN ISLAND_SABAH_1_A4_HORIZONTAL.jpg" "gal-sabah-2" 1000
proc "$B4/horizontal/JPEG-20260903T095043Z-1-001/JPEG/VM2026_ORANGUTAN_A4_1_HORIZONTAL.jpg" "gal-sabah-3" 1000

echo "ALL DONE"
