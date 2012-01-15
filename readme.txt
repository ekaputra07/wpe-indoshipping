=== WPE Indoshipping ===
Contributors: ekaputra07
Tags: wp e-commerce, shipping plugin, Indonesian Shipping plugin, JNE shipping, TIKI shipping
Requires at least: 2.8
Tested up to: 3.1.4
Stable tag: 1.3.1

Plugin shipping Indonesia yang khusus untuk diintegrasikan dengan plugin WP-Ecommerce.

== Description ==

Dengan **WPE Indoshipping** maka anda dapat menampilkan daftar ongkos kirim per daerah di Indonesia yang anda pilih.

Cocok digunakan untuk menampilkan daftar ongkos kirim dari JNE, TIKI atau yang lainnya dan secara langsung akan berpengaruh pada nilai order anda.

Database harga hanya menggunakan file PHP untuk menyimpan daftar harga dan daerahnya, pengeditan harga dan nama daerah harus dilakukkan secara manual melalui plugin editor
atau menggunakan FTP.

**[Tersedia versi PRO - more features, more powerful](http://balitechy.com/wp-plugins/wpe-indoshipping-pro/)**

**[Laporkan Bug dan support](http://balitechy.com/wp-plugins/wp-ecommerce-indoshipping/)**

== Installation ==

Proses instalasi sangatlah mudah, sama dengan melakukkan instalasi plugin WordPress lainnya.

1. Plugin ini adalah sebuah modul shipping dari [WP E-Commerce](http://wordpress.org/extend/plugins/wp-e-commerce/), maka sebelum plugin ini diinstall, plugin WP E-commerce harus sudah terinstall terlebih dahulu.

2. Instalasi dapat dilakukan dengan 2 cara:

- cara yang pertama adalah dengan langsung melalui plugin installer WordPress, plugin ini sudah terdapat di repository plugin WordPress.org jadi bisa langsung diinstall. -

- Cara ke-dua adalah dengan mendownload plugin ini terlebih dahulu, setelah itu bisa diupload ke directory /wp-content/plugins/, setelah itu tinggal diaktifkan dari plugin manager WordPress.

3. Setelah terinstall dan aktif, masuk ke bagian setting Shipping WP E-commerce, dan centang Nama shipping ini untuk mengintegrasikannya dengan WP e-commerce.

4. Jangan lupa untuk mengganti nama Shipping sesuai dengan Jasa pengiriman yang anda pakai.

**PERHATIAN :
Plugin ini hanya akan berfungsi dengan baik apabila modul shipping ini diaktifkan sendiri. Modul shipping lain harap jangan diaktifkan.**

== Frequently Asked Questions ==

= Sudah saya install, knapa ga muncul di halaman checkout? =
Pastikan Enable shipping sudah dicentang di halaman setting wp e-commerce.

= Sudah mau muncul di halaman checkout, knapa formnya juga muncul di modul shipping lain? =
Seperti yang sudah dijelaskan pada bagian instalasi diatas, diharapkan sekali modul shipping yang aktif hanyalah satu, yaitu WPE indoshipping ini.
Karena wp e-commerce memiliki cara khusus untuk menampilkan ongkos kirim, sedangkan untuk memanipulasi tampilan ongkos kirim per daerah/propinsi maka satu-satunya cara adalah dengan memanipulasi DOM dengan memasukkan form dengan Javascript.

= Apakah plugin ini bisa jalan apa Javascript di browser saya dimatikan/disable? =
Maaf, plugin ini mutlak memerlukan javascript.

== Changelog ==

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

= 1.2.1 =
Segera upgrade ke versi ini, bug pada versi 1.2.0 sudah diperbaiki.

= 1.2.1 =
Segera upgrade ke versi ini, bug pada versi 1.2.0 sudah diperbaiki.

= 1.2.0 =
Dalam versi ini terdapat bug pada nilai shipping.

