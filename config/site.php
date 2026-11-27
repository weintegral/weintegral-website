<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sample content
    |--------------------------------------------------------------------------
    |
    | When true, every page shows a "Sample content — not for publication"
    | banner and fictional values (App\Content\SampleContent) fill the gaps
    | that await owner facts, so the owner can review the complete site
    | locally. It is ignored when APP_ENV is production.
    |
    */

    'sample_content' => (bool) env('SITE_SAMPLE_CONTENT', false),

];
