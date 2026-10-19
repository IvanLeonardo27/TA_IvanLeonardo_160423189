<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KawruhBasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Arane Anak Kewan (61 entri lengkap sesuai Buku Pepak Kaca 18-19)
        $araneAnakKewan = [
            ['Ampal', 'Embug-embugan'],
            ['Angkrang', 'Kroto'],
            ['Asu', 'Kirik'],
            ['Ayam (pitik)', 'Kuthuk'],
            ['Babi', 'Gembluk'],
            ['Bandeng', 'Nener'],
            ['Bantheng', 'Wereng'],
            ['Banyak', 'Blengur'],
            ['Baya', 'Rete'],
            ['Bebek', 'Meri'],
            ['Bethik', 'Menter'],
            ['Blanak', 'Sendha'],
            ['Brati', 'Tongki'],
            ['Budheng', 'Kowe'],
            ['Bulus', 'Ketul'],
            ['Cacing', 'Lur'],
            ['Cecak', 'Sawiyah'],
            ['Celeng', 'Genjik'],
            ['Coro', 'Mendhet'],
            ['Dara', 'Piyik'],
            ['Dhorang', 'Tamper'],
            ['Emprit', 'Indhil'],
            ['Gagak', 'Engkak'],
            ['Gajah', 'Bledug'],
            ['Gangsir', 'Clondho'],
            ['Garangan', 'Rase'],
            ['Garengpung', 'Drungkuk'],
            ['Gemak', 'Drigul'],
            ['Glathik', 'Cecrekan'],
            ['Gundhik', 'Laron/rayap'],
            ['Iwak', 'Beyong'],
            ['Jangkrik', 'Gendholo'],
            ['Jaran', 'Belo'],
            ['Kadhal', 'Tobil'],
            ['Kakap', 'Caplek'],
            ['Kalajengking', 'Ketupa'],
            ['Kancil', 'Kenthi'],
            ['Kebo', 'Gudel'],
            ['Kecapung', 'Jenthit'],
            ['Kemangga', 'Ceriwi'],
            ['Kepik', 'Mreki'],
            ['Kidang', 'Kompreng'],
            ['Kimar', 'Kedah'],
            ['Kinjeng', 'Senggutru'],
            ['Kinjeng dom', 'Undur-undur'],
            ['Kintel', 'Kenthus'],
            ['Kethek', 'Munyuk / kenyung'],
            ['Kodhok', 'Precil'],
            ['Kombang', 'Engkuk'],
            ['Konang', 'Endrak'],
            ['Kremi', 'Racek'],
            ['Kucing', 'Cemeng'],
            ['Kul / keyong', 'Krikik'],
            ['Kupu', 'Uler'],
            ['Kura', 'Laos'],
            ['Kutuk', 'Kotesan'],
            ['Kwangwung', 'Gendhot'],
            ['Laler', 'Set / singgat'],
            ['Lamuk', 'Jenthik'],
            ['Lawa', 'Kampret'],
            ['Lele', 'Jabrisan'],
        ];

        // 2. Urutane Turunan (10 entri sesuai Buku Pepak Kaca 26)
        $urutaneTurunan = [
            ['Bapak ibu', 'Ayah dan ibu (Bale somah)'],
            ['Embah', 'Kakek atau nenek'],
            ['Buyut', 'Leluhur / keturunan generasi ke-3'],
            ['Canggah', 'Generasi ke-4'],
            ['Wareng', 'Generasi ke-5'],
            ['Udheg-udheg', 'Generasi ke-6'],
            ['Gantung siwur', 'Generasi ke-7'],
            ['Grepak senthe', 'Generasi ke-8'],
            ['Anak', 'Keturunan generasi pertama'],
            ['Putu', 'Keturunan generasi ke-2 (cucu)'],
        ];

        // 3. Urutane Sedulur (5 entri sesuai Buku Pepak Kaca 26)
        $urutaneSedulur = [
            ['Pembarep', 'Anak sulung (anak nomer siji)'],
            ['Penggulu', 'Anak nomer loro'],
            ['Pandhadha', 'Anak nomer telu'],
            ['Sumendhi', 'Anak sadurunge wuragil'],
            ['Wuragil / waruju', 'Anak bungsu (anak pungkasan)'],
        ];

        // 4. Prenahe Sedulur (20 entri lengkap sesuai Buku Pepak Kaca 27)
        $prenahSedulur = [
            ['Sedulur', 'Tunggal bapak ibu'],
            ['Misanan', 'Sedulur tunggal embah, nakdulur'],
            ['Mindhoan', 'Sedulur tunggal buyut'],
            ['Keponakan', 'Anake sedulur'],
            ['Putu keponakan', 'Anake keponakan'],
            ['Paklik / Bulik', 'Adhine bapak/ibu'],
            ['Pakdhe / Budhe (uwa)', 'Kakang/mbakyune bapak utawa ibu'],
            ['Anak mantu', 'Bojone anak'],
            ['Putu mantu', 'Bojone putu'],
            ['Maratuwo', 'Wong tuwane bojo'],
            ['Besan', 'Wong tuwane mantu'],
            ['Ipe', 'Sedulure bojo'],
            ['Pripean', 'Ipene sedulur'],
            ['Sedulur kuwalon', 'Tunggal bapak seje ibu utawa tunggal ibu seje bapak'],
            ['Bapak kuwalon', 'Bapak sambungan'],
            ['Anak angkat', 'Bocah sing diakui anak'],
            ['Sedulur asu', 'Sedulur tunggal ibu seje bapak'],
            ['Tunggal guru', 'Sedulur tunggal guru'],
            ['Tunggal banyu', 'Sedulur tunggal guru'],
            ['Tunggal welat', 'Sedulur tunggal bapak ibu'],
        ];

        // 5. Arane Kembang (47 entri sesuai Buku Pepak Kaca 13-14)
        $araneKembang = [
            ['Aren', 'Dangu'],
            ['Blimbing', 'Maya'],
            ['Blutru', 'Montro'],
            ['Cengkeh', 'Polong'],
            ['Cubung', 'Torong'],
            ['Dhadhap', 'Celung'],
            ['Duren', 'Dlongop'],
            ['Ganyong', 'Puspanyindra'],
            ['Garut', 'Grameng'],
            ['Gebang', 'Krandhing'],
            ['Gedhang', 'Ontong (tuntut)'],
            ['Gembili', 'Seneng'],
            ['Jagung', 'Sinuwun (jeprak)'],
            ['Jambe', 'Mayang'],
            ['Jambu', 'Karuk'],
            ['Jarak', 'Juwis'],
            ['Jati', 'Janggleng'],
            ['Jengkol', 'Kecuwis'],
            ['Kacang', 'Besengut (bundhel)'],
            ['Kanthil', 'Gadhing'],
            ['Kapas', 'Kadi'],
            ['Kara', 'Kepek'],
            ['Kecipir', 'Cethethet'],
            ['Kelor', 'Limaran'],
            ['Kemlandhingan', 'Jedhidhing'],
            ['Kencur', 'Sedhet'],
            ['Tales (kimpul)', 'Pancal'],
            ['Kluwih', 'Onthel'],
            ['Kopi', 'Blanggreng'],
            ['Krambil', 'Manggar'],
            ['Krokot', 'Naknik'],
            ['Lamtara', 'Jedhidhing'],
            ['Lombok', 'Menik'],
            ['Mlinjo (so)', 'Uceng (kroto)'],
            ['Nangka', 'Angkup'],
            ['Nipah', 'Dongong'],
            ['Pandhan', 'Pudhak'],
            ['Pace', 'Nyrewenteh'],
            ['Pete', 'Pendul'],
            ['Pohong', 'Ingklik'],
            ['Pring', 'Krosak'],
            ['Randhu', 'Karuk'],
            ['Salak', 'Ketheker'],
            ['Suruh', 'Drenges'],
            ['Tebu', 'Glagah'],
            ['Timun', 'Montro'],
            ['Widara putih', 'Rejasa'],
        ];

        // 6. Arane Pentil (13 entri sesuai Buku Pepak Kaca 14-15)
        $aranePentil = [
            ['Asem', 'Cempaluk'],
            ['Jagung', 'Janten'],
            ['Jambe', 'Bleber'],
            ['Jambu', 'Karuk'],
            ['Kacang', 'Besengut'],
            ['Krambil', 'Bluluk, cengkir, degan'],
            ['Manggis', 'Blibar'],
            ['Nangka', 'Babal, gori'],
            ['Pelem', 'Pencit'],
            ['Randhu', 'Plencing'],
            ['Semangka', 'Plonco'],
            ['So / mlinjo', 'Kroto'],
            ['Timun', 'Serit'],
        ];

        // 7. Arane Woh (16 entri sesuai Buku Pepak Kaca 15)
        $araneWoh = [
            ['Aren', 'Kolang-kaling'],
            ['Bengkowang', 'Besusu'],
            ['Cengkeh', 'Polong'],
            ['Gebang', 'Krandhing'],
            ['Gembili', 'Katak'],
            ['Jati', 'Janggleng'],
            ['Kanthil', 'Gandhek'],
            ['Kelor', 'Klenthang'],
            ['Kesambi', 'Kecacil'],
            ['Kluwek', 'Pocung'],
            ['Pandhan eri', 'Padhaga'],
            ['So', 'Mlinjo'],
            ['Tal', 'Siwalan'],
            ['Turi', 'Klenthang'],
            ['Uwi', 'Katak'],
            ['Widara putih', 'Anyang'],
        ];

        // 8. Arane Isi (16 entri sesuai Buku Pepak Kaca 16)
        $araneIsi = [
            ['Asem', 'Klungsu'],
            ['Cipir', 'Botor'],
            ['Duren', 'Pongge'],
            ['Jambe', 'Jebug'],
            ['Kapas', 'Wuku'],
            ['Kates', 'Trempos'],
            ['Kluwek', 'Pocung'],
            ['Kluwih', 'Bethem'],
            ['Krambil', 'Kenthos'],
            ['Mlinjo', 'Klathak'],
            ['Nangka', 'Beton'],
            ['Pelem', 'Pelok'],
            ['Randhu', 'Klentheng'],
            ['Salak', 'Kenthos'],
            ['Sawo', 'Kecik'],
            ['Semangka', 'Kuwaci'],
        ];

        // 9. Arane Wit (14 entri sesuai Buku Pepak Kaca 16-17)
        $araneWit = [
            ['Aren', 'Ruyung'],
            ['Gedhang', 'Debog'],
            ['Jagung', 'Tebon'],
            ['Jambe', 'Pucang'],
            ['Kacang', 'Rendeng'],
            ['Kapuk', 'Randhu'],
            ['Krambil', 'Glugu'],
            ['Mlinjo', 'So, bego'],
            ['Pari', 'Damen'],
            ['Pohong', 'Benggol'],
            ['Pring enom', 'Bung'],
            ['Pring tuwa', 'Bungkilan'],
            ['Siwalan', 'Tal, bogor'],
            ['Tela', 'Lung'],
        ];

        // 10. Arane Godhong (20 entri sesuai Buku Pepak Kaca 17)
        $araneGodhong = [
            ['Aren', 'Dliring'],
            ['Asem', 'Sinom'],
            ['Cocor bebek', 'Tiba urip'],
            ['Dhadhap', 'Tawa'],
            ['Gedhang enom', 'Pupus'],
            ['Gedhang tuwa', 'Ujungan'],
            ['Gedhang garing', 'Klaras'],
            ['Gebang', 'Kajang'],
            ['Jambe', 'Pracat, dedel'],
            ['Jarak', 'Bledheg'],
            ['Jarak kebo', 'Lomah-lameh'],
            ['Jati', 'Jompong'],
            ['Kacang brol', 'Rendeng'],
            ['Kacang lanjaran', 'Lembayung'],
            ['Kates', 'Gampleng'],
            ['Kecipir', 'Cethethet'],
            ['Kelor', 'Limaran (sewu)'],
            ['Kemladheyan', 'Kumuda'],
            ['Kluwih', 'Kleyang'],
            ['Krambil enom', 'Janur'],
        ];

        // 11. Arane Wong (21 entri sesuai Buku Pepak Kaca 27-28)
        $araneWong = [
            ['Jaka', 'Bocah lanang sing wis diwasa durung rabi'],
            ['Jaka jebug', 'Jaka sing wis tuwa'],
            ['Dudha', 'Wong lanang sing wis ora duwe bojo'],
            ['Dhudha kembang', 'Dhudha sing isih enom durung duwe anak'],
            ['Dhudha kawuk', 'Dhudha sing wis tuwa'],
            ['Dhudha bangsong', 'Dhudha mlarat sing sugih anak'],
            ['Dhudha kalung', 'Dhudha seng duwe anak wadon bisa ngopeni'],
            ['Khaki', 'Wong lanang sing wis tuwa banget'],
            ['Kyai', 'Wong lanang sing diajeni'],
            ['Prawan', 'Bocah wadon sing wis diwasa durung rabi'],
            ['Prawan sunthi', 'Prawan cilik (prawan kencur)'],
            ['Prawan gendhor', 'Prawan kasep'],
            ['Randha', 'Wong wadon sing wis ora duwe bojo'],
            ['Randha tanggung', 'Randha sing isih enom'],
            ['Randha kembang / wulanjar', 'Randha enom seng durung duwe anak'],
            ['Randha kisi', 'Randha sing duwe anak lanang'],
            ['Randha kasihan', 'Randha mlarat anake akeh'],
            ['Randha keringan', 'Randha sing sugih'],
            ['Randha menter', 'Randha sing panggonane sarwa apik'],
            ['Nini', 'Wong wadon sing wis tuwa banget'],
            ['Nyai / nyi', 'Wong wadon sing diajeni'],
        ];

        // 12. Sebutane Bocah (50 entri lengkap sesuai Buku Pepak Kaca 28-30)
        $sebutaneBocah = [
            ['Ontang-anting', 'Anak siji lanang'],
            ['Unting-unting', 'Anak siji wadon'],
            ['Uger-uger lawang', 'Anak loro lanang kabeh'],
            ['Kembang sepasang', 'Anak loro wadon kabeh'],
            ['Cukit dulit', 'Anak telu lanang kabeh'],
            ['Gotong mayit', 'Anak telu wadon kabeh'],
            ['Saramba', 'Anak papat lanang kabeh'],
            ['Sarimpi', 'Anak papat wadon kabeh'],
            ['Pandhawa', 'Anak lima lanang kabeh'],
            ['Pancagati', 'Anak lima wadon kabeh'],
            ['Kedhana-kedhini', 'Anak loro lanang wadon'],
            ['Sendhang kapit pancuran', 'Anak telu lanang-wadon-lanang'],
            ['Pancuran kapit sendhang', 'Anak telu wadon-lanang-wadon'],
            ['Keblat papat', 'Anak papat lanang wadon'],
            ['Pandangan', 'Anak lima wadon siji'],
            ['Ipil-ipil', 'Anak lima lanang siji'],
            ['Kembar', 'Anak loro lair bareng'],
            ['Kembar gantung', 'Bocah kembar laire sedina'],
            ['Dhampit', 'Anak loro lanang wadon laire bareng'],
            ['Gilir kacang', 'Anake giliran lanang wadon'],
            ['Lumpat kidang', 'Anake akeh ora giliran lanang wadon'],
            ['Gendhong', 'Anak wadon sing ana tengah-tengah anak lanang'],
            ['Pathok', 'Anak lanang sing ana tengah-tengah anak wadon'],
            ['Grandhel', 'Anak lanang pirang-pirang wuragil wadon, utawa kosok baline'],
            ['Anggana', 'Anak siji ora duwe sedulur'],
            ['Cemani', 'Anak ireng mulus'],
            ['Wungle / bule', 'Anak putih mulus'],
            ['Gondhang kasih', 'Anak loro beda pakulitane'],
            ['Pambarep', 'Anak seng nomer siji'],
            ['Penggulu', 'Anak sing nomer loro'],
            ['Pandhadha', 'Anak sing nomer telu'],
            ['Sumendhi', 'Kakang wuragil'],
            ['Wuragil / waruju', 'Anak seng keri dhewe'],
            ['Yatim', 'Bocah lair wis ora menangi bapake'],
            ['Lola', 'Bocah sing wis ditinggal wong tuwane'],
            ['Lola bapa (biyung)', 'Bocah sing wis ora duwe bapak (ibu)'],
            ['Koduran', 'Bocah lair sing ibune seda'],
            ['Sumala', 'Bocah sing cacad wiwit lair'],
            ['Thok thing', 'Bocah sing lair kanthi sirah cilik'],
            ['Julung kembang', 'Bocah lair nalika srengenge mlethek'],
            ['Julung sungsang', 'Bocah sing lair nalika bedhug awan'],
            ['Julung sarab', 'Bocah sing lair ngarepake surup'],
            ['Julung caplok', 'Bocah sing lair nalika surup'],
            ['Margana', 'Bocah sing lair nalika ibune lelungan'],
            ['Wuyungan', 'Bocah sing lair nalika perang'],
            ['Wahana', 'Bocah sing lair nalika ana pasamuan'],
            ['Jempina', 'Bocah sing lair durung titi mangsane'],
            ['Tiba sampir', 'Bocah sing lair kalung usus'],
            ['Tiba ungker', 'Bocah lair ususe nggubed gulu'],
            ['Wungkul', 'Bocah sing lair tanpa ari-ari'],
        ];

        $this->seedTable('arane_anak_kewan', $araneAnakKewan);
        $this->seedTable('urutane_turunan', $urutaneTurunan);
        $this->seedTable('urutane_sedulur', $urutaneSedulur);
        $this->seedTable('prenah_sedulur', $prenahSedulur);
        $this->seedTable('arane_kembang', $araneKembang);
        $this->seedTable('arane_pentil', $aranePentil);
        $this->seedTable('arane_woh', $araneWoh);
        $this->seedTable('arane_isi', $araneIsi);
        $this->seedTable('arane_wit', $araneWit);
        $this->seedTable('arane_godhong', $araneGodhong);
        $this->seedTable('arane_wong', $araneWong);
        $this->seedTable('sebutane_bocah', $sebutaneBocah);
    }

    private function seedTable(string $table, array $data): void
    {
        $now = now();
        foreach ($data as $item) {
            DB::table($table)->updateOrInsert(
                ['javanese_term' => $item[0]],
                [
                    'indonesia_meaning' => $item[1],
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]
            );
        }
    }
}
