<?php

function findView() {
    $route = explode('/', Request()->route()->uri());
    foreach ($route as $key => $value) {
        if (strrpos($value, '{') !== false) unset($route[$key]);
            if ($value == 'edit') $route[$key] = 'create';
        }
        if (count($route) == 2) $route[3] = 'index';
    return implode('.', array_values($route));
}

function getError($errors, $name) {
    if ($errors->has($name)) return "<span class=\"form-text text-danger\">{$errors->first($name)}</span>";
    return '';
}

function isCreate() {
    return Request()->route()->getActionMethod() == 'create';
}

function configureConnectionByName($tenantName) {
    // Just get access to the config.
    $config = App::make('config');
    // Will contain the array of connections that appear in our database config file.
    $connections = $config->get('database.connections');
    // This line pulls out the default connection by key (by default it's `mysql`)
    $defaultConnection = $connections[$config->get('database.default')];
    // Now we simply copy the default connection information to our new connection.
    $newConnection = $defaultConnection;
    // Override the database name.
    $newConnection['database'] = $tenantName;
    // This will add our new connection to the run-time configuration for the duration of the request.
    App::make('config')->set('database.connections.' . $tenantName, $newConnection);
}
function DBCreate($name){
    return \DB::statement('CREATE DATABASE IF NOT EXISTS '.$name.' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
}
function DBRemove($name){
    return \DB::statement('DROP DATABASE IF EXISTS '.$name.';');
}
function DBName($domain){
    return str_ireplace(['www.','.'], ['','_'], $domain);
}
function DBRename($DB,$newDB){
    DBCreate($newDB);
    $tables = DB::select('select * from information_schema.tables where table_schema="'.$DB.'"');
    foreach ($tables as $table){
        DB::statement('RENAME TABLE '.$DB.'.'.$table->TABLE_NAME.' TO '.$newDB.'.'.$table->TABLE_NAME);
    }
    DB::statement('DROP DATABASE '.$DB);
}
function connectionName(){
    return 'localhost:8000';
    $connection = DBName($_SERVER['HTTP_HOST'] ?? DBName(env('APP_URL')));
    return $connection == (env('DB_DATABASE') ?? \Illuminate\Support\Facades\Config::get('system.database')) ? 'mysql' : $connection;
}
function getFileExtension($fileName){
    return pathinfo($fileName, PATHINFO_EXTENSION);
}
function isAgency() {
//    return true;
    if (is_null(env('DB_CONNECTION'))) configClear();
    return connectionName() !== env('DB_CONNECTION');
}
function siteUrl(){
//    return 'gashttravel.ir';
    return $_SERVER['HTTP_HOST'];
}
function getFileResize($file,$x,$y){
//  return substr($file, strrpos($file, '.')+1);
    return $file.'_'.$x.'_'.$y.'.'.getFileExtension($file);
}
function configClear(){
    return \Illuminate\Support\Facades\Artisan::call('config:clear');
}
function addPlatIp(\Illuminate\Http\Request &$request) {
    $request->merge(['ip' => \Request::ip(), 'platform' => \Request::server('HTTP_USER_AGENT')]);
//    collect($request)->put('ip', \Request::ip())->put('platform', \Request::server('HTTP_USER_AGENT'));
}
function inRange($val, $min, $max) {
    return ($val >= $min && $val <= $max);
}
function gatewayTable(){
    return connectionName() == 'mysql' ? 'gateway_transactions' : DBName(siteUrl()).'.gateway_transactions';
}
function getMonthNames($month)
{
    $ret = '';
    switch ($month) {
        case '1':
            $ret = 'فروردین';
            break;
        case '2':
            $ret = 'اردیبهشت';
            break;
        case '3':
            $ret = 'خرداد';
            break;
        case '4':
            $ret = 'تیر';
            break;
        case '5':
            $ret = 'مرداد';
            break;
        case '6':
            $ret = 'شهریور';
            break;
        case '7':
            $ret = 'مهر';
            break;
        case '8':
            $ret = 'آبان';
            break;
        case '9':
            $ret = 'آذر';
            break;
        case '10':
            $ret = 'دی';
            break;
        case '11':
            $ret = 'بهمن';
            break;
        case '12':
            $ret = 'اسفند';
            break;
    }

    return  $ret;
}
function getTravelMethod($TravelMethod)
{
    $ret = '';
    switch ($TravelMethod) {
        case 'aerial':
            $ret = 'هوایی';
            break;
        case 'earthy':
            $ret = 'زمینی';
            break;
        case 'marine':
            $ret = 'دریایی';
            break;
    }

    return  $ret;
}
function getResidenceType($ResidenceType)
{
    $ret = '';
    switch ($ResidenceType) {
        case '1':
            $ret = 'هتل';
            break;
        case '2':
            $ret = 'هتل آپارتمان';
            break;
        case '3':
            $ret = 'مهمانپذیر';
            break;
        case '4':
            $ret = 'خانه مسافر';
            break;
        case '5':
            $ret = 'اقامتگاه';
            break;
    }

    return  $ret;
}
function getMonthNumber($month)
{
    $ret = '';
    switch ($month) {
        case 'فروردین':
            $ret = '01';
            break;
        case 'اردیبهشت':
            $ret = '02';
            break;
        case 'خرداد':
            $ret = '03';
            break;
        case 'تیر':
            $ret = '04';
            break;
        case 'مرداد':
            $ret = '05';
            break;
        case 'شهریور':
            $ret = '06';
            break;
        case 'مهر':
            $ret = '07';
            break;
        case 'آبان':
            $ret = '08';
            break;
        case 'آذر':
            $ret = '09';
            break;
        case 'دی':
            $ret = '10';
            break;
        case 'بهمن':
            $ret = '11';
            break;
        case 'اسفند':
            $ret = '12';
            break;
    }

    return  $ret;
}