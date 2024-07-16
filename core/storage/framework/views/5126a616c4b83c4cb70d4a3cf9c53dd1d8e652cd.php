<script src="<?php echo e(global_asset('assets/landlord/common/js/summernote-lite.min.js')); ?>"></script>
<script>
    $('textarea.summernote').summernote({
        placeholder: "<?php echo e(__('Hello stand alone ui')); ?>",
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen','help']]
        ],
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            }
        }
    });
</script>
<?php /**PATH C:\laragon\www\nazmart\core\resources\views/components/summernote/js.blade.php ENDPATH**/ ?>