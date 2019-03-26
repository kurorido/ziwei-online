<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\Chart;
use App\Domain\Temple;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ZiWeiTest extends TestCase
{
    /** @test */
    public function testExample()
    {
        $chart = new Chart();
        // $chart->ziwei(29, 4);
        // $chart->zuofu(7);
        // $chart->youbi(7);
        // $chart->wenqu(7);
        // $chart->wenchang(7);
        // $chart->calcElement(1990, 7);
        // $data = [
        //     'birthday' => '1990-09-17',
        //     'gender' => 1,
        //     'hour' => 7,
        // ];
        $birthday = '1990-09-17';
        $hour = 7;
        $gender = 1;
        $result = $chart->run($birthday, $hour, $gender);

        echo json_encode($result);

        // 天干 decimal cycle
        // 地支 duodecimal cycle

        // $result = ZiWei::run($data);

        // $this->assertEquals($result[0]);

    }
}
