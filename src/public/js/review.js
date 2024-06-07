// Dropzone.autoDiscover = false;
// $(document).ready(function () {
//     var myDropzone = new Dropzone("#my-dropzone", {
//         url: "/review/post",
//         paramName: "file",
//         maxFilesize: 2,
//         addRemoveLinks: true,
//         acceptedFiles: ".png,.jpg,.jpeg",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//         },
//         dictDefaultMessage: "<p class='large-text'>クリックして写真を追加</p><p class='small-text'>またはドロッグアンドドロップ</p>",
//     });
// });



// Dropzone.autoDiscover = false;
// var myDropzone = new Dropzone(".dropzone", {
//     // url: "{{ route('upload') }}",
//     url: "/review/post",
//     paramName: "file",
//     required: true,
//     maxFilesize: 2, // 最大ファイルサイズ（単位: MB）
//     acceptedFiles: ".png,.jpg,.jpeg",
//     addRemoveLinks: true,
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//     },
//     dictDefaultMessage: "<p class='large-text'>クリックして写真を追加</p><p class='small-text'>またはドロッグアンドドロップ</p>",
// });



document.getElementById('showAllReviews').addEventListener('click', function () {
    var otherReviews = document.getElementById('otherReviews');
    otherReviews.style.display = 'block'; // 他のユーザーのレビューを表示

    // var userReviews = document.querySelector('.user-post');
    // userReviews.style.display = 'none'; // ログインユーザーのレビューを非表示
});

