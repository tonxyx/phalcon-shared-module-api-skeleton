
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="previous pull-left">
        <?= $this->tag->linkTo(['admin/users', '&larr; Go Back']) ?>
    </li>
    <li class="pull-right">
        <?= $this->tag->submitButton(['Save', 'class' => 'btn btn-big btn-success']) ?>
    </li>
</ul>

<?= $this->getContent() ?>

<div class="center scaffold">
    <h2>Edit users</h2>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Basic</a></li>
        <li><a href="#B" data-toggle="tab">Successful Logins</a></li>
        <li><a href="#C" data-toggle="tab">Password Changes</a></li>
        <li><a href="#D" data-toggle="tab">Reset Passwords</a></li>
    </ul>

<div class="tabbable">
    <div class="tab-content">
        <div class="tab-pane active" id="A">

            <?= $form->render('id') ?>

            <div class="span4">

                <div class="clearfix">
                    <label for="name">Name</label>
                    <?= $form->render('name') ?>
                </div>

                <div class="clearfix">
                    <label for="profilesId">Profile</label>
                    <?= $form->render('profilesId') ?>
                </div>

                <div class="clearfix">
                    <label for="suspended">Suspended?</label>
                    <?= $form->render('suspended') ?>
                </div>

            </div>

            <div class="span4">

                <div class="clearfix">
                    <label for="email">E-Mail</label>
                    <?= $form->render('email') ?>
                </div>

                <div class="clearfix">
                    <label for="banned">Banned?</label>
                    <?= $form->render('banned') ?>
                </div>

                <div class="clearfix">
                    <label for="active">Confirmed?</label>
                    <?= $form->render('active') ?>
                </div>

            </div>
        </div>

        <div class="tab-pane" id="B">
            <p>
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $v110335837439034108361iterated = false; ?><?php foreach ($user->successLogins as $login) { ?><?php $v110335837439034108361iterated = true; ?>
                        <tr>
                            <td><?= $login->id ?></td>
                            <td><?= $login->ipAddress ?></td>
                            <td><?= $login->userAgent ?></td>
                        </tr>
                    <?php } if (!$v110335837439034108361iterated) { ?>
                        <tr><td colspan="3" align="center">User does not have successfull logins</td></tr>
                    <?php } ?>
                    </tbody>
                </table>
            </p>
        </div>

        <div class="tab-pane" id="C">
            <p>
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $v110335837439034108361iterated = false; ?><?php foreach ($user->passwordChanges as $change) { ?><?php $v110335837439034108361iterated = true; ?>
                        <tr>
                            <td><?= $change->id ?></td>
                            <td><?= $change->ipAddress ?></td>
                            <td><?= $change->userAgent ?></td>
                            <td><?= date('Y-m-d H:i:s', $change->createdAt) ?></td>
                        </tr>
                    <?php } if (!$v110335837439034108361iterated) { ?>
                        <tr><td colspan="3" align="center">User has not changed his/her password</td></tr>
                    <?php } ?>
                    </tbody>
                </table>
            </p>
        </div>

        <div class="tab-pane" id="D">
            <p>
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Reset?</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $v110335837439034108361iterated = false; ?><?php foreach ($user->resetPasswords as $reset) { ?><?php $v110335837439034108361iterated = true; ?>
                        <tr>
                            <th><?= $reset->id ?></th>
                            <th><?= date('Y-m-d H:i:s', $reset->createdAt) ?>
                            <th><?= ($reset->reset == true ? 'Yes' : 'No') ?>
                        </tr>
                    <?php } if (!$v110335837439034108361iterated) { ?>
                        <tr><td colspan="3" align="center">User has not requested reset his/her password</td></tr>
                    <?php } ?>
                    </tbody>
                </table>
            </p>
        </div>

    </div>
</div>

    </form>
</div>
