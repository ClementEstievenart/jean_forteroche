<?php
$title = 'Nouveau chapitre';

ob_start();
?>
<script src='<?= $this->_url ?>/vendor/tinymce/js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: '#title',
        inline: true,
        toolbar: false,
        menubar: false,
        mobile: {
            theme: 'modern',
            toolbar: false,
            menubar: false }
    });
</script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: "lists image imagetools media link paste help autolink preview searchreplace wordcount visualchars autoresize autosave contextmenu fullscreen nonbreaking save",
        content_css: ['/public/css/editor.css'],
        menu: {
            file: {title: 'File', items: 'restoredraft | preview'},
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall searchreplace'},
            insert: {title: 'Insert', items: 'image link media'},
            view: {title: 'View', items: 'visualaid visualblocks visualchars | fullscreen'},
            format: {title: 'Format', items: 'bold italic underline strikethrough | blockformats | removeformat'},
            help : {title: 'Help', items: 'help'}},
        toolbar: ["formatselect | bold italic underline blockquote | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | save publish fullscreen"],
        language: 'fr_FR',
        image_advtab: true,
        image_caption: true,
        imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
        link_context_toolbar: true,
        paste_data_images: true,
        autoresize_bottom_margin: 0,
        autoresize_max_height: 400,
        autoresize_min_height: 400,
        contextmenu: "undo redo | copy cut paste | link image media inserttable",
        nonbreaking_force_tab: true
    });
</script>
<?php
$tinyMCE = ob_get_clean();

ob_start();
?>
<h2 class="page_content">Rédiger un nouveau chapitre</h2>
<form id="newPostForm" action="Ajouter-chapitre" method="post" name="newPost">
    <div id="edit_title_container"><h3 id="title" class="page_content">Editer le titre</h3></div>
    <div style="display: none"><input id="published" name="published"></div>
    <div><textarea id="content" name="content" required></textarea></div>
</form>

<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
