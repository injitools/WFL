<div class="row justify-content-md-center">
    <div class="col-md-9 col-lg-7 col-xl-6">
        <form class="ajaxForm" method="post" enctype="multipart/form-data" novalidate>
            <?php $this->widget('form/inputs', compact('form')); ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"><?= $this->lang('users', 'Sign Up'); ?></button>
            </div>
        </form>
    </div>
</div>