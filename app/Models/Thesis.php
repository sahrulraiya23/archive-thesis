<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'thesis';

    protected $fillable = [
        'title',
        'keywords',
        'abstract',
        'author',
        'program_study',
        'year',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    /**
     * Ekstraksi otomatis tepat 5 kata kunci dari Judul dengan memprioritaskan nama Algoritma / Metode / Teknologi.
     */
    public static function extractKeywordsFromTitle(string $title, int $count = 5): string
    {
        // 1. Daftar Algoritma & Metode Terkemuka (Diprioritaskan Utama)
        $knownAlgorithms = [
            'YOLO', 'CNN', 'LSTM', 'XGBoost', 'SVM', 'Fuzzy', 'IoT', 'KNN', 'Rabin-Karp', 'SWR', 
            'Next.js', 'Laravel', 'GIS', 'Android', 'MobileNet', 'ResNet', 'VGG', 'BERT', 
            'K-Means', 'AHP', 'SAW', 'TOPSIS', 'C4.5', 'Naive Bayes', 'Random Forest', 
            'Decision Tree', 'Genetic Algorithm', 'TF-IDF', 'Microservices', 'Blockchain', 
            'React', 'Vue', 'Flutter', 'Augmented Reality', 'Virtual Reality', 'OCR', 'NLP', 
            'Deep Learning', 'Machine Learning', 'Computer Vision', 'Web', 'API', 'CodeIgniter', 
            'Firebase', 'MySQL', 'PostgreSQL', 'Python', 'PHP', 'TensorFlow', 'PyTorch'
        ];

        $prioritized = [];

        // Deteksi jika judul mengandung singkatan dalam kurung seperti "(YOLO)", "(CNN)", "(SWR)"
        if (preg_match_all('/\(([\p{L}\p{N}\-.]+)\)/u', $title, $matches)) {
            foreach ($matches[1] as $match) {
                $mClean = trim($match);
                if (mb_strlen($mClean) >= 2 && !in_array(mb_strtolower($mClean), ['uho', 'ti', 'skripsi', 'ta', 'spk'])) {
                    $prioritized[] = $mClean;
                }
            }
        }

        // Cari algoritma yang cocok dari database algoritma terkemuka
        foreach ($knownAlgorithms as $algo) {
            if (preg_match('/\b' . preg_quote($algo, '/') . '\b/i', $title)) {
                if (!in_array(mb_strtolower($algo), array_map('mb_strtolower', $prioritized))) {
                    $prioritized[] = $algo;
                }
            }
        }

        // 2. Ekstraksi Kata-kata lain dari judul
        $cleanedTitle = preg_replace('/[^\p{L}\p{N}\s\-.]+/u', ' ', $title);
        $words = array_values(array_filter(explode(' ', $cleanedTitle)));

        $stopWords = [
            'dan', 'atau', 'yang', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada', 'dalam',
            'oleh', 'terhadap', 'sebagai', 'studi', 'kasus', 'berbasis', 'menggunakan',
            'penerapan', 'implementasi', 'pengembangan', 'perancangan', 'rancang', 'bangun',
            'analisis', 'sistem', 'aplikasi', 'metode', 'algoritma', 'model', 'data',
            'uho', 'teknik', 'informatika', 'tingkat', 'upaya', 'hasil', 'pada',
            'skripsi', 'tugas', 'akhir', 'judul', 'kemiripan', 'validasi', 'pengajuan'
        ];

        $generalWords = [];
        foreach ($words as $w) {
            $wClean = trim($w, " \t\n\r\0\x0B.-()");
            if (mb_strlen($wClean) >= 3 && !in_array(mb_strtolower($wClean), $stopWords)) {
                if (!in_array(mb_strtolower($wClean), array_map('mb_strtolower', $prioritized)) &&
                    !in_array(mb_strtolower($wClean), array_map('mb_strtolower', $generalWords))) {
                    $generalWords[] = $wClean;
                }
            }
        }

        // Gabungkan: Algoritma diprioritaskan di depan, diikuti kata umum penting
        $merged = array_merge($prioritized, $generalWords);

        // Jika kurang dari 5, ambil kata apa saja >= 3 karakter dari judul yang belum terambil
        if (count($merged) < $count) {
            foreach ($words as $w) {
                $wClean = trim($w, " \t\n\r\0\x0B.-()");
                if (mb_strlen($wClean) >= 3 && !in_array(mb_strtolower($wClean), array_map('mb_strtolower', $merged))) {
                    $merged[] = $wClean;
                }
                if (count($merged) >= $count) {
                    break;
                }
            }
        }

        // Backup kata IT jika masih kurang dari 5
        $fallbackWords = ['Informatika', 'Algoritma', 'Sistem', 'Aplikasi', 'Database', 'Teknologi', 'Web', 'Data'];
        foreach ($fallbackWords as $fb) {
            if (count($merged) >= $count) {
                break;
            }
            if (!in_array(mb_strtolower($fb), array_map('mb_strtolower', $merged))) {
                $merged[] = $fb;
            }
        }

        $selected = array_slice($merged, 0, $count);

        return implode(', ', $selected);
    }

    /**
     * Mengembalikan array berisi tepat 5 kata kunci individual (per kata).
     */
    public function getKeywordArrayAttribute(): array
    {
        if (empty($this->keywords)) {
            $extractedStr = self::extractKeywordsFromTitle($this->title ?? '', 5);
            return array_map('trim', explode(',', $extractedStr));
        }

        // Jika keywords berisi kalimat panjang tanpa koma (seperti judul)
        if (!str_contains($this->keywords, ',')) {
            $words = array_values(array_filter(explode(' ', preg_replace('/[^\p{L}\p{N}\s\-.]+/u', ' ', $this->keywords))));
            if (count($words) > 3) {
                $extractedStr = self::extractKeywordsFromTitle($this->keywords, 5);
                return array_map('trim', explode(',', $extractedStr));
            }
        }

        $items = array_values(array_filter(array_map('trim', explode(',', $this->keywords)), fn($w) => $w !== ''));

        if (count($items) < 5 && !empty($this->title)) {
            $extractedStr = self::extractKeywordsFromTitle($this->title, 5);
            return array_map('trim', explode(',', $extractedStr));
        }

        return array_slice($items, 0, 5);
    }
}
