# laravel-chart-sample
利用Laravel透過[Server Sent Events](https://en.wikipedia.org/wiki/Server-sent_events)串接XAMPP資料庫與chartjs圖表的實作過程教學

此專案是依老師要求，要教學弟妹們laravel串接資料庫與圖表的教學，如有錯誤請鞭小力點，有其他問題都歡迎提問或指正，感謝大家

## Requirements

- [XAMPP](https://www.apachefriends.org/zh_tw/download.html)
- [Composer](https://getcomposer.org/)
- [Laravel 7.x](https://laravel.com/docs/7.x/installation)
- [Chart.js](https://www.chartjs.org/)

## 第一步-環境安裝

### 安裝XAMPP

https://www.apachefriends.org/zh_tw/download.html

![alt xampp](/img/xampp.png "xampp")

請先下載並安裝XAMPP，下載完成後下一步直到完成即可

### 安裝Composer

https://getcomposer.org/

![alt composer](/img/composer.png "composer")
![alt composer-1](/img/composer-2.png "composer-2")

![alt composer](/img/composer-3.png "composer-3")

下載完成後，請選擇安裝路徑為xampp中的php底下，並將添加至環境變數打勾

![alt composer-1](/img/composer-4.png "composer-4")

cmd中輸入composer，出現此畫面代表成功

## 第二步-建立及運行Larvel 專案

### ~~利用 Composer 下載 Laravel 安裝器，開啟cmd輸入~~

~~composer global require laravel/installer~~

~~laravel new blog~~


### 建立 Larvel 專案，用Composer 下載了 Laravel 安裝套件，可以利用這個安裝套件輕易的建立好 Laravel 專案，cmd輸入
```
composer create-project --prefer-dist laravel/laravel blog 7.30.*
```
blog為你的專案名稱

### 開啟開發環境網頁伺服器，此命令將在http://127.0.0.1:8000 啟動開發服務器，cmd輸入
```
cd blog
php artisan serve
```
![alt laravel](/img/laravel.png "laravel")

在瀏覽器中輸入http://127.0.0.1:8000 ，能看到以上畫面代表運行成功

### 生成註冊登入頁面

```
composer require laravel/ui "^2.0"
php artisan ui vue --auth
```

這樣就構建好使用者登入註冊介面了

介面在resources\views\auth下

註冊登入控制器在app\Http\Controllers\Auth下

### install node & npm

先安裝node https://nodejs.org/en/

前面生成註冊登入頁面會友提示訊息:Please run "npm install && npm run dev" to compile your fresh scaffolding. 所以要再下指令

```
npm install && npm run dev
```

## 第三步-資料庫串接與取值

請先開啟XAMPP

![alt xampp-2](/img/xampp-2.png "xampp-2")

將上圖中紅色圈圈的部分Start，並點開藍色圈圈Admin進入phpmyadmin中

![alt xampp-3](/img/xampp-3.png "xampp-3")

首先，請建立一個帳號密碼，本教學帳號設定為sample，密碼為123456

![alt laravel-2](/img/laravel-2.png "laravel-2")

接著建立一個名為laravel的資料庫

再來打開laravel專案根目錄中的.env檔，這邊本人偏好用visual studio code，也可用notepad++或電腦內建的記事本都行

找到以下這幾行

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
這邊是mysql的設定，其中laravel就是對應到剛剛在phpmyadmin中建立的laravel資料庫

![alt laravel-3](/img/laravel-3.png "laravel-3")

請將DB_USERNAME 及 DB_PASSWORD 更改為自己設定的使用者帳號及密碼並儲存

### 資料庫遷移

使用以下指令進行資料庫遷移
```
php artisan migrate
```
![alt laravel-4](/img/laravel-4.png "laravel-4")
![alt laravel-5](/img/laravel-5.png "laravel-5")

看到以上內容代表遷移成功

### 資料庫取值

請先建立一個chart資料表，並照著下圖所示加入三個欄位，最後再新增一個值

![alt xampp-4](/img/xampp-4.png "xampp-4")

![alt xampp-5](/img/xampp-5.png "xampp-5")

![alt xampp-6](/img/xampp-6.png "xampp-6")

#### 新增完後換到laravel專案中

#### 開啟sample\resources\views中的welcome.blade.php

找到以下此行
```
<div class="links">
    <a href="https://laravel.com/docs">Docs</a>
    <a href="https://laracasts.com">Laracasts</a>
    <a href="https://laravel-news.com">News</a>
    <a href="https://blog.laravel.com">Blog</a>
    <a href="https://nova.laravel.com">Nova</a>
    <a href="https://forge.laravel.com">Forge</a>
    <a href="https://vapor.laravel.com">Vapor</a>
    <a href="https://github.com/laravel/laravel">GitHub</a>
</div>
```
在div中多加一個連結並儲存
```
<a href="{{ url('/chart') }}">Chart</a>
```
  
#### 開啟sample\app\Http\Controllers中的HomeController.php，在最上方加入use DB，並加入以下function儲存
```
use DB;
```
```
public function chart()
{
    // 連線到資料庫
    DB::connection('mysql');

    // 取值
    $value = DB::table('chart')->orderBy('id', 'desc')->limit(1)->value('value');
        
    return view('chart')->with('value',$value);
}
```

#### 開啟sample\routes中的web.php

在下方加入以下路由
```
Route::get('/chart', 'HomeController@chart')->name('chart');
```

#### 在sample\resources\views中新增chart.blade.php

這邊仿照welcome.blade.php的內容貼過來，把div class="links"的部分替換掉

貼過來後請把以下code
```
<div class="links">
     <a href="https://laravel.com/docs">Docs</a>
     <a href="https://laracasts.com">Laracasts</a>
     <a href="https://laravel-news.com">News</a>
     <a href="https://blog.laravel.com">Blog</a>
     <a href="https://nova.laravel.com">Nova</a>
     <a href="https://forge.laravel.com">Forge</a>
     <a href="https://vapor.laravel.com">Vapor</a>
     <a href="https://github.com/laravel/laravel">GitHub</a>
     <a href="{{ url('/chart') }}">Chart</a>
</div>
```

替換為以下code

```
<div>
    {{ $value }}
</div>
```

#### 更改完之後全部儲存好，到專案根目錄下用cmd下 php artisan serve 啟動網頁伺服器，在 http://127.0.0.1:8000/chart 中如果能看到以下資料庫中value的值就是資料庫串接成功了

![alt laravel-6](/img/laravel-6.png "laravel-6")

## 第四步-加入Server Sent Event(SSE)伺服器推送事件

### 在HomeController加入Server Sent Event的function

先在最上方加入use Symfony\Component\HttpFoundation\StreamedResponse
```
use Symfony\Component\HttpFoundation\StreamedResponse;
```

```
public function chartEventStream()
    {
    // 連線到資料庫
    DB::connection('mysql');

    $data = [
        $t = strtotime('+8 hours'),
        'time' => date('Y-m-d H:i:s', $t),
        
        // 取值
        'value' => DB::table('chart')->orderBy('id', 'desc')->limit(1)->value('value')
    ];

    $response = new StreamedResponse();
    $response->setCallback(function () use ($data){
         echo 'data: ' . json_encode($data) . "\n\n";
         echo "retry: 1000\n";
         ob_flush();
         flush();
    });

    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('X-Accel-Buffering', 'no');
    $response->headers->set('Cach-Control', 'no-cache');
    $response->send();
}
```

### 在web.php加入chartEventStream的路由

```
Route::get('/chartEventStream', 'HomeController@chartEventStream')->name('chartEventStream');
```

### 在chart.blade.php加入接收chartEventStream值的script

```
<script>
    let evtSource = new EventSource("/chartEventStream", {withCredentials: true});
        evtSource.onmessage = function (e) {
            let serverData = JSON.parse(e.data);
            console.log('EventData:- ', serverData);
        };
</script>
```

![alt laravel-7](/img/laravel-7.png "laravel-7")

之後在瀏覽器按F12，切換到Console，如果出現了上圖中推送的console log就是SSE串接前端成功了

## 第五步-串接Chart.js圖表

參考資料： [Chart.js](https://www.chartjs.org/)

### 在chart.blade.php加入script引用此[Chart.js](https://cdnjs.com/libraries/Chart.js)圖表

```
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"></script>
```
將以下code
```
<div>
    {{ $value }}
</div>
```
替換為以下，增加一個canvas用以顯示圖表
```
<div>
    <canvas id="myChart" width="600" height="600"></canvas>
</div>
```

將以下code增加宣告Chart.js的內容
```
<script>
    let evtSource = new EventSource("/chartEventStream", {withCredentials: true});
        evtSource.onmessage = function (e) {
            let serverData = JSON.parse(e.data);
            console.log('EventData:- ', serverData);
        };
</script>
```
增加為
```
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        datasets: [{
            label: '圖表',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '時間軸'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '值'
                        }
                    }]
        }
    }
});

let evtSource = new EventSource("/chartEventStream", {withCredentials: true});
    evtSource.onmessage = function (e) {
        let serverData = JSON.parse(e.data);
        console.log('EventData:- ', serverData);

        myChart.data.labels.push(serverData.time);
        myChart.data.datasets[0].data.push(serverData.value);
        myChart.update();
    };
</script>
```

更改完後儲存並執行專案，在 http://127.0.0.1:8000/chart 如果能夠顯示以下圖表就是成功了!!!

![alt laravel-8](/img/laravel-8.png "laravel-8")
