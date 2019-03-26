<?php

namespace App\Http\Controllers\Api;

use App\Domain\Temple;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ZiWeiCalcRequest;

class ZiWeiController extends Controller
{
    public function calc(ZiWeiCalcRequest $request)
    {
        $data = $request->validated();

        $data['birthday'];
        $data['time'];
        $data['gender'];
    }


}
