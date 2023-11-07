# Twitter 風 SNS アプリ

Twitter 風 SNS アプリ
<img width="1335" alt="" src="https://github.com/nojinogit/20231104_suzuki/assets/127584258/70595551-fde0-4ea5-9e6f-29a563c71da4">

#作成の目的  
vue と laravelapi の演習問題

#機能一覧  
ユーザー認証（Firebase Authentication）  
投稿の一覧表示　追加処理　削除処理  
投稿した名前と投稿内容が表示される  
投稿の追加  
バツマークを押すと投稿が削除される  
いいね機能  
ハートマークを押すと良いね数が増えたり減ったりする  
コメント機能  
矢印マークを押すとコメント画面に遷移する  
コメントした名前と投稿内容が表示される  
コメントの追加

#使用技術  
Laravel Framework 8.83.27/
php:7.4.9/
mysql:8.0.26/
node:20/
nuxt.js:2.17.2/
phpmyadmin/

#テーブル設計  
<img width="563" alt="" src="https://github.com/nojinogit/20231104_suzuki/assets/127584258/cb4066ce-ee29-49b7-ba63-9d3780b40310">

#ER 図  
<img width="410" alt="" src="https://github.com/nojinogit/20231104_suzuki/assets/127584258/9d8154ed-55ed-4abe-bad3-ced2dc67662c">

#環境構築  
・プロジェクトをコピーしたいディレクトリにて「git clone git@github.com:nojinogit/20231104_suzuki.git 」を行いプロジェクトをコピー  
・「cd 20231104_suzuki/src/laravel」を行い.env.example のあるディレクトリに移動  
・.env.example をコピーし.env を作成  
・.env の　 DB_DATABASE=laravel_db DB_USERNAME=laravel_user DB_PASSWORD=laravel_pass を記載  
・docker-compose.yml の存在するディレクトリにて「docker-compose up -d --build」  
・php コンテナに入る「docker-compose exec php bash」  
・「cd laravel」へ移動  
・コンポーザのアップデート「composer update」  
・APP_KEY の作成「php artisan key:generate」  
・テーブルの作成「php artisan migrate」もしくは「php artisan migrate:fresh」※私の環境では「fresh」をつけないと git hub からクローンしたプロジェクトではテーブルを作成できませんでした  
・exit する  
・docker-compose.yml の存在するディレクトリにて「sudo chmod -R 777 src」にて権限解除してください  
・node コンテナに入る「docker-compose exec node bash」  
・「cd nuxt.js」へ移動  
・「yarn install」yarn をインストールする  
・「yarn dev」をする。  
以上でアプリ使用可能です「http://localhost:3000/」にてログインページ開きます。新規登録よりアカウントを登録してください。

##備考
