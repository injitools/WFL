<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $this->title; ?></title>

    <link href="/static/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/stylesheet.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php
    $this->widget('navbar');
    if (!empty($_SESSION['_msgs'])) {
        foreach ($_SESSION['_msgs'] as $msg) {
            ?>
            <div class="alert alert-<?= $msg['status']; ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $msg['text']; ?>
            </div>
            <?php
        }
        $_SESSION['_msgs'] = [];
    }
    $this->content();
    ?>
</div>
<script type="text/javascript" src="/static/libs/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/static/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  window.i18n = {
    validator:<?=json_encode(App::$cur->i18n->loadGroup('validator'));?>
  };
</script>
<script type="text/javascript" src="/static/js/script.js"></script>
</body>
</html>