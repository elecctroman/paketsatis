# PaketSatis - Kurumsal SMM Paket Satış Platformu

Bu proje, paylaşımlı cPanel ortamlarında Laravel gibi framework'lere ihtiyaç duymadan çalışacak şekilde tasarlanmış kurumsal bir SMM paket satış yazılımıdır.

## Özellikler
- Tek giriş noktası (Front Controller) ile yönlendirme.
- Bootstrap 5 tabanlı vitrın ve yönetim arayüzü.
- iyzico & PayTR ödeme servisleri için mock entegrasyon sınıfları.
- Kurulum sihirbazı (`public/installer.php`) ile otomatik veritabanı kurulumu ve yapılandırma.
- Cron görevleri için `cli/schedule.php` ve örnek işler.
- RBAC, CSRF koruması, HTML sanitize, audit log altyapısı.

## Kurulum
1. Paketi sunucunuza yükleyip zip'ten çıkarın. Web root `public/` klasörüne işaret etmelidir.
2. Tarayıcıdan `https://alanadiniz.com/installer.php` adresine gidin.
3. Veritabanı bilgilerinizi, site adını ve yönetici kullanıcı bilgilerini girin.
4. Kurulum tamamlandığında admin paneline giriş yapabilirsiniz.

### Cron Ayarı
```
* * * * * /usr/local/bin/php /home/CPANEL_USER/public_html/cli/schedule.php >> /dev/null 2>&1
```

### Gerekli PHP Uzantıları
- pdo_mysql
- mbstring
- intl
- gd
- fileinfo
- curl
- openssl

## Test Verileri
Kurulum sırasında oluşturulan admin kullanıcısı varsayılan olarak `admin@example.com` / `Admin123!` bilgileriyledir (kurulumda değiştirilebilir).

## Güvenlik Notları
- Tüm formlarda CSRF token kullanımı mevcuttur.
- HTML içerikleri beyaz liste ile sanitize edilir.
- Şifreler `password_hash` ile saklanır.
- Rate limit yapılandırması config içerisinden yönetilir.

## Geliştirme
- Kodlar `app/`, `core/`, `cli/` gibi klasörlere ayrılmıştır.
- Özel autoloader `core/Autoloader.php` içindedir.
- Veritabanı bağlantısı `core/DB.php` üzerinden yapılır.

## Lisans
Bu proje örnek amaçlıdır.
