<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('redirect')) {

    function redirect($uri = '', $method = 'location', $http_response_code = 302) {
        if (!preg_match('#^https?://#i', $uri)) {
            $uri = site_url($uri);
        }
        $_CI = &get_instance();
        if ($_CI->input->is_ajax_request())
            die(json_encode(array('status' => strval($http_response_code), 'location' => $uri)));
        switch ($method) {
            case 'refresh' : header("Refresh:0;url=" . $uri);
                break;
            default : header("Location: " . $uri, TRUE, $http_response_code);
                break;
        }
        exit;
    }

}

if (!function_exists('url_rewrite')) {
    function url_rewrite ($str = '', $id = NULL) {
        $str = str_replace(' ', '-', strtolower(convert_accented_characters($str)));
        $str = preg_replace('#[^a-z0-9]#i', '-', $str);
        $str = preg_replace('#\-{1,}#', '-', $str);
        $str .= intval($id) ? '-'.$id.'.html' : '';
        return $str;
    }
}

/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */