<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />
    <!-- jQuery and jQuery UI (REQUIRED) -->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/plugins/elFinder/css/elfinder.min.css'); ?>">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/plugins/elFinder/themes/windows-10/css/theme.css'); ?>">
    <!-- elFinder JS (REQUIRED) -->
    <script src="<?php echo base_url('assets/plugins/elFinder/js/elfinder.min.js'); ?>"></script>
    <?php echo app_stylesheet('assets/css','style.css'); ?>
    <?php if(file_exists(FCPATH.'assets/plugins/elFinder/js/i18n/elfinder.'.$locale.'.js')){ ?>
    <script src="<?php echo base_url('assets/plugins/elFinder/js/i18n/elfinder.'.$locale.'.js'); ?>"></script>
    <?php } ?>
    <script type="text/javascript">
        var FileBrowserDialogue = {
          init: function() {
          },
          mySubmit: function (URL) {
            // pass selected file path to TinyMCE
            parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL.url);
            // force the TinyMCE dialog to refresh and fill in the image dimensions
            var t = parent.tinymce.activeEditor.windowManager.windows[0];
            t.find('#src').fire('change');
            // close popup window
            parent.tinymce.activeEditor.windowManager.close();
        }
    }
    $().ready(function() {
        var elf = $('#elfinder').elfinder({
            lang: '<?php echo ($locale == 'pt'?'pt_BR':$locale); ?>',
            url : '<?php echo admin_url(); ?>utilities/elfinder_init',
            uiOptions : {
            // toolbar configuration
            toolbar : [
            ['back', 'forward'],
            ['mkdir', 'mkfile', 'upload'],
            ['open', 'download', 'getfile'],
            ['info'],
            ['quicklook'],
            ['copy', 'cut', 'paste'],
            ['rm'],
            ['duplicate', 'rename', 'edit', 'resize'],
            ['extract', 'archive'],
            ['search'],
            ['view'],
            ]
        },
            getFileCallback: function(file) { // editor callback
              // file.url - commandsOptions.getfile.onlyURL = false (default)
              // file     - commandsOptions.getfile.onlyURL = true
              FileBrowserDialogue.mySubmit(file); // pass selected file path to TinyMCE
          }
      }).elfinder('instance');
    });
</script>
</head>
<body>
    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>
</body>
</html>
