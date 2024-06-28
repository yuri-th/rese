# Rese（リーズ）<br>
ある企業のグループ会社の飲食店予約サービス<br>

◆ユーザーページ<br>

<img src="https://github.com/yuri-th/rese/assets/117786989/551cff24-76d2-41d6-847c-75d0b8645c59" width="800" alt="user_page"><br>

◆店舗情報管理ページ<br>
<img src="https://github.com/yuri-th/rese/assets/117786989/294011dc-f0cf-48c9-8b4a-a05b16023fe3"　width="800" alt="shop_manager_page"><br>

◆店舗代表者管理ページ<br>
<img src="https://github.com/yuri-th/rese/assets/117786989/970b46e0-e830-45f6-af83-0fd765a4c7cc" width="800" alt="admin_page"><br>

## 作成の目的<br>
外部の飲食店予約サービスを利用すると手数料がかかるので、自社で予約サービスを作って管理するため。<br>

・アプリケーションURL<br>
　http://localhost/<br>
  ※ログインには、名前とemail、パスワードでの会員登録が必要です。<br>

## 機能一覧<br>
会員登録/ログイン、ログアウト/メール認証/ユーザー情報取得/ユーザー飲食店お気に入り一覧取得/ユーザー飲食店予約情報取得/飲食店一覧取得/飲食店詳細取得/飲食店お気に入り追加、削除/飲食店予約情報追加、削除、変更/
店舗のエリア検索、ジャンル検索、店名検索/飲食店レビュー投稿機能（星５段階評価、コメント、画像）/認証、予約、レビュー投稿、店舗情報作成、店舗代表者作成の際のバリデーション機能/管理者、店舗代表者の管理画面/
お店の画像をストレージに保存/予約者にメールでお知らせを送信/予約日当日の朝に予約者にリマインダー送信/Stripe決済機能（メールに添付）/店舗一覧ソート機能（評価の高い順、低い順、ランダム）/CSVインポート機能（新規店舗追加）/レスポンシブデザイン（ブレイクポイント768px)<br>

## 使用言語、フレームワーク、DBなど<br>
HTML/CSS/PHP/JavaScript/Laravel (v8)/Vue.js/MySQL/Docker<br>

## テーブル設計<br><br>

## ER図<br><br>

## 環境構築<br>
・プロジェクトをコピーしたいディレクトリにて「git clone <https://github.com/yuri-th/rese.git>」を行いプロジェクトをコピー<br>
・「cd rese/src」を行い.env.example のあるディレクトリに移動<br>
・.env.example をコピーし.env を作成<br>
・.env の DB_DATABASE=laravel_db DB_USERNAME=laravel_user DB_PASSWORD=laravel_pass を記載<br>
・docker-compose.yml の存在するディレクトリにて「docker-compose up -d --build」<br>
・php コンテナに入る「docker-compose exec php bash」<br>
・コンポーザのアップデートを行う「composer update」<br>
・APP_KEY の作成「php artisan key:generate」<br>
・テーブルの作成「php artisan migrate」または「php artisan migrate:fresh」<br>
※環境により「fresh」をつけないとテーブルを作成できない場合があります。<br>
・ユーザー、店舗データ、店舗代表者、管理者、予約の作成「php artisan db:seed」<br>
・Windowsで権限のエラーが出た場合は「sudo chmod -R 777 src」にて権限解除をしてください。<br>

以上でアプリの使用が可能です。<br>
*「localhost/」にて店舗一覧ページが開きます。<br>
*「localhost/manage/manager_manage/」で管理者ログイン画面が開きます。
*「localhost/manage/」で店舗代表者ログイン画面が開きます。<br>
認証メール、お知らせメール、リマインダーメールはMailHogに届きます。<br>
リマインダーメールは予約日の当日9:00に届きます。<br>
お知らせメール、リマインダーメールにはStripe決済リンクがあります。<br>

## 追記事項<br>
・予約の削除はマイページの予約テーブルの×印を押すとできます。（予約日の前日までキャンセル可）<br>
・stripe決済は、<br>
  カード番号: 4242 4242 4242 4242<br>
  有効期限: 任意の未来の日付<br>
  CVC（セキュリティコード）: 任意の3桁の数字<br>
  で決済のテスト確認ができます。(*.envで公開鍵と秘密鍵の設定が必要です)
