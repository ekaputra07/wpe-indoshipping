=== WPE Indoshipping ===
Contributors: ekaputra07
Tags: wp e-commerce, shipping plugin, Indonesian Shipping plugin, JNE shipping, TIKI shipping
Requires at least: 2.8
Tested up to: 3.5.1
Stable tag: 2.5.0

Plugin shipping Indonesia yang khusus untuk diintegrasikan dengan plugin WP-Ecommerce.

== Description ==

**Terakhir di test pada WP-Ecommerce versi 3.8.11.1**

Dengan **WPE Indoshipping** maka anda dapat menampilkan daftar ongkos kirim per daerah di Indonesia yang anda pilih.

Cocok digunakan untuk menampilkan daftar ongkos kirim dari JNE, TIKI atau yang lainnya dan secara langsung akan berpengaruh pada nilai order anda.

**[Laporkan Bug dan support](http://balitechy.com/wp-plugins/wp-ecommerce-indoshipping/)**

**[Ingin kembangkan lebih lanjut?](https://github.com/ekaputra07/wpe-indoshipping)**

== Installation ==

Proses instalasi sangatlah mudah, sama dengan melakukkan instalasi plugin WordPress lainnya.

1. Plugin ini adalah sebuah modul shipping dari [WP E-Commerce](http://wordpress.org/extend/plugins/wp-e-commerce/), maka sebelum plugin ini diinstall, plugin WP E-commerce harus sudah terinstall terlebih dahulu.

2. Instalasi dapat dilakukan dengan 2 cara:

- cara yang pertama adalah dengan langsung melalui plugin installer WordPress, plugin ini sudah terdapat di repository plugin WordPress.org jadi bisa langsung diinstall. -

- Cara ke-dua adalah dengan mendownload plugin ini terlebih dahulu, setelah itu bisa diupload ke directory /wp-content/plugins/, setelah itu tinggal diaktifkan dari plugin manager WordPress.

3. Setelah terinstall dan aktif, masuk ke bagian setting Shipping WP E-commerce, dan centang Nama shipping ini untuk mengintegrasikannya dengan WP e-commerce.

4. Jangan lupa untuk mengganti nama Shipping sesuai dengan Jasa pengiriman yang anda pakai.

== Frequently Asked Questions ==

= Sudah saya install, knapa ga muncul di halaman checkout? =
Pastikan Enable shipping sudah dicentang di halaman setting wp e-commerce.

= Apakah plugin ini bisa jalan apa Javascript di browser saya dimatikan/disable? =
Maaf, plugin ini mutlak memerlukan javascript.

== Changelog ==

= 2.5.0 =
* Hanys support CSV Import
* PHP import sudah tidak digunakan lagi
* Few fixes and tweaks (Thanks to Dimas Tarich W)

= 2.0.0 =
* Data shipping tersimpan di database
* Terdapat DB importer untuk mengimport data shipping dari plugin sebelumnya
* Support multi shipping, bisa dipadukan dengan plugin shipping lainnya

= 1.4.0 =
* Sudah bisa dipergunakan bersamaan dengan metode shipping lain
* Style bawaan plugin dihilangkan.
* Daftar Provinsi dan Kota sekarang sudah ditampilkan secara berurutan berdasarkan nama.

= 1.3.1 =
* Bug fixed - Nilai shipping tidak otomatis saat kota muncul
* Bug fixed - default ongkir tidak 0

= 1.3.0 =
* Menggunakan 2 dropdown untuk memilih provinsi dan kota
* Tidak perlu load daftar shipping yang panjang kebawah

= 1.2.1 =
* Bug fixed, Ketika harga di klik, shipping belum berubah.

= 1.2.0 =
* Display stabil di semua browser.
* Metode baru search propinsi, berbasis Javascript, dijamin lebih cepat tanpa load halaman berulang kali.

= 1.0.1 =
* Fixed bug, menghitung otomatis Ongkir diatas 1 Kg
* Default province featured removed

= 1.0 =
* Initial Release
* Database harga dan daerah berupa file PHP.

== Upgrade Notice ==

= 2.5.0 =
Pada versi 2.5 ini import file PHP sudah tidak digunakan lagi, sekarang sudah tersedia import file CSV. 
Tidak ada perubahan dalam database, jadi ketika sebelumnya sudah menggunakan wpe-indoshipping, maka cukup update plugin saja.

= 2.0.0 =
Sebelum melakukkan update, ambil file daerah.db.php dari plugin sebelum nya, karena akan diperlukan untuk diimport ke plugin
versi ini. Ini artinya anda tidak perlu mengulang lagi memasukkan data shipping, tinggal import saja.

= 1.2.1 =
Segera upgrade ke versi ini, bug pada versi 1.2.0 sudah diperbaiki.

= 1.2.1 =
Segera upgrade ke versi ini, bug pada versi 1.2.0 sudah diperbaiki.

= 1.2.0 =
Dalam versi ini terdapat bug pada nilai shipping.

