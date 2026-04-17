<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Excel Lao font (client-side)
    |--------------------------------------------------------------------------
    |
    | The .xlsx file only stores a font *name*. Microsoft Excel resolves it
    | on the machine that opens the file. "Noto Sans Lao" is correct only if
    | that font is installed; macOS ships "Lao Sangam MN", which renders
    | complex syllables (e.g. ລ້ຽງ) reliably. Override per environment:
    | REPORT_EXCEL_LAO_FONT="Phetsarath OT"
    |
    */
    'excel_lao_font' => env('REPORT_EXCEL_LAO_FONT', 'Lao Sangam MN'),

];
