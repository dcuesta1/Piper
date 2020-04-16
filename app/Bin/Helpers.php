<?php
use Illuminate\Support\Str;

function ApiAuth()
{
    return app('ApiAuth');
}

function ApiResponse()
{
    return app('ApiResponse');
}

function snakeToCamel($string, $capitalizeFirstCharacter = false)
{

    $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

    if (!$capitalizeFirstCharacter) {
        $str[0] = strtolower($str[0]);
    }

    return $str;
}

function toCamelcase($data)
{
//    $camelObj = new StdClass();
//    $arr = [];
//    if ( is_object($data->attributes) ) {
//        $i = 0;
//        foreach ( $data as $key1 => $val1 ) {
//            if($i === 0) {
////                dd($data->$key1);
//            }
//            $i++;
//            $arr[$i] = $val1;
//
//            if ( is_object( $val1 ) ) {
//                return 'obj';
//                //TODO: Seconds level ONE object (one-to-one relationship)
//            } else if ( is_array( $val1 ) ) {
//                //TODO: Second level array of objects (hasMany, ManyToMany relationships)
//                return 'arr';
//            }
//        }
//
//    } else if ( is_array($data) ) {
//        // Top level array (of objs)
//        return 'arr top';
//    }
//    dd($data);
}
