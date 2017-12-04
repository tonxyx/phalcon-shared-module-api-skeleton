<?= $this->getContent() ?>

<ul class="pager">
    <li class="previous pull-left">
        <?= $this->tag->linkTo(['admin/users/index', '&larr; Go Back']) ?>
    </li>
    <li class="pull-right">
        <?= $this->tag->linkTo(['admin/users/create', 'Create users', 'class' => 'btn btn-primary']) ?>
    </li>
</ul>

<?php $v166744263664009886121iterated = false; ?><?php $v166744263664009886121iterator = $page->items; $v166744263664009886121incr = 0; $v166744263664009886121loop = new stdClass(); $v166744263664009886121loop->self = &$v166744263664009886121loop; $v166744263664009886121loop->length = count($v166744263664009886121iterator); $v166744263664009886121loop->index = 1; $v166744263664009886121loop->index0 = 1; $v166744263664009886121loop->revindex = $v166744263664009886121loop->length; $v166744263664009886121loop->revindex0 = $v166744263664009886121loop->length - 1; ?><?php foreach ($v166744263664009886121iterator as $user) { ?><?php $v166744263664009886121loop->first = ($v166744263664009886121incr == 0); $v166744263664009886121loop->index = $v166744263664009886121incr + 1; $v166744263664009886121loop->index0 = $v166744263664009886121incr; $v166744263664009886121loop->revindex = $v166744263664009886121loop->length - $v166744263664009886121incr; $v166744263664009886121loop->revindex0 = $v166744263664009886121loop->length - ($v166744263664009886121incr + 1); $v166744263664009886121loop->last = ($v166744263664009886121incr == ($v166744263664009886121loop->length - 1)); ?><?php $v166744263664009886121iterated = true; ?>
<?php if ($v166744263664009886121loop->first) { ?>
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Profile</th>
            <th>Banned?</th>
            <th>Suspended?</th>
            <th>Confirmed?</th>
        </tr>
    </thead>
<?php } ?>
    <tbody>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->name ?></td>
            <td><?= $user->email ?></td>
            <td><?= $user->profile->name ?></td>
            <td><?= ($user->banned == true ? 'Yes' : 'No') ?></td>
            <td><?= ($user->suspended == true ? 'Yes' : 'No') ?></td>
            <td><?= ($user->active == true ? 'Yes' : 'No') ?></td>
            <td width="12%"><?= $this->tag->linkTo(['admin/users/edit/' . $user->id, '<i class="icon-pencil"></i> Edit', 'class' => 'btn']) ?></td>
            <td width="12%"><?= $this->tag->linkTo(['admin/users/delete/' . $user->id, '<i class="icon-remove"></i> Delete', 'class' => 'btn']) ?></td>
        </tr>
    </tbody>
<?php if ($v166744263664009886121loop->last) { ?>
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    <?= $this->tag->linkTo(['admin/users/search', '<i class="icon-fast-backward"></i> First', 'class' => 'btn']) ?>
                    <?= $this->tag->linkTo(['admin/users/search?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn ']) ?>
                    <?= $this->tag->linkTo(['admin/users/search?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn']) ?>
                    <?= $this->tag->linkTo(['admin/users/search?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn']) ?>
                    <span class="help-inline"><?= $page->current ?>/<?= $page->total_pages ?></span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
<?php } ?>
<?php $v166744263664009886121incr++; } if (!$v166744263664009886121iterated) { ?>
    No users are recorded
<?php } ?>
