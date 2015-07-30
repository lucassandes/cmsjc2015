<?php
/**
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>
       <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/login.css" rel="stylesheet">

        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>


        <div class="container">
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger" role="alert"><p class="error">Erro ao efetuar Login</p></div>';
            }
            ?>
            <form class="form-signin"  action="includes/process_login.php" method="post" name="login_form">
                <h2 class="form-signin-heading">Por favor, faça login</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="email@dominio.com"  name="email" required autofocus>
                <label for="inputPassword" class="sr-only">Senha</label>
                <input type="password"  id="password" name="password"  class="form-control" placeholder="Password" required>
                <input type="button"
                       value="Login"
                       class="btn btn-lg btn-primary btn-block"
                       onclick="formhash(this.form, this.form.password);" />
                <!--<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>-->
            </form>

        </div> <!-- /container -->

    </body>
</html>
