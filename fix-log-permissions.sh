#!/bin/bash

# Script untuk fix permission file log
# Jalankan sebagai root atau dengan sudo

LOG_DIR="/var/www/kartika/storage/logs"

# Ubah ownership semua file log ke www-data
chown -R www-data:www-data "$LOG_DIR"

# Set permission directory
chmod 775 "$LOG_DIR"

# Set permission semua file log
find "$LOG_DIR" -type f -name "*.log" -exec chmod 664 {} \;

echo "Log permissions fixed successfully!"
