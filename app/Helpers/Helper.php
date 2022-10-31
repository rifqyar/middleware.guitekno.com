<?php

namespace App\Helpers;

use Auth;

class Helper
{
    public static function getRupiah($value)
    {
        $res = "IDR " . number_format($value, 0, ',', '.');
        return $res;
    }

    public static function getFormatWib($tanggal)
    {
        return date('d-m-Y H:i', strtotime($tanggal . "+7 hour",)) . ' Wib';
    }

    public static function getFormatWibTanggal($tanggal)
    {
        return date('d-m-Y', strtotime($tanggal));
    }

    public static function cleanFormString($string)
    {
        $string = str_replace("/", " ", $string);
        $regex = "/[ ](=[ ])|[^-_:,A-Za-z0-9.`: ]+/m";
        $string = str_replace("'", "`", $string);
        return preg_replace($regex, "", $string);
    }

    public static function uploadPicture($upload_dir, $path_name, $file_request, $is_create_dir = 1)
    {
        // $pic_path       = $req->file('Pic_Path');
        $pic_path       = $file_request;
        $fileName       = $pic_path->getClientOriginalName();

        $ext = $pic_path->getClientOriginalExtension();
        if (preg_match('/jpg|jpeg/i', $ext))
            $imageTmp = imagecreatefromjpeg($pic_path->getRealPath());
        else if (preg_match('/png/i', $ext))
            $imageTmp = imagecreatefrompng($pic_path->getRealPath());
        else if (preg_match('/gif/i', $ext))
            $imageTmp = imagecreatefromgif($pic_path->getRealPath());
        else if (preg_match('/bmp/i', $ext))
            $imageTmp = imagecreatefrombmp($pic_path->getRealPath());
        else {
            $notsupported = 1;
        }

        if (!isset($notsupported)) {
            $uploaded = 1;
            // Upload Image
            $path = base_path("public/" . $upload_dir . $path_name);
            if ($is_create_dir === 1) {
                mkdir($path);
            }
            if (!file_exists($path)) {
                mkdir($path);
            }
            imagejpeg($imageTmp, $path . "/" . $fileName, 40);
        } else {
            $uploaded = 0;
        }

        $response['status']     = $uploaded;
        $response['file_name']  = $fileName;
        return $response;
    }

    public static function getPermission($user)
    {
        $role = [
            '1' => ['1', '2', '3', '4', '5'],
            '3' => ['4', '5'],
            '4' => ['5']
        ];

        return $role[$user->role_id];
    }

    public static function getRoleFilter($type, $query = null)
    {
        if ($type == 'query') {
            $role = Auth::user()->role_id;
            $prop = Auth::user()->province_id;
            $kabupaten = Auth::user()->dati_id;
            $where = '';

            switch ($role) {
                case 4:
                    $where = "prop_id = '$prop'";
                    break;

                case 5:
                    $where = "prop_id = '$prop' AND dati2_id = '$kabupaten'";
                    break;
                default:
                    $where = '';
                    break;
            }

            return $where;
        } else if ($type == 'model') {
            $role = Auth::user()->role_id;
            $prop = Auth::user()->province_id;
            $kabupaten = Auth::user()->dati_id;

            $query->where(function ($query) use ($role, $prop, $kabupaten) {
                switch ($role) {
                    case 4:
                        $query->where('prop_id', $prop);
                        break;

                    case 5:
                        $query->where('prop_id', $prop);
                        $query->where('dati2_id', $kabupaten);
                        break;
                    default:
                        $where = '';
                        break;
                }
            });

            return $query;
        }
    }
}
