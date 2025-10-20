FROM php:8.3-apache

# Instala dependencias del sistema y SSH
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    npm \
    openssh-server

# Instala extensiones de PHP requeridas por Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copia el código de la aplicación
WORKDIR /var/www/html
COPY . .

# Instala dependencias de PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Instala dependencias de Node y genera el build de assets (si usas Vite)
RUN npm install && npm run build

# Da permisos a la carpeta de almacenamiento y cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Configura Apache para Laravel
RUN a2enmod rewrite
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Configura SSH
RUN echo 'root:root' | chpasswd
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# Expone el puerto 80 para Apache y el 22 para SSH
EXPOSE 80 22

# Inicia tanto Apache como SSH
CMD service ssh start && apache2-foreground