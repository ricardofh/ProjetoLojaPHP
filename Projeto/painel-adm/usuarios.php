<?php
$pag = 'usuarios';
?>

<!-- BOOTSTRAP E JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<!-- BOTAO DE NOVO USUARIO -->
<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-secondary mt-2">Novo Usuário</a>


<!--MODAL -->
<div class="modal fade" tabindex="-1" id="modalCadastrar">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Inserir Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!--FORMULARIO DE CADASTRO -->
            <form method="POST" id="form">

                <div class="modal-body">

                    <!--NOME E CPF -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required="">
                            </div>
                        </div>
                    </div>

                    <!--DEMAIS DADOS-->
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Senha</label>
                        <input type="text" class="form-control" id="senha" name="senha" placeholder="Senha" required="">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nivel</label>
                        <select class="form-select mt-1" aria-label="Default select example" name="nivel" required=""> 
							
							<option <?php if(@$nivel_ed == 'Operador'){ ?> selected <?php } ?>  value="Operador">Operador</option>

							<option <?php if(@$nivel_ed == 'Administrador'){ ?> selected <?php } ?>  value="Administrador">Administrador</option>
							
							<option <?php if(@$nivel_ed == 'Tesoureiro'){ ?> selected <?php } ?>  value="Tesoureiro">Tesoureiro</option>
                        
                        </select>
                    </div>

                    <small>
                        <div align="center" class="mt-1" id="mensagem">

                        </div>
                    </small> 
                    
                </div>

                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- CHAMANDO A MODEL -->
<?php
if (@$_GET['funcao'] == "novo") { ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
            backdrop: 'static'
        })
        myModal.show();
    </script>
<?php } ?>

<!--AJAX PARA O FORMULARIO DE USUARIOS-->
<script type="text/javascript">
    $("#form").submit(function () {
        var pag = "<?=$pag?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    //window.location = "index.php?pag="+pag;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>

