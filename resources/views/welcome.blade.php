<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="m-4">

            <label for="birthday">出生年月日</label>
            <input type="text" name="birthday" value="1990-09-17">

            <label for="hour">時辰</label>
            <input type="text" name="hour" value="7">

            <label for="gender">性別</label>
            <input type="text" name="gender" value="1">

            <button onclick="submit()" class="btn btn-primary btn-sm">OK</button>

        </div>

        <canvas id="canvas" width="800" height="800">

        </canvas>
        <script>

        /**
        * @author zhangxinxu(.com)
        * @licence MIT
        * @description http://www.zhangxinxu.com/wordpress/?p=7362
        */
        CanvasRenderingContext2D.prototype.fillTextVertical = function (text, x, y) {
            var context = this;
            var canvas = context.canvas;

            var arrText = text.split('');
            var arrWidth = arrText.map(function (letter) {
                return context.measureText(letter).width;
            });

            var align = context.textAlign;
            var baseline = context.textBaseline;

            if (align == 'left') {
                x = x + Math.max.apply(null, arrWidth) / 2;
            } else if (align == 'right') {
                x = x - Math.max.apply(null, arrWidth) / 2;
            }
            if (baseline == 'bottom' || baseline == 'alphabetic' || baseline == 'ideographic') {
                y = y - arrWidth[0] / 2;
            } else if (baseline == 'top' || baseline == 'hanging') {
                y = y + arrWidth[0] / 2;
            }

            context.textAlign = 'center';
            context.textBaseline = 'middle';

            // 开始逐字绘制
            arrText.forEach(function (letter, index) {
                // 确定下一个字符的纵坐标位置
                var letterWidth = arrWidth[index];
                // 是否需要旋转判断
                var code = letter.charCodeAt(0);
                if (code <= 256) {
                    context.translate(x, y);
                    // 英文字符，旋转90°
                    context.rotate(90 * Math.PI / 180);
                    context.translate(-x, -y);
                } else if (index > 0 && text.charCodeAt(index - 1) < 256) {
                    // y修正
                    y = y + arrWidth[index - 1] / 2;
                }
                context.fillText(letter, x, y);
                // 旋转坐标系还原成初始态
                context.setTransform(1, 0, 0, 1, 0, 0);
                // 确定下一个字符的纵坐标位置
                var letterWidth = arrWidth[index];
                y = y + letterWidth + 4;
            });
            // 水平垂直对齐方式还原
            context.textAlign = align;
            context.textBaseline = baseline;
        };


    var c = document.getElementById("canvas");
    var ctx = c.getContext("2d");
    // 上下左右留 32px
    // 每個格子的寬高度計算
    var chartWidth = 800 - (32 * 2);
    var chartHeight = 800 - (32 * 2);

    var templeWidth = chartWidth / 4;
    var templeHeight = chartHeight / 4;

    // 順時針
    var positions = [
        // 第一格
        {
            primary: {
                x: templeWidth,
                y: 64
            },
            bad: {
                x: 32 + 10,
                y: 64
            },
            name: {
                x: 32 + 10,
                y: templeHeight + 24
            }
        },
        // 第二格
        {
            primary: {
                x: templeWidth * 2,
                y: 64
            },
            bad: {
                x: templeWidth + 32 + 10,
                y: 64
            },
            name: {
                x: 32 + 10 + templeWidth,
                y: templeHeight + 24
            }
        },
        // 第三格
        {
            primary: {
                x: templeWidth * 3,
                y: 64,
            },
            bad: {
                x: templeWidth * 2 + 32 + 10,
                y: 64
            },
            name: {
                x: 32 + 10 + templeWidth * 2,
                y: templeHeight + 24
            }
        },
        // 第四格
        {
            primary: {
                x: templeWidth * 4,
                y: 64,
            },
            bad: {
                x: templeWidth * 3 + 32 + 10,
                y: 64
            },
            name: {
                x: 32 + 10 + templeWidth * 3,
                y: templeHeight + 24
            }
        },
        // 第五格
        {
            primary: {
                x: templeWidth * 4,
                y: templeHeight + 64
            },
            bad: {
                x: templeWidth * 3 + 32 + 10,
                y: templeHeight + 64
            },
            name: {
                x: 32 + 10 + templeWidth * 3,
                y: templeHeight * 2 + 24
            }
        },
        // 第六格
        {
            primary: {
                x: templeWidth * 4,
                y: templeHeight * 2 + 64
            },
            bad: {
                x: templeWidth * 3 + 32 + 10,
                y: templeHeight * 2 + 64
            },
            name: {
                x: 32 + 10 + templeWidth * 3,
                y: templeHeight * 3 + 24
            }
        },
        // 第七格
        {
            primary: {
                x: templeWidth * 4,
                y: templeHeight * 3 + 64
            },
            bad: {
                x: templeWidth * 3 + 32 + 10,
                y: templeHeight * 3 + 64
            },
            name: {
                x: 32 + 10 + templeWidth * 3,
                y: templeHeight * 4 + 24
            }
        },
        // 第八格
        {
            primary: {
                x: templeWidth * 3,
                y: templeHeight * 3 + 64
            },
            bad: {
                x: templeWidth * 2 + 32 + 10,
                y: templeHeight * 3 + 64
            },
            name: {
                x: 32 + 10 + templeWidth * 2,
                y: templeHeight * 4 + 24
            }
        },
        // 第九格
        {
            primary: {
                x: templeWidth * 2,
                y: templeHeight * 3 + 64
            },
            bad: {
                x: templeWidth + 32 + 10,
                y: templeHeight * 3 + 64
            },
            name: {
                x: 32 + 10 + templeWidth,
                y: templeHeight * 4 + 24
            }
        },
        // 第十格
        {
            primary: {
                x: templeWidth,
                y: templeHeight * 3 + 64
            },
            bad: {
                x: 32 + 10,
                y: templeHeight * 3 + 64
            },
            name: {
                x: 32 + 10,
                y: templeHeight * 4 + 24
            }
        },
        {
            primary: {
                x: templeWidth,
                y: templeHeight * 2 + 64
            },
            bad: {
                x: 32 + 10,
                y: templeHeight * 2 + 64
            },
            name: {
                x: 32 + 10,
                y: templeHeight * 3 + 24
            }
        },
        {
            primary: {
                x: templeWidth,
                y: templeHeight + 64
            },
            bad: {
                x: 32 + 10,
                y: templeHeight + 64
            },
            name: {
                x: 32 + 10,
                y: templeHeight * 2 + 24
            }
        },
    ];

    function clearCanvas () {
        ctx.clearRect(0, 0, 800, 800);
    }

    function initCanvas () {
        // 開始準備畫格子
        // 左上角座標 (32, 32)
        ctx.moveTo(32, 32);
        // 左下角座標 (32, 高 - 邊距)
        ctx.lineTo(32, 800 - 32);
        // 右下角
        ctx.lineTo(800 - 32, 800 - 32);
        // 右上角
        ctx.lineTo(800 - 32, 32);
        // 回歸
        ctx.lineTo(32, 32);
        ctx.stroke();

        // 開始準備畫每個宮位

        // 第一條水平線
        ctx.beginPath();
        ctx.moveTo(32, 32 + templeHeight)
        ctx.lineTo(800 - 32, 32 + templeHeight);
        ctx.stroke();

        // 第二條水平線
        ctx.beginPath();
        ctx.moveTo(32, 32 + templeHeight * 2)
        ctx.lineTo(32 + templeWidth, 32 + templeHeight * 2);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(32 + templeWidth * 3, 32 + templeHeight * 2);
        ctx.lineTo(32 + templeWidth * 4, 32 + templeHeight * 2);
        ctx.stroke();

        // 第三條水平線
        ctx.beginPath();
        ctx.moveTo(32, 32 + templeHeight * 3)
        ctx.lineTo(800 - 32, 32 + templeHeight * 3);
        ctx.stroke();

        // 第一條垂直線
        ctx.beginPath();
        ctx.moveTo(32 + templeWidth, 32);
        ctx.lineTo(32 + templeWidth, 800 - 32);
        ctx.stroke();

        // 第二條垂直線
        ctx.beginPath();
        ctx.moveTo(32 + templeWidth * 2, 32);
        ctx.lineTo(32 + templeWidth * 2, 32 + templeHeight);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(32 + templeWidth * 2, 32 + templeHeight * 3);
        ctx.lineTo(32 + templeWidth * 2, 32 + templeHeight * 4);
        ctx.stroke();

        // 第三條垂直線
        ctx.beginPath();
        ctx.moveTo(32 + templeWidth * 3, 32);
        ctx.lineTo(32 + templeWidth * 3, 800 - 32);
        ctx.stroke();
    }

    function submit() {

        var formData = {
            birthday: $('input[name=birthday]').val(),
            hour: $('input[name=hour]').val(),
            gender: $('input[name=gender]').val(),
        };

        $.post('/api/chart', formData, function (data) {

            clearCanvas();
            initCanvas();

            ctx.font = "500 20px 'Noto Sans TC'";
            ctx.fillStyle = "#000";

            var temples = data.temples;
            var lunar_date = data.lunar_date;
            var element = data.element;
            var birthday = data.date;
            var four_types = data.four_types;
            var time = data.time;

            for (var i = 0; i < 12; i++) {

                var primary_position = positions[i].primary;
                var bad_position = positions[i].bad;
                var name_position = positions[i].name;

                var temple = temples[i];
                // 取出主星
                var primary_stars = temple.primary_stars;
                // 移動到第 i 個宮位座標
                for (var j = 0; j < primary_stars.length; j++) {
                    var star = primary_stars[j];
                    ctx.fillTextVertical(star, primary_position.x + 10 - j * 24, primary_position.y);
                }

                var secondary_stars = temple.secondary_stars;
                for (var j = 0; j < secondary_stars.length; j++) {
                    var star = secondary_stars[j];
                    ctx.fillTextVertical(star, primary_position.x + 10 - (primary_stars.length + j) * 24, primary_position.y);
                }

                var bad_stars = temple.bad_stars;
                for (var j = 0; j < bad_stars.length; j++) {
                    var star = bad_stars[j];
                    ctx.fillTextVertical(star, bad_position.x + 10 + j * 24, bad_position.y);
                }

                ctx.fillText(`${temple.name}`, name_position.x + 32, name_position.y);
                ctx.fillTextVertical(`${temple.sky}${temple.time}`, name_position.x + 10, name_position.y - 20);
            }

            // 中間格的左上角
            ctx.fillText(`農曆 ${lunar_date[3]} ${lunar_date[0]} 年 ${lunar_date[1]} ${lunar_date[2]} (${time}時)`, templeHeight + 32 + 10, templeHeight + 64);
            ctx.fillText(`國曆 ${birthday}`, templeHeight + 32 + 10, templeHeight + 64 + 32);
            ctx.fillText(`${element}`, templeHeight + 32 + 10, templeHeight + 64 + 32 + 32);

            var arr = [];
            for (var key of Object.keys(four_types)) {
                arr.push(four_types[key] + '化' + key);
            }
            ctx.fillText(arr.join(','), templeHeight + 32 + 10, templeHeight + 64 + 32 + 32 + 32);
        });
    }

        </script>
    </body>
</html>
