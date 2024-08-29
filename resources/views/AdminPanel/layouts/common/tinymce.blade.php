<!-- TinyMCE -->
<script src="{{ asset('AdminAssets/app-assets/js/scripts/tinymce/tinymce.js')}}"></script>

<script>
    $(function () {
        //TinyMCE
        tinymce.init({
            selector: "textarea.editor_ar",
        image_title: true,
        automatic_uploads: true,
        images_upload_url: '{{url('/AdminPanel/UploadPhotos')}}',
        file_picker_types: 'image media',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        },
            allow_script_urls: true,
            relative_urls: false,
            document_base_url: '{{url("/")}}',
            language: "ar",
            directionality : "rtl",
            theme: "modern",
            height: 100,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools paste'
            ],
            paste_as_text: true,
            toolbar1: 'insertfile undo redo paste | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '{{ asset("AdminAssets/app-assets/js/scripts/tinymce")}}';
    });
    $(function () {
        //TinyMCE
        tinymce.init({
            selector: "textarea.editor_en",
        image_title: true,
        automatic_uploads: true,
        images_upload_url: '{{url('/AdminPanel/UploadPhotos')}}',
        file_picker_types: 'image media',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        },
            allow_script_urls: true,
            relative_urls: false,
            document_base_url: '{{url("/")}}',
            language: "en",
            directionality : "ltr",
            theme: "modern",
            height: 100,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools paste'
            ],
            paste_as_text: true,
            toolbar1: 'insertfile undo redo paste | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '{{ asset("AdminAssets/app-assets/js/scripts/tinymce")}}';
    });
</script>