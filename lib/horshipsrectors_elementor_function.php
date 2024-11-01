<?php

function show_website_content_in_wordpress_page_or_post_elementor_block() {
    if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {

        class My_Elementor_Custom_Block_Widget extends \Elementor\Widget_Base {
            public function get_name() {
                return 'my-elementor-custom-block';
            }

            public function get_title() {
                return __('Show Website Content in Page or Post', 'show-website-ciwpop');
            }

            public function get_icon() {
                return 'eicon-product-description';
            }

            public function get_categories() {
                return ['basic']; 
            }

            protected function _register_controls() {
                $this->start_controls_section(
                    'section_content',
                    [
                        'label' => __('Settings', 'show-website-ciwpop'),
                    ]
                );

                $this->add_control(
                    'site_url',
                    [
                        'label' => __('Website URL', 'show-website-ciwpop'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => 'https://wordpress.org',
                    ]
                );

                $this->add_control(
                    'select_option',
                    [
                        'label' => __('Selection Option', 'show-website-ciwpop'),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            'horshipsrectors_get_html' => __('Standard', 'show-website-ciwpop'),
                            'horshipsrectors_get_html_get' => __('GET method', 'show-website-ciwpop'),
                            'horshipsrectors_get_html_curl' => __('cURL library', 'show-website-ciwpop'),
                        ],
                        'default' => 'horshipsrectors_get_html',
                    ]
                );

                $this->end_controls_section();
            }

            public function render() {
                $settings = $this->get_settings();
                $site_url = !empty($settings['site_url']) ? esc_url($settings['site_url']) : 'https://wordpress.org';
                $select_option = !empty($settings['select_option']) ? $settings['select_option'] : 'horshipsrectors_get_html';

                // Utilizza il tuo shortcode con il sito configurabile
                echo do_shortcode("[$select_option $site_url]");
            }
        }

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new My_Elementor_Custom_Block_Widget());
    }
}

