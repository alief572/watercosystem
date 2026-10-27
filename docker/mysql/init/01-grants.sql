-- Pastikan user alief memiliki hak akses penuh ke seluruh database (termasuk gl_waterco dan database lainnya)
GRANT ALL PRIVILEGES ON *.* TO 'alief'@'%';
FLUSH PRIVILEGES;
