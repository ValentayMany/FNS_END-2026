<?php

namespace Tests\Unit;

use App\Support\LaoText;
use PHPUnit\Framework\TestCase;

class LaoTextTest extends TestCase
{
    public function test_reorders_semivowel_nyo_before_tone_after_consonant(): void
    {
        $c = static fn (int $cp): string => mb_chr($cp, 'UTF-8');
        // Wrong: ລ ຽ ້ ງ — tone after ຽ → dotted circle in Excel
        $wrong = $c(0x0EA5).$c(0x0EBD).$c(0x0EC9).$c(0x0E87);
        // Expected: ລ ້ ຽ ງ
        $expect = $c(0x0EA5).$c(0x0EC9).$c(0x0EBD).$c(0x0E87);

        $this->assertSame($expect, LaoText::normalize($wrong));
    }

    public function test_leaves_already_correct_order_unchanged(): void
    {
        $c = static fn (int $cp): string => mb_chr($cp, 'UTF-8');
        $ok = $c(0x0EA5).$c(0x0EC9).$c(0x0EBD).$c(0x0E87);

        $this->assertSame($ok, LaoText::normalize($ok));
    }

    public function test_reorders_tone_after_coda_ng_before_semivowel_ny(): void
    {
        $c = static fn (int $cp): string => mb_chr($cp, 'UTF-8');
        // ລ ຽ ງ ້
        $wrong = $c(0x0EA5).$c(0x0EBD).$c(0x0E87).$c(0x0EC9);
        $expect = $c(0x0EA5).$c(0x0EC9).$c(0x0EBD).$c(0x0E87);

        $this->assertSame($expect, LaoText::normalize($wrong));
    }
}
