<?= $this->getContent() ?>

<form method="post" autocomplete="off" action="<?= $this->url->get('admin/users/changePassword') ?>">

    <div class="center scaffold">

        <h2>Change Password</h2>

        <div class="clearfix">
            <label for="password">Password</label>
            <?= $form->render('password') ?>
        </div>

        <div class="clearfix">
            <label for="confirmPassword">Confirm Password</label>
            <?= $form->render('confirmPassword') ?>
        </div>

        <div class="clearfix">
            <?= $this->tag->submitButton(['Change Password', 'class' => 'btn btn-primary']) ?>
        </div>

    </div>

</form>
