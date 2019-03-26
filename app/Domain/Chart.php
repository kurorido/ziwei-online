<?php

namespace App\Domain;

use Carbon\Carbon;
use App\Domain\Temple;
use App\Helpers\Lunar;

class Chart
{
    public $time;
    protected $year;
    protected $temples;
    protected $element;
    protected $decimal_years = [
        1 => '甲',
        2 => '乙',
        3 => '丙',
        4 => '丁',
        5 => '戊',
        6 => '己',
        7 => '庚',
        8 => '辛',
        9 => '壬',
        10 => '癸'
    ];

    protected $times = [
        '子', '丑', '寅', '卯',
        '辰', '巳', '午', '未',
        '申', '酉', '戌', '亥'
    ];

    // 祿存存放宮位 （十天干 => 宮位）
    protected $lucun_mapping = [
        '甲' => '寅',
        '乙' => '卯',
        '丙' => '巳',
        '丁' => '午',
        '戊' => '巳',
        '己' => '午',
        '庚' => '申',
        '辛' => '酉',
        '壬' => '亥',
        '癸' => '子',
    ];

    // 天魁鉞
    protected $tian_kuei_yue = [
        '甲' => [
            'kuei' => '丑',
            'yue' => '未'
        ],
        '乙' => [
            'kuei' => '子',
            'yue' => '申'
        ],
        '丙' => [
            'kuei' => '亥',
            'yue' => '酉'
        ],
        '丁' => [
            'kuei' => '亥',
            'yue' => '酉'
        ],
        '戊' => [
            'kuei' => '丑',
            'yue' => '未'
        ],
        '己' => [
            'kuei' => '子',
            'yue' => '申'
        ],
        '庚' => [
            'kuei' => '丑',
            'yue' => '未'
        ],
        '辛' => [
            'kuei' => '午',
            'yue' => '寅'
        ],
        '壬' => [
            'kuei' => '卯',
            'yue' => '巳'
        ],
        '癸' => [
            'kuei' => '卯',
            'yue' => '巳'
        ],
    ];

    protected $time_to_pointer = [
        '巳' => 0,
        '午' => 1,
        '未' => 2,
        '申' => 3,
        '酉' => 4,
        '戌' => 5,
        '亥' => 6,
        '子' => 7,
        '丑' => 8,
        '寅' => 9,
        '卯' => 10,
        '辰' => 11,
    ];

    protected $pointer_to_time = [
        0 => '巳',
        1 => '午',
        2 => '未',
        3 => '申',
        4 => '酉',
        5 => '戌',
        6 => '亥',
        7 => '子',
        8 => '丑',
        9 => '寅',
        10 => '卯',
        11 => '辰',
    ];

    protected $element_mapping = [
        2 => '水二局',
        3 => '木三局',
        4 => '金四局',
        5 => '土五局',
        6 => '火六局'
    ];

    protected $times_mapping = [
        0 => '子',
        1 => '丑',
        2 => '丑',
        3 => '寅',
        4 => '寅',
        5 => '卯',
        6 => '卯',
        7 => '辰',
        8 => '辰',
        9 => '巳',
        10 => '巳',
        11 => '午',
        12 => '午',
        13 => '未',
        14 => '未',
        15 => '申',
        16 => '申',
        17 => '酉',
        18 => '酉',
        19 => '戌',
        20 => '戌',
        21 => '亥',
        22 => '亥',
        23 => '子',
    ];

    protected $reverse_ziwei = [
        '子' => '辰',
        '丑' => '卯',
        '寅' => '寅',
        '卯' => '丑',
        '辰' => '子',
        '巳' => '亥',
        '午' => '戌',
        '未' => '酉',
        '申' => '申',
        '酉' => '未',
        '戌' => '午',
        '亥' => '巳',
    ];

    protected $four_types = [
        '甲' => [
            '祿' => '廉貞',
            '權' => '破軍',
            '科' => '武曲',
            '忌' => '太陽',
        ],
        '乙' => [
            '祿' => '天機',
            '權' => '天梁',
            '科' => '紫微',
            '忌' => '太陰',
        ],
        '丙' => [
            '祿' => '天同',
            '權' => '天機',
            '科' => '文昌',
            '忌' => '廉貞',
        ],
        '丁' => [
            '祿' => '太陰',
            '權' => '天同',
            '科' => '天機',
            '忌' => '巨門',
        ],
        '戊' => [
            '祿' => '太陰',
            '權' => '天同',
            '科' => '天機',
            '忌' => '巨門',
        ],
        '己' => [
            '祿' => '武曲',
            '權' => '貪狼',
            '科' => '天梁',
            '忌' => '文曲',
        ],
        '庚' => [
            '祿' => '太陽',
            '權' => '武曲',
            '科' => '太陰',
            '忌' => '天同',
        ],
        '辛' => [
            '祿' => '巨門',
            '權' => '太陽',
            '科' => '武曲',
            '忌' => '文昌',
        ],
        '壬' => [
            '祿' => '天梁',
            '權' => '紫微',
            '科' => '左輔',
            '忌' => '武曲',
        ],
        '癸' => [
            '祿' => '破軍',
            '權' => '巨門',
            '科' => '太陽',
            '忌' => '貪狼',
        ]
    ];

    protected $month_chinese_to_number = [
        '一月' => 1,
        '二月' => 2,
        '三月' => 3,
        '四月' => 4,
        '五月' => 5,
        '六月' => 6,
        '七月' => 7,
        '八月' => 8,
        '九月' => 9,
        '十月' => 10,
        '十一月' => 11,
        '十二月' => 12,
    ];

    // 金四
    // 水二
    // 木三
    // 土五
    // 火六
    protected $elements_mapping = [
        '甲子' => 4, // 海中金
        '乙丑' => 4, // 海中金
        '丙寅' => 6, // 爐中火
        '丁卯' => 6, // 爐中火
        '戊辰' => 3, // 大林木
        '己巳' => 3, // 大林木
        '庚午' => 5, // 路旁土
        '辛未' => 5, // 路旁土
        '壬申' => 4, // 劍鋒金
        '癸酉' => 4, // 劍鋒金
        '甲戌' => 6, // 山頭火
        '乙亥' => 6, // 山頭火
        '丙子' => 2, // 洞下水
        '丁丑' => 2, // 洞下水
        '戊寅' => 5, // 城牆土
        '已卯' => 5, // 城牆土
        '庚辰' => 4, // 白蠟金
        '辛巳' => 4, // 白蠟金
        '壬午' => 3, // 楊柳木
        '癸末' => 3, // 楊柳木
        '甲申' => 2, // 泉中水
        '乙酉' => 2, // 泉中水
        '丙戌' => 5, // 屋上土
        '丁亥' => 5, // 屋上土
        '戊子' => 2, // 霹靂火
        '己丑' => 2, // 霹靂火
        '庚寅' => 3, // 松柏木
        '辛卯' => 3, // 松柏木
        '壬辰' => 2, // 長流水
        '癸巳' => 2, // 長流水
        '甲午' => 4, // 沙中金
        '乙未' => 4, // 沙中金
        '丙申' => 2, // 天河水
        '丁酉' => 2, // 天河水
        '戊戌' => 3, // 平地木
        '已亥' => 3, // 平地木
        '庚子' => 5, // 壁上土
        '辛丑' => 5, // 壁上土
        '壬寅' => 4, // 金箔金
        '癸卯' => 4, // 金箔金
        '甲辰' => 6, // 覆燈火
        '乙巳' => 6, // 覆燈火
        '丙午' => 2, // 天河水
        '丁未' => 2, // 天河水
        '戊申' => 5, // 大驛土
        '己酉' => 5, // 大驛土
        '庚戌' => 4, // 釵川金
        '辛亥' => 4, // 釵川金
        '壬子' => 3, // 桑松木
        '癸丑' => 3, // 桑松木
        '甲寅' => 2, // 大溪水
        '乙卯' => 2, // 大溪水
        '丙辰' => 5, // 沙中土
        '丁巳' => 5, // 沙中土
        '戊午' => 6, // 天上火
        '己末' => 6, // 天上火
        '庚申' => 3, // 石榴木
        '辛酉' => 3, // 石榴木
        '壬戌' => 2, // 大海水
        '癸亥' => 2, // 大海水
    ];

    // 起寅手
    // 甲年 or 己年生 = 丙寅宮
    // 乙年 or 庚年生 = 戊寅宮
    // 丙年 or 辛年生 = 庚寅宮
    // 丁年 or 壬年生 = 壬寅宮
    // 戊年 or 癸年生 = 甲寅宮
    protected $hands = [
        '甲' => '丙',
        '乙' => '戊',
        '丙' => '庚',
        '丁' => '壬',
        '戊' => '甲',
        '己' => '丙',
        '庚' => '戊',
        '辛' => '庚',
        '壬' => '壬',
        '癸' => '甲',
    ];

    private $currentPointer = 0;

    public function __construct() {
        // 12 格拉成 array
        $this->temples = [
            new Temple('巳'),
            new Temple('午'),
            new Temple('未'),
            new Temple('申'),
            new Temple('酉'),
            new Temple('戌'),
            new Temple('亥'),
            new Temple('子'),
            new Temple('丑'),
            new Temple('寅'),
            new Temple('卯'),
            new Temple('辰'),
        ];
    }

    public function run ($birthday, $hour, $gender) {

        $date = Carbon::parse($birthday);
        $lunar = (new Lunar())->convertSolarToLunar($date->year,
            $date->month, $date->day);

        $lunar_month = $this->month_chinese_to_number[$lunar[1]];
        $lunar_year = $lunar[0];

        // 取得出生時十二地支
        $this->time = $this->times_mapping[$hour];

        // 取得出生年天干
        $this->year = $this->decimal_years[$this->calcYearDecimal($lunar_year)];
        // 取得出生年地支
        $val = (($lunar_year - 1911) % 12);
        if ($val <= 0) { $val++; }
        $this->year_earth = $this->times[$val - 1];

        // 訂命宮
        $this->startAssignTempleName($lunar_month, $hour);
        // 起寅手
        $this->assignTempleSky();

        // TODO  訂身宮
        // 順數生月，順數生時 就可以找到身宮

        // 訂局數
        // 出生西元年最尾數減 3 為年干, 1982 年 2 - 3 = -1 (壬)
        // 快速移到命宮
        $this->currentPointer = $this->lifeTempleIndex;
        // 命宮位置會決定元素 ~ 取得對應局數
        $this->element = $this->elements_mapping[$this->currentTemple()->sky . $this->currentTemple()->time];
        // 定紫微
        $this->ziwei($lunar[5], $this->element);
        // 訂紫微 Pointer
        // 一個星座由紫微帶領，順地支而行：紫機○陽，武同○○廉
        $ziwei_position = $this->currentPointer;
        $this->counter_clockwise(1);
        array_push($this->currentTemple()->primary_stars, '天機');
        $this->counter_clockwise(2);
        array_push($this->currentTemple()->primary_stars, '太陽');
        $this->counter_clockwise(1);
        array_push($this->currentTemple()->primary_stars, '武曲');
        $this->counter_clockwise(1);
        array_push($this->currentTemple()->primary_stars, '天同');
        $this->counter_clockwise(3);
        array_push($this->currentTemple()->primary_stars, '廉貞');
        // 紫微 對宮 天府
        $this->currentPointer = $this->time_to_pointer[$this->reverse_ziwei[$this->pointer_to_time[$ziwei_position]]];
        array_push($this->currentTemple()->primary_stars, '天府');
        // 由天府帶領，逆地支而行：府陰貪巨相，梁殺○○○破
        $this->clockwise(1);
        array_push($this->currentTemple()->primary_stars, '太陰');
        $this->clockwise(1);
        array_push($this->currentTemple()->primary_stars, '貪狼');
        $this->clockwise(1);
        array_push($this->currentTemple()->primary_stars, '巨門');
        $this->clockwise(1);
        array_push($this->currentTemple()->primary_stars, '天相');
        $this->clockwise(1);
        array_push($this->currentTemple()->primary_stars, '天梁');
        $this->clockwise(1);
        array_push($this->currentTemple()->primary_stars, '七殺');
        $this->clockwise(4);
        array_push($this->currentTemple()->primary_stars, '破軍');

        // dd($lunar_month);
        // 左輔
        $this->zuofu($lunar_month);
        // 右弼
        $this->youbi($lunar_month);
        $time = $this->times_mapping[$hour];
        $index = array_search($time, $this->times) + 2;
        // 文曲
        $this->wenqu($index);
        // 文昌
        $this->wenchang($index);

        // 天魁
        // 天鉞
        $this->tian_kuei_yue($this->year);

        // 祿存
        // 擎羊
        // 陀羅
        $this->lucun($this->year);

        // 火星
        // 鈴星
        $this->fire_bell($this->year_earth, $this->time);

        // 地空
        // 地劫
        $this->earth_sky($this->time);

        // TODO 生年四化

        return [
            'time' => $this->time,
            'temples' => $this->temples,
            'date' => $date->toDateString(),
            'lunar_date' => $lunar,
            'element' => $this->element_mapping[$this->element],
            'four_types' => $this->four_types[$this->year]
        ];
    }

    public function assignTempleSky()
    {
        $hand = $this->hands[$this->year];

        $map = [
            '丙' => ['丙', '丁', '戊', '己', '庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁'],
            '戊' => ['戊', '己', '庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁', '戊', '己'],
            '庚' => ['庚', '辛', '壬', '癸', '甲', '乙', '丙', '丁', '戊', '己', '庚', '辛'],
            '壬' => ['壬', '癸', '甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'],
            '甲' => ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸', '甲', '乙'],
        ];

        $this->resetCounter();
        // 從左下角開始 (逆時針 3)
        $this->counter_clockwise(3);
        foreach ($map[$hand] as $sky) {
            $this->currentTemple()->sky = $sky;
            $this->clockwise();
        }
    }

    // 地空, 地劫
    public function earth_sky($time)
    {
        // 由亥宮起子時逆時針數至生時安天空，由亥宮起子時順時針數至生時安地劫
        $move = array_search($time, $this->times);
        $this->currentPointer = array_search('亥', $this->pointer_to_time);
        $this->counter_clockwise($move);
        array_push($this->currentTemple()->bad_stars, '地空');

        $this->currentPointer = array_search('亥', $this->pointer_to_time);
        $this->clockwise($move);
        array_push($this->currentTemple()->bad_stars, '地劫');
    }

    // 火星, 鈴星
    public function fire_bell($year_earth, $time)
    {
        switch ($year_earth)
        {
            // 火星由丑宮起子時順時針數至生時安火星
            // 鈴星由卯宮起子時順時針數至生時安鈴星
            case '寅':
            case '午':
            case '戊':
            $move = array_search($time, $this->times);
            $this->currentPointer = array_search('丑', $this->pointer_to_time);
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '火星');
            $this->currentPointer = array_search('卯', $this->pointer_to_time);
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '鈴星');
            break;

            // 火星由寅宮起子時順時針數至生時安火星
            // 鈴星由戌宮起子時順時針數至生時安鈴星
            case '申':
            case '子':
            case '辰':
            $this->currentPointer = array_search('寅', $this->pointer_to_time);
            $move = array_search($time, $this->times) + 1;
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '火星');
            $this->currentPointer = array_search('戌', $this->pointer_to_time);
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '鈴星');
            break;

            // 火星由卯宮起子時順時針數至生時安火星
            // 鈴星由戌宮起子時順時針數至生時安鈴星
            case '巳':
            case '丑':
            case '酉':
            $this->currentPointer = array_search('卯', $this->pointer_to_time);
            $move = array_search($time, $this->times) + 1;
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '火星');
            $this->currentPointer = array_search('戌', $this->pointer_to_time);
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '鈴星');
            break;

            // 火星由酉宮起子時順時針數至生時安火星
            // 鈴星由戌宮起子時順時針數至生時安鈴星
            case '亥':
            case '卯':
            case '未':
            $this->currentPointer = array_search('酉', $this->pointer_to_time);
            $move = array_search($time, $this->times);
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '火星');
            $this->currentPointer = array_search('戌', $this->pointer_to_time);
            $this->clockwise($move);
            array_push($this->currentTemple()->bad_stars, '鈴星');
            break;
        }
    }

    // 天魁, 天鉞
    public function tian_kuei_yue($year)
    {
        $position = $this->tian_kuei_yue[$year];
        $this->currentPointer = $this->time_to_pointer[$position['kuei']];
        array_push($this->currentTemple()->secondary_stars, '天魁');
        $this->currentPointer = $this->time_to_pointer[$position['yue']];
        array_push($this->currentTemple()->secondary_stars, '天鉞');
    }

    public function lucun($year)
    {
        // $this->resetCounter();
        // // 從左下角開始 (逆時針 3)
        // $this->counter_clockwise(3);
        // 快速取得 currentPointer 位置
        $position = $this->time_to_pointer[$this->lucun_mapping[$year]];
        $this->currentPointer = $position;
        array_push($this->currentTemple()->secondary_stars, '祿存');

        // 前羊
        $this->clockwise(1);
        array_push($this->currentTemple()->bad_stars, '擎羊');

        // 後陀
        $this->currentPointer = $position;
        $this->counter_clockwise(1);
        array_push($this->currentTemple()->bad_stars, '陀羅');
    }

    // 左輔
    public function zuofu($month)
    {
        $this->resetCounter();
        // 左輔從「辰」起正月 （順時針）
        $this->counter_clockwise(1); // 辰
        $this->clockwise($month - 1);
        array_push($this->currentTemple()->secondary_stars, '左輔');
    }

    // 右弼
    public function youbi($month)
    {
        $this->resetCounter();
        // 右弼從「戌」起正月 （逆時針）
        $this->clockwise(5); // 戌
        $this->counter_clockwise($month - 1);
        array_push($this->currentTemple()->secondary_stars, '右弼');
    }

    // 文曲
    public function wenqu($hour)
    {
        $this->resetCounter();
        // 文曲從「辰」起子時 （順時針）
        $this->counter_clockwise(1); // 辰
        $this->clockwise(intval($hour / 2) + 1);
        array_push($this->currentTemple()->secondary_stars, '文曲');
    }

    // 文昌
    public function wenchang($hour)
    {
        $this->resetCounter();
        // 文昌從「戌」起子時 （順時針）
        $this->clockwise(5); // 戌
        $this->counter_clockwise(intval($hour / 2) + 1);
        array_push($this->currentTemple()->secondary_stars, '文昌');
    }

    public function ziwei($date, $element)
    {
        $this->resetCounter();
        $heaps = intval($date / $element) - 1;
        $mod = $date % $element;
        $mod = $element - $mod;
        if ($mod !== $element) { // 整除
            $heaps++;
        }
        // 從左下角開始 (逆時針 3)
        $this->counter_clockwise(3);
        $this->clockwise($heaps);
        switch ($mod) {
            case 1:
                // 缺一退一
                $this->counter_clockwise(1);
                break;
            case 2:
                // 缺二進二
                $this->clockwise(2);
                break;
            case 3:
                // 缺三退三
                $this->counter_clockwise(3);
                break;
            case 4:
                // 缺四進四
                $this->clockwise(4);
                break;
            case 5:
                // 缺五退五
                $this->counter_clockwise(5);
                break;
        }

        array_push($this->currentTemple()->primary_stars, '紫微');
    }

    // 計算年干 (會回傳一個數字)
    protected function calcYearDecimal ($year)
    {
        $str_year = (string) $year;
        $last_digit = intval($str_year[strlen($str_year)-1]);
        $val = $last_digit - 3;
        if ($val <= 0) {
            $val += 10;
        }
        return $val;
    }

    protected function startAssignTempleName($month, $hour)
    {
        $this->resetCounter();
        // 從左下角開始 (逆時針 3)
        $this->counter_clockwise(3);
        // 順時針數出生月份（農曆)
        $this->clockwise($month - 1);
        // 再從該格逆時針數數出生時辰
        $time = $this->times_mapping[$hour];
        $index = array_search($time, $this->times);
        $this->counter_clockwise($index);

        // shortcut for life temple
        $this->lifeTempleIndex = $this->currentPointer;

        $this->currentTemple()->name = '命宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '兄弟宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '夫妻宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '子女宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '財帛宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '疾厄宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '遷移宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '交友宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '事業宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '田宅宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '福德宮';
        $this->counter_clockwise();
        $this->currentTemple()->name = '父母宮';
    }

    protected function currentTemple ()
    {
        return $this->temples[$this->currentPointer];
    }

    protected function resetCounter()
    {
        $this->currentPointer = 0;
    }

    protected function hasNext () {
        return $this->currentPointer + 1 < 12;
    }

    protected function hasPrev () {
        return $this->currentPointer != 0;
    }

    protected function clockwise ($step = 1) {
        for ($i = 0; $i < $step; $i++)
        {
            if ($this->hasNext()) {
                $this->currentPointer++;
            } else {
                $this->currentPointer = 0;
            }
        }
    }

    protected function counter_clockwise ($step = 1) {
        for ($i = 0; $i < $step; $i++) {
            if ($this->hasPrev()) {
                $this->currentPointer--;
            } else {
                $this->currentPointer = 11;
            }
        }
    }
}