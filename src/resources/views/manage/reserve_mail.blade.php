{{ $name }}様

<p>この度は誠にありがとうございます。</p>
<p>以下の内容でご予約が完了いたしました。</p>

<ol>
    <li>ご予約日：{{$reserve_date}}</li>
    <li>時間：{{$reserve_time}}</li>
    <li>人数：{{$reserve_number}}人</li>
</ol>

<p>ご来店をお待ちしております。</p>

<div>
<p>※当店は、便利なStripe決済もご利用いただけます。
<br>ご利用の際は下記リンク先をクリックしてください。</p>
<p><a href="http://localhost/payment/stripe">Stripe決済</a></P>
</div>

*************************
<div>{{ $shop_name }}</div>