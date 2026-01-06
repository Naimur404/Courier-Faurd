#!/bin/bash

# PWA Icon Generator Script
# This script generates all required PWA icon sizes from the source favicon

SOURCE_IMAGE="../favicon.png"
OUTPUT_DIR="."

# Check if source image exists
if [ ! -f "$SOURCE_IMAGE" ]; then
    echo "Error: Source image $SOURCE_IMAGE not found!"
    echo "Please ensure favicon.png exists in public/assets/"
    exit 1
fi

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null; then
    echo "ImageMagick is required but not installed."
    echo "Install it with: brew install imagemagick"
    exit 1
fi

# Icon sizes required for PWA
SIZES=(72 96 128 144 152 192 384 512)

echo "🎨 Generating PWA icons..."

for size in "${SIZES[@]}"; do
    output_file="${OUTPUT_DIR}/icon-${size}x${size}.png"
    echo "  Creating ${size}x${size}..."
    convert "$SOURCE_IMAGE" -resize ${size}x${size} -background transparent -gravity center -extent ${size}x${size} "$output_file"
done

# Generate maskable icon (with padding for safe zone)
echo "  Creating maskable icon 512x512..."
convert "$SOURCE_IMAGE" -resize 400x400 -background "#4f46e5" -gravity center -extent 512x512 "${OUTPUT_DIR}/maskable-icon-512x512.png"

echo "✅ PWA icons generated successfully!"
echo ""
echo "Icons created:"
ls -la *.png
