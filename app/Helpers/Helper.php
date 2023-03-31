<?php


namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Intervention\Image\Facades\Image;

class Helper
{
    /**
     * @param $subject
     * @param $column_name
     * @param $old_data
     * @param $new_data
     * @param $table_name
     * @param $action
     */
    public static function addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action): void
    {
        $log['log_entry'] = $subject;
        $log['url'] = request()->url();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['column_name'] = $column_name;
        $log['old_data'] = $old_data;
        $log['new_data'] = $new_data;
        $log['data_table'] = $table_name;
        $log['action'] = $action;
        ActivityLog::create($log);
    }

    /**
     * @param $name
     * @param $height
     * @param $width
     * @param $path
     * @param $file
     * @return string
     */
    public static function uploadImage($name, $height, $width, $path, $file): string
    {
        $image_file_name = $name . '.webp';
        Image::make($file)->fit($width, $height)->save(public_path($path) . $image_file_name, 50, 'webp');
        return $image_file_name;
    }

    /**
     * @param $path
     * @param $img
     */
    public static function unlinkImage($path, $img): void
    {
        $path = public_path($path) . $img;
        if ($img !== '' && file_exists($path)) {
            unlink($path);
        }
    }

    public static function calculate_price($price, $discount_amount, $discount_percent)
    {
        $calculated_price = $price;
        if ($discount_amount != null) {
            $calculated_price = $price - $discount_amount;
        }
        if ($discount_percent != null) {
            $calculated_price -= ($calculated_price * $discount_percent) / 100;
        }
        return $calculated_price;
    }

}
