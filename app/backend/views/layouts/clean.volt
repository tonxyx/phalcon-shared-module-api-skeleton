<div class="navbar">
  <div class="navbar-inner">
    <div class="container" style="width: auto;">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      {{ link_to(null, 'class': 'brand', 'PSMAS')}}
    </div>
  </div><!-- /navbar-inner -->
</div>

<div class="container main-container">

  {{ flash.output() }}
  {{ flashSession.output() }}
  
  {{ content() }}
</div>

<footer>
Made with love by the Phalcon Team

    {{ link_to("privacy", "Privacy Policy") }}
    {{ link_to("terms", "Terms") }}

© {{ date("Y") }} Phalcon Team.
</footer>
