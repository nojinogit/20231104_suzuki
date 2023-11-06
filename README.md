# Twitter 風 SNS アプリ

メルカリ風アプリ『COACHTECH』
<img width="1882" alt="COACHTECH index" src="https://github.com/nojinogit/web-3-1/assets/127584258/372d59a0-3cc4-4e3e-83f4-9997d5dc5974">

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
<img width="1152" alt="テーブル仕様書" src="https://github.com/nojinogit/web-3-1/assets/127584258/499328c6-cd67-4c89-bddd-23d7f21f428c">

#ER 図  
<img width="624" alt="rese-ER" src="https://github.com/nojinogit/web-3-1/assets/127584258/b24e8e62-20e2-4917-9a18-fb279b4f3b3b">

#環境構築  
・プロジェクトをコピーしたいディレクトリにて「git clone https://github.com/nojinogit/web-3-1.git/ 」を行いプロジェクトをコピー  
・「cd web-3-1/src」を行い.env.example のあるディレクトリに移動  
・.env.example をコピーし.env を作成  
・.env の　 DB_DATABASE=laravel_db DB_USERNAME=laravel_user DB_PASSWORD=laravel_pass を記載  
・docker-compose.yml の存在するディレクトリにて「docker-compose up -d --build」  
・php コンテナに入る「docker-compose exec php bash」  
・コンポーザのアップデート「composer update」  
・APP_KEY の作成「php artisan key:generate」  
・テーブルの作成「php artisan migrate」もしくは「php artisan migrate:fresh」※私の環境では「fresh」をつけないと git hub からクローンしたプロジェクトではテーブルを作成できませんでした  
・アイテムデータ・ユーザの作成「php artisan db:seed」  
・シンボリックリンク作成「php artisan storage:link」  
・権限のエラーが出た場合は「sudo chmod -R 777 src」にて権限解除してください  
以上でアプリ使用可能です「localhost/」にて店舗検索ページ開きます。  
管理者ユーザメールアドレス『admin@aol.com』パスワード『123456789』でログイン可能です。

##備考  
・決済システム stripe にはアカウント作成後にテスト環境の公開キー・シークレットキーを.env ファイルの STRIPE_PUBLIC_KEY=　 STRIPE_SECRET_KEY=　に下さい。

・github のファイルではローカルで環境が完結した方がよいと考え、画像ファイルは storage/app/public/sample に保存されます。デプロイしたアプリでは s3 に保存されるコードにしてあります。

・phpunit テストについて‥まず src の.env.testing.example をコピーして.env.example を作ります。php コンテナにて「php artisan key:generate --env=testing」→ テスト用テーブルの作成「php artisan migrate --env=testing または php artisan migrate:fresh --env=testing」。今回はコントローラごとに tests/Feature にテストファイルを作成しました。php コンテナにて「vendor/bin/phpunit tests/Feature」ですべてのテストが実行されますが、stripe の公開キーとシークレットキーを.env.testing に入れておかないと stripe の決済機能はエラーがでます。stripe_webhook は入れなくてもテストは実行できます。

・webhook について‥今回 stripe の webhook を使い銀行振込・コンビニ入金で購入した商品に対し、金額を入金した時に stripe からの webhook によりアプリのデータベースに入金が記録される機能を実装しました。ですが webhook が https のみに対応しているため aws では機能は反映されていません（ドメインが必要なため見送りました）。ローカル環境では ngork を使用して https 環境を再現し機能の確認ができています。

ローカル環境での webhook の受信の方法 → こちらのサイト「https://biz.addisteria.com/ngrok-windows/ 」を参考に ngrok を導入して下さい → 次にコードを一部修正します、app/Providers/AppServiceProvider.php の//URL::forceScheme('https');のコメントアウトを外してコードを有効にしてください（https では js・css が崩れてしまうためそれを防ぎます）→ngrok.exe のあるフォルダで shift+右クリックで powershell ウインドウをここで開く →「./ngrok http 127.0.0.1」を入力 →Forwarding の「（例）https://4aca-219-100-86-141.ngrok-free.app 」ここが https の url になるのでブラウザでトップページ開きます。

次に stripe の webhook の設定です → 開発者 →webhook→ エンドポイントを追加 → エンドポイント URL に先ほどの URL の後に/stripe/webhook をつけて入力「（例）https://4aca-219-100-86-141.ngrok-free.app/stripe/webhook 」します → バージョンを最新の API バージョン → リッスンするイベントで payment_intent.succeeded にチェックつけイベント追加。→ 開発者 →webhook の先ほど作成したオンラインエンドポイントをクリック → 署名シークレットをクリックしそこに表示された文字列を.env の STRIPE_WEBHOOK に入れてください。

最後にアプリで銀行振込にて商品を購入 →strip のページの支払に売上が反映するのでクリック → 顧客（例：admin）をクリック → 支払方法の右の三点リーダー → 預金残高に資金を追加（テスト環境のみ）→ 購入した商品の金額を入れてください。

これで webhook が動き purchases テーブルの deposited に入金日付が記録されます。コンビニ入金で購入した場合テスト環境では数分すると自動的に strip 側で入金判定が行われ webhook が動くようです。

circleCI について‥テストと aws の EC2 へのデプロイが可能となっておりますが、デプロイに使っているリポジトリは「https://github.com/nojinogit/web-3-dep 」（画像の保存先を s3 に変更したコードにするためリポジトリを分けました）のため現在のリポジトリ「https://github.com/nojinogit/web-3-1 」に push してもテスト・デプロイは行われません（circleCI のプロジェクトのセットアップを行っていません）。一応 web-3-1 の circleCI/config.yml は web-3-dep のファイルと同じものが入っていますので確認はできます。
