
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="previous pull-left">
        <?= $this->tag->linkTo(['admin/profiles', '&larr; Go Back']) ?>
    </li>
    <li class="pull-right">
        <?= $this->tag->submitButton(['Save', 'class' => 'btn btn-success']) ?>
    </li>
</ul>

<?= $this->getContent() ?>

<div class="center scaffold">

    <h2>Edit profile</h2>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Basic</a></li>
        <li><a href="#B" data-toggle="tab">Users</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">

                <?= $form->render('id') ?>

                <div class="clearfix">
                    <label for="name">Name</label>
                    <?= $form->render('name') ?>
                </div>

                <div class="clearfix">
                    <label for="active">Active?</label>
                    <?= $form->render('active') ?>
                </div>

            </div>

            <div class="tab-pane" id="B">
                <p>
                    <table class="table table-bordered table-striped" align="center">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Banned?</th>
                                <th>Suspended?</th>
                                <th>Active?</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $v150747351984507207741iterated = false; ?><?php foreach ($profile->users as $user) { ?><?php $v150747351984507207741iterated = true; ?>
                            <tr>
                                <td><?= $user->id ?></td>
                                <td><?= $user->name ?></td>
                                <td><?= ($user->banned == true ? 'Yes' : 'No') ?></td>
                                <td><?= ($user->suspended == true ? 'Yes' : 'No') ?></td>
                                <td><?= ($user->active == true ? 'Yes' : 'No') ?></td>
                                <td width="12%"><?= $this->tag->linkTo(['admin/users/edit/' . $user->id, '<i class="icon-pencil"></i> Edit', 'class' => 'btn']) ?></td>
                                <td width="12%"><?= $this->tag->linkTo(['admin/users/delete/' . $user->id, '<i class="icon-remove"></i> Delete', 'class' => 'btn']) ?></td>
                            </tr>
                        <?php } if (!$v150747351984507207741iterated) { ?>
                            <tr><td colspan="3" align="center">There are no users assigned to this profile</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </p>
            </div>

        </div>
    </div>

    </form>
</div>
