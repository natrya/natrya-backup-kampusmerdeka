# Tentang script ini

script ini membantu mentor kampus merdeka untuk melakukan backup ke file excell terhadap apa yang sudah ditulis. sampai saat ini masih teruji untuk program Studi Independen Bersertifikat. 

script ini menggunakan bash dan php {php-curl}
masih banyak ruang untuk berkolaborasi, yuk gass.

## cara install
install PHP dan git di komputer dan mendukung bash script (optional)

PHP module yang dibutuhkan

bcmath
bz2
calendar
Core
ctype
curl
date
dba
dom
exif
FFI
fileinfo
filter
ftp
gd
gettext
gmp
hash
iconv
intl
json
ldap
libxml
mbstring
mysqli
mysqlnd
odbc
openssl
pcntl
pcre
PDO
pdo_dblib
pdo_mysql
PDO_ODBC
pdo_pgsql
pdo_sqlite
pgsql
Phar
phpdbg_webhelper
posix
pspell
readline
Reflection
session
shmop
SimpleXML
soap
sockets
sodium
SPL
sqlite3
standard
sysvmsg
sysvsem
sysvshm
tidy
tokenizer
xml
xmlreader
xmlwriter
xsl
zip
zlib

clone repository

```bash
git clone https://github.com/natrya/natrya-backup-kampusmerdeka.git
```

install library php yang dibutuhkan dengan 

```bash
composer install
```

kalau di windows

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

### set env variabel di linux/macOS untuk login di kampus merdeka

```bash
export MERDEKAUN=email@kampusmerdeka
export MERDEKAPSS=passwordnya
```

### set env variabel di windows 

```bash
set MERDEKAUN=email@kampusmerdeka
set MERDEKAPSS=passwordnya
```

### membuat backup ke file rangkuman.xls 
jalankan dengan bash untuk linux/macOS

```bash
sh rekap.sh
```

jalankan dengan batch file untuk windows

```bash
rekap.bat
```
jika tidak ada bash bisa menggunakan manual, pastikan sudah setting variabel seperti diatas

```bash
php login.php
php daftarmentee.php
php rekap-monthly-logs.php
php rekap-initial-assessment.php
php rekap-final-assessment.php
php rekap-mhs-weekly.php
```

akan ada file baru bernama rangkuman.xls yang berisi informasi dari website mentor.kampusmerdeka.kemdikbud.go.id

### rekap weekly report yang belum diisi
untuk mendapatkan rekap weekly report yang belum di isi oleh setiap mentee dengan cara sebagai berikut

```bash
php weekly-reminder.php
```

contoh hasilnya

```bash
MAWADDAH MAULIDIYAH WANDASARI kurang 1
Dewi Aurellia Destiana kurang 6
MUNAWAROH kurang 6
Krisya Nurul Khoiriyah kurang 9
FAYOLA LIYANI kurang 6
Sabrina heryanti suryandari kurang 13
MUHAMMAD ULUL ARHAM AL HIKAMI kurang 16
Pradita Ramadhani Putri kurang 15
Muhammad Nadir Raihan kurang 9
Petrus Perlindungan Zai kurang 1
LAYLA NOVIA RAHMAH kurang 4
Siti Rahma Saputri Ningsih kurang 1
Dina Destya Rohmah kurang 2
RARASANTI RANIA QODRI kurang 1
Pramitha Ayu Ningtyas kurang 5
Melati Khatulistiwa kurang 16
CLEMENTINO BRAMEDSA kurang 14
SARI INDAHYANI kurang 6
RARA ENDAH CAHYARANI kurang 1
TSALISA FEBRIANA ZIYADATUR RAHMAH kurang 14
NUR WAHYUDIMAS PUTRA kurang 1
DEDY AUFANSYAH PUTRA kurang 10
KHIFDHIYA SYARIFA AGUSTINA kurang 1
DEDY YUSUF kurang 16
Muhammad Nizamuddin Aulia kurang 3
```


### rekap weekly report yang belum direview
untuk mendapatkan rekap weekly report khusus mentor yang belum di review dengan cara sebagai berikut

```bash
php weekly-reminder-mentor.php
```

contoh hasilnya 

```bash
MAWADDAH MAULIDIYAH WANDASARI kurang 1 belumrev 0
Dewi Aurellia Destiana kurang 6 belumrev 0
MUNAWAROH kurang 6 belumrev 0
Krisya Nurul Khoiriyah kurang 9 belumrev 1
FAYOLA LIYANI kurang 6 belumrev 0
Sabrina heryanti suryandari kurang 13 belumrev 0
MUHAMMAD ULUL ARHAM AL HIKAMI kurang 16 belumrev 0
Pradita Ramadhani Putri kurang 15 belumrev 1
Muhammad Nadir Raihan kurang 9 belumrev 0
Petrus Perlindungan Zai kurang 1 belumrev 0
LAYLA NOVIA RAHMAH kurang 4 belumrev 1
Siti Rahma Saputri Ningsih kurang 1 belumrev 0
Dina Destya Rohmah kurang 2 belumrev 0
RARASANTI RANIA QODRI kurang 1 belumrev 0
Pramitha Ayu Ningtyas kurang 5 belumrev 0
Melati Khatulistiwa kurang 16 belumrev 0
CLEMENTINO BRAMEDSA kurang 14 belumrev 1
SARI INDAHYANI kurang 6 belumrev 0
RARA ENDAH CAHYARANI kurang 1 belumrev 0
TSALISA FEBRIANA ZIYADATUR RAHMAH kurang 14 belumrev 0
NUR WAHYUDIMAS PUTRA kurang 1 belumrev 0
DEDY AUFANSYAH PUTRA kurang 10 belumrev 0
KHIFDHIYA SYARIFA AGUSTINA kurang 1 belumrev 0
DEDY YUSUF kurang 16 belumrev 0
Muhammad Nizamuddin Aulia kurang 3 belumrev 2
```

### autoconfirm untuk weekly report 
untuk melakukan autoconfirm weekly report

```bash
php autoconfirm.php
```

contoh hasilnya

```bash
autoconfirm Krisya Nurul Khoiriyah
autoconfirm Pradita Ramadhani Putri
autoconfirm Pramitha Ayu Ningtyas
autoconfirm CLEMENTINO BRAMEDSA
autoconfirm Muhammad Nizamuddin Aulia
```

### Rekap weekly report mahasiswa 
untuk melakukan rekap weekly report mahasiswa ke excel, 
apabila dilakukan berulang maka worksheet akan dihapus kemudian dibuat lagi 

```bash
php rekap-mhs-weekly.php
```
