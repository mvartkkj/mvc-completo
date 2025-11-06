FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP (incluindo GD)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /app

# Copiar arquivos
COPY . .

# Instalar dependências
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Instalar dependências NPM e buildar
RUN npm ci && npm run build

# Cache do Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Permissões
RUN chmod -R 755 storage bootstrap/cache

# Expor porta
EXPOSE 8080

# Comando de start
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}