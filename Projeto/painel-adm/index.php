<?php
//SESSÃO
@session_start();

//requisição de conexão
require_once('../conexao.php');

//PERMISSÃO
require_once('verificar-permissao.php');

//MENU ADMINISTRATIVO
$menu1 = 'home';
$menu2 = 'usuarios';
$menu3 = 'fornecedores';
$menu4 = 'categorias';

//RECUPERAR DADOS DO USSUARIO
$query = $pdo->query("SELECT * from tbl_usuario WHERE id = '$_SESSION[id_usuario]'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = $res[0]['nome'];
$email_usu = $res[0]['email'];
$senha_usu = $res[0]['senha'];
$nivel_usu = $res[0]['nivel'];
$cpf_usu = $res[0]['cpf'];
$id_usu = $res[0]['id'];

?>

<!DOCTYPE html>
<html>

<head>
  <title>Painel Administrativo</title>

  <!-- BOOTSTRAP, DATATABLE E JQUERY -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="../vendor/DataTable/datatables.min.css" />

  <script type="text/javascript" src="../vendor/DataTable/datatables.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <link rel="shortcut icon" href="../img/favcon2.ico" />

</head>

<body>

  <!-- MENU DE NAVEGAÇÃO -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="../img/logo2.png" width="100">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php?pagina=<?php echo $menu1 ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=<?php echo $menu2 ?>">Usuários</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=<?php echo $menu3 ?>">Fornecedores</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Produtos
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Cadastro de Produtos</a></li>
              <li><a class="dropdown-item" href="index.php?pagina=<?php echo $menu4 ?>">Cadastro de Categorias</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>

        </ul>

        <!-- ICONE DE USUARIO -->
        <div class="d-flex mx-3">
          <img src="../img/icone-user.png" width="40px" height="40px">
          <!-- DROPDOWN DO MENU DE USUARIO -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo $nome_usu ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                  <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#modalPerfil">Editar Perfil</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="../logout.php">Sair</a></li>

                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- DIRECIONAMENTO PARA AS PAGINAS -->
  <div class="container-fluid mt-2 mx-3">
    <?php

    if (@$_GET['pagina'] == $menu1) {
      require_once($menu1 . '.php');
    } else if (@$_GET['pagina'] == $menu2) {
      require_once($menu2 . '.php');
    } else if (@$_GET['pagina'] == $menu3) {
      require_once($menu3 . '.php');
    } else if (@$_GET['pagina'] == $menu4) {
      require_once($menu4 . '.php');
    } else {
      require_once($menu1 . '.php');
    }

    ?>
  </div>

</body>

</html>

<!-- MODAL DE EDIÇÃO DE SENHA -->
<div class="modal fade" tabindex="-1" id="modalPerfil">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"> Mudar Senha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!--FORMULARIO DE EDIÇÃO DE SENHA -->
      <form method="POST" id="form-perfil">

        <div class="modal-body">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Senha</label>
            <input type="text" class="form-control" id="senha-perfil" name="senha-perfil" placeholder="Senha" required="" value="<?php echo @$senha_usu ?>">
          </div>
          <small>
            <div align="center" class="mt-1" id="mensagem">

            </div>
          </small>
        </div>

        <div class="modal-footer">
          <button type="button" id="btn-fechar-perfil" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-salvar-perfil" id="btn-salvar-perfil" type="submit" class="btn btn-primary">Salvar</button>

          <!-- BLOCO OCULTO DO ID PARA A EDIÇÃO -->
          <input name="id-perfil" type="hidden" value="<?php echo @$id_usu ?>">
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MASCARAS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script type="text/javascript" src="../vendor/js/mascaras.js"></script>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM E MUDANÇA DE SENHA -->
<script type="text/javascript">
  $("#form-perfil").submit(function() {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: "editar-perfil.php",
      type: 'POST',
      data: formData,

      success: function(mensagem) {

        $('#mensagem-perfil').removeClass()

        if (mensagem.trim() == "Salvo com Sucesso!") {

          //$('#nome').val('');
          //$('#cpf').val('');
          $('#btn-fechar-perfil').click();
          //window.location = "index.php?pagina="+pag;

        } else {

          $('#mensagem-perfil').addClass('text-danger')
        }

        $('#mensagem-perfil').text(mensagem)

      },

      cache: false,
      contentType: false,
      processData: false,
      xhr: function() { // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
          myXhr.upload.addEventListener('progress', function() {
            /* faz alguma coisa durante o progresso do upload */
          }, false);
        }
        return myXhr;
      }
    });
  });
</script>