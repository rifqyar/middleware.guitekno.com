<?php
namespace Vanguard\Http\Controllers\Web\MasterData\ApiStatus;

use Vanguard\Models\RefApiStatus;

class DbController 
{
    /**
     * DB Controller to processing data
     */

    public static function getRAS($id = null){
        $data = RefApiStatus::all();

        if (null != $id){
            $data = RefApiStatus::where('ras_id', $id)->count();
        }

        return $data;
    }

    public static function postInsertUpdate($data, $type){
        try {
            if ($type == 'insert'){
                RefApiStatus::create($data);
            } else {
                $ras_id = $data['ras_id'];
                unset($data['ras_id']);

                RefApiStatus::where('ras_id', $ras_id)->update($data);
            }

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'OK'
                ], 'detail' => 'Process Running Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error',
                ],
                'detail' => $th
            ], 500);
        }
        
    }

    public static function deleteData($id){
        try {
            RefApiStatus::where('ras_id', $id)->delete();

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'OK'
                ], 'detail' => 'Process Running Successfully'
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error',
                ],
                'detail' => $th
            ], 500);
        }
    }
}
?>