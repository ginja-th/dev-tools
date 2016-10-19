<?php

namespace App\Services;

use Carbon\Carbon;

class Settings
{
    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public static function get($key, $default = null)
    {
        if (self::has($key)) {
            return \DB::table('settings')
                ->where('key', $key)
                ->first()
                ->value;
        }
        return $default;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function set($key, $value)
    {
        if (self::has($key)) {
            \DB::table('settings')
                ->where('key', $key)
                ->update([
                    'value' => $value,
                    'updated_at' => Carbon::now(),
                ]);
        } else {
            \DB::table('settings')
                ->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }
        
        return $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return !!\DB::table('settings')
            ->where('key', $key)
            ->first();
    }
}