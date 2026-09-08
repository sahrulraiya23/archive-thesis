<?php

namespace Tests\Unit;

use App\Models\Thesis;
use Tests\TestCase;

class ThesisTypeTest extends TestCase
{
    public function test_thesis_accepts_keywords(): void
    {
        $thesis = new Thesis(['title' => 'Judul', 'keywords' => 'kata kunci']);

        $this->assertSame('kata kunci', $thesis->keywords);
    }
}
