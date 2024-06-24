document.addEventListener('DOMContentLoaded', () => {

    // 画像アップロードエリアのイベントリスナー
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');

    if (!uploadArea || !fileInput) {
        console.error('uploadAreaまたはfileInputが見つかりません。HTML構造を確認してください。');
        return;
    }

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        console.log('Selected files:', files); // 選択されたファイルをコンソールに出力

        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        fetch('/review/post', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});

