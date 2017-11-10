<div class="row justify-content-md-center">
    <div class="col-md-9 col-lg-7 col-xl-6">
        <form class="ajaxForm" method="post" novalidate>
            <?php $this->widget('form/inputs', compact('form')); ?>
            <button type="submit" class="btn btn-primary btn-block"><?= $this->lang('users', 'Login'); ?></button>
        </form>
    </div>
</div>