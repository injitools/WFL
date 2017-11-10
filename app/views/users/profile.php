<div class="row justify-content-md-center">
    <div class="col-md-9 col-lg-7 col-xl-6">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <?= $this->lang('users', 'Profile card'); ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <img src="/static/<?= $user->avatar ? 'avatars/' . $user->avatar : 'images/no-image.png'; ?>"
                             class="img-fluid"/>
                    </div>
                    <div class="col-8">
                        <table class="table">
                            <tr>
                                <td> <?= $this->lang('form', 'Full name'); ?></td>
                                <td><?= $user->name; ?></td>
                            </tr>
                            <tr>
                                <td> <?= $this->lang('form', 'Email'); ?></td>
                                <td><?= $user->email; ?></td>
                            </tr>
                            <tr>
                                <td> <?= $this->lang('form', 'Sex'); ?></td>
                                <td><?= $this->lang('form', [1 => 'Male', 2 => 'Female'][$user->sex]); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>