<?php

if (!defined('ABSPATH')) {
    exit;
}

class WabbrGrid extends WabbrShortcode
{
    /**
     * Shortcodes.
     */
    public function addShortcodes()
    {
        add_shortcode('container', [&$this, 'container']);
        add_shortcode('row', [&$this, 'row']);
        add_shortcode('col', [&$this, 'col']);

        // Fix nested shortcodes
        add_shortcode('child-row', [&$this, 'row']);
        add_shortcode('child-col', [&$this, 'col']);
    }

    /**
     * Container.
     *
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function container($atts, $content = null)
    {
        extract(shortcode_atts([
            'class'     => '',
        ], $atts));

        return '<div class="container wabbr wabbr-container '.$class.'">'.do_shortcode($content).'</div>';
    }

    /**
     * Row.
     *
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function row($atts, $content = null)
    {
        extract(shortcode_atts([
            'class'     => '',
        ], $atts));

        return '<div class="row wabbr wabbr-row '.$class.'">'.do_shortcode($content).'</div>';
    }

    /**
     * Col.
     *
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function col($atts, $content = null)
    {
        extract(shortcode_atts([
            'size'      => '',
            'class'     => '',
        ], $atts));

        // Convert numeric classes
        $size = $this->_convertSizes($size);

        // Output
        return '<div class="wabbr-col '.$size.' '.$class.'">'.do_shortcode($content).'</div>';
    }

    /**
     * Convert sizes.
     *
     * @param array $size
     *
     * @return string
     */
    private function _convertSizes($size)
    {
        $sizes = explode(' ', $size);
        $classes = [];

        foreach ($sizes as $size) {
            if (preg_match('/^[0-9]{1,2}\/[0-9]{1,2}$/', $size)) {
                switch ($size) {
                    case '1/2':
                    case '2/4':
                    case '3/6':
                    case '4/8':
                    case '5/10':
                    case '6/12':
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-6', 'col-lg-6']);
                    break;

                    case '1/3':
                    case '2/6':
                    case '3/9':
                    case '4/12':
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-4', 'col-lg-4']);
                    break;

                    case '1/4':
                    case '2/8':
                    case '3/12':
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-3', 'col-lg-3']);
                    break;

                    case '1/6':
                    case '2/12':
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-2', 'col-lg-2']);
                    break;

                    case '2/3':
                    case '4/6':
                    case '8/12':
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-8', 'col-lg-8']);
                    break;

                    case '3/4':
                    case '6/8':
                    case '9/12':
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-9', 'col-lg-9']);
                    break;

                    case '5/6':
                    case '10/12':
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-10', 'col-lg-10']);
                    break;

                    default:
                        $classes = array_merge($classes, ['col-xs-12', 'col-sm-12', 'col-md-12', 'col-lg-12']);
                    break;
                }
            } else {
                $classes[] = $size;
            }
        }

        $class = apply_filters('wabbr_col_class', $classes, $size);
        $class = is_array($class) ? implode(' ', $class) : $class;

        return $class;
    }
}
