<?php

namespace Tests\Unit;

use App\Models\Thesis;
use Tests\TestCase;

class ThesisTypeTest extends TestCase
{
    public function test_thesis_types_use_peminatan(): void
    {
        $this->assertSame([
            'kcv' => 'Komputasi Cerdas dan Visual',
            'kbj' => 'Komputasi Berbasis Jaringan',
            'rpl' => 'Rekayasa Perangkat Lunak',
        ], Thesis::getTypes());
    }
}
