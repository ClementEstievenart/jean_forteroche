<?php
$title = 'Nouvel épisode';

ob_start();
?>
<script src='http://localhost/projet_4/vendor/tinymce/js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: '#title',
        inline: true,
        toolbar: 'undo redo | bold italic underline strikethrough | subscript superscript | removeformat',
        menubar: false,
        language_url: 'http://localhost/projet_4/vendor/tinymce/js/tinymce/langs/fr_FR'
    });
</script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: "textcolor colorpicker lists advlist image imagetools code media link table paste help anchor autolink preview searchreplace wordcount visualchars autoresize autosave charmap codesample contextmenu fullscreen hr nonbreaking print save spellchecker",
        menu: {
            file: {title: 'File', items: 'newdocument restoredraft | preview print'},
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall searchreplace'},
            insert: {title: 'Insert', items: 'image link media inserttable | codesample hr charmap | anchor nonbreaking'},
            view: {title: 'View', items: 'visualaid visualblocks visualchars | spellchecker | fullscreen code'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats blockformats | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell | row column'},
            tools: {title: 'Tools', items: 'spellchecker | code'},
            help : {title: 'Help', items: 'help'}},
        toolbar: ["fontselect | formatselect | fontsizeselect | bold italic underline blockquote | alignleft aligncenter alignright alignjustify | forecolor backcolor | numlist bullist outdent indent", "spellchecker save publish"],
        language_url: 'http://localhost/projet_4/vendor/tinymce/js/tinymce/langs/fr_FR',
        image_advtab: true,
        image_caption: true,
        imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
        link_context_toolbar: true,
        paste_data_images: true,
        autoresize_bottom_margin: 0,
        autoresize_max_height: 400,
        autoresize_min_height: 400,
        contextmenu: "undo redo | copy cut paste | link image media inserttable",
        nonbreaking_force_tab: true,
        spellchecker_rpc_url: 'spellchecker.php',
        spellchecker_language: 'fr_FR',
        spellchecker_languages: 'French=fr_FR',
    });
</script>
<?php
$tinyMCE = ob_get_clean();

ob_start();
?>
<h2>Rédiger un nouvel épisode</h2>
<form id="newPostForm" action="index.php?action=addPost" method="post" name="newPost">
    <h3 id="title">Editer le titre</h3>
    <div style="display: none"><input id="published" name="published"></div>
    <div><textarea id="content" name="content" required></textarea></div>
</form>

<?php
$content = ob_get_clean();

require('template/template.php');
