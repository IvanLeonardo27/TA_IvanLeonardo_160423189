<?php

namespace App\Http\Controllers;

use App\Models\AraneAnakKewan;
use App\Models\AraneGodhong;
use App\Models\AraneIsi;
use App\Models\AraneKembang;
use App\Models\AranePentil;
use App\Models\AraneWit;
use App\Models\AraneWoh;
use App\Models\AraneWong;
use App\Models\PrenahSedulur;
use App\Models\SebutaneBocah;
use App\Models\UrutaneSedulur;
use App\Models\UrutaneTurunan;
use Illuminate\Http\Request;

class KawruhBasaController extends Controller
{
    /**
     * Definisi Seluruh Kategori Kawruh Basa Jawa (Tetuwuhan, Kewan, Manungsa)
     */
    public const CATEGORIES = [
        // Tetuwuhan (Tumbuhan)
        'arane_kembang' => [
            'name'  => 'Arane Kembang',
            'desc'  => 'Sebutan arane kembang utawa sekar ing basa Jawa.',
            'icon'  => 'fa-spa',
            'model' => AraneKembang::class,
        ],
        'arane_pentil' => [
            'name'  => 'Arane Pentil',
            'desc'  => 'Sebutan arane woh-wohan sing isih cilik utawa enom.',
            'icon'  => 'fa-seedling',
            'model' => AranePentil::class,
        ],
        'arane_woh' => [
            'name'  => 'Arane Woh',
            'desc'  => 'Sebutan jeneng woh-wohan tradisi Jawa.',
            'icon'  => 'fa-apple-whole',
            'model' => AraneWoh::class,
        ],
        'arane_isi' => [
            'name'  => 'Arane Isi',
            'desc'  => 'Sebutan jeneng isi utawa wiji woh-wohan ing basa Jawa.',
            'icon'  => 'fa-cubes-stacked',
            'model' => AraneIsi::class,
        ],
        'arane_wit' => [
            'name'  => 'Arane Wit',
            'desc'  => 'Sebutan jeneng wit-witan ing basa Jawa.',
            'icon'  => 'fa-tree',
            'model' => AraneWit::class,
        ],
        'arane_godhong' => [
            'name'  => 'Arane Godhong',
            'desc'  => 'Sebutan jeneng godhong-godhongan ing basa Jawa.',
            'icon'  => 'fa-leaf',
            'model' => AraneGodhong::class,
        ],
        // Kewan (Hewan)
        'arane_anak_kewan' => [
            'name'  => 'Arane Anak Kewan',
            'desc'  => 'Sebutan nama-nama anak hewan dalam bahasa Jawa.',
            'icon'  => 'fa-paw',
            'model' => AraneAnakKewan::class,
        ],
        // Manungsa (Kekerabatan & Ciri)
        'urutane_turunan' => [
            'name'  => 'Urutane Turunan',
            'desc'  => 'Tingkatan silsilah keturunan dan leluhur tradisi Jawa.',
            'icon'  => 'fa-sitemap',
            'model' => UrutaneTurunan::class,
        ],
        'urutane_sedulur' => [
            'name'  => 'Urutane Sedulur',
            'desc'  => 'Urutan kelahiran saudara kandung dalam keluarga Jawa.',
            'icon'  => 'fa-people-roof',
            'model' => UrutaneSedulur::class,
        ],
        'prenah_sedulur' => [
            'name'  => 'Prenah Sedulur',
            'desc'  => 'Sebutan sapaan dan kekerabatan keluarga Jawa.',
            'icon'  => 'fa-users',
            'model' => PrenahSedulur::class,
        ],
        'arane_wong' => [
            'name'  => 'Arane Wong',
            'desc'  => 'Sebutan untuk profesi, kebiasaan, atau kondisi seseorang.',
            'icon'  => 'fa-user-tag',
            'model' => AraneWong::class,
        ],
        'sebutane_bocah' => [
            'name'  => 'Sebutane Bocah',
            'desc'  => 'Sebutan khusus untuk anak berdasarkan urutan atau keunikan kelahiran.',
            'icon'  => 'fa-children',
            'model' => SebutaneBocah::class,
        ],
    ];

    /**
     * Tampilkan Halaman Katalog Kawruh Basa Jawa
     */
    public function index(Request $request)
    {
        $activeCategory = $request->query('category', 'arane_kembang');

        if (!array_key_exists($activeCategory, self::CATEGORIES)) {
            $activeCategory = 'arane_kembang';
        }

        $categoryMeta = self::CATEGORIES[$activeCategory];
        $modelClass   = $categoryMeta['model'];

        $search = $request->query('search');

        $query = $modelClass::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('javanese_term', 'like', "%{$search}%")
                  ->orWhere('indonesia_meaning', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('id', 'asc')->paginate(12)->withQueryString();

        // Hitung jumlah record per kategori untuk badge tab
        $counts = [];
        $totalAll = 0;
        foreach (self::CATEGORIES as $key => $meta) {
            $count = $meta['model']::count();
            $counts[$key] = $count;
            $totalAll += $count;
        }

        return view('kawruh-basa.index', [
            'categories'     => self::CATEGORIES,
            'activeCategory' => $activeCategory,
            'categoryMeta'   => $categoryMeta,
            'items'          => $items,
            'counts'         => $counts,
            'totalAll'       => $totalAll,
            'search'         => $search,
        ]);
    }
}
