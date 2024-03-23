# AHP (Analytical Hierarchy Process) 

AHP merupakan suatu model pendukung keputusan
dikembangkan oleh Thomas L. Saaty. Model pendukung keputusan ini
akan menguraikan masalah multi factor atau multi kriteria yang
kompleks menjadi suatu hirarki, menurut Saaty (1993), hirarki
didefinisikan sebagai suatu representasi dari sebuah permasalahan
yang kompleks dalam suatu struktur multi level dimana level pertama
adalah tujuan, yang diikuti level faktor, kriteria, sub kriteria, dan
seterusnya ke bawah hingga level terakhir dari alternatif. Dengan
hirarki, suatu masalah yang kompleks dapat diuraikan ke dalam
kelompok-kelompoknya yang kemudian diatur menjadi suatu bentuk
hirarki sehingga permasalahan akan tampak lebih terstruktur dan
sistematis.

AHP sering digunakan sebagai metode pemecahan masalah
dibanding dengan metode yang lain karena alasan-alasan sebagai
berikut :
a. Struktur yang berhirarki, sebagai konsekuesi dari kriteria yang
dipilih, sampai pada subkriteria yang paling dalam.
b. Memperhitungkan validitas sampai dengan batas toleransi
inkonsistensi berbagai kriteria dan alternatif yang dipilih oleh
pengambil keputusan.
c. Memperhitungkan daya tahan output analisis sensitivitas
pengambilan keputusan.

Kelebihan dan Kelemahan AHP
Layaknya sebuah metode analisis, AHP pun memiliki kelebihan
dan kelemahan dalam system analisisnya. Kelebihan-kelebihan
analisis ini adalah :
- Kesatuan (Unity)
AHP membuat permasalahan yang luas dan tidak terstruktur
menjadi suatu model yang fleksibel dan mudah dipahami.
12
- Kompleksitas (Complexity)
AHP memecahkan permasalahan yang kompleks melalui
pendekatan sistem dan pengintegrasian secara deduktif.
- Saling ketergantungan (Inter Dependence)
AHP dapat digunakan pada elemen-elemen sistem yang saling
bebas dan tidak memerlukan hubungan linier.
- Struktur Hirarki (Hierarchy Structuring)
AHP mewakili pemikiran alamiah yang cenderung
mengelompokkan elemen sistem ke level-level yang berbeda dari
masing-masing level berisi elemen yang serupa.
- Pengukuran (Measurement)
AHP menyediakan skala pengukuran dan metode untuk
mendapatkan prioritas.
- Konsistensi (Consistency)
AHP mempertimbangkan konsistensi logis dalam penilaian yang
digunakan untuk menentukan prioritas.
- Sintesis (Synthesis)
AHP mengarah pada perkiraan keseluruhan mengenai seberapa
diinginkannya masing-masing alternatif.
- Trade Off
AHP mempertimbangkan prioritas relatif faktor-faktor pada
sistem sehingga orang mampu memilih altenatif terbaik berdasarkan
tujuan mereka.
- Penilaian dan Konsensus (Judgement and Consensus)
AHP tidak mengharuskan adanya suatu konsensus, tapi
menggabungkan hasil penilaian yang berbeda.
- Pengulangan Proses (Process Repetition)
AHP mampu membuat orang menyaring definisi dari suatu
permasalahan dan mengembangkan penilaian serta pengertian
mereka melalui proses pengulangan.

# Matrix Perbandingan Kriteria (Criteria Comparison Matrix):

- Matriks ini digunakan untuk membandingkan setiap kriteria satu sama lain untuk menentukan tingkat kepentingan relatif dari setiap kriteria.
Pada project ini, matriks perbandingan digunakan untuk membandingkan kepentingan relatif dari KEPRIBADIAN DAN PERILAKU, PRESTASI DAN HASIL KERJA, dan PROSES KERJA.

- Consistency Ratio (CR):
CR digunakan untuk memeriksa konsistensi matriks perbandingan kriteria.
Nilai CR yang rendah menunjukkan bahwa matriks perbandingan kriteria konsisten dan dapat diandalkan.

- Eigenvalue :
Eigenvalue adalah nilai penting yang menunjukkan seberapa pentingnya suatu kriteria dalam konteks perbandingan.

- Eigenvector : 
Eigenvector adalah vektor yang menunjukkan bobot relatif dari setiap kriteria.
Perhitungan Nilai Index Random (IR):

- IR digunakan sebagai acuan untuk mengevaluasi konsistensi perbandingan dalam matriks.
Nilai IR berbeda tergantung pada jumlah kriteria yang dibandingkan.

# Perhitungan  Kriteria

1. Membuat Matriks Perbandingan Kriteria:
Identifikasi kriteria yang akan dibandingkan.
Berikan nilai perbandingan relatif antara kriteria menggunakan skala 1-9, di mana:

1 = Kedua elemen sama pentingnya.
3 = Satu elemen sedikit lebih penting dari yang lain.
5 = Satu elemen jelas lebih penting dari yang lain.
7 = Satu elemen jelas jauh lebih penting dari yang lain.
9 = Satu elemen mutlak lebih penting dari yang lain.
2, 4, 6, 8 = Nilai-nilai antara dua nilai berdekatan.

Contoh matriks perbandingan untuk 3 kriteria:

- 1   3   5
- 1/3  1   4
- 1/5  1/4 1

2. Normalisasi Matriks Perbandingan:
Untuk setiap kolom, bagi setiap elemen dengan jumlah semua elemen dalam kolom tersebut.
Contoh normalisasi matriks perbandingan:

- 0.50  0.60  0.56
- 0.17  0.20  0.44
- 0.33  0.20  0.00

3. Menghitung Bobot Kriteria:
Hitung rata-rata dari setiap baris pada matriks normalisasi untuk mendapatkan vektor bobot kriteria.

Contoh:

- Bobot KEPRIBADIAN DAN PERILAKU = (0.50 + 0.60 + 0.56) / 3 = 0.55
- Bobot PRESTASI DAN HASIL KERJA = (0.17 + 0.20 + 0.44) / 3 = 0.27
- Bobot PROSES KERJA = (0.33 + 0.20 + 0.00) / 3 = 0.18

4. Menghitung Konsistensi:
Hitung Nilai Konsistensi (Consistency Ratio, CR) untuk memastikan konsistensi perbandingan.
CR dihitung dengan rumus CR = (CI / IR), di mana CI adalah Indeks Konsistensi dan IR adalah Nilai Indeks Random yang tergantung pada jumlah kriteria.
Jika CR kurang dari 0,1, maka matriks perbandingan dianggap konsisten.

5. Analisis Hasil:
Gunakan bobot kriteria yang dihasilkan untuk pengambilan keputusan.
Semakin tinggi bobot suatu kriteria, semakin penting kriteria tersebut dalam proses pengambilan keputusan.

Dalam perhitungan subkriteria pada metode AHP, langkah-langkahnya mirip dengan perhitungan kriteria, namun dilakukan untuk setiap pasangan subkriteria.

Membuat Matriks Perbandingan Subkriteria:

Identifikasi subkriteria yang akan dibandingkan.
Berikan nilai perbandingan relatif antara subkriteria menggunakan skala 1-9, di mana:
1 = Kedua elemen sama pentingnya.
3 = Satu elemen sedikit lebih penting dari yang lain.
5 = Satu elemen jelas lebih penting dari yang lain.
7 = Satu elemen jelas jauh lebih penting dari yang lain.
9 = Satu elemen mutlak lebih penting dari yang lain.
2, 4, 6, 8 = Nilai-nilai antara dua nilai berdekatan.

Normalisasi Matriks Perbandingan:
Bagi setiap elemen dengan jumlah semua elemen dalam kolom tersebut.
Menghitung Bobot Subkriteria:

Hitung rata-rata dari setiap baris pada matriks normalisasi untuk mendapatkan vektor bobot subkriteria.
Menghitung Konsistensi:

Hitung Nilai Konsistensi (CR) untuk memastikan konsistensi perbandingan.
CR dihitung dengan rumus CR = (CI / IR), di mana CI adalah Indeks Konsistensi dan IR adalah Nilai Indeks Random yang tergantung pada jumlah subkriteria.
Jika CR kurang dari 0,1, maka matriks perbandingan dianggap konsisten.
Analisis Hasil:

Gunakan bobot subkriteria yang dihasilkan untuk pengambilan keputusan.
Semakin tinggi bobot suatu subkriteria, semakin penting subkriteria tersebut dalam proses pengambilan keputusan.

# Matrix Perbandingan Subkriteria (Subcriteria Comparison Matrix):
- Matriks ini digunakan untuk membandingkan setiap subkriteria satu sama lain untuk menentukan tingkat kepentingan relatif dari setiap subkriteria

- Consistency Ratio (CR):
CR digunakan untuk memeriksa konsistensi matriks perbandingan subkriteria.
Nilai CR yang rendah menunjukkan bahwa matriks perbandingan subkriteria konsisten dan dapat diandalkan.

- Eigenvalue :
Eigenvalue adalah nilai penting yang menunjukkan seberapa pentingnya suatu subkriteria dalam konteks perbandingan.

- Eigenvector adalah vektor yang menunjukkan bobot relatif dari setiap subkriteria.
Perhitungan Nilai Index Random (IR):

- IR digunakan sebagai acuan untuk mengevaluasi konsistensi perbandingan dalam matriks.
Nilai IR berbeda tergantung pada jumlah subkriteria yang dibandingkan.

# Perhitungan Subkriteria

1. Membuat Matriks Perbandingan Subkriteria:
Anda memberikan nilai perbandingan relatif antara subkriteria menggunakan skala 1-9. Contoh:

Kedisiplinan    Tanggung Jawab    Komunikasi     Antusiasme
1               3                 3              5               -> Kedisiplinan sama penting dengan Tanggung Jawab, Komunikasi, dan Antusiasme
1/3             1                 1              3               -> Tanggung Jawab lebih penting dari Kedisiplinan, Komunikasi, dan Antusiasme
1/3             1                 1              3               -> Komunikasi lebih penting dari Kedisiplinan, Tanggung Jawab, dan Antusiasme
1/5             1/3               1/3            1               -> Antusiasme lebih penting dari Kedisiplinan, Tanggung Jawab, dan Komunikasi


2. Normalisasi Matriks Perbandingan:
Bagi setiap elemen dengan jumlah semua elemen dalam kolom tersebut. Hasilnya menjadi:

Kedisiplinan    Tanggung Jawab    Komunikasi     Antusiasme
0.2500          0.3913            0.3913         0.5556
0.0833          0.1304            0.1304         0.3333
0.0833          0.1304            0.1304         0.3333
0.0500          0.0869            0.0869         0.2222


3. Menghitung Bobot Subkriteria:
Hitung rata-rata dari setiap baris pada matriks normalisasi untuk mendapatkan vektor bobot subkriteria contoh :

Bobot Kedisiplinan = (0.2500 + 0.0833 + 0.0833 + 0.0500) / 4 = 0.1167
Bobot Tanggung Jawab = (0.3913 + 0.1304 + 0.1304 + 0.0869) / 4 = 0.1848
Bobot Komunikasi = (0.3913 + 0.1304 + 0.1304 + 0.0869) / 4 = 0.1848
Bobot Antusiasme = (0.5556 + 0.3333 + 0.3333 + 0.2222) / 4 = 0.3611

4. Menghitung Konsistensi:
Hitung Nilai Konsistensi (CR) untuk memastikan konsistensi perbandingan. Misalnya:

CI = (λmax - n) / (n - 1), di mana n adalah jumlah subkriteria.
IR untuk 3 kriteria adalah 0.58.
CR = CI / IR, jika hasilnya kurang dari 0.1, maka matriks konsisten.

5. Analisis Hasil:
Gunakan bobot kriteria yang dihasilkan untuk pengambilan keputusan.
Semakin tinggi bobot suatu kriteria, semakin penting kriteria tersebut dalam proses pengambilan keputusan.

Dalam perhitungan subkriteria pada metode AHP, langkah-langkahnya mirip dengan perhitungan kriteria, namun dilakukan untuk setiap pasangan subkriteria.

Membuat Matriks Perbandingan Subkriteria:

Identifikasi subkriteria yang akan dibandingkan.
Berikan nilai perbandingan relatif antara subkriteria menggunakan skala 1-9, di mana:
1 = Kedua elemen sama pentingnya.
3 = Satu elemen sedikit lebih penting dari yang lain.
5 = Satu elemen jelas lebih penting dari yang lain.
7 = Satu elemen jelas jauh lebih penting dari yang lain.
9 = Satu elemen mutlak lebih penting dari yang lain.
2, 4, 6, 8 = Nilai-nilai antara dua nilai berdekatan.

Normalisasi Matriks Perbandingan:
Bagi setiap elemen dengan jumlah semua elemen dalam kolom tersebut.

Menghitung Bobot Subkriteria:
Hitung rata-rata dari setiap baris pada matriks normalisasi untuk mendapatkan vektor bobot subkriteria.

Menghitung Konsistensi:
Hitung Nilai Konsistensi (CR) untuk memastikan konsistensi perbandingan.
CR dihitung dengan rumus CR = (CI / IR), di mana CI adalah Indeks Konsistensi dan IR adalah Nilai Indeks Random yang tergantung pada jumlah subkriteria.
Jika CR kurang dari 0,1, maka matriks perbandingan dianggap konsisten.

Analisis Hasil:
Gunakan bobot subkriteria yang dihasilkan untuk pengambilan keputusan.
Semakin tinggi bobot suatu subkriteria, semakin penting subkriteria tersebut dalam proses pengambilan keputusan.


