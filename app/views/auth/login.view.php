<div class="container" style="margin-top: 20px; margin-bottom:20px;">
  <div class="content" style="max-width: 500px; margin: auto">
    <div class="card mx-auto mt-5" style="text-align: center">
      <div class="card-header">
        <h3>Accesso CDC</h3>
        <p>Accedi all'area riservata del Centro Diagnostico</p>
      </div>
      <div class="card-body card-login">
        <form action="actions.php?a=login" method="post" name="myform" id="myform">
          <div class="form-group">
            <label for="login">Login</label>
            <input class="form-control" type="text" autocomplete="username" placeholder="utente" id="username" name="username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" autocomplete="current-password" id="password" name="password">
          </div>
          <input class="btn btn-block" name="Login" type="submit" value="Accedi" />
        </form>
        <?php if (hasMessage()) {
        ?>
          <br />
          <div class="panel panel-<?= getMessagePanel(); ?>">
            <div class="panel-heading">
              <?= getMessage() ?>
            </div>
          </div>
        <?php
          clearMessage();
        }
        unset($_SESSION["id"]); ?>
        <hr>
        <a href="?v=forgot">Password dimenticata? Clicca qui.</a>
      </div>
    </div>
  </div>
</div>
<script>
  $("#myform").validate({
    rules: {
      username: "required",
      password: "required"
    }
  });
</script>