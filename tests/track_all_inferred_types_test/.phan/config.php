<?php

use \Phan\Issue;

/**
 * This configuration tests the `track_all_inferred_types` config setting.
 */
return [
    'target_php_version' => '8.1',
    'assume_real_types_for_internal_functions' => true,
    'allow_missing_properties' => true,
    'null_casts_as_any_type' => false,
    'scalar_implicit_cast' => false,
    'dead_code_detection' => false,
    'unused_variable_detection' => true,
    'minimum_severity' => Issue::SEVERITY_LOW,
    'directory_list' => ['src'],
    'analyzed_file_extensions' => ['php'],
    'cache_polyfill_asts' => false,
    'plugins' => [],
    'track_all_inferred_types' => true,
];
