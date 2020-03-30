<?php

defined('BASEPATH') or exit('No direct script access allowed');


if (!function_exists('trim_str')) {

    function trim_str($str = '') {
        $str = str_replace('&nbsp;', ' ', $str);
        return preg_replace('/\s+/', ' ', strip_tags($str));
    }

}

if (!function_exists('formatt_array')) {

    function formatt_array($results, $id, $name, $word) {
        $data = array("Tous les $word");
        if ($results) {
            foreach ($results AS $v)
                $data[$v->$id] = $v->$name;
            return $data;
        } else {
            return NULL;
        }
    }

}

if (!function_exists('p')) {

    function p($data) {
        echo '<pre><p>';
        print_r($data);
        echo '</p></pre>';
    }

}

function navigation($header_nav) {

    return '';
}

function process_sub_nav($nav_item,$lang='') {
    $sub_item_htm = "";
    if (isset($nav_item["sub"]) && $nav_item["sub"]) {
        $sub_nav_item = $nav_item["sub"];
        $sub_item_htm = process_sub_nav($sub_nav_item);
    } else {
        $sub_item_htm .= '<ul class="dropdown-menu" role="menu">';
        foreach ($nav_item as $key => $sub_item) {
            $url = isset($sub_item["url"]) ? base_url($sub_item["url"]) : "#";
            if(isset($lang) && $lang != "english"){
            $nav_title = isset($sub_item["title"]) ? $sub_item["title"] : "(sans nom)";
            }else{
                $nav_title = isset($sub_item["titleA"]) ? $sub_item["titleA"] : "(sans nom)";
            }
            $sub_item_htm .=
                    '<li>
                             <a href="' . $url . '">' . $nav_title . '</a>
                             ' . (isset($sub_item["sub"]) ? process_sub_nav($sub_item["sub"]) : '') . '
                          </li>';
        }
        $sub_item_htm .= '</ul>';
    }
    return $sub_item_htm;
}
