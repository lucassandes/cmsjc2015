<!DOCTYPE html><html lang="en"><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1">    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->    <title>Bootstrap 101 Template</title>    <!-- Bootstrap -->    <link href="css/bootstrap.min.css" rel="stylesheet">    <link href="css/starter-template.css" rel="stylesheet">    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->    <!--[if lt IE 9]>    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>    <![endif]--></head><body><nav class="navbar navbar-inverse navbar-fixed-top">    <div class="container">        <div class="navbar-header">            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"                    aria-expanded="false" aria-controls="navbar">                <span class="sr-only">Toggle navigation</span>                <span class="icon-bar"></span>                <span class="icon-bar"></span>                <span class="icon-bar"></span>            </button>            <a class="navbar-brand" href="index.php">Adm Solicitações</a>        </div>        <div id="navbar" class="collapse navbar-collapse">            <ul class="nav navbar-nav">                <li class="active"><a href="#">Solicitações em aberto</a></li>                <li><a href="#about">Solicitações Conluidas</a></li>                <!--<li><a href="#contact">Contact</a></li>-->            </ul>        </div>        <!--/.nav-collapse -->    </div></nav><?phpinclude_once("../connect.php");$id_solicitacao = $_GET["id_solicitacao"];echo $id_solicitacao;?><div class="container">    <h1>Editar solicitação</h1>    <h3>Solicitação</h3>    <table class="table table-striped table-hover">        <thead>        <tr>            <th>#</th>            <th>Protocolo</th>            <th>Assunto</th>            <th>Status Atual</th>            <th>Descrição Status</th>        </tr>        </thead>        <tbody>        <?php        //$sql = "SELECT * FROM solicitacao INNER JOIN solicitante ON solicitacao.solicitante=solicitante.id INNER JOIN historico_solicitacao ON solicitacao.id = historico_solicitacao.id_solicitacao";        $sql = "SELECT * FROM solicitacao WHERE id=$id_solicitacao";        $result = $conn->query($sql);        if ($result->num_rows > 0) {        // output data of each row        while ($row = $result->fetch_assoc()) {        $solicitante = $row["solicitante"];        ?>        <tr>            <th scope="row"><?php echo $row["id"] ?></th>            <td><?php echo $row["protocolo"] ?></td>            <td><?php echo $row["assunto"] ?></td>            <?php            // PEGA STATUS            $sql_log = 'SELECT status, descricao FROM historico_solicitacao WHERE id_solicitacao = ' . $row["id"] . ' ORDER BY id DESC LIMIT 1';            $result_log = $conn->query($sql_log);            if ($result_log->num_rows > 0) {                while ($row_status = $result_log->fetch_assoc()) {                    echo ' <td>' . $row_status["status"] . '</td>';                    echo ' <td>' . $row_status["descricao"] . '</td>';                }            } else {                echo '<td>Erro ao carregar status</td>';            }            ?>        </tr>        </tbody>    </table>    <p><strong>Descrição da Solicitação:</strong><br/> <?php echo $row["descricao"] ?></p>    <p><strong>Endereço da Solicitação:</strong><br/> <?php echo $row["endereco"] ?> <?php echo $row["bairro"] ?>.        CEP: <?php echo $row["cep"] ?></p>    <?php    }    }    ?>    <hr>    <h3>Solicitante</h3>    <?php    $sql_log = 'SELECT * FROM solicitante WHERE id = ' . $solicitante . '';    $result_log = $conn->query($sql_log);    if ($result_log->num_rows > 0) {        while ($row = $result_log->fetch_assoc()) {            if ($row["tipo"] == 0) { //pessoa física                ?>                <div class="row">                    <div class="col-md-6"><p><strong>Nome:</strong> <?php echo $row["nome"]; ?> </p></div>                    <div class="col-md-6"><p><strong>CPF:</strong> <?php echo $row["cpf"]; ?> </p></div>                </div>            <?php            } else {                ?>                <div class="row">                    <div class="col-md-6"><p><strong>Nome do Contato:</strong> <?php echo $row["nome_contato"]; ?>                        </p></div>                    <div class="col-md-3"><p><strong>CNPJ:</strong> <?php echo $row["cnpj"]; ?> </p></div>                    <div class="col-md-3"><p><strong>Inscrição                                estadual:</strong> <?php echo $row["inscricao_estadual"]; ?> </p></div>                </div>            <?php            } //end else            ?>            <p><strong>Endereço:</strong><br/> <?php echo $row["endereco"] ?> <?php echo $row["bairro"] ?>. <br/>                <?php echo $row["cidade"] ?> - <?php echo $row["estado"] ?><br/>                CEP: <?php echo $row["cep"] ?></p>            <h4>Contato:</h4>            <table class="table table-striped table-hover">                <thead>                <tr>                    <th>Residencial</th>                    <th>Celular</th>                    <th>Comercial</th>                    <th>Email</th>                </tr>                </thead>                <tbody>                <tr>                    <td><?php echo ($row["tel_residencial"]) ? $row["tel_residencial"] : "Não fornecido"; ?></td>                    <td><?php echo ($row["celular"]) ? $row["celular"] : "Não fornecido"; ?></td>                    <td><?php echo ($row["tel_comercial"]) ? $row["tel_comercial"] : "Não fornecido"; ?></td>                    <td><a href="mailto:<?php echo $row["email"] ?>"><?php echo $row["email"] ?></a></td>                </tr>                </tbody>            </table>        <?php        }    } else {        echo '<td>Erro ao carregar Histórico</td>';    }    ?>    <div class="clearfix"></div>    <hr>    <h3>Histórico</h3>    <table class="table table-striped table-hover">        <thead>        <tr>            <th>Data</th>            <th>Status</th>            <th>Descrição</th>        </tr>        </thead>        <tbody>        <?php        $sql_log = 'SELECT * FROM historico_solicitacao WHERE id_solicitacao = ' . $id_solicitacao . ' ORDER BY id ';        $result_log = $conn->query($sql_log);        if ($result_log->num_rows > 0) {            while ($row_status = $result_log->fetch_assoc()) {                ?>                <tr>                    <td><?php echo $row_status["time_stamp"] ?></td>                    <td><?php echo $row_status["status"] ?></td>                    <td><?php echo $row_status["descricao"] ?></td>                </tr>            <?php            }        } else {            echo '<td>Erro ao carregar Histórico</td>';        }        ?>        </tbody>    </table></div><?phpinclude_once("../connect_close.php");?><!-- jQuery (necessary for Bootstrap's JavaScript plugins) --><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><!-- Include all compiled plugins (below), or include individual files as needed --><script src="js/bootstrap.min.js"></script></body></html>