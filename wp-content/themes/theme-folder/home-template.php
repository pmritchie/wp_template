<?php /* Template Name: Home Page */ ?>

<?php get_header(); ?>

<div class="modal fade"
  id="homePageVideoModal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="homePageVideoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog"
    role="document">
    <button type="button"
      class="close"
      data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-content">
      <div class="modal-body">
        <div class="video-wrapper embed-responsive embed-responsive-16by9">

        </div>
      </div>
    </div>
  </div>
</div>
<!--Hero-->
<section class="section hero-section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="hero-content">
          <h1>Title</h1>
          <h3>Sub title</h3>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Hero-->

<?php get_footer(); ?>
