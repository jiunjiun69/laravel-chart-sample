# laravel-chart-sample
laravel chart sample,use xampp and chartjs

透過[Server Sent Events](https://en.wikipedia.org/wiki/Server-sent_events) 將XAMPP架設的MySQL資料庫中的數據推送到chart顯示


## Requirements

- [XAMPP](https://www.apachefriends.org/zh_tw/download.html)
- [Composer](https://getcomposer.org/)
- [Laravel 7.x](https://laravel.com/docs/7.x/installation)

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

### 利用 Composer 下載 Laravel 安裝器，開啟cmd輸入
```
composer global require laravel/installer
```

### 建立 Larvel 專案，用Composer 下載了 Laravel 安裝套件，可以利用這個安裝套件輕易的建立好 Laravel 專案，cmd輸入
```
~~laravel new blog~~
composer create-project --prefer-dist laravel/laravel blog 7.30.*
```
blog為你的專案名稱
