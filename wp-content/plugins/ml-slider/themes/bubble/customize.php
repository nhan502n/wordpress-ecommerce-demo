<?php
/**
 * Keep this file as is. 
 * You can optionally add array() values to allow to customize theme design
 * See themes/customize.php as reference
 */

return array(
    array(
        'label' => esc_html__('Arrows', 'ml-slider'),
        'name' => 'arrows',
        'type' => 'section',
        'default' => 'on',
        'settings' => array(
            array(
                'label' => esc_html__('Background', 'ml-slider'),
                'type' => 'fields',
                'fields' => array(
                    array(
                        'label' => esc_html__('Default', 'ml-slider'),
                        'name' => 'arrows_color',
                        'type' => 'color',
                        'default' => 'rgba(255,255,255,0.9)',
                        'css' => '[ms_id] .flexslider ul.flex-direction-nav li a { background: [ms_value] }'
                    ),
                    array(
                        'label' => esc_html__('Hover', 'ml-slider'),
                        'name' => 'arrows_color_hover',
                        'type' => 'color',
                        'default' => 'rgba(255,255,255,0.9)',
                        'css' => '[ms_id] .flexslider ul.flex-direction-nav li a:hover { background: [ms_value] }'
                    )
                )
            ),
            array(
                'label' => esc_html__('Icon Colors', 'ml-slider'),
                'type' => 'fields',
                'fields' => array(
                    array(
                        'label' => esc_html__('Default', 'ml-slider'),
                        'name' => 'arrows_icon',
                        'type' => 'color',
                        'default' => '#6c6c6c',
                        'css' => '[ms_id] .flexslider .flex-direction-nav li a:before { background-color: [ms_value] }'
                    ),
                    array(
                        'label' => esc_html__('Hover', 'ml-slider'),
                        'name' => 'arrows_icon_hover',
                        'type' => 'color',
                        'default' => '#6c6c6c',
                        'css' => '[ms_id] .flexslider .flex-direction-nav li a:hover:before { background-color: [ms_value] }'
                    )
                )
            ),
            /*array(
                'label' => esc_html__('Width', 'ml-slider'),
                'name' => 'arrows_width',
                'type' => 'range',
                'default' => 70,
                'metric' => 'px',
                'min' => 20,
                'max' => 100,
                'css' => '[ms_id] .flexslider ul.flex-direction-nav li a { width: [ms_value]px }'
            ),
            array(
                'label' => esc_html__('Height', 'ml-slider'),
                'name' => 'arrows_height',
                'type' => 'range',
                'default' => 70,
                'metric' => 'px',
                'min' => 20,
                'max' => 100,
                'css' => '[ms_id] .flexslider ul.flex-direction-nav li a { height: [ms_value]px }'
            ),*/
            array(
                'label' => esc_html__('Border Radius', 'ml-slider'),
                'name' => 'arrows_border_radius',
                'type' => 'range',
                'default' => 50,
                'metric' => '%',
                'min' => 0,
                'max' => 50,
                'css' => '[ms_id] .flexslider ul.flex-direction-nav li a { border-radius: [ms_value]% }'
            ),
            array(
                'label' => esc_html__('Opacity (default)', 'ml-slider'),
                'name' => 'arrows_opacity',
                'type' => 'range',
                'default' => 0.8,
                'min' => 0.1,
                'max' => 1,
                'step' => 0.1,
                'css' => '[ms_id] .flexslider .flex-direction-nav li a:not(:hover) { opacity: [ms_value] }'
            ),
            array(
                'label' => esc_html__('Opacity (hover)', 'ml-slider'),
                'name' => 'arrows_opacity_hover',
                'type' => 'range',
                'default' => 1,
                'min' => 0.1,
                'max' => 1,
                'step' => 0.1,
                'css' => '[ms_id] .flexslider .flex-direction-nav li a:hover { opacity: [ms_value] }'
            ),
        )
    ),
    array(
        'label' => esc_html__('Navigation', 'ml-slider'),
        'name' => 'navigation',
        'type' => 'section',
        'default' => 'on',
        'settings' => array(
            array(
                'label' => esc_html__('Colors', 'ml-slider'),
                'type' => 'fields',
                'fields' => array(
                    array(
                        'label' => esc_html__('Default', 'ml-slider'),
                        'name' => 'navigation_color',
                        'type' => 'color',
                        'default' => 'rgba(255,255,255,0.95)',
                        'css' => '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a:not(.flex-active):not(:hover) { background: [ms_value]; border-color: [ms_value] }'
                    ),
                    array(
                        'label' => esc_html__('Hover', 'ml-slider'),
                        'name' => 'navigation_color_hover',
                        'type' => 'color',
                        'default' => 'rgba(255,255,255,0.95)',
                        'css' =>  '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a:hover { border-color: [ms_value]; color: [ms_value] }'
                    ),
                    array(
                        'label' => esc_html__('Active', 'ml-slider'),
                        'name' => 'navigation_color_active',
                        'type' => 'color',
                        'default' => 'rgba(255,255,255,0.95)',
                        'css' => '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a.flex-active:not(:hover) { border-color: [ms_value]; color: [ms_value] }'
                    )
                )
            ),
            array(
                'label' => esc_html__('Numbers', 'ml-slider'),
                'type' => 'fields',
                'fields' => array(
                    array(
                        'label' => esc_html__('Default', 'ml-slider'),
                        'name' => 'navigation_number_color',
                        'type' => 'color',
                        'default' => 'rgba(74,74,74,0.8)',
                        'css' => '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a:not(.flex-active):not(:hover) { color: [ms_value] }'
                    ),
                    array(
                        'label' => esc_html__('Hover', 'ml-slider'),
                        'name' => 'navigation_number_color_hover',
                        'type' => 'color',
                        'default' => '#ffffff',
                        'css' =>  '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a:hover { color: [ms_value] }'
                    ),
                    array(
                        'label' => esc_html__('Active', 'ml-slider'),
                        'name' => 'navigation_number_color_active',
                        'type' => 'color',
                        'default' => '#ffffff',
                        'css' => '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a.flex-active:not(:hover) { color: [ms_value] }'
                    )
                )
            ),
            array(
                'label' => esc_html__('Dots Border Radius', 'ml-slider'),
                'name' => 'navigation_border_radius',
                'type' => 'range',
                'default' => 50,
                'metric' => '%',
                'min' => 0,
                'max' => 100,
                'css' => '[ms_id] .flexslider .flex-control-nav li a { border-radius: [ms_value]% }'
            ),
            array(
                'label' => esc_html__('Dots Width', 'ml-slider'),
                'name' => 'navigation_width',
                'type' => 'range',
                'default' => 70,
                'metric' => 'px',
                'min' => 20,
                'max' => 100,
                'css' => '[ms_id] .flexslider .flex-control-nav li a { width: [ms_value]px }'
            ),
            array(
                'label' => esc_html__('Dots Height', 'ml-slider'),
                'name' => 'navigation_height',
                'type' => 'range',
                'default' => 70,
                'metric' => 'px',
                'min' => 20,
                'max' => 100,
                'css' => '[ms_id] .flexslider .flex-control-nav li a { height: [ms_value]px }'
            ),
            array(
                'label' => esc_html__('Distance Between Dots', 'ml-slider'),
                'name' => 'navigation_between',
                'type' => 'range',
                'default' => 5,
                'metric' => 'px',
                'min' => 0,
                'max' => 20,
                'css' => '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a { margin: 0 [ms_value]px }'
            ),
            array(
                'label' => esc_html__('Dots Border Width', 'ml-slider'),
                'name' => 'navigation_border_width',
                'type' => 'range',
                'default' => 4,
                'metric' => 'px',
                'min' => 1,
                'max' => 10,
                'css' => '[ms_id] .flexslider ol.flex-control-nav:not(.flex-control-thumbs) li a { border-width: [ms_value]px }'
            ),
        )
    ),
    array(
        'label' => esc_html__('Caption', 'ml-slider'),
        'name' => 'caption',
        'type' => 'section',
        'default' => 'on',
        'settings' => array(
            array(
                'label' => esc_html__('Colors', 'ml-slider'),
                'type' => 'fields',
                'fields' => array(
                    array(
                        'label' => esc_html__('Background', 'ml-slider'),
                        'name' => 'caption_background',
                        'type' => 'color',
                        'default' => 'rgba(0,0,0,0.8)',
                        'css' =>  '[ms_id] .flexslider ul.slides .caption-wrap { background: linear-gradient(rgba(0,0,0,0),[ms_value]) }'
                    ),
                    array(
                        'label' => esc_html__('Text', 'ml-slider' ),
                        'name' => 'caption_text_color',
                        'type' => 'color',
                        'default' => '#ffffff',
                        'css' => '[ms_id] .flexslider ul.slides .caption-wrap .caption { color: [ms_value] }'
                    )
                )
            ),
            array(
                'label' => esc_html__('Font Size', 'ml-slider'),
                'name' => 'caption_font_size',
                'type' => 'range',
                'default' => 0.9,
                'metric' => 'rem',
                'min' => 0.5,
                'max' => 3,
                'step' => 0.1,
                'css' => '[ms_id] .flexslider .caption-wrap .caption { font-size: [ms_value]rem }'
            ),
            array(
                'label' => esc_html__('Line Height', 'ml-slider'),
                'name' => 'caption_line_height',
                'type' => 'range',
                'default' => 1.2,
                'metric' => 'rem',
                'min' => 0.5,
                'max' => 3,
                'step' => 0.1,
                'css' => '[ms_id] .flexslider .caption-wrap .caption { line-height: [ms_value]rem }'
            ),
            array(
                'label' => esc_html__('Text Align', 'ml-slider'),
                'name' => 'caption_text_align',
                'type' => 'select',
                'default' => 'center',
                'options' => array(
                    array(
                        'label' => esc_html__('Left', 'ml-slider'),
                        'value' => 'left'
                    ),
                    array(
                        'label' => esc_html__('Right', 'ml-slider'),
                        'value' => 'right'
                    ),
                    array(
                        'label' => esc_html__('Center', 'ml-slider'),
                        'value' => 'center'
                    )
                ),
                'css' => '[ms_id] .flexslider .caption-wrap .caption { text-align: [ms_value] }'
            ),
        )
    )
);