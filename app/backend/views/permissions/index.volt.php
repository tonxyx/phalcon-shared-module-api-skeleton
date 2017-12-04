
<?= $this->getContent() ?>

<form method="post">

<h2>Manage Permissions</h2>

<div class="well" align="center">

	<table class="perms">
		<tr>
			<td><label for="profileId">Profile</label></td>
			<td><?= $this->tag->select(['profileId', $profiles, 'using' => ['id', 'name'], 'useEmpty' => true, 'emptyText' => '...', 'emptyValue' => '']) ?></td>
			<td><?= $this->tag->submitButton(['Search', 'class' => 'btn btn-primary', 'name' => 'search']) ?></td>
		</tr>
	</table>

</div>

<?php if ($this->request->isPost() && $profile) { ?>

<?php foreach ($this->acl->getResources() as $module => $actionsCollection) { ?>

	<h3><?= $module ?></h3>

	<table class="table table-bordered table-striped" align="center">
		<thead>
			<tr>
				<th width="5%"></th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($actionsCollection as $controller => $actions) { ?>
  			<?php if (gettype($actions) === ('array')) { ?>
          <?php foreach ($actions as $action) { ?>
            <tr>
              <td align="center">
                <input type="checkbox" name="permissions[]"
                value="<?= $module . '_' . $controller . '.' . $action ?>"
                <?php if (isset($permissions[$module . '_' . $controller . '.' . $action])) { ?>
                  checked="checked"
                <?php } ?>>
              </td>
              <td>
                <?= $module . ' -> ' . $controller . ' -> ' . $action ?>
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
			<?php } ?>
		</tbody>
	</table>

<?php } ?>

<?= $this->tag->submitButton(['Submit', 'class' => 'btn btn-primary', 'name' => 'submit']) ?>

<?php } ?>

</form>
