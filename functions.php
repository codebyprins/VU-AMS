<?php

$theme_files = ['setup', 'menus', 'enqueue', 'acf', 'pagination'];

foreach ($theme_files as $file) {
    $path = "functions/{$file}.php";
    if (!locate_template($path, true, true)) {
        wp_die(sprintf(__('Error locating <code>%s</code> for inclusion.'), $path));
    }
}
