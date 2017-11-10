<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">WFL</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php
            if (empty($_SESSION['user_id'])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->href('/login'); ?>"><?= $this->lang('users', 'Login'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="<?= $this->href('/signup'); ?>"><?= $this->lang('users', 'Sign Up'); ?></a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->href('/logout'); ?>"><?= $this->lang('users', 'Logout'); ?></a>
                </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownLangSelect"
                   data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false"><?= App::$cur->i18n->lang; ?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLangSelect">
                    <?php
                    foreach (App::$cur->i18n->langs as $langCode => $langName) {
                        $newUrl = preg_replace("!^/" . (App::$cur->i18n->lang) . "!", '/' . $langCode, App::$cur->request->getUrl());
                        ?>
                        <a class="dropdown-item" href="<?= $newUrl; ?>"><?= $langName; ?> (<?= $langCode; ?>)</a>
                        <?php
                    }
                    ?>
                </div>
            </li>
        </ul>
    </div>
</nav>