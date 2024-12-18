<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('setup_pagination')) {
    /**
     * Setup pagination for CodeIgniter
     *
     * @param string $base_url Base URL for pagination links
     * @param int $total_rows Total number of records
     * @param int $per_page Number of records per page
     * @param int $uri_segment URI segment containing the page number
     * @return array Pagination configuration
     */
    function setup_pagination($base_url, $total_rows, $per_page, $uri_segment = 3) {

        $CI = get_instance();
        $CI->load->library('pagination');
        
        // Pagination configuration
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;

        // Pagination customization
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        // Initialize pagination
        $CI->pagination->initialize($config);

        return [
            'links' => $CI->pagination->create_links(), // Pagination links
            'offset' => ($CI->uri->segment($uri_segment)) ? $CI->uri->segment($uri_segment) : 0, // Offset
        ];
    }
}
