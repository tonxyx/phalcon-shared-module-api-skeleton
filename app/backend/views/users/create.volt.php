
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="previous pull-left">
        <?= $this->tag->linkTo(['admin/users', '&larr; Go Back']) ?>
    </li>
    <li class="pull-right">
        <?= $this->tag->submitButton(['Save', 'class' => 'btn btn-success']) ?>
    </li>
</ul>

<?= $this->getContent() ?>

<div class="center scaffold">
    <h2>Create a User</h2>

    <div class="clearfix">
        <label for="name">Name</label>
        <?= $form->render('name') ?>
    </div>

    <div class="clearfix">
        <label for="email">E-Mail</label>
        <?= $form->render('email') ?>
    </div>

    <div class="clearfix">
        <label for="profilesId">Profile</label>
        <?= $form->render('profilesId') ?>
    </div>

</div>

</form>
