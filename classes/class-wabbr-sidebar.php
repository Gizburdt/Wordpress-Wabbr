<?php

class Wabbr_Sidebar extends Wabbr_Shortcode
{
    /**
     * Shortcodes
     */
    function add_shortcodes()
    {
        add_shortcode( 'sidebar', array( &$this, 'sidebar' ) );
    }

    /**
     * Sidebar.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    function sidebar( $atts, $content = null )
    {
        extract( shortcode_atts( array(
            'name'  => '',
            'class' => ''
        ), $atts ) );

        // View
        Wabbr::view('sidebar', array(
            'name'       => $name,
            'class'      => $class,
            'responsive' => $responsive
        ));
    }
}
