<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function pr($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

if(!function_exists('hashGivenPassword')){
    function hashGivenPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

if(!function_exists('verifyHashedPassword')){
    function verifyHashedPassword($plainPassword, $hashedPassword){
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}


if(!function_exists('randomString')){
	function randomString($length = 7) {
	    $randstr;
	    srand((double) microtime(TRUE) * 1000000);
	    //our array add all letters and numbers if you wish
	    /*
	    $chars = array(
	        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p',
	        'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '2', '3', '4', '5',
	        '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 
	        'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	    */
	    $chars = array(
	        '2', '3', '4', '5','6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 
	        'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	
	    for ($rand = 0; $rand <= $length; $rand++) {
	        $random = rand(0, count($chars) - 1);
	        $randstr .= $chars[$random];
	    }
	    return $randstr;
	}
}

if(!function_exists('customEncryptDecrypt')){
	function customEncryptDecrypt($string, $action) {
		//$action: e->encrypt, d->decrypt
	    $secret_key = 'n134M3fb6P8Sz2d3';
	    $secret_iv = 'k170X4DM1N7rc5d3';
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = hash('sha256',$secret_key);
	    $iv = substr(hash('sha256',$secret_iv),0,16);
	    if($action == 'e') {
	        $output = base64_encode(openssl_encrypt($string,$encrypt_method,$key,0,$iv));
	    }
	    else if($action == 'd'){
	        $output = openssl_decrypt(base64_decode($string),$encrypt_method,$key,0,$iv);
	    }
	    return $output;
	}
}

if(!function_exists('limitLongText')){
	function limitLongText($text,$limit){
		if (str_word_count($text, 0) > $limit) {
          	$words = str_word_count($text, 2);
          	$pos = array_keys($words);
			$text = substr($text, 0, $pos[$limit]) . '...';
      	}
      	return $text;
    }
}

if(!function_exists('resizeImage')){
    function resizeImage($image_data,$n_w,$n_h){
        $CI =   & get_instance();
        $w  =   $image_data['image_width']; // original image's width
        $h  =   $image_data['image_height']; // original images's height
        
        $source_ratio   =   $w / $h;
        $new_ratio      =   $n_w / $n_h;
        if($source_ratio != $new_ratio){
            $config['image_library']    =   'gd2';
            $config['source_image']     =   $image_data['full_path'];
            $config['maintain_ratio']   =   FALSE;
            if($new_ratio > $source_ratio || (($new_ratio == 1) && ($source_ratio < 1))){
                $config['width']    =   $w;
                $config['height']   =   round($w/$new_ratio);
                $config['y_axis']   =   round(($h - $config['height'])/2);
                $config['x_axis']   =   0;
            }else{
                $config['width']   =   round($h * $new_ratio);
                $config['height']  =   $h;
                $config['x_axis']  =   round(($w - $config['width'])/2);
                $config['y_axis']  =   0;
            }
            $CI->image_lib->initialize($config);
            $CI->image_lib->crop();
            $CI->image_lib->clear();
        }
        $config['image_library']    =   'gd2';
        $config['source_image']     =   $image_data['full_path'];
        $config['maintain_ratio']   =   TRUE;
        $config['width']            =   $n_w;
        $config['height']           =   $n_h;
        $CI->image_lib->initialize($config);
        if (!$CI->image_lib->resize()){
            //echo $this->image_lib->display_errors();
        }else{
            //echo "done";
        }
    }
}


if (!function_exists('get_user_counts')) {
    function get_user_counts($userType, $requisitionFrom) {
        $CI = &get_instance(); // Get CodeIgniter instance
        $counts = $CI->common_model->countMultipleRequisitions($requisitionFrom);
        
        $data = [];
        
        switch($userType)
        {
            case 1:
                $data['countTotalUsers'] = $CI->users_model->countData(0);
                break;
            case 3:
                $data['ward_name'] = $CI->common_model->getSpecificRecord('wards', $requisitionFrom)[0]->ward_name;
                $data['countPending'] = $counts->wp;
                $data['countTransferred'] = $counts->wt;
                $data['countTotalRequisition'] = $counts->t;
                break;
            case 4:
                $data['countTotalRequisition'] = $counts->t;
                $data['countPending'] = $counts->wp;
                $data['countTransferred'] = $counts->wt;
                break;
            case 2:
                $data['countTotalTransferRequisition'] = $counts->t;
                $data['countTransferPendingAlerts'] = $counts->pt;
                $data['countTransferPartialAlerts'] = $counts->part;
                $data['countTransferredAlerts'] = $counts->ft;
                $data['countRequestsClosedAlerts'] = $counts->rc;
                break;
            case 5:
                $data['countTotalSterilizationRequisition'] = $counts->t;
                $data['countSterlizationPendingAlerts'] = $counts->s;
                $data['countAcknowledgedAlerts'] = $counts->sa;
                break;
        }
        
        return $data;
    }
}