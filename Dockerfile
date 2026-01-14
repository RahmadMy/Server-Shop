# Gunakan PHP 8.5 CLI image
FROM php:8.5-cli

# Install PDO dan PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /app

# Copy semua file project ke container
COPY . /app

# Expose port Railway (PORT akan di-set otomatis)
EXPOSE 8080

# Jalankan PHP built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]
