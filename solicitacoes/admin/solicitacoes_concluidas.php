<!DOCTYPE html><html lang="en"><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1">    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->    <title>Bootstrap 101 Template</title>    <!-- Bootstrap -->    <link href="css/bootstrap.min.css" rel="stylesheet">    <link href="css/starter-template.css" rel="stylesheet">    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->    <!--[if lt IE 9]>    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>    <![endif]--></head><body><nav class="navbar navbar-inverse navbar-fixed-top">    <div class="container">        <div class="navbar-header">            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"                    aria-expanded="false" aria-controls="navbar">                <span class="sr-only">Toggle navigation</span>                <span class="icon-bar"></span>                <span class="icon-bar"></span>                <span class="icon-bar"></span>            </button>            <a class="navbar-brand" href="index.php">Adm Solicitações</a>        </div>        <div id="navbar" class="collapse navbar-collapse">            <ul class="nav navbar-nav">                <li><a href="index.php">Solicitações em aberto</a></li>                <li  class="active"><a href="solicitacoes_concluidas.php">Solicitações Conluidas</a></li>                <!--<li><a href="#contact">Contact</a></li>-->            </ul>        </div>        <!--/.nav-collapse -->    </div></nav><?phpinclude_once("../connect.php");?><div class="container">    <h1>Administração solicitação</h1>    <table class="table table-striped table-hover">        <thead>        <tr>            <th>#</th>            <th>Protocolo</th>            <th>Assunto</th>            <th>Solicitante</th>            <th>E-mail</th>            <th>Status</th>            <th>Editar</th>        </tr>        </thead>        <tbody>        <?php        //$sql = "SELECT * FROM solicitacao INNER JOIN solicitante ON solicitacao.solicitante=solicitante.id INNER JOIN historico_solicitacao ON solicitacao.id = historico_solicitacao.id_solicitacao";        // $sql = "SELECT * FROM solicitacao INNER JOIN solicitante ON solicitacao.solicitante=solicitante.id ";        $sql = "select s.*, st.*, (select statusfrom historico_solicitacao hs where hs.id_solicitacao = s.id  order by hs.id desc limit 1) as historicofrom solicitacao sjoin solicitante st on s.solicitante = st.id";        $result = $conn->query($sql);        if ($result->num_rows > 0) {// output data of each row            while ($row = $result->fetch_assoc()) {                if (strcmp($row["historico"],"Atendimento Encerrado") == 0) {                    ?>                    <tr>                        <th scope="row"><?php echo $row["id"] ?></th>                        <td><?php echo $row["protocolo"] ?></td>                        <td><?php echo $row["assunto"] ?></td>                        <?php                        if ($row["tipo"] == 0) {                            ?>                            <td><?php echo $row["nome"] ?></td>                        <?php                        } else {                            ?>                            <td><?php echo $row["nome_contato"] ?></td>                        <?php } ?>                        <td><?php echo $row["email"] ?></td>                        <td><?php echo $row["historico"] ?></td>                        <?php                        // PEGA STATUS                        /*$sql_log = 'SELECT status FROM historico_solicitacao WHERE id_solicitacao = ' . $row["id"] . ' ORDER BY id DESC LIMIT 1';                        $result_log = $conn->query($sql_log);                        if ($result_log->num_rows > 0) {                            while ($row_status = $result_log->fetch_assoc()) {                                echo ' <td>' . $row_status["historico"] . '</td>';                            }                        } else {                            echo '<td>Erro ao carregar status</td>';                        }*/                        ?>                        <td><?php echo $row["assunto"] ?></td>                        <td>                            <form action="editar_solicitacao.php" method="get">                                <input type="hidden" name="id_solicitacao" value="<?php echo $row["id"]; ?>">                                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-edit"                                                                                    aria-hidden="true"></span> Editar                                </button>                            </form>                        </td>                    </tr>                <?php                }            }        }        ?>        </tbody>    </table></div><?phpinclude_once("../connect_close.php");?><!-- jQuery (necessary for Bootstrap's JavaScript plugins) --><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><!-- Include all compiled plugins (below), or include individual files as needed --><script src="js/bootstrap.min.js"></script></body></html>