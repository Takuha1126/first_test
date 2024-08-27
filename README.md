＃アプリケーション名
勤怠アプリシステム

＃作成した目的
会社員の時間を管理するため

＃機能一覧
ログイン機能
ログアウト機能
打刻機能
認証メール機能
マイページ機能

#使用技術
Laravel,php

#環境構築
クローンする
git clone https://github.com/Takuha1126/first_test.git

ここではfirst_testでする

cd　first_test

Dockerで環境構築
docker-compose up -d --build

Laravelパッケージをインストール
docker-compose exec php bash

composer install

.envファイルを作成
cp .env.example .env
.envファイルを書き換える
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

アプリケーションキーを作成する
php artisan key:generate

テーブルの作成
php artisan migrate:refresh

