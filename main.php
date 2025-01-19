<?php
/*
Plugin Name: add-url-to-blocks
Description: Add URL to blocks
*/

namespace AddUrlToBlocks;

add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_assets');
// add_filter('register_block_type_args', __NAMESPACE__ . '\chg_args', 10, 2);

function enqueue_assets()
{
    $asset_file = include plugin_dir_path(__FILE__) . 'build/index.asset.php';

    wp_enqueue_script(
        'add-url-to-blocks-scripts',
        plugin_dir_url(__FILE__) . 'build/index.js',
        $asset_file['dependencies'],
        $asset_file['version']
    );

    // wp_set_script_translations(
    //     'add-url-to-blocks-scripts',
    //     'add-url-to-blocks'
    // );

}

function chg_args($args, $block_type)
{

    if ('core/cover' === $block_type) {
        $args['attributes']['url'] = array(
            'type' => 'string',
        );
    }

    return $args;
}
