<?= $this->getContent() ?>

<div align="center" class="well">

	<?= $this->tag->form(['class' => 'form-search']) ?>

	<div align="left">
		<h2>Log In</h2>
	</div>

		<?= $form->render('email') ?>
		<?= $form->render('password') ?>
		<?= $form->render('go') ?>

		<div align="center" class="remember">
			<?= $form->render('remember') ?>
			<?= $form->label('remember') ?>
		</div>

		<?= $form->render('csrf', ['value' => $this->security->getToken()]) ?>

		<hr>

		<div class="forgot">
			<?= $this->tag->linkTo(['admin/session/forgotPassword', 'Forgot my password']) ?>
		</div>

	</form>

</div>
