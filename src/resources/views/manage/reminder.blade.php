{{ $reservation->shopUser()}}様

<p>この度は誠にありがとうございます。</p>
<p>本日以下の内容でご予約をお取りしております。</p>

<ol>
    <li>ご予約日：{{$reservation->date}}</li>
    <li>時間：{{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}</li>
    <li>人数：{{$reservation->num_of_users}}人</li>
</ol>

<p>ご来店をお待ちしております。</p>

<div>
<p>※当店は、便利なStripe決済もご利用いただけます。
<br>ご利用の際は下記リンク先をクリックしてください。</p>
<p><a href="http://localhost/payment/stripe">Stripe決済</a></P>
</div>

*************************
<div>{{ $reservation->shopName() }}</div>