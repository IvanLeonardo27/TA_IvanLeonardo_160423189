<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use App\Models\VocabularyExample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder1741To1875 extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        $dataset = [
            [1741, "Ujian", "Ujian", "Ujian", "Pendidikan", "Siswa sedang mengikuti ujian.", "Murid lagi melu ujian.", "Siswa saweg ndherek ujian."],
            [1742, "Ujung", "Pucuk", "Pucuk", "Kata Benda", "Ujung pensil itu tumpul.", "Pucuk potlot kuwi benter.", "Pucuk potlot punika benter."],
            [1743, "Ukir", "Ngukir", "Ngukir", "Seni", "Ayah mengukir kayu jati.", "Bapak ngukir kayu jati.", "Rama ngukir kajeng jati."],
            [1744, "Ular", "Ula", "Ula", "Hewan", "Ular itu sangat panjang.", "Ula kuwi dawa banget.", "Ula punika dawa sanget."],
            [1745, "Ulat", "Uler", "Uler", "Hewan", "Ulat memakan daun.", "Uler mangan godhong.", "Uler dhahar ron."],
            [1746, "Ulekan", "Cobek lan Ulekan", "Cobek lan Ulekan", "Dapur", "Ibu memakai ulekan batu.", "Ibu nganggo ulekan watu.", "Ibu ngagem ulekan sela."],
            [1747, "Ulet", "Ulet", "Ulet", "Kata Sifat", "Adik sangat ulet belajar.", "Adhik ulet sinau.", "Adhi ulet sinau."],
            [1748, "Ulung", "Apik banget", "Sae sanget", "Kata Sifat", "Hasil gambarnya ulung.", "Asil gambare apik banget.", "Asil gambaripun sae sanget."],
            [1749, "Umbi", "Umbi", "Umbi", "Tumbuhan", "Umbi itu masih segar.", "Umbi kuwi isih seger.", "Umbi punika taksih seger."],
            [1750, "Umur", "Umur", "Yuswa", "Kata Benda", "Umur adik delapan tahun.", "Umure adhik wolung taun.", "Yuswanipun adhi wolu taun."],
            [1751, "Unggas", "Manuk piaraan", "Sato unggas", "Hewan", "Petani memelihara unggas.", "Petani ngingu manuk piaraan.", "Petani ngingu sato unggas."],
            [1752, "Ungu", "Ungu", "Ungu", "Warna", "Bunga itu berwarna ungu.", "Kembang kuwi ungu.", "Sekar punika ungu."],
            [1753, "Universitas", "Universitas", "Universitas", "Pendidikan", "Kakak kuliah di universitas.", "Mas kuliah ing universitas.", "Raka kuliah wonten universitas."],
            [1754, "Unjuk", "Tuduh", "Tedah", "Kata Kerja", "Guru unjuk hasil karya siswa.", "Guru nuduhake asil karya murid.", "Guru nedahaken asil karya siswa."],
            [1755, "Upacara", "Upacara", "Upacara", "Sekolah", "Siswa mengikuti upacara bendera.", "Murid melu upacara gendera.", "Siswa ndherek upacara gendéra."],
            [1756, "Upah", "Upah", "Upah", "Ekonomi", "Pekerja menerima upah.", "Buruh nampa upah.", "Buruh nampi upah."],
            [1757, "Update", "Nganyari", "Nganyari", "Teknologi", "Ayah mengupdate aplikasi.", "Bapak nganyari aplikasi.", "Rama nganyari aplikasi."],
            [1758, "Upload", "Ngunggah", "Ngunggah", "Teknologi", "Saya upload tugas hari ini.", "Aku ngunggah tugas dina iki.", "Kula ngunggah tugas dinten punika."],
            [1759, "Urap", "Urap", "Urap", "Makanan", "Ibu membuat urap sayur.", "Ibu nggawe urap sayur.", "Ibu damel urap sayur."],
            [1760, "Urat", "Urat", "Urat", "Anggota Tubuh", "Urat tangan terlihat jelas.", "Urat tangan katon cetha.", "Urat asta katingal cetha."],
            [1761, "Urut", "Ngurut", "Ngurut", "Kata Kerja", "Ibu mengurut punggung ayah.", "Ibu ngurut gegere bapak.", "Ibu ngurut pengkeranipun rama."],
            [1762, "Usaha", "Usaha", "Usaha", "Ekonomi", "Usaha ayah semakin maju.", "Usahane bapak maju.", "Usahanipun rama majeng."],
            [1763, "Usai", "Rampung", "Rampung", "Kata Kerja", "Pelajaran sudah usai.", "Pelajaran wis rampung.", "Pawiyatan sampun rampung."],
            [1764, "Usap", "Ngusap", "Ngusap", "Kata Kerja", "Adik mengusap meja.", "Adhik ngusap meja.", "Adhi ngusap meja."],
            [1765, "Usia", "Umur", "Yuswa", "Kata Benda", "Usia nenek tujuh puluh tahun.", "Umure mbah pitung puluh taun.", "Yuswanipun eyang pitung dasa taun."],
            [1766, "Usul", "Usul", "Usul", "Kata Benda", "Guru menerima usul siswa.", "Guru nampa usul murid.", "Guru nampi usul siswa."],
            [1767, "Utama", "Utama", "Utami", "Kata Sifat", "Keselamatan adalah utama.", "Kaslametan kuwi utama.", "Kaslametan punika utami."],
            [1768, "Utara", "Lor", "Lor", "Arah", "Rumah kami menghadap utara.", "Omahku madhep lor.", "Griya kula madhep lor."],
            [1769, "Utas", "Utas", "Utas", "Benda", "Ibu membeli utas benang.", "Ibu tuku utas benang.", "Ibu mundhut utas benang."],
            [1770, "Utuh", "Wutuh", "Wutuh", "Kata Sifat", "Gelas itu masih utuh.", "Gelas kuwi isih wutuh.", "Gelas punika taksih wutuh."],
            [1771, "Wadah", "Wadah", "Wadah", "Peralatan", "Ibu menyiapkan wadah makanan.", "Ibu nyiapake wadah panganan.", "Ibu nyawisaken wadah dhaharan."],
            [1772, "Wafat", "Seda", "Seda", "Agama", "Kakek wafat tahun lalu.", "Mbah seda taun kepungkur.", "Eyang seda taun kepengker."],
            [1773, "Wajah", "Rai", "Pasuryan", "Anggota Tubuh", "Wajah adik tampak ceria.", "Raine adhik katon bungah.", "Pasuryanipun adhi katingal bingah."],
            [1774, "Wajan", "Wajan", "Wajan", "Dapur", "Ibu menggoreng ikan memakai wajan.", "Ibu nggoreng iwak nganggo wajan.", "Ibu nggoreng iwak ngagem wajan."],
            [1775, "Wajib", "Kudu", "Kedah", "Kata Sifat", "Siswa wajib memakai seragam.", "Murid kudu nganggo seragam.", "Siswa kedah ngagem seragam."],
            [1776, "Waktu", "Wektu", "Wekdal", "Waktu", "Waktu belajar sudah tiba.", "Wektu sinau wis teka.", "Wekdal sinau sampun dumugi."],
            [1777, "Wakil", "Wakil", "Wakil", "Pendidikan", "Wakil ketua memimpin rapat.", "Wakil ketua mimpin rapat.", "Wakil ketua mimpin rapat."],
            [1778, "Wali", "Wali", "Wali", "Pendidikan", "Wali kelas hadir pagi.", "Wali kelas teka esuk.", "Wali kelas rawuh enjing."],
            [1779, "Waluh", "Waluh", "Waluh", "Sayuran", "Ibu memasak waluh.", "Ibu masak waluh.", "Ibu masak waluh."],
            [1780, "Wangi", "Arum", "Arum", "Kata Sifat", "Bunga melati sangat wangi.", "Kembang melati arum.", "Sekar melati arum."],
            [1781, "Wanita", "Wadon", "Putri/Estri", "Keluarga", "Wanita itu sangat ramah.", "Wadon kuwi grapyak.", "Putri punika grapyak."],
            [1782, "Warga", "Warga", "Warga", "Sosial", "Warga bekerja bakti bersama.", "Warga kerja bakti bareng.", "Warga makarya sesarengan."],
            [1783, "Waris", "Waris", "Waris", "Keluarga", "Ayah menerima waris.", "Bapak nampa waris.", "Rama nampi waris."],
            [1784, "Warna", "Werna", "Warna", "Kata Sifat", "Warna bunga sangat indah.", "Werna kembang apik.", "Warna sekar endah."],
            [1785, "Warnai", "Marna", "Marna", "Kata Kerja", "Adik mewarnai gambar.", "Adhik marna gambar.", "Adhi marna gambar."],
            [1786, "Warteg", "Warteg", "Warteg", "Tempat", "Kami makan di warteg.", "Kita mangan ing warteg.", "Kula dhahar wonten warteg."],
            [1787, "Warung", "Warung", "Warung", "Tempat", "Ibu membeli gula di warung.", "Ibu tuku gula ing warung.", "Ibu mundhut gula wonten warung."],
            [1788, "Warung makan", "Warung mangan", "Warung dhahar", "Tempat", "Kami makan di warung makan.", "Kita mangan ing warung mangan.", "Kula dhahar wonten warung dhahar."],
            [1789, "Wasit", "Wasit", "Wasit", "Olahraga", "Wasit meniup peluit.", "Wasit niup sempritan.", "Wasit niup sempritan."],
            [1790, "Waspada", "Waspada", "Waspada", "Kata Sifat", "Kita harus waspada saat hujan.", "Kita kudu waspada wektu udan.", "Kita kedah waspada nalika jawah."],
            [1791, "Wastu", "Wastu", "Wastu", "Budaya", "Rumah dibangun sesuai wastu.", "Omah dibangun manut wastu.", "Griya dipundamel manut wastu."],
            [1792, "Watak", "Watak", "Watak", "Kata Benda", "Wataknya sangat baik.", "Watake apik.", "Watakipun sae."],
            [1793, "Wau", "Wau", "Wau", "Kata Keterangan", "Saya baru melihatnya tadi.", "Aku weruh wau.", "Kula ningali wau."],
            [1794, "Wayang", "Wayang", "Wayang", "Budaya", "Kami menonton wayang kulit.", "Kita nonton wayang kulit.", "Kula mirsani wayang kulit."],
            [1795, "Wayang kulit", "Wayang kulit", "Wayang kulit", "Budaya", "Wayang kulit berasal dari Jawa.", "Wayang kulit saka Jawa.", "Wayang kulit saking Jawi."],
            [1796, "Wayang golek", "Wayang golek", "Wayang golek", "Budaya", "Anak melihat wayang golek.", "Bocah ndelok wayang golek.", "Putra ningali wayang golek."],
            [1797, "Web", "Web", "Web", "Teknologi", "Saya membuka web sekolah.", "Aku mbukak web sekolah.", "Kula mbikak web sekolah."],
            [1798, "Website", "Situs web", "Situs web", "Teknologi", "Guru mengunggah materi ke website.", "Guru ngunggah materi menyang situs web.", "Guru ngunggah materi dhateng situs web."],
            [1799, "Wedang", "Wedang", "Wedang", "Minuman", "Nenek membuat wedang jahe.", "Mbah nggawe wedang jahe.", "Eyang damel wedang jahe."],
            [1800, "Wedhus", "Wedhus", "Wedhus", "Hewan", "Wedhus makan rumput.", "Wedhus mangan suket.", "Wedhus dhahar rumput."],
            [1801, "Welas asih", "Welas asih", "Welas asih", "Perasaan", "Guru mengajarkan welas asih.", "Guru mulang welas asih.", "Guru mucal welas asih."],
            [1802, "Wengi", "Bengi", "Dalu", "Waktu", "Kami belajar pada malam hari.", "Kita sinau bengi.", "Kula sinau dalu."],
            [1803, "Wesi", "Wesi", "Wesi", "Benda", "Pagar dibuat dari besi.", "Pager digawe saka wesi.", "Pager kadamel saking wesi."],
            [1804, "Weton", "Weton", "Weton", "Budaya", "Weton dihitung menurut kalender Jawa.", "Weton dietung manut penanggalan Jawa.", "Weton dipunetang manut penanggalan Jawi."],
            [1805, "Wewangian", "Wewangian", "Wewangian", "Benda", "Ibu membeli wewangian baru.", "Ibu tuku wewangian anyar.", "Ibu mundhut wewangian enggal."],
            [1806, "Wicara", "Ngomong", "Ngendika", "Kata Kerja", "Guru berbicara dengan siswa.", "Guru ngomong karo murid.", "Guru ngendika kaliyan siswa."],
            [1807, "Widuri", "Widuri", "Widuri", "Tumbuhan", "Bunga widuri berwarna ungu.", "Kembang widuri ungu.", "Sekar widuri ungu."],
            [1808, "Wijen", "Wijen", "Wijen", "Tumbuhan", "Ibu menaburkan wijen pada roti.", "Ibu nyebar wijen ing roti.", "Ibu nyebar wijen wonten roti."],
            [1809, "Wilayah", "Wilayah", "Wewengkon", "Geografi", "Wilayah desa sangat luas.", "Wilayah desa amba.", "Wewengkon desa wiyar."],
            [1810, "Wilujeng", "Wilujeng", "Wilujeng", "Ungkapan", "Guru mengucapkan wilujeng dalu.", "Guru ngomong wilujeng dalu.", "Guru ngaturaken wilujeng dalu."],
            [1811, "Wirausaha", "Wirausaha", "Wirausaha", "Profesi", "Paman menjadi wirausaha sukses.", "Paklik dadi wirausaha sukses.", "Paman dados wirausaha sukses."],
            [1812, "Wisata", "Plesiran/Piknik", "Wisata", "Aktivitas", "Keluarga pergi wisata.", "Kulawarga plesiran.", "Kulawarga wisata."],
            [1813, "Wisatawan", "Wisatawan", "Wisatawan", "Profesi", "Wisatawan mengunjungi candi.", "Wisatawan dolan candi.", "Wisatawan ngunjungi candhi."],
            [1814, "Wisma", "Wisma", "Wisma", "Bangunan", "Tamu menginap di wisma.", "Tamu nginep ing wisma.", "Tamu nginep wonten wisma."],
            [1815, "Wisuda", "Wisuda", "Wisuda", "Pendidikan", "Kakak mengikuti wisuda.", "Mas melu wisuda.", "Raka ndherek wisuda."],
            [1816, "Wiwit", "Wiwit", "Wiwit", "Kata Kerja", "Pelajaran dimulai pukul tujuh.", "Pelajaran wiwit jam pitu.", "Pelajaran wiwit tabuh pitu."],
            [1817, "Woh", "Woh", "Woh", "Buah", "Woh mangga sudah matang.", "Woh pelem wis mateng.", "Woh pelem sampun mateng."],
            [1818, "Wortel", "Wortel", "Wortel", "Sayuran", "Ibu memasak wortel.", "Ibu masak wortel.", "Ibu masak wortel."],
            [1819, "Wudu", "Adus wudu", "Wudu", "Agama", "Ayah berwudu sebelum salat.", "Bapak adus wudu sadurunge salat.", "Rama wudu saderengipun salat."],
            [1820, "Wujud", "Wujud", "Wujud", "Kata Benda", "Air memiliki tiga wujud.", "Banyu nduweni telung wujud.", "Toya gadhah tigang wujud."],
            [1821, "Yaitu", "Yaiku", "Punika", "Kata Hubung", "Hewan itu yaitu sapi.", "Kewan kuwi yaiku sapi.", "Sato punika sapi."],
            [1822, "Yakin", "Mantep", "Yakin/Kenthel Manah", "Kata Sifat", "Saya yakin bisa belajar.", "Aku mantep isa sinau.", "Kula yakin saged sinau."],
            [1823, "Yang", "Sing", "Ingkang", "Kata Hubung", "Anak yang rajin disukai guru.", "Anak sing sregep disenengi guru.", "Putra ingkang sregep dipuntresnani guru."],
            [1824, "Yatim", "Yatim", "Yatim", "Sosial", "Anak yatim mendapat bantuan.", "Anak yatim entuk pitulungan.", "Putra yatim pikantuk pitulungan."],
            [1825, "Yayasan", "Yayasan", "Yayasan", "Organisasi", "Yayasan itu membantu sekolah.", "Yayasan kuwi mbantu sekolah.", "Yayasan punika mitulungi sekolah."],
            [1826, "Yoga", "Yoga", "Yoga", "Olahraga", "Ibu berlatih yoga pagi ini.", "Ibu latihan yoga esuk iki.", "Ibu latihan yoga enjing punika."],
            [1827, "Yodium", "Yodium", "Yodium", "Sains", "Garam mengandung yodium.", "Uyah ngandhut yodium.", "Sarem ngemot yodium."],
            [1828, "Yoghurt", "Yoghurt", "Yoghurt", "Minuman", "Adik minum yoghurt dingin.", "Adhik ngombe yoghurt adhem.", "Adhi ngunjuk yoghurt asrep."],
            [1829, "Yudikatif", "Yudikatif", "Yudikatif", "Pemerintahan", "Lembaga yudikatif menegakkan hukum.", "Lembaga yudikatif netepake hukum.", "Lembaga yudikatif netepaken ukum."],
            [1830, "Yunior", "Yunior", "Yunior", "Pendidikan", "Kakak membimbing siswa yunior.", "Mas mbimbing murid yunior.", "Raka nuntun siswa yunior."],
            [1831, "Zaitun", "Zaitun", "Zaitun", "Tumbuhan", "Pohon zaitun tumbuh subur.", "Wit zaitun thukul subur.", "Uwit zaitun tuwuh subur."],
            [1832, "Zakat", "Zakat", "Zakat", "Agama", "Umat Islam membayar zakat.", "Umat Islam mbayar zakat.", "Umat Islam mbayar zakat."],
            [1833, "Zamrud", "Zamrud", "Zamrud", "Benda", "Batu zamrud berwarna hijau.", "Watu zamrud ijo.", "Sela zamrud ijem."],
            [1834, "Zat", "Zat", "Zat", "Sains", "Air terdiri dari berbagai zat.", "Banyu kasusun saka macem-macem zat.", "Toya kadamel saking manéka warna zat."],
            [1835, "Zebra", "Zebra", "Zebra", "Hewan", "Zebra memiliki belang hitam putih.", "Zebra nduweni loreng ireng putih.", "Zebra gadhah loreng cemeng pethak."],
            [1836, "Ziarah", "Nyekar/Nyiarah", "Ziarah", "Agama", "Kami ziarah ke makam kakek.", "Kita nyekar menyang makam mbah.", "Kula ziarah dhateng pasareyan eyang."],
            [1837, "Zigzag", "Zigzag", "Zigzag", "Bentuk", "Jalan itu berbentuk zigzag.", "Dalan kuwi zigzag.", "Margi punika zigzag."],
            [1838, "Zikir", "Dzikir", "Dzikir", "Agama", "Kakek membaca zikir.", "Mbah maca dzikir.", "Eyang maos dzikir."],
            [1839, "Zinc", "Seng", "Seng", "Sains", "Atap rumah terbuat dari zinc.", "Gendheng digawe saka seng.", "Gendheng kadamel saking seng."],
            [1840, "Zona", "Zona", "Zona", "Geografi", "Sekolah berada di zona aman.", "Sekolah ana ing zona aman.", "Sekolah wonten zona aman."],
            [1841, "Zoologi", "Ilmu kewan", "Zoologi", "Pendidikan", "Kakak belajar zoologi.", "Mas sinau ilmu kewan.", "Raka sinau zoologi."],
            [1842, "Zoom", "Zoom", "Zoom", "Teknologi", "Guru mengajar melalui Zoom.", "Guru mulang liwat Zoom.", "Guru mucal lumantar Zoom."],
            [1843, "Zuhur", "Dhuhur", "Dhuhur", "Agama", "Ayah salat Zuhur di masjid.", "Bapak salat Dhuhur ing masjid.", "Rama salat Dhuhur wonten masjid."],
            [1844, "Zuriat", "Turunan", "Zuriyat", "Keluarga", "Mereka menjaga zuriat keluarga.", "Dheweke njaga turunan kulawarga.", "Piyambakipun njagi zuriyat kulawarga."],
            [1845, "Zebra cross", "Lintasan sebrang", "Lintasan nyebrang", "Transportasi", "Kami menyeberang di zebra cross.", "Kita nyebrang ing lintasan sebrang.", "Kula nyebrang wonten lintasan nyebrang."],
            [1846, "Zaman", "Jaman", "Jaman", "Waktu", "Zaman terus berubah.", "Jaman terus owah.", "Jaman tansah ewah."],
            [1847, "Ziarah kubur", "Nyekar", "Ziarah pasareyan", "Agama", "Keluarga melakukan ziarah kubur.", "Kulawarga nyekar.", "Kulawarga ziarah pasareyan."],
            [1848, "Zodiak", "Zodiak", "Zodiak", "Istilah Modern", "Dia membaca zodiak hari ini.", "Dheweke maca zodiak dina iki.", "Piyambakipun maos zodiak dinten punika."],
            [1849, "Zumba", "Zumba", "Zumba", "Olahraga", "Ibu mengikuti senam zumba.", "Ibu melu senam zumba.", "Ibu ndherek senam zumba."],
            [1850, "Zona waktu", "Zona wektu", "Zona wekdal", "Geografi", "Indonesia memiliki tiga zona waktu.", "Indonesia nduweni telung zona wektu.", "Indonesia gadhah tigang zona wekdal."],
            [1860, "Zat gizi", "Zat gizi", "Zat gizi", "Kesehatan", "Buah mengandung banyak zat gizi.", "Woh ngandhut akeh zat gizi.", "Woh ngemot kathah zat gizi."],
            [1861, "Zat besi", "Zat wesi", "Zat wesi", "Kesehatan", "Bayam mengandung zat besi.", "Bayem ngandhut zat wesi.", "Bayem ngemot zat wesi."],
            [1862, "Zat cair", "Zat cair", "Zat cair", "Sains", "Air termasuk zat cair.", "Banyu klebu zat cair.", "Toya kalebet zat cair."],
            [1863, "Zat padat", "Zat padhet", "Zat padhet", "Sains", "Es termasuk zat padat.", "Ès klebu zat padhet.", "Ès kalebet zat padhet."],
            [1864, "Zat warna", "Zat warna", "Zat warna", "Sains", "Kunyit menghasilkan zat warna alami.", "Kunir ngasilake zat warna alami.", "Kunir ngasilaken zat warna alami."],
            [1865, "Zikir pagi", "Dzikir esuk", "Dzikir enjing", "Agama", "Kakek membaca zikir pagi.", "Mbah maca dzikir esuk.", "Eyang maos dzikir enjing."],
            [1866, "Zikir petang", "Dzikir sore", "Dzikir sonten", "Agama", "Ibu membaca zikir petang.", "Ibu maca dzikir sore.", "Ibu maos dzikir sonten."],
            [1867, "Zebra laut", "Zebra laut", "Zebra laut", "Hewan", "Zebra laut hidup di lautan.", "Zebra laut urip ing segara.", "Zebra laut gesang wonten seganten."],
            [1868, "Zona aman", "Zona aman", "Zona aman", "Keamanan", "Anak bermain di zona aman.", "Bocah dolanan ing zona aman.", "Putra dolanan wonten zona aman."],
            [1869, "Zona bahaya", "Zona bebaya", "Zona bebaya", "Keamanan", "Dilarang masuk zona bahaya.", "Aja mlebu zona bebaya.", "Sampun mlebet zona bebaya."],
            [1870, "Zona hijau", "Zona ijo", "Zona ijem", "Lingkungan", "Desa memiliki zona hijau.", "Desa nduweni zona ijo.", "Desa gadhah zona ijem."],
            [1871, "Vaksin", "Vaksin", "Vaksin", "Kesehatan", "Anak menerima vaksin.", "Bocah nampa vaksin.", "Putra nampi vaksin."],
            [1872, "Video", "Video", "Video", "Teknologi", "Guru memutar video pembelajaran.", "Guru muter video pasinaon.", "Guru muter video pasinaon."],
            [1873, "Vitamin", "Vitamin", "Vitamin", "Kesehatan", "Ibu membeli vitamin.", "Ibu tuku vitamin.", "Ibu mundhut vitamin."],
            [1874, "Volume", "Volume", "Volume", "Sains", "Guru menaikkan volume suara.", "Guru ngunggahake volume swara.", "Guru nginggilaken volume swanten."],
            [1875, "Voucher", "Voucher", "Voucher", "Teknologi", "Saya memakai voucher internet.", "Aku nganggo voucher internet.", "Kula ngagem voucher internet."],
        ];

        foreach ($dataset as $row) {
            $vocab = Vocabulary::updateOrCreate(
                ['id' => $row[0]],
                [
                    'indonesian_word' => $row[1],
                    'javanese_ngoko'  => $row[2],
                    'javanese_krama'  => $row[3],
                    'category'        => $row[4] ?? null,
                ]
            );

            if (!empty($row[5]) || !empty($row[6]) || !empty($row[7])) {
                VocabularyExample::updateOrCreate(
                    ['vocabulary_id' => $vocab->id],
                    [
                        'indonesian_sentence' => $row[5] ?? null,
                        'ngoko_sentence'      => $row[6] ?? null,
                        'krama_sentence'      => $row[7] ?? null,
                        'javanese_sentence'   => $row[6] ?? $row[7] ?? null,
                    ]
                );
            }
        }
    }
}
