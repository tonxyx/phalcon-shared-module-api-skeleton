<?= $this->getContent() ?>

<div align="center" class="well">

	<?= $this->tag->form(['class' => 'form-search']) ?>

	<div align="left">
		<h2>Forgot Password?</h2>
	</div>

		<?= $form->render('email') ?>
		<?= $form->render('Send') ?>

		<hr>

	</form>

</div>