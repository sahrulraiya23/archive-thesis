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

        // Seed test data for RPL, KCV, and KBJ
        Thesis::create([
            'title' => 'Sistem Rekomendasi UMKM berbasis Web',
            'abstract' => 'Abstrak RPL',
            'type' => 'rpl',
            'author' => 'Budi Santoso',
            'program_study' => 'Rekayasa Perangkat Lunak (RPL)',
            'year' => 2026,
        ]);

        Thesis::create([
            'title' => 'Klasifikasi Citra Medis Menggunakan CNN',
            'abstract' => 'Abstrak KCV',
            'type' => 'kcv',
            'author' => 'Siti Aminah',
            'program_study' => 'Komputasi Cerdas dan Visual (KCV)',
            'year' => 2026,
        ]);

        Thesis::create([
            'title' => 'Monitoring IoT Sistem Keamanan Server Network',
            'abstract' => 'Abstrak KBJ',
            'type' => 'kbj',
            'author' => 'Andi Wijaya',
            'program_study' => 'Komputasi Berbasis Jaringan (KBJ)',
            'year' => 2025,
        ]);

        Thesis::create([
            'title' => 'Klasifikasi Lanjutan Sistem Rekomendasi RPL',
            'abstract' => 'Abstrak RPL 2',
            'type' => 'rpl',
            'author' => 'Dewi Lestari',
            'program_study' => 'Rekayasa Perangkat Lunak (RPL)',
            'year' => 2025,
        ]);
    }

    public function test_public_thesis_index_filters_by_rpl_type(): void
    {
        $response = $this->get(route('public.thesis.index', ['type' => 'rpl']));

        $response->assertStatus(200);
        $response->assertSee('Sistem Rekomendasi UMKM berbasis Web');
        $response->assertSee('Klasifikasi Lanjutan Sistem Rekomendasi RPL');
        $response->assertDontSee('Klasifikasi Citra Medis Menggunakan CNN');
        $response->assertDontSee('Monitoring IoT Sistem Keamanan Server Network');
    }

    public function test_public_thesis_index_filters_by_kcv_type(): void
    {
        $response = $this->get(route('public.thesis.index', ['type' => 'kcv']));

        $response->assertStatus(200);
        $response->assertSee('Klasifikasi Citra Medis Menggunakan CNN');
        $response->assertDontSee('Sistem Rekomendasi UMKM berbasis Web');
        $response->assertDontSee('Monitoring IoT Sistem Keamanan Server Network');
    }

    public function test_public_thesis_index_filters_by_kbj_type(): void
    {
        $response = $this->get(route('public.thesis.index', ['type' => 'kbj']));

        $response->assertStatus(200);
        $response->assertSee('Monitoring IoT Sistem Keamanan Server Network');
        $response->assertDontSee('Sistem Rekomendasi UMKM berbasis Web');
        $response->assertDontSee('Klasifikasi Citra Medis Menggunakan CNN');
    }

    public function test_filter_handles_uppercase_type_parameter(): void
    {
        $response = $this->get(route('public.thesis.index', ['type' => 'RPL']));

        $response->assertStatus(200);
        $response->assertSee('Sistem Rekomendasi UMKM berbasis Web');
        $response->assertDontSee('Klasifikasi Citra Medis Menggunakan CNN');
    }

    public function test_combined_search_and_type_filter(): void
    {
        // Searching for 'Klasifikasi' with type='rpl' should only match RPL thesis containing 'Klasifikasi'
        $response = $this->get(route('public.thesis.index', ['search' => 'Klasifikasi', 'type' => 'rpl']));

        $response->assertStatus(200);
        $response->assertSee('Klasifikasi Lanjutan Sistem Rekomendasi RPL');
        // KCV thesis also has 'Klasifikasi', but should NOT be shown because type is 'rpl'
        $response->assertDontSee('Klasifikasi Citra Medis Menggunakan CNN');
    }

    public function test_admin_thesis_index_filters_by_type(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/thesis?type=rpl');

        $response->assertStatus(200);
        $response->assertSee('Sistem Rekomendasi UMKM berbasis Web');
        $response->assertDontSee('Klasifikasi Citra Medis Menggunakan CNN');
    }

    public function test_admin_can_create_thesis_without_program_study_input(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/thesis', [
            'title' => 'Judul Penelitian Baru Tanpa Input Prodi',
            'abstract' => 'Abstrak baru',
            'type' => 'rpl',
            'author' => 'Mahasiswa Baru',
            'year' => 2026,
        ]);

        $response->assertRedirect('/admin/thesis');
        $this->assertDatabaseHas('thesis', [
            'title' => 'Judul Penelitian Baru Tanpa Input Prodi',
            'program_study' => 'S1 Teknik Informatika',
        ]);
    }

    public function test_admin_can_export_thesis_data_to_csv(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.thesis.export', ['type' => 'rpl']));

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
