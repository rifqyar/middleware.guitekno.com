<?php
namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Vanguard\Http\Controllers\Controller;

class Library extends Controller {

    public static function cleanFormString($string)
    {
        $string = str_replace("/", " ", $string);
        $regex = "/[ ](=[ ])|[^-_:,A-Za-z0-9.`: ]+/m";
        $string = str_replace("'", "`", $string);
        return preg_replace($regex, "", $string);
    }

    public static function genereteDataQuery($array)
    {
    	$setParam = "";
        $insert_query = "(";
        $setParam = [];
        $i = 0;
		foreach ($array as $key => $value) {
            if($value == null){
                // $setParam .= "SET @$key = NULL;";
                $setParam[$i++] = "SET p_$key = NULL;";
                $insert_query .= "NULL,";
            } else {
                $setParam[$i++] = "SET p_$key = '$value';";
                $insert_query .= "'$value',";
            }

            // $insert_query .= "p_$key,";
        }
        $insert_query = rtrim($insert_query,",");
        $insert_query .= ")";

        return ['param' => $setParam, 'query' => $insert_query ];
    }

    public static function uploadPicture($upload_dir,$path_name,$file_request,$is_create_dir = 1){
        // $pic_path       = $req->file('Pic_Path');
        $pic_path       = $file_request;
        $fileName       = $pic_path->getClientOriginalName();

        $ext = $pic_path->getClientOriginalExtension();
        if (preg_match('/jpg|jpeg/i',$ext))
            $imageTmp=imagecreatefromjpeg($pic_path->getRealPath());
        else if (preg_match('/png/i',$ext))
            $imageTmp=imagecreatefrompng($pic_path->getRealPath());
        else if (preg_match('/gif/i',$ext))
            $imageTmp=imagecreatefromgif($pic_path->getRealPath());
        else if (preg_match('/bmp/i',$ext))
            $imageTmp=imagecreatefrombmp($pic_path->getRealPath());
        else {
            $notsupported = 1;
        }

        if(!isset($notsupported)){
            $uploaded = 1;
            // Upload Image
                $path = base_path("public/".$upload_dir.$path_name);
                if($is_create_dir === 1){
                    mkdir($path);
                }
                if(!file_exists($path)){
                    mkdir($path);
                }
                imagejpeg($imageTmp, $path."/".$fileName, 40);
        } else {
            $uploaded = 0;
        }

        $response['status']     = $uploaded;
        $response['file_name']  = $fileName;
        return $response;
    }

    public static function group_array($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }


	public static function curlcall($url,$method,$header = [],$data = []){
		if($method == 'get'){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$curl_response = curl_exec($ch);
			curl_close ($ch);
		} else if($method == 'post'){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$curl_response = curl_exec($ch);
			curl_close ($ch);
		} else {
			return null;
			exit;
		}

		return $curl_response;
	}

    public static function encrypt($key){
        $encrypt_method = 'AES-256-CBC';
        $key = \Illuminate\Support\Str::random(32);
        $encryption_key = openssl_random_pseudo_bytes(32);
        $string = $key;
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $output = openssl_encrypt($string, $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }

    public static function encryptPass($key){
        $secret = str_split($key);
        $key = '';
        foreach ($secret as $val) {
            $key .= base64_encode('.'.$val.'.'.\Illuminate\Support\Str::random(3)).'#';
        }
        // $secret = base64_encode($key);
        $secret = base64_encode(\Illuminate\Support\Str::random(12).'.'.$key.'.');
        // $secret = Crypt::encrypt(\Illuminate\Support\Str::random(12).'.'.$key.'.'.env('APP_KEY'));
        return $secret;
    }

    public static function decryptPass($key){
        $secret = explode('#', explode('.', base64_decode($key))[1]);
        $sec = '';
        foreach($secret as $val){
            $sec .= base64_decode($val);
        }

        $sec = explode('.', $sec);
        $pass = '';
        foreach ($sec as $key => $val) {
            if ($key % 2 != 0){
                $pass .= $val;
            }
        }
        return $pass;
    }

    public static function incrementID($data){
        $id = explode('-', $data);
        $next = (int)$id[1] + 1;
        $return = str_pad($next, strlen($id[1]), '0', STR_PAD_LEFT);
        return $return;
    }

    public static function convertCurrency($int, $presisi = 1){
        if ($int < 900) {
            $format_angka = number_format($int, $presisi);
            $simbol = '';
        } else if ($int < 900000) {
            $format_angka = number_format($int / 1000, $presisi);
            $simbol = ' rb';
        } else if ($int < 900000000) {
            $format_angka = number_format($int / 1000000, $presisi);
            $simbol = ' jt';
        } else if ($int < 900000000000) {
            $format_angka = number_format($int / 1000000000, $presisi);
            $simbol = ' M';
        } else {
            $format_angka = number_format($int / 1000000000000, $presisi);
            $simbol = ' T';
        }
     
        if ( $presisi > 0 ) {
            $pisah = '.' . str_repeat( '0', $presisi );
            $format_angka = str_replace( $pisah, '', $format_angka );
        }
        
        return $format_angka . $simbol;
    }

}
