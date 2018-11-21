(function () {
    'use strict';

    var vm = new Vue({
            el: '#vue-contents',
            data: {
                uploadedImage: '',
            },
            methods: {
                moveToDetail: function (id) {
                    window.location.href = '/detail/' + id;
                },
                moveToRegister: function() {
                    window.location.href = '/register';
                },
                moveToSearch: function() {
                    window.location.href = '/search';
                },
                onFileChange(event) {
                    alert();
                    const files = event.target.files || event.dataTransfer.files;
                    this.createImage(files[0]);
                },
                // アップロードした画像を表示
                createImage(file) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        this.uploadedImage = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
            }
        })
    ;
})();