<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentParent;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $roleId = Role::where('name', 'orang_tua')->value('id') ?? 3;

$parents = [
[
        'name' => 'euis khoirunnisa',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'euis.khoirunnisa@bogor.albahjah.sch.id',
        'phone' => '8561168120.0',
        'address' => 'Gandaria Utara'
    ],
[
        'name' => 'lastri',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'lastri@bogor.albahjah.sch.id',
        'phone' => '084343631423',
        'address' => 'Karangasih'
    ],
[
        'name' => 'mega yeta puspita sari',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'mega.yeta.puspita.sari@bogor.albahjah.sch.id',
        'phone' => '089509293675',
        'address' => 'Desa/Kel. Ciampea'
    ],
[
        'name' => 'eka kartikasari',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'eka.kartikasari@bogor.albahjah.sch.id',
        'phone' => '81585859627.0',
        'address' => 'Sukamulih'
    ],
[
        'name' => 'irma sulaeman',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'irma.sulaeman@bogor.albahjah.sch.id',
        'phone' => '85697053053.0',
        'address' => 'BANTARJATI'
    ],
[
        'name' => 'kurnia fitriani',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'kurnia.fitriani@bogor.albahjah.sch.id',
        'phone' => '881025224536.0',
        'address' => 'Buaran Indah'
    ],
[
        'name' => 'ani fitriani',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ani.fitriani@bogor.albahjah.sch.id',
        'phone' => '89622905804.0',
        'address' => 'Duri Pulo'
    ],
[
        'name' => 'rita rosita',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'rita.rosita@bogor.albahjah.sch.id',
        'phone' => '082807344735',
        'address' => 'Rancamaya'
    ],
[
        'name' => 'pipih sopiah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'pipih.sopiah@bogor.albahjah.sch.id',
        'phone' => '088397522740',
        'address' => 'Desa/Kel. Sadeng'
    ],
[
        'name' => 'ruslina',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ruslina@bogor.albahjah.sch.id',
        'phone' => '089641672331',
        'address' => 'Desa/Kel. Cipayung'
    ],
[
        'name' => 'yunita pandiangan',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'yunita.pandiangan@bogor.albahjah.sch.id',
        'phone' => '086884060541',
        'address' => 'PONDOK BENDA'
    ],
[
        'name' => 'nuni mulyani',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'nuni.mulyani@bogor.albahjah.sch.id',
        'phone' => '87837547807.0',
        'address' => 'Muarasari'
    ],
[
        'name' => 'rita karmila',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'rita.karmila@bogor.albahjah.sch.id',
        'phone' => '895365345502.0',
        'address' => 'CIBADAK'
    ],
[
        'name' => 'siti saadah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti.saadah@bogor.albahjah.sch.id',
        'phone' => '082953476887',
        'address' => 'Serang'
    ],
[
        'name' => 'eka lediana mukti',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'eka.lediana.mukti@bogor.albahjah.sch.id',
        'phone' => '81298977714.0',
        'address' => 'CILENDEK TIMUR'
    ],
[
        'name' => 'sri astuti hijriyani',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sri.astuti.hijriyani@bogor.albahjah.sch.id',
        'phone' => '82386116618.0',
        'address' => 'GEMPOL SARI'
    ],
[
        'name' => 'homsih',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'homsih@bogor.albahjah.sch.id',
        'phone' => '082002266569',
        'address' => 'Desa/Kel. Cikedokan'
    ],
[
        'name' => 'sulvana djafar amri',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sulvana.djafar.amri@bogor.albahjah.sch.id',
        'phone' => '81806001828.0',
        'address' => 'SUKATANI'
    ],
[
        'name' => 'rina mariyana',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'rina.mariyana@bogor.albahjah.sch.id',
        'phone' => '086767659447',
        'address' => 'Desa/Kel. Girimulya'
    ],
[
        'name' => 'yulia purnama sari',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'yulia.purnama.sari@bogor.albahjah.sch.id',
        'phone' => '081019939118',
        'address' => 'Desa/Kel. Girimulya'
    ],
[
        'name' => 'nia kurniasih',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'nia.kurniasih@bogor.albahjah.sch.id',
        'phone' => '83818926445.0',
        'address' => 'Desa/Kel. Sukaraja'
    ],
[
        'name' => 'damia fitriyah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'damia.fitriyah@bogor.albahjah.sch.id',
        'phone' => '81315282367.0',
        'address' => 'POndok Kelapa'
    ],
[
        'name' => 'martha dewinta stephanie ',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'martha.dewinta.stephanie@bogor.albahjah.sch.id',
        'phone' => '083994765511',
        'address' => 'Desa/Kel. Benda Baru'
    ],
[
        'name' => 'wilda hurriya',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'wilda.hurriya@bogor.albahjah.sch.id',
        'phone' => '81398066635.0',
        'address' => 'Petogogan'
    ],
[
        'name' => 'DWI WIJI LESTARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dwi.wiji.lestari@bogor.albahjah.sch.id',
        'phone' => '85779741275.0',
        'address' => 'Srengseng'
    ],
[
        'name' => 'JUBAEDAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'jubaedah@bogor.albahjah.sch.id',
        'phone' => '087312757303',
        'address' => 'Desa/Kel. Rawabadak Utara'
    ],
[
        'name' => 'Dina Koespriandini',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dina.koespriandini@bogor.albahjah.sch.id',
        'phone' => '81282226661.0',
        'address' => 'Desa/Kel. Mekarwangi'
    ],
[
        'name' => 'Susilawati',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'susilawati@bogor.albahjah.sch.id',
        'phone' => '81363052911.0',
        'address' => 'Kaliabang Tengah'
    ],
[
        'name' => 'Eka Giantika',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'eka.giantika@bogor.albahjah.sch.id',
        'phone' => '082264517062',
        'address' => 'Bojongkulur'
    ],
[
        'name' => 'ROSI SULASTRI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'rosi.sulastri@bogor.albahjah.sch.id',
        'phone' => '8999574250.0',
        'address' => 'PARAKANJAYA'
    ],
[
        'name' => 'WINANINGSIH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'winaningsih@bogor.albahjah.sch.id',
        'phone' => '89530301531.0',
        'address' => 'Sinar Sari'
    ],
[
        'name' => 'Dedis Ayu Juliyanti',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dedis.ayu.juliyanti@bogor.albahjah.sch.id',
        'phone' => '81280418355.0',
        'address' => 'Jatireja'
    ],
[
        'name' => 'RIZKI RAHMA MULYATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'rizki.rahma.mulyati@bogor.albahjah.sch.id',
        'phone' => '81223929473.0',
        'address' => 'Cikarang Kota'
    ],
[
        'name' => 'Hikmah Nuryatun',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'hikmah.nuryatun@bogor.albahjah.sch.id',
        'phone' => '89520038272.0',
        'address' => 'Jatireja'
    ],
[
        'name' => 'YULINESYA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'yulinesya@bogor.albahjah.sch.id',
        'phone' => '083776223451',
        'address' => 'Desa/Kel. Cemplang'
    ],
[
        'name' => 'WAHYU KUSUMANINGRUM',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'wahyu.kusumaningrum@bogor.albahjah.sch.id',
        'phone' => '89638100018.0',
        'address' => 'LALADON'
    ],
[
        'name' => 'ANNISAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'annisah@bogor.albahjah.sch.id',
        'phone' => '81286238773.0',
        'address' => 'SEMPER BARAT'
    ],
[
        'name' => 'Rita Diana Fitri',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'rita.diana.fitri@bogor.albahjah.sch.id',
        'phone' => '088539598242',
        'address' => 'Desa/Kel. Cipinang Muara'
    ],
[
        'name' => 'BEKTI ISWANDARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'bekti.iswandari@bogor.albahjah.sch.id',
        'phone' => '82213448460.0',
        'address' => 'Desa/Kel. Jatireja'
    ],
[
        'name' => 'ARIYANTI FEBRIYANI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ariyanti.febriyani@bogor.albahjah.sch.id',
        'phone' => '81282352072.0',
        'address' => 'CURUG'
    ],
[
        'name' => 'Idawati',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'idawati@bogor.albahjah.sch.id',
        'phone' => '89519281034.0',
        'address' => 'Bencongan'
    ],
[
        'name' => 'SARMIYATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sarmiyati@bogor.albahjah.sch.id',
        'phone' => '082566050120',
        'address' => 'Cibatok 1'
    ],
[
        'name' => 'IDA FARIDA1',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ida.farid1a@bogor.albahjah.sch.id',
        'phone' => '81383015680.0',
        'address' => 'CILANGKAP'
    ],
[
        'name' => 'KARNI ASTUTI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'karni.astuti@bogor.albahjah.sch.id',
        'phone' => '81357634578.0',
        'address' => 'KARANGASIH'
    ],
[
        'name' => 'Elis',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'elis@bogor.albahjah.sch.id',
        'phone' => '83818182452.0',
        'address' => 'Desa/Kel. Pondok Kaso Tengah'
    ],
[
        'name' => 'ITA YUNIATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ita.yuniati@bogor.albahjah.sch.id',
        'phone' => '8558758100.0',
        'address' => 'CIKOKO'
    ],
[
        'name' => 'YAYEH AZHARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'yayeh.azhari@bogor.albahjah.sch.id',
        'phone' => '83890788781.0',
        'address' => 'Desa/Kel. Simpangan'
    ],
[
        'name' => 'HARIROH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'hariroh@bogor.albahjah.sch.id',
        'phone' => '82123921552.0',
        'address' => 'Cibinong'
    ],
[
        'name' => 'Emalia Nursyamsah Sitorus',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'emalia.nursyamsah.sitorus@bogor.albahjah.sch.id',
        'phone' => '81280761999.0',
        'address' => 'Desa/Kel. Sukamantri'
    ],
[
        'name' => 'IBAH HABIBAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ibah.habibah@bogor.albahjah.sch.id',
        'phone' => '81299264035.0',
        'address' => 'Gunung Bunder 2'
    ],
[
        'name' => 'KHATIMAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'khatimah@bogor.albahjah.sch.id',
        'phone' => '81617406770.0',
        'address' => 'SASAK PANJANG'
    ],
[
        'name' => 'Mahyati',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'mahyati@bogor.albahjah.sch.id',
        'phone' => '87747649098.0',
        'address' => 'Karang Asih'
    ],
[
        'name' => 'WINAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'winawati@bogor.albahjah.sch.id',
        'phone' => '81808066916.0',
        'address' => 'CIJUJUNG'
    ],
[
        'name' => 'ASTI INDRIATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'asti.indriati@bogor.albahjah.sch.id',
        'phone' => '81281663674.0',
        'address' => 'KARANG SATRIA'
    ],
[
        'name' => 'IDEH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ideh@bogor.albahjah.sch.id',
        'phone' => '083819157995',
        'address' => 'Desa/Kel. Leuwiliang'
    ],
[
        'name' => 'ETI SUMIATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'eti.sumiati@bogor.albahjah.sch.id',
        'phone' => '85892381390.0',
        'address' => 'Desa/Kel. Cilebut Timur'
    ],
[
        'name' => 'Yulia Handayani',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'yulia.handayani@bogor.albahjah.sch.id',
        'phone' => '82180427686.0',
        'address' => 'Desa/Kel. Paku Alam'
    ],
[
        'name' => 'Warnih',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'warnih@bogor.albahjah.sch.id',
        'phone' => '81315113162.0',
        'address' => 'Sertajaya'
    ],
[
        'name' => 'SITI NURJANAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti.nurjanah@bogor.albahjah.sch.id',
        'phone' => '81818604900.0',
        'address' => 'Desa/Kel. Tanahsareal'
    ],
[
        'name' => 'HOLILAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'holilah@bogor.albahjah.sch.id',
        'phone' => '084087042241',
        'address' => 'Desa/Kel. Cibening'
    ],
[
        'name' => 'Ida Waridah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ida.waridah@bogor.albahjah.sch.id',
        'phone' => '088964738472',
        'address' => 'Desa/Kel. Sadeng'
    ],
[
        'name' => 'INDA SARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'inda.sari@bogor.albahjah.sch.id',
        'phone' => '87873038525.0',
        'address' => 'BOJONG NANGKA'
    ],
[
        'name' => 'AI BADRIAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ai.badriah@bogor.albahjah.sch.id',
        'phone' => '85659034889.0',
        'address' => 'Desa/Kel. Petir'
    ],
[
        'name' => 'SITI NURAYATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti.nurayati@bogor.albahjah.sch.id',
        'phone' => '85697129945.0',
        'address' => 'Sirnajaya'
    ],
[
        'name' => 'ERNAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ernawati@bogor.albahjah.sch.id',
        'phone' => '81287844751.0',
        'address' => 'PINANG RANTI'
    ],
[
        'name' => 'NIMATURROHMAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'nimaturrohmah@bogor.albahjah.sch.id',
        'phone' => '085239693202',
        'address' => 'Desa/Kel. Leuwisadeng'
    ],
[
        'name' => 'WIDYAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'widyawati@bogor.albahjah.sch.id',
        'phone' => '086328742379',
        'address' => 'Desa/Kel. KUDU GANTIANG'
    ],
[
        'name' => 'ENDANG SRI HASTUTI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'endang.sri.hastuti@bogor.albahjah.sch.id',
        'phone' => '085203686699',
        'address' => 'Desa/Kel. Palmerah'
    ],
[
        'name' => 'REVI RIDHA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'revi.ridha@bogor.albahjah.sch.id',
        'phone' => '88809200959.0',
        'address' => 'Bojongbaru'
    ],
[
        'name' => 'Euis Darmayanti',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'euis.darmayanti@bogor.albahjah.sch.id',
        'phone' => '085012347713',
        'address' => 'Desa/Kel. Leuwiliang'
    ],
[
        'name' => 'SRI UTAMI ENDAH SUSANTI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sri.utami.endah.susanti@bogor.albahjah.sch.id',
        'phone' => '083414776703',
        'address' => 'Desa/Kel. Kranji'
    ],
[
        'name' => 'MELIA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'melia@bogor.albahjah.sch.id',
        'phone' => '89697686999.0',
        'address' => 'BOJONG NANGKA'
    ],
[
        'name' => 'SISKA PRATIWI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siska.pratiwi@bogor.albahjah.sch.id',
        'phone' => '89651151611.0',
        'address' => 'TEGAL ANGUS'
    ],
[
        'name' => 'YANI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'yani@bogor.albahjah.sch.id',
        'phone' => '81220802332.0',
        'address' => 'KUTAWARINGIN'
    ],
[
        'name' => 'Dwi Hariyanti',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dwi.hariyanti@bogor.albahjah.sch.id',
        'phone' => '81314906626.0',
        'address' => 'Cimuning'
    ],
[
        'name' => 'Masitoh',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'masitoh@bogor.albahjah.sch.id',
        'phone' => '81772857686.0',
        'address' => 'Sindanglaya'
    ],
[
        'name' => 'Sifah Fauziah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sifah.fauziah@bogor.albahjah.sch.id',
        'phone' => '89674570588.0',
        'address' => 'Semanan'
    ],
[
        'name' => 'Widayati',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'widayati@bogor.albahjah.sch.id',
        'phone' => '81314099988.0',
        'address' => 'Sertajaya'
    ],
[
        'name' => 'ANI WAHYUNI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ani.wahyuni@bogor.albahjah.sch.id',
        'phone' => '81234081200.0',
        'address' => 'MONDOKAN'
    ],
[
        'name' => 'EVA NITA JULAEHA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'eva.nita.julaeha@bogor.albahjah.sch.id',
        'phone' => '83891693380.0',
        'address' => 'Desa/Kel. Sukasari'
    ],
[
        'name' => 'DWI MARTINI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dwi.martini@bogor.albahjah.sch.id',
        'phone' => '89514388853.0',
        'address' => 'TELUK NAGA'
    ],
[
        'name' => 'NURLELA SARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'nurlela.sari@bogor.albahjah.sch.id',
        'phone' => '81352073040.0',
        'address' => 'LULUT'
    ],
[
        'name' => 'FUJI ARYANTI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'fuji.aryanti@bogor.albahjah.sch.id',
        'phone' => '81290275754.0',
        'address' => 'LEUWISADENG'
    ],
[
        'name' => 'AI SHOFIAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ai.shofiah@bogor.albahjah.sch.id',
        'phone' => '085251575486',
        'address' => 'Kayu Putih'
    ],
[
        'name' => 'Sifa Fauziah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sifa.fauziah@bogor.albahjah.sch.id',
        'phone' => '82111100083.0',
        'address' => 'Desa/Kel. Mekarwangi'
    ],
[
        'name' => 'KURMA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'kurma@bogor.albahjah.sch.id',
        'phone' => '81291259665.0',
        'address' => 'CANGKUDU'
    ],
[
        'name' => 'Niya Fithniyati',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'niya.fithniyati@bogor.albahjah.sch.id',
        'phone' => '085760971499',
        'address' => 'Desa/Kel. Suka Bakti'
    ],
[
        'name' => 'NURMALA SARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'nurmala.sari@bogor.albahjah.sch.id',
        'phone' => '082382620478',
        'address' => 'Desa/Kel. Taman Sari'
    ],
[
        'name' => 'PUTRI WULANDARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'putri.wulandari@bogor.albahjah.sch.id',
        'phone' => '85813190933.0',
        'address' => 'Desa/Kel. Pamijahan'
    ],
[
        'name' => 'Alimah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'alimah@bogor.albahjah.sch.id',
        'phone' => '083634388409',
        'address' => 'Desa/Kel. Purwawinangun'
    ],
[
        'name' => 'DEWI RATNASARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dewi.ratnasari@bogor.albahjah.sch.id',
        'phone' => '083721931501',
        'address' => 'Pasarean'
    ],
[
        'name' => 'Atikah',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'atikah@bogor.albahjah.sch.id',
        'phone' => '81298181726.0',
        'address' => 'Cibogo'
    ],
[
        'name' => 'PENI SULASTRI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'peni.sulastri@bogor.albahjah.sch.id',
        'phone' => '82312168910.0',
        'address' => 'PASIR SARI'
    ],
[
        'name' => 'Dedeh Dianawati',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dedeh.dianawati@bogor.albahjah.sch.id',
        'phone' => '082876580349',
        'address' => 'Cukang Galih'
    ],
[
        'name' => 'RENI NUR AENI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'reni.nur.aeni@bogor.albahjah.sch.id',
        'phone' => '82113116270.0',
        'address' => 'BOJONG JAYA'
    ],
[
        'name' => 'PRIHATIN',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'prihatin@bogor.albahjah.sch.id',
        'phone' => '81398569332.0',
        'address' => 'Desa/Kel. Tambun'
    ],
[
        'name' => 'IIS SETIAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'iis.setiawati@bogor.albahjah.sch.id',
        'phone' => '089193278096',
        'address' => 'Desa/Kel. Karang Timur'
    ],
[
        'name' => 'SURIMA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'surima@bogor.albahjah.sch.id',
        'phone' => '089245028002',
        'address' => 'Labuang'
    ],
[
        'name' => 'DIAH NURLITA YULIANTI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'diah.nurlita.yulianti@bogor.albahjah.sch.id',
        'phone' => '084934536121',
        'address' => 'BALEKAMBANG'
    ],
[
        'name' => 'Hj. ASYURO',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'hj..asyuro@bogor.albahjah.sch.id',
        'phone' => '085134019312',
        'address' => 'Desa/Kel. Karangasem'
    ],
[
        'name' => 'Nova Lensiana',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'nova.lensiana@bogor.albahjah.sch.id',
        'phone' => '089940711885',
        'address' => 'Cibogo'
    ],
[
        'name' => 'IPIH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ipih@bogor.albahjah.sch.id',
        'phone' => '089920007488',
        'address' => 'CIBEBER'
    ],
[
        'name' => 'Lina Novianti',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'lina.novianti@bogor.albahjah.sch.id',
        'phone' => '081516049262',
        'address' => 'Parung'
    ],
[
        'name' => 'EKA WAFIKA SURTINI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'eka.wafika.surtini@bogor.albahjah.sch.id',
        'phone' => '083079745866',
        'address' => 'Pasir Angin'
    ],
[
        'name' => 'SOLECHA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'solecha@bogor.albahjah.sch.id',
        'phone' => '083833488046',
        'address' => 'Desa/Kel. Cihideung Udik'
    ],
[
        'name' => 'KURNIA LISMA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'kurnia.lisma@bogor.albahjah.sch.id',
        'phone' => '089671733892',
        'address' => 'Desa/Kel. Sindangbarang'
    ],
[
        'name' => 'WINA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'wina@bogor.albahjah.sch.id',
        'phone' => '089505424876',
        'address' => 'Cipinang Cempedak'
    ],
[
        'name' => 'MAULIDAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'maulidah@bogor.albahjah.sch.id',
        'phone' => '089611364420',
        'address' => 'Desa/Kel. Ciaruten Udik'
    ],
[
        'name' => 'Erna Sri Yuliatin',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'erna.sri.yuliatin@bogor.albahjah.sch.id',
        'phone' => '087343882335',
        'address' => 'Harapan Baru'
    ],
[
        'name' => 'SITI SARA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti.sara@bogor.albahjah.sch.id',
        'phone' => '084390881937',
        'address' => 'PONDOK JAYA'
    ],
[
        'name' => 'HENA ROHAENA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'hena.rohaena@bogor.albahjah.sch.id',
        'phone' => '086544632268',
        'address' => 'Karehkel'
    ],
[
        'name' => 'WIRAHMA YANTI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'wirahma.yanti@bogor.albahjah.sch.id',
        'phone' => '085546736211',
        'address' => 'KEBON BARU'
    ],
[
        'name' => 'WAWAT MULYAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'wawat.mulyawati@bogor.albahjah.sch.id',
        'phone' => '084386973954',
        'address' => 'Desa/Kel. Munjul'
    ],
[
        'name' => 'ERFINA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'erfina@bogor.albahjah.sch.id',
        'phone' => '088660004349',
        'address' => 'Desa/Kel. Bojong Koneng'
    ],
[
        'name' => 'Siti Rahayu Hidayanti',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti.rahayu.hidayanti@bogor.albahjah.sch.id',
        'phone' => '082354002070',
        'address' => 'Sindangbarang'
    ],
[
        'name' => 'KIKI KURNIAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'kiki.kurniawati@bogor.albahjah.sch.id',
        'phone' => '083857703034',
        'address' => 'Desa/Kel. Cipayung'
    ],
[
        'name' => 'ADE ZAKIAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ade.zakiah@bogor.albahjah.sch.id',
        'phone' => '088446980443',
        'address' => 'SURADITA'
    ],
[
        'name' => 'NURHALIMAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'nurhalimah@bogor.albahjah.sch.id',
        'phone' => '086923456423',
        'address' => 'lulut'
    ],
[
        'name' => 'MASITOH PUSPITASARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'masitoh.puspitasari@bogor.albahjah.sch.id',
        'phone' => '084676455148',
        'address' => 'Desa/Kel. Cipulir'
    ],
[
        'name' => 'DEWI APRININGTIAS',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dewi.apriningtias@bogor.albahjah.sch.id',
        'phone' => '084523729000',
        'address' => 'Curug Sangereng'
    ],
[
        'name' => 'SITI AISYAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti.aisyah@bogor.albahjah.sch.id',
        'phone' => '089961044975',
        'address' => 'Grogol Selatan'
    ],
[
        'name' => 'HJ. RANIDEM',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'hj..ranidem@bogor.albahjah.sch.id',
        'phone' => '086409017661',
        'address' => 'CEMARA KULON'
    ],
[
        'name' => 'IDA SUAIDAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ida.suaidah@bogor.albahjah.sch.id',
        'phone' => '084125426394',
        'address' => 'Desa/Kel. Talaga'
    ],
[
        'name' => 'SRI RIZKI MULYANI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sri.rizki.mulyani@bogor.albahjah.sch.id',
        'phone' => '087279975834',
        'address' => 'Bale Kambang'
    ],
[
        'name' => 'DEVI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'devi@bogor.albahjah.sch.id',
        'phone' => '088201872814',
        'address' => 'Cihideung Ilir'
    ],
[
        'name' => 'MELAN MAELANI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'melan.maelani@bogor.albahjah.sch.id',
        'phone' => '085738843702',
        'address' => 'Desa/Kel. Pondok Bahar'
    ],
[
        'name' => 'Melati Agusti Wulandari',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'melati.agusti.wulandari@bogor.albahjah.sch.id',
        'phone' => '087104671189',
        'address' => 'Tanah Tinggi'
    ],
[
        'name' => 'FITRIAH HUSNI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'fitriah.husni@bogor.albahjah.sch.id',
        'phone' => '085206706162',
        'address' => 'TUGU SELATAN'
    ],
[
        'name' => 'ERMA RATNASARI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'erma.ratnasari@bogor.albahjah.sch.id',
        'phone' => '086419416697',
        'address' => 'Pasarean'
    ],
[
        'name' => 'Achdes Sumantri',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'achdes.sumantri@bogor.albahjah.sch.id',
        'phone' => '083467174946',
        'address' => 'Pancoran mas'
    ],
[
        'name' => 'KARMILA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'karmila@bogor.albahjah.sch.id',
        'phone' => '088606491924',
        'address' => 'MUSTIKAJAYA'
    ],
[
        'name' => 'SITI BARKAH KOMALA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti.barkah.komala@bogor.albahjah.sch.id',
        'phone' => '087551213158',
        'address' => 'JATINEGARA'
    ],
[
        'name' => 'IDA FARIDA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ida.farida@bogor.albahjah.sch.id',
        'phone' => '086190572378',
        'address' => 'Desa/Kel. Sukarame'
    ],
[
        'name' => 'AYU KENCANA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'ayu.kencana@bogor.albahjah.sch.id',
        'phone' => '088044550940',
        'address' => 'JAYA MUKTI'
    ],
[
        'name' => 'SUSI LISTIANA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'susi.listiana@bogor.albahjah.sch.id',
        'phone' => '084930785746',
        'address' => 'Kedoya Utara'
    ],
[
        'name' => 'FITRI YANTI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'fitri.yanti@bogor.albahjah.sch.id',
        'phone' => '089710050762',
        'address' => 'Pasirsari'
    ],
[
        'name' => 'Eneng Santi',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'eneng.santi@bogor.albahjah.sch.id',
        'phone' => '084209247592',
        'address' => 'Babakan Pari'
    ],
[
        'name' => 'DELA KOMALAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'dela.komalawati@bogor.albahjah.sch.id',
        'phone' => '081892979562',
        'address' => 'Petukangan Selatan'
    ],
[
        'name' => 'Hestin',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'hestin@bogor.albahjah.sch.id',
        'phone' => '085572494484',
        'address' => 'Desa/Kel. Suranenggala Kulon'
    ],
[
        'name' => 'ANY FAHRIYANI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'any.fahriyani@bogor.albahjah.sch.id',
        'phone' => '082577825157',
        'address' => 'CIPINANG MELAYU'
    ],
[
        'name' => 'ENDAH NURSANA ASSIPA',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'endah.nursana.assipa@bogor.albahjah.sch.id',
        'phone' => '087829458630',
        'address' => 'Sirnajaya'
    ],
[
        'name' => 'SRI NURHAYATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sri.nurhayati@bogor.albahjah.sch.id',
        'phone' => '084831402156',
        'address' => 'Poris Plawad Indah'
    ],
[
        'name' => 'Sri Warhuni',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'sri.warhuni@bogor.albahjah.sch.id',
        'phone' => '086846647107',
        'address' => 'Desa/Kel. Tajur'
    ],
[
        'name' => 'SITI  KOMARIYAH',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'siti..komariyah@bogor.albahjah.sch.id',
        'phone' => '085853835553',
        'address' => 'PASIR MUKTI'
    ],
[
        'name' => 'TETI ROSTIAWATI',
        'gender' => 'P',
        'relationship' => 'ibu',
        'email' => 'teti.rostiawati@bogor.albahjah.sch.id',
        'phone' => '086181556760',
        'address' => 'Pejaten Timur'
    ]
];

        foreach ($parents as $data) {
    $baseUsername = strtolower(Str::slug($data['name'], '_'));
    $username = $baseUsername;
    $counter = 1;

    // Cek dan buat username unik
    while (User::where('username', $username)->exists()) {
        $username = $baseUsername . '_' . $counter;
        $counter++;
    }

    $user = User::create([
        'uuid' => Str::uuid(),
        'name' => $data['name'],
        'email' => $data['email'],
        'username' => $username,
        'password' => Hash::make('password'),
        'role_id' => $roleId,
    ]);

    StudentParent::create([
        'uuid' => Str::uuid(),
        'user_id' => $user->id,
        'nik' => rand(1000000000000000, 9999999999999999),
        'name' => $data['name'],
        'gender' => $data['gender'],
        'relationship' => $data['relationship'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'address' => $data['address'],
        'is_active' => true,
    ]);
}

    }
}
