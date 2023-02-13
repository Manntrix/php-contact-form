<?php
/**
 * Function to generate random string.
 */
function randomString($n) {

	$generated_string = "";

	$domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

	$len = strlen($domain);

	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, $len - 1);
		$generated_string = $generated_string . $domain[$index];
	}

	return $generated_string;
}

/**
 *
 */
function getSecureRandomToken() {
	$token = bin2hex(openssl_random_pseudo_bytes(16));
	return $token;
}

/**
 * Clear Auth Cookie
 */
function clearAuthCookie() {

	unset($_COOKIE['series_id']);
	unset($_COOKIE['remember_token']);
	setcookie('series_id', null, -1, '/');
	setcookie('remember_token', null, -1, '/');
}
/**
 *
 */
function clean_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function paginationLinks($current_page, $total_pages, $base_url) {

	if ($total_pages <= 1) {
		return false;
	}

	$html = '';

	if (!empty($_GET)) {
		unset($_GET['page']);
		$http_query = "?" . http_build_query($_GET);
	} else {
		$http_query = "?";
	}

	$html = '<ul class="pagination text-center">';

	if ($current_page == 1) {

		$html .= '<li class="disabled"><a>First</a></li>';
	} else {
		$html .= '<li><a href="' . $base_url . $http_query . '&page=1">First</a></li>';
	}

	if ($current_page > 5) {
		$i = $current_page - 4;
	} else {
		$i = 1;
	}

	for (; $i <= ($current_page + 4) && ($i <= $total_pages); $i++) {
		($current_page == $i) ? $li_class = ' class="active"' : $li_class = '';

		$link = $base_url . $http_query;

		$html = $html . '<li' . $li_class . '><a href="' . $link . '&page=' . $i . '">' . $i . '</a></li>';

		if ($i == $current_page + 4 && $i < $total_pages) {

			$html = $html . '<li class="disabled"><a>...</a></li>';

		}

	}

	if ($current_page == $total_pages) {
		$html .= '<li class="disabled"><a>Last</a></li>';
	} else {

		$html .= '<li><a href="' . $base_url . $http_query . '&page=' . $total_pages . '">Last</a></li>';
	}

	$html = $html . '</ul>';

	return $html;
}

/**
 * to prevent xss
 */
function xss_clean($string){
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

}
function pathUrl($dir = __DIR__){

    $root = "";
    $dir = str_replace('\\', '/', realpath($dir));

    $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

    $root .= '://' . $_SERVER['HTTP_HOST'];

    //ALIAS
    if(!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER[ 'CONTEXT_DOCUMENT_ROOT' ]));
    } else {
        $root .= substr($dir, strlen($_SERVER[ 'DOCUMENT_ROOT' ]));
    }

    $root .= '/';

    return $root;
}
function redirect($url)
{
    if (!headers_sent())
    {
        header('Location: '.$url);
        exit;
    }
    else
    {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

function sendsms ($led_id, $template_id){
    $db = getDbInstance();
    $db->where('id', $led_id);
    $led = $db->get('leds');

    $db = getDbInstance();
    $db->where('id', $template_id);
    $template = $db->get('sms_template');

    return $led;


}

function getuserip(){
    if ((isset($_SERVER['HTTP_X_FORWARDED_FOR'])) &&
        (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])))
    { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
    elseif ((isset($_SERVER['HTTP_CLIENT_IP'])) &&
        (!empty($_SERVER['HTTP_CLIENT_IP'])))
    { $ip = explode(".",$_SERVER['HTTP_CLIENT_IP']);
        $ip = $ip[3].".".$ip[2].".".$ip[1].".".$ip[0];}
    elseif ((!isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ||
        (empty($_SERVER['HTTP_X_FORWARDED_FOR'])))
        { if ((!isset($_SERVER['HTTP_CLIENT_IP'])) &&
    (empty($_SERVER['HTTP_CLIENT_IP'])))
        { $ip = $_SERVER['REMOTE_ADDR']; }}
        else
        { $ip = "0.0.0.0";}

        return $ip;
}
function addOrUpdateUrlParam($name, $value)
{
    $params = $_GET;
    unset($params[$name]);
    $params[$name] = $value;
    return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
}
if (!function_exists('dd')) {
    function dd()
    {
        array_map(function($x) {
            dump($x);
        }, func_get_args());
        die;
    }
}

function categories(){
    $db = getDbInstance();
    $db->where ("parent_category_id", 0);
    $catArray = $db->get('categories');

    $categories = array();

    foreach ($catArray as $cat){
        $categories[] = array(
            'id' => $cat['id'],
            'parent_id' => $cat['parent_category_id'],
            'category_name' => $cat['name'],
            'subcategory' => sub_categories($cat['id']),
        );
    }

    return $categories;
}

function get_led_status(){
    $db = getDbInstance();
    $ledStatus = $db->get('led_status');


    return $ledStatus;
}



function sub_categories($id)
{
    $db = getDbInstance();
    $db->where ("parent_category_id", $id);
    $catArray = $db->get('categories');

    $categories = array();

    foreach ($catArray as $cat){
        $categories[] = array(
            'id' => $cat['id'],
            'parent_id' => $cat['parent_category_id'],
            'category_name' => $cat['name'],
            'subcategory' => sub_categories($cat['id']),
        );
    }
    return $categories;
}

function viewsubcat($categories, $matchcatid)
{
    $html = '';
    foreach($categories as $category){
        $selected = $category['id'] == $matchcatid ? "selected" : '';

        $html .= '<option '.$selected.' value="'.$category['id'].'">'.$category['category_name'].'</option>';

        if( ! empty($category['subcategory'])){
            $html .= viewsubcat($category['subcategory']);
        }
    }


    return $html;
}

function category_with_child_id(){
    $categories = categories();
    $check_value = array();
    foreach ($categories as $cat){
        if(!empty($cat['subcategory'])){
            $check_value[] = $cat['id'];
        }
    }
    return $check_value;
}

function category_with_products(){
    $db = getDbInstance();
    $catArray = $db->get('categories');

    $categories = array();

    foreach ($catArray as $cat){
        $categories[] = array(
            'id' => $cat['id'],
            'parent_id' => $cat['parent_category_id'],
            'category_name' => $cat['name'],
            'products' => get_products_by_id($cat['id']),
        );
    }

    return $categories;
}

function get_products_by_id($id){
    $db = getDbInstance();
    $db->where ("category_id", $id);
    $products = $db->get('products');

    return $products;
}

function category_with_products_id(){
    $categories = category_with_products();
    $check_value = array();
    foreach ($categories as $cat){
        if(!empty($cat['products'])){
            $check_value[] = $cat['id'];
        }
    }
    return $check_value;
}

function get_date_time_randomnumber(){
    $date = new DateTime();
    $date = $date->format('Ymd');

    $time = new DateTime();
    $time = $time->format('Hi');

    $number = '21';

    return $date . '_' . $time . '_' . $number;
}

function time_Ago($time) {
    $diff     = time() - $time;

    $hrs  = round($diff / 3600);


    return $hrs;

}

function get_current_login_user_full_name(){
    if(isset($_SESSION['user_id'])){
        $userID = $_SESSION['user_id'];
    }
    $db = getDbInstance();
    $db->where ("id", $userID);
    $user = $db->getOne ("users");
    $first_name = $user['u_firstname'];
    $last_name = $user['u_lastname'];

    return $first_name . ' ' . $last_name;

}
function get_current_login_username(){

    if($_SESSION['admin_type'] == 'agent'){
        if(isset($_SESSION['user_id'])){
            $userID = $_SESSION['user_id'];
        }
        $db = getDbInstance();
        $db->where ("id", $userID);
        $user = $db->getOne ("agents");
        $user_name = $user['a_username'];
    }else{
        if(isset($_SESSION['user_id'])){
            $userID = $_SESSION['user_id'];
        }
        $db = getDbInstance();
        $db->where ("id", $userID);
        $user = $db->getOne ("users");
        $user_name = $user['u_username'];
    }



    return $user_name;

}

function get_led_fullname_by_id($id){

    $db = getDbInstance();
    $db->where ("id", $id);
    $leds = $db->getOne ("leds");

    return $leds['c_name'];

}
function get_user_fullname_by_id($id){
    if($id != null){
        $db = getDbInstance();
        $db->where ("id", $id);
        $user = $db->getOne ("users");

        return $user['u_firstname'] . " " . $user['u_lastname'];
    }else{
        return "";
    }


}

function is_admin(){
    if($_SESSION['admin_type'] && $_SESSION['admin_type'] == 'admin'){
        return true;
    }else{
        return false;
    }
}
function is_agent(){
    if($_SESSION['admin_type'] && $_SESSION['admin_type'] == 'agent'){
        return true;
    }else{
        return false;
    }
}
function is_user(){
    if($_SESSION['admin_type'] && $_SESSION['admin_type'] == 'user'){
        return true;
    }else{
        return false;
    }
}
function get_current_user_id(){
    if(isset($_SESSION['user_id'])){
        return $_SESSION['user_id'];
    }else{
        return null;
    }
}

if (!function_exists('home_url')) {
    function home_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}

