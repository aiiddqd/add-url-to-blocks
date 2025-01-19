<?php
/*
Plugin Name: @ add URL to blocks
Description: Add URL to blocks like Cover, Group etc
Plugin URI: https://github.com/aiiddqd/add-url-to-blocks
Version: 0.2.250119
*/

namespace AddUrlToBlocks;

use WP_HTML_Tag_Processor;

defined( 'ABSPATH' ) || exit;

add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_assets');
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\assets' );
add_filter('render_block_core/cover', __NAMESPACE__ . '\change_block_html', 10, 2);

/**
 * @param string $block_content The original HTML content of the block.
 * @param array  $block         The block details, including attributes.
 * @return string               The modified block content with the decorative role applied, or the original content if not decorative.
 */
function change_block_html($block_content, $block)
{
    $urlCustom = $block['attrs']['urlCustom'] ?? null;
    $urlCustomNewTab = $block['attrs']['urlCustomNewTab'] ?? null;
    do_action('qm/debug', $block_content);

    if ($urlCustom) {

        // Use the HTML API to modify the block content.
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($block_content, 'HTML-ENTITIES', "UTF-8"));

        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query('//div[contains(@class, "wp-block-cover")]');
        if ($elements->length) {
            $element = $elements->item(0);
            $element->setAttribute('class', $element->getAttribute('class') . ' has-link');
            $a = $dom->createElement('a');
            $a->setAttribute('href', $urlCustom);
            $a->setAttribute('class', 'url-wrapper');
            if ($urlCustomNewTab) {
                $a->setAttribute('target', '_blank');
                $a->setAttribute('rel', 'noopener noreferrer');
            }
            $element->appendChild($a);
        }
        $block_content = $dom->saveHTML();

    }

    return $block_content;
}

function enqueue_assets()
{
    $asset_file = include plugin_dir_path(__FILE__) . 'build/index.asset.php';

    wp_enqueue_script(
        'add-url-to-blocks-scripts',
        plugin_dir_url(__FILE__) . 'build/index.js',
        $asset_file['dependencies'],
        $asset_file['version']
    );

    // @todo
    // wp_set_script_translations(
    //     'add-url-to-blocks-scripts',
    //     'add-url-to-blocks'
    // );

}

function assets()
{
    $asset_file = include plugin_dir_path(__FILE__) . 'build/index.asset.php';

    wp_enqueue_style(
        'add-url-to-blocks-style',
        plugin_dir_url(__FILE__) . 'build/index.css',
        [],
        $asset_file['version']
    );
}
