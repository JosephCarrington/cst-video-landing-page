<html>
<head>
  <?php wp_head(); ?>
  <title> <?php wp_title('', true,''); ?> </title>
</head>
<body <?php body_class(); ?>>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="<?php bloginfo('siteurl'); ?>"><?php bloginfo('title'); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuLandingPage" aria-controls="menuLandingPage" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="menuLandingPage">
      <?php wp_nav_menu( array(
        'theme_location' => 'landing-page-menu',
        'menu_class' => 'navbar-nav mr-auto',
        'walker' => new T5_Nav_Menu_Walker_Simple()
      )); ?>
    </div>
  </nav>
  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <?php $button_text = get_post_meta(get_the_ID(), 'wpcf-secondary-button-text', true); ?>
    <div class="jumbotron">
      <div class="container">
        <div class="row">
          <div class="col title">
            <h1><?php the_title(); ?></h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="embed-responsive embed-responsive-16by9">
              <?php echo(apply_filters('the_content', get_post_meta(get_the_ID(), 'wpcf-primary-content', true))); ?>
            </div>
          </div>
          <div class="col-lg-4">
            <?php echo(apply_filters('the_content', get_post_meta(get_the_ID(), 'wpcf-secondary-content', true))); ?>
          </div>
        </div>
      </div>
    </div>
    <?php echo(apply_filters('the_content', get_post_meta(get_the_ID(), 'wpcf-tertiary-content', true))); ?>
  <?php endwhile; endif; ?>
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col">
          <p>&copy; <?php echo(date('Y')); ?> Karen George</p>
        </div>
      </div>
    </div>
  </div>
  <?php wp_footer(); ?>
</body>
