<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset=utf-8>
    <meta content="IE=edge" http-equiv=X-UA-Compatible>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name=viewport>
    <meta content="Description" name=description>
    <meta content="Reeder" name=author>
    <title>Content Editor</title>
    <base href="<php? echo $baseurl; ?>" />
    
    <!--bootstrap CDN-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!--custom css if available-->
    <link href="../assets/css/custom.css" rel="stylesheet">

    <!--web font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!--include tinymce-->
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#body-input',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | table',
            toolbar2: 'forecolor backcolor emoticons | codesample',
            height: "400",
            menubar: false,
            table_default_attributes: {
                class: 'table'
            },
            table_default_styles: {
                width: '100%'
            },
            table_appearance_options: false

        });
        tinymce.DOM.addClass('table', 'table');
        // tinymce.activeEditor.dom.addClass(tinymce.activeEditor.dom.select('table'), 'table');
    </script>

    <!--[if lt IE 9]><script src=../assets/js/ie8-responsive-file-warning.js></script><![endif]-->
    <!--[if lt IE 9]> <script src=https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js></script> <script src=https://oss.maxcdn.com/respond/1.4.2/respond.min.js></script> <![endif]-->
    
    <!--icons-->
    <!--<link href="/apple-touch-icon.png" rel="apple-touch-icon">-->
    <!--<link href="/favicon.ico" rel="icon">-->
</head>

<body>
    <!--bootstrap css test-->
    <div id="bootstrapCssTest" class="hidden"></div>