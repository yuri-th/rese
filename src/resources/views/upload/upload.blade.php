<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-star-rating/dist/VueStarRating.umd.min.js"></script>`
</head>

<body>
    <form action="/upload/upload/image" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <button type="submit">アップロード</button>
    </form>
</body>

</html>