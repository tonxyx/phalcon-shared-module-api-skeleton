<?= $this->getContent() ?>

<ul class="pager">
    <li class="previous pull-left">
        <?= $this->tag->linkTo(['admin/profiles/index', '&larr; Go Back']) ?>
    </li>
    <li class="pull-right">
        <?= $this->tag->linkTo(['admin/profiles/create', 'Create profiles', 'class' => 'btn btn-primary']) ?>
    </li>
</ul>

<?php $v179398987886934506781iterated = false; ?><?php $v179398987886934506781iterator = $page->items; $v179398987886934506781incr = 0; $v179398987886934506781loop = new stdClass(); $v179398987886934506781loop->self = &$v179398987886934506781loop; $v179398987886934506781loop->length = count($v179398987886934506781iterator); $v179398987886934506781loop->index = 1; $v179398987886934506781loop->index0 = 1; $v179398987886934506781loop->revindex = $v179398987886934506781loop->length; $v179398987886934506781loop->revindex0 = $v179398987886934506781loop->length - 1; ?><?php foreach ($v179398987886934506781iterator as $profile) { ?><?php $v179398987886934506781loop->first = ($v179398987886934506781incr == 0); $v179398987886934506781loop->index = $v179398987886934506781incr + 1; $v179398987886934506781loop->index0 = $v179398987886934506781incr; $v179398987886934506781loop->revindex = $v179398987886934506781loop->length - $v179398987886934506781incr; $v179398987886934506781loop->revindex0 = $v179398987886934506781loop->length - ($v179398987886934506781incr + 1); $v179398987886934506781loop->last = ($v179398987886934506781incr == ($v179398987886934506781loop->length - 1)); ?><?php $v179398987886934506781iterated = true; ?>
<?php if ($v179398987886934506781loop->first) { ?>
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Active?</th>
        </tr>
    </thead>
<?php } ?>
    <tbody>
        <tr>
            <td><?= $profile->id ?></td>
            <td><?= $profile->name ?></td>
            <td><?= ($profile->active == true ? 'Yes' : 'No') ?></td>
            <td width="12%"><?= $this->tag->linkTo(['admin/profiles/edit/' . $profile->id, '<i class="icon-pencil"></i> Edit', 'class' => 'btn']) ?></td>
            <td width="12%"><?= $this->tag->linkTo(['admin/profiles/delete/' . $profile->id, '<i class="icon-remove"></i> Delete', 'class' => 'btn']) ?></td>
        </tr>
    </tbody>
<?php if ($v179398987886934506781loop->last) { ?>
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    <?= $this->tag->linkTo(['admin/profiles/search', '<i class="icon-fast-backward"></i> First', 'class' => 'btn']) ?>
                    <?= $this->tag->linkTo(['admin/profiles/search?page=' . $page->before, '<i class="icon-step-backward"></i> Previous', 'class' => 'btn ']) ?>
                    <?= $this->tag->linkTo(['admin/profiles/search?page=' . $page->next, '<i class="icon-step-forward"></i> Next', 'class' => 'btn']) ?>
                    <?= $this->tag->linkTo(['admin/profiles/search?page=' . $page->last, '<i class="icon-fast-forward"></i> Last', 'class' => 'btn']) ?>
                    <span class="help-inline"><?= $page->current ?>/<?= $page->total_pages ?></span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
<?php } ?>
<?php $v179398987886934506781incr++; } if (!$v179398987886934506781iterated) { ?>
    No profiles are recorded
<?php } ?>
