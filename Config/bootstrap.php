<?php
    Cache::config('seo_tools_optimized_url',
        array(
            'engine' => 'File',
            'path' => TMP . 'cache' . DS,
            'duration' => '+10 Years'
        )
    );