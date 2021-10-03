<?php if (!isset($_GET["f"]) || $_GET["f"] != "confirm") {
?>
  <div class="container" style="margin-top: 20px; margin-bottom:20px">
    <div class="content" style="max-width: 500px; margin: auto">
      <div class="card mx-auto mt-3" style="text-align: center">
        <div class="card-header">
          <h3>Password dimenticata</h3>
          <p>Inserisci la tua email per ricevere una nuova password</p>
        </div>
        <div class="card-body card-login">
          <form action="actions.php?a=forget" method="post" name="myform" id="myform">
            <div class="form-group">
              <label for="email">Email</label>
              <input class="form-control" type="text" name="email" id="email">
            </div>
            <input class="btn btn-block" name="Login" type="submit" value="Conferma" />
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
          } ?>
          <hr>
          <a href="./">Torna alla login.</a>
        </div>
      </div>
    </div>
  </div>
  <script>
    $("#myform").validate({
      rules: {
        email: {
          required: true,
          email: true
        }
      }
    });
  </script>
<?php
} else {
?>
  <div class="container" style="margin-top: 50px; margin-bottom:50px">
    <div class="content" style="max-width: 500px; margin: auto">
      <div class="card mx-auto mt-5" style="text-align: center">
        <div class="card-header">
          <h3>Password resettata con successo! </h3>
        </div>
        <div class="card-body card-login">
          <br>
          <p>Verifica la tua mail e torna alla <a href="./">schermata di accesso!</a></p>
        </div>
      </div>
    </div>
  </div>
<?php
} ?>