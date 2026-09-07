<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

foreach (DB::table('thesis')->get() as $t) {
    $program = strtolower((string) $t->program_study);

    if (str_contains($program, 'jaringan') || str_contains($program, 'kbj')) {
        $type = 'kbj';
    } elseif (str_contains($program, 'rpl') || str_contains($program, 'rekayasa perangkat lunak')) {
        $type = 'rpl';
    } else {
        $type = 'kcv';
    }

    DB::table('thesis')->where('id', $t->id)->update(['type' => $type]);
}

$rows = DB::table('thesis')
    ->select('type', DB::raw('count(*) as total'))
    ->groupBy('type')
    ->get();

echo json_encode($rows, JSON_PRETTY_PRINT), PHP_EOL;
