<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

$html = <<<EOM
<html>
<head>
<title>Hello</title>
<style>
body { font-size:16pt; color:#999; }
h1 { font-size:100pt; text-align:right; color:#eee; margin:-40px 0px -50px 0px; }
</style>
</head>
<body>
    <h1>Hello</h1>
    <p>this is sample page.</p>
    <p>これはサンプルページ。</p>
</body>
</html>
EOM;

Route::get('hello', function () use ($html) {
    return $html;
});