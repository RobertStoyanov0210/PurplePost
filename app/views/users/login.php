<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <?php flash('register_success') ?>
      <?php flash('unknown_user') ?>
      <h2>Login</h2>
      <p>Fill the field to login</p>
      <form action="<?php echo URLROOT ?>/users/login" method="post">
        <div class="form-group">
          <label for="email">Email: </label>
          <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['email'] ?>">
          <span class="span invalid-feedback"><?php echo $data['email_err'] ?></span>
        </div>
        <div class="form-group">
          <label for="password">Password: </label>
          <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['password'] ?>">
          <span class="span invalid-feedback"><?php echo $data['password_err'] ?></span>
        </div>
        <div class="row">
          <div class="col">
            <input type="submit" value="Login" class="btn btn-success btn-block">
          </div>
          <div class="col">
            <a href="<?php echo URLROOT ?>/users/register" class="btn btn-light btn-block">Don't have an account?</a>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>