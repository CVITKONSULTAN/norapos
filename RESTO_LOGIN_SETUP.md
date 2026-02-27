# Setup Landing Page Login untuk resto.grandkartika.com

## 📋 Deskripsi
Landing page login khusus untuk domain **resto.grandkartika.com** dengan desain modern, responsif, dan animasi menarik.

## 🎨 Fitur Landing Page

### Design Features:
- ✨ **Animated Background** - Efek partikel mengambang yang elegan
- 🎭 **Two-Column Layout** - Pembagian kiri (branding) dan kanan (form login)
- 📱 **Fully Responsive** - Otomatis menyesuaikan dengan berbagai ukuran layar
- 🎯 **Modern UI/UX** - Menggunakan gradient warna ungu yang modern
- 💫 **Smooth Animations** - Transisi dan hover effects yang halus
- 🔐 **Secure Form** - Integrated dengan Laravel authentication

### Visual Elements:
- Logo dan branding Grand Kartika Restaurant & Hotel
- Icon utensils (alat makan) sebagai simbol restoran
- Gradient background (ungu ke pink)
- Input fields dengan icon
- Social login buttons (Google & Facebook)
- Remember me checkbox
- Forgot password link
- Register link

## 📁 File yang Dibuat/Dimodifikasi

1. **resources/views/compro/grandkartika/login.blade.php**
   - Landing page login lengkap dengan styling
   - Fully self-contained (CSS & JavaScript inline)
   - Terintegrasi dengan Laravel authentication

2. **routes/web.php**
   - Menambahkan route khusus untuk subdomain resto.grandkartika.com
   - Redirect otomatis ke /home jika sudah login

## 🚀 Cara Penggunaan

### 1. Konfigurasi DNS
Tambahkan A record atau CNAME untuk subdomain:
```
resto.grandkartika.com -> IP Server Anda
```

### 2. Konfigurasi Web Server (Apache/Nginx)

#### Untuk Apache:
Pastikan Virtual Host sudah dikonfigurasi untuk menerima subdomain:
```apache
<VirtualHost *:80>
    ServerName grandkartika.com
    ServerAlias *.grandkartika.com
    DocumentRoot /var/www/norapos/public
    
    <Directory /var/www/norapos/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Untuk Nginx:
```nginx
server {
    listen 80;
    server_name grandkartika.com *.grandkartika.com;
    root /var/www/norapos/public;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 3. Clear Cache Laravel
```bash
cd /var/www/norapos
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 4. Restart Web Server
```bash
# Untuk Apache
sudo systemctl restart apache2

# Untuk Nginx
sudo systemctl restart nginx
```

### 5. Test Akses
Buka browser dan akses:
```
http://resto.grandkartika.com
atau
http://resto.grandkartika.com/login
```

## 🔧 Kustomisasi

### Mengubah Warna Gradient:
Edit bagian CSS di file login.blade.php:
```css
/* Background gradient */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Ubah ke warna lain, contoh: */
background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
```

### Mengubah Logo/Icon:
Ganti icon class di section logo:
```html
<i class="fas fa-utensils"></i>
<!-- Ganti dengan icon lain, contoh: -->
<i class="fas fa-concierge-bell"></i>
```

### Menambahkan Logo Image:
Ganti icon dengan image:
```html
<img src="/path/to/logo.png" alt="Grand Kartika" style="width: 120px;">
```

## 📱 Responsive Breakpoints

- **Desktop**: > 768px (2 kolom)
- **Tablet**: 481px - 768px (1 kolom, show logo)
- **Mobile**: < 480px (1 kolom, compact)

## 🔐 Keamanan

Landing page ini terintegrasi dengan:
- Laravel CSRF Protection
- Laravel Authentication
- Session Management
- Password Encryption

## 🎯 Next Steps (Optional)

### Menambahkan Fitur Tambahan:
1. **Email Verification** - Verifikasi email setelah registrasi
2. **Two-Factor Authentication** - Keamanan berlapis
3. **Login Attempts Limit** - Batasi percobaan login
4. **Activity Log** - Log aktivitas login user
5. **Social Login Integration** - Aktifkan login Google/Facebook

### Contoh Social Login (Google):
```bash
composer require laravel/socialite
```

Kemudian konfigurasi di `config/services.php` dan aktifkan tombol social login.

## 📞 Support

Untuk bantuan atau pertanyaan lebih lanjut:
- Developer: M. Khairudin - IT KONSULTAN
- Email: support@grandkartika.com

## 📝 Changelog

### Version 1.0.0 (27 Februari 2026)
- ✅ Initial release
- ✅ Modern login page dengan animasi
- ✅ Fully responsive design
- ✅ Integrated dengan Laravel auth
- ✅ Route configuration untuk subdomain

---

**© 2026 Grand Kartika Hotel & Restaurant. All rights reserved.**
