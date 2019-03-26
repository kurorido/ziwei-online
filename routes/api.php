<?php

use App\Domain\Chart;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('chart', function (Request $request) {
    $chart = new Chart();
    $birthday = request('birthday');
    $hour = request('hour');
    $gender = request('gender');
    $result = $chart->run($birthday, $hour, $gender);

    return response()->json($result);
});