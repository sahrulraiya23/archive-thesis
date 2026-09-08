<?php

namespace Tests\Feature;

use App\Models\Thesis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThesisFilterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Thesis::create([
            'title' => 'Sistem Rekomendasi UMKM berbasis Web',
            'keywords' => 'sistem, rekomendasi, umkm, web, aplikasi',
            'abstract' => 'Abstrak RPL',
            'author' => 'Budi Santoso',
            'nim' => 'E1E122001',
            'program_study' => 'S1 Teknik Informatika',
            'year' => 2026,
        ]);

        Thesis::create([
            'title' => 'Klasifikasi Citra Medis Menggunakan CNN',
            'keywords' => 'klasifikasi, citra, medis, cnn, python',
            'abstract' => 'Abstrak KCV',
            'author' => 'Siti Aminah',
            'nim' => 'E1E122002',
            'program_study' => 'S1 Teknik Informatika',
            'year' => 2026,
        ]);

        Thesis::create([
            'title' => 'Monitoring IoT Sistem Keamanan Server Network',
            'keywords' => 'monitoring, iot, keamanan, server, network',
            'abstract' => 'Abstrak KBJ',
            'author' => 'Andi Wijaya',
            'nim' => 'E1E122003',
            'program_study' => 'S1 Teknik Informatika',
            'year' => 2025,
        ]);

        Thesis::create([
            'title' => 'Klasifikasi Lanjutan Sistem Rekomendasi RPL',
            'keywords' => 'klasifikasi, sistem, rekomendasi, rpl, database',
            'abstract' => 'Abstrak RPL 2',
            'author' => 'Dewi Lestari',
            'nim' => 'E1E122004',
            'program_study' => 'S1 Teknik Informatika',
            'year' => 2025,
        ]);
    }

    public function test_public_thesis_index_searches_by_nim(): void
    {
        $response = $this->get(route('public.thesis.index', ['search' => 'E1E122002']));

        $response->assertStatus(200);
        $response->assertSee('Siti Aminah');
        $response->assertSee('E1E122002');
        $response->assertDontSee('Budi Santoso');
    }

    public function test_public_thesis_index_searches_keywords(): void
    {
        $response = $this->get(route('public.thesis.index', ['search' => 'CNN']));

        $response->assertStatus(200);
        $response->assertSee('Klasifikasi Citra Medis Menggunakan CNN');
        $response->assertDontSee('Sistem Rekomendasi UMKM berbasis Web');
        $response->assertDontSee('Monitoring IoT Sistem Keamanan Server Network');
    }

    public function test_public_thesis_index_filters_by_year(): void
    {
        $response = $this->get(route('public.thesis.index', ['year' => 2025]));

        $response->assertStatus(200);
        $response->assertSee('Monitoring IoT Sistem Keamanan Server Network');
        $response->assertDontSee('Klasifikasi Citra Medis Menggunakan CNN');
    }

    public function test_admin_can_create_thesis_without_program_study_input(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/thesis', [
            'title' => 'Judul Penelitian Baru Tanpa Input Prodi',
            'keywords' => 'penelitian, baru, sistem, informasi, web',
            'abstract' => 'Abstrak baru',
            'author' => 'Mahasiswa Baru',
            'year' => 2026,
        ]);

        $response->assertRedirect('/admin/thesis');
        $this->assertDatabaseHas('thesis', [
            'title' => 'Judul Penelitian Baru Tanpa Input Prodi',
            'program_study' => 'S1 Teknik Informatika',
        ]);
    }

    public function test_admin_auto_extracts_five_keywords_from_title_when_empty(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/thesis', [
            'title' => 'Rancang Bangun Sistem Informasi Geografis Pemetaan Lokasi UMKM Berbasis Web Python',
            'keywords' => '', // Dikosongkan agar mengekstrak otomatis
            'abstract' => 'Abstrak uji otomatis',
            'author' => 'Penguji Auto Extract',
            'year' => 2026,
        ]);

        $response->assertRedirect('/admin/thesis');
        $createdThesis = Thesis::where('author', 'Penguji Auto Extract')->first();
        $this->assertNotNull($createdThesis);
        $extracted = array_map('trim', explode(',', $createdThesis->keywords));
        $this->assertCount(5, $extracted);
    }

    public function test_algorithm_terms_are_prioritized_in_keyword_extraction(): void
    {
        $title = 'Deteksi Objek Kendaraan Menggunakan Algoritma You Only Look Once (YOLO) Berbasis Web Next.js';
        $keywords = Thesis::extractKeywordsFromTitle($title, 5);

        $extracted = array_map('trim', explode(',', $keywords));
        $this->assertCount(5, $extracted);
        $this->assertContains('YOLO', $extracted);
        $this->assertContains('Next.js', $extracted);
    }

    public function test_admin_can_update_existing_thesis(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $thesis = Thesis::first();

        $response = $this->actingAs($admin)->put(route('admin.thesis.update', $thesis), [
            'title' => 'Judul Tugas Akhir Terupdate Oleh Admin Dengan Judul Yang Cukup Panjang',
            'keywords' => 'update, judul, admin, sistem, web',
            'abstract' => 'Abstrak terupdate',
            'author' => 'Penulis Terupdate',
            'year' => 2026,
        ]);

        $response->assertRedirect('/admin/thesis');
        $this->assertDatabaseHas('thesis', [
            'id' => $thesis->id,
            'title' => 'Judul Tugas Akhir Terupdate Oleh Admin Dengan Judul Yang Cukup Panjang',
            'author' => 'Penulis Terupdate',
        ]);
    }

    public function test_admin_can_export_thesis_data_to_csv(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.thesis.export'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Sistem Rekomendasi UMKM berbasis Web', $response->streamedContent());
    }

    public function test_plagiarism_check_highlights_shared_words(): void
    {
        $response = $this->post(route('plagiarism.submit'), [
            'title' => 'Klasifikasi Citra Medis Berbasis Web',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Kata Kunci Cocok:');
        $response->assertSee('klasifikasi');
        $response->assertSee('citra');
        $response->assertSee('<mark class="bg-warning text-dark px-1 rounded fw-semibold">Klasifikasi</mark>', false);
    }
}
