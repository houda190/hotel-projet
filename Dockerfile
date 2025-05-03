# نستخدم صورة PHP رسمية
FROM php:8.1-apache

# ننسخ جميع الملفات للمجلد داخل السيرفر
COPY . /var/www/html/

# نتيقن أن Apache يقدر يقرا الملفات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# نفتح البورت 80 (الافتراضي)
EXPOSE 80
