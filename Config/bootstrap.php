<?php
	if (!is_dir(CACHE . 'seo_tools')) {
		@mkdir(CACHE . 'seo_tools');
	}

    Cache::config('seo_tools_optimized_url',
        array(
            'engine' => 'File',
            'path' => CACHE . 'seo_tools',
            'duration' => '+10 Years'
        )
    );