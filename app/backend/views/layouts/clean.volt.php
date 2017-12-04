<div class="navbar">
  <div class="navbar-inner">
    <div class="container" style="width: auto;">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <?= $this->tag->linkTo([null, 'class' => 'brand', 'PSMAS']) ?>
    </div>
  </div><!-- /navbar-inner -->
</div>

<div class="container main-container">

  <?= $this->flash->output() ?>
  <?= $this->flashSession->output() ?>
  
  <?= $this->getContent() ?>
</div>

<footer>
Made with love by the Phalcon Team

    <?= $this->tag->linkTo(['privacy', 'Privacy Policy']) ?>
    <?= $this->tag->linkTo(['terms', 'Terms']) ?>

© <?= date('Y') ?> Phalcon Team.
</footer>
