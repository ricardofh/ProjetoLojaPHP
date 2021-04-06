<?php
$pag = 'usuarios';
@session_start();

require_once('../conexao.php');
require_once('verificar-permissao.php')
?>

<!-- BOTAO DE NOVO USUARIO -->
<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-primary mt-2">Novo Usuário</a>

<!-- DATATABLE -->
<div class="mt-4" style="margin-right:25px">

	<!-- SELECT NO BANCO DE DADOS -->
	<?php
	$query = $pdo->query("SELECT * from usuarios order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if ($total_reg > 0) {
	?>
		<small>
			<table id="example" class="table table-hover my-4" style="width:100%">
				<thead>
					<tr>
						<th>Nome</th>
						<th>CPF</th>
						<th>Email</th>
						<th>Nível</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>

					<?php
					for ($i = 0; $i < $total_reg; $i++) {
						foreach ($res[$i] as $key => $value) {
						}
					?>

						<tr>
							<td><?php echo $res[$i]['nome'] ?></td>
							<td><?php echo $res[$i]['cpf'] ?></td>
							<td><?php echo $res[$i]['email'] ?></td>
							<td><?php echo $res[$i]['nivel'] ?></td>
							<td>
								<!-- BOTAO DE EDIÇÃO -->
								<a href="index.php?pagina=<?php echo $pag ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro">
									<i class="bi bi-pencil-square text-primary"></i>
								</a>
								<!-- BOTAO DE EXCLUSÃO -->
								<a href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro">
									<i class="bi bi-x-square text-danger mx-1"></i>
								</a>
							</td>
						</tr>

					<?php } ?>

				</tbody>

			</table>
		</small>
	<?php } else {
		echo '<p>Não existem dados para serem exibidos!!';
	} ?>
</div>

<!-- BLOCO PARA SABER QUAL TITULO DE MODAL ABRIR -->
<?php
//BLOCO PARA EDITAR DADOS  
if (@$_GET['funcao'] == "editar") {
	$titulo_modal = 'Editar Registro';
	$query = $pdo->query("SELECT * from usuarios where id = '$_GET[id]'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if ($total_reg > 0) {
		$nome = $res[0]['nome'];
		$email = $res[0]['email'];
		$cpf = $res[0]['cpf'];
		$senha = $res[0]['senha'];
		$nivel = $res[0]['nivel'];
	}
	//BLOCO PARA INSERIR DADOS 
} else {
	$titulo_modal = 'Inserir Registro';
}
?>

<!--MODAL -->
<div class="modal fade" tabindex="-1" id="modalCadastrar" data-bs-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $titulo_modal ?></h5>
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
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required="" value="<?php echo @$nome ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">CPF</label>
								<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required="" value="<?php echo @$cpf ?>">
							</div>
						</div>
					</div>


					<!--DEMAIS DADOS-->
					<div class="mb-3">
						<label for="exampleFormControlInput1" class="form-label">Email</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required="" value="<?php echo @$email ?>">
					</div>

					<div id="div-pass">
					<div class="mb-3">
						<label for="exampleFormControlInput1" class="form-label">Senha</label>
						<input type="text" class="form-control" id="senha" name="senha" placeholder="Senha" required="" value="<?php echo @$senha ?>">
					</div>
					</div>

					<div class="mb-3">
						<label for="exampleFormControlInput1" class="form-label">Nível</label>
						<select class="form-select mt-1" aria-label="Default select example" name="nivel">

							<option <?php if (@$nivel == 'Operador') { ?> selected <?php } ?> value="Operador">Operador</option>

							<option <?php if (@$nivel == 'Administrador') { ?> selected <?php } ?> value="Administrador">Administrador</option>

							<option <?php if (@$nivel == 'Tesoureiro') { ?> selected <?php } ?> value="Tesoureiro">Tesoureiro</option>


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

					<!-- BLOCO OCULTO DO ID PARA A EDIÇÃO -->
					<input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

					<!-- BLOCO PARA EVITAR DUPLICIDADE DO CPF E EMAIL NA EDIÇÃO -->
					<input name="antigo" type="hidden" value="<?php echo @$cpf ?>">
					<input name="antigo2" type="hidden" value="<?php echo @$email ?>">

				</div>
			</form>
		</div>
	</div>
</div>

<!--MODAL EXCLUIR -->
<div class="modal fade" tabindex="-1" id="modalDeletar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $titulo_modal ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<!--FORMULARIO DE EXCLUSÃO -->
			<form method="POST" id="form-excluir">
				<div class="modal-body">

					<p>Deseja Realmente Excluir o Registro?</p>

					<small>
						<div align="center" class="mt-1" id="mensagem-excluir">

						</div>
					</small>

				</div>
				<div class="modal-footer">
					<button type="button" id="btn-fechar-excluir" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">DELETAR</button>

					<!-- BLOCO OCULTO DO ID PARA A EDIÇÃO -->
					<input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

				</div>
			</form>
		</div>
	</div>
</div>

<!-- CHAMANDO A MODEL CADASTRAR -->
<?php
if (@$_GET['funcao'] == "novo") { ?>
	<script type="text/javascript">
		var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
			backdrop: 'static'
		})
		myModal.show();
	</script>
<?php } ?>

<!-- CHAMANDO A MODAL EDITAR -->
<?php
if (@$_GET['funcao'] == "editar") { ?>
	<script type="text/javascript">
		
		//BLOCO PARA OCULTAR EXBIÇÃO DA SENHA NA MODAL DE EDIÇÃO
		if (senha != " ") {
			document.getElementById("div-pass").style.display = 'none';
		} else {
			document.getElementById("div-pass").style.display = 'block';
		}
		
		var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
			backdrop: 'static'
		})

		myModal.show();

		
	</script>
<?php } ?>

<!-- CHAMANDO A MODAL EXLUIR -->
<?php
if (@$_GET['funcao'] == "deletar") { ?>
	<script type="text/javascript">
		var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {

		})

		myModal.show();
	</script>
<?php } ?>

<!--AJAX PARA O FORMULARIO DE USUARIOS-->
<script type="text/javascript">
	$("#form").submit(function() {
		var pag = "<?= $pag ?>";
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: pag + "/inserir.php",
			type: 'POST',
			data: formData,

			success: function(mensagem) {

				$('#mensagem').removeClass()

				if (mensagem.trim() == "Salvo com Sucesso!") {

					//$('#nome').val('');
					//$('#cpf').val('');
					$('#btn-fechar').click();
					window.location = "index.php?pagina=" + pag;

				} else {

					$('#mensagem').addClass('text-danger')
				}

				$('#mensagem').text(mensagem)

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

<!--AJAX PARA O FORMULARIO DE EXCLUSÃO DE USUARIOS-->
<script type="text/javascript">
	$("#form-excluir").submit(function() {
		var pag = "<?= $pag ?>";
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: pag + "/excluir.php",
			type: 'POST',
			data: formData,

			success: function(mensagem) {

				$('#mensagem').removeClass()

				if (mensagem.trim() == "Excluído com Sucesso!") {

					$('#mensagem-excluir').addClass('text-success')

					$('#btn-fechar').click();
					window.location = "index.php?pagina=" + pag;

				} else {

					$('#mensagem-excluir').addClass('text-danger')
				}

				$('#mensagem-excluir').text(mensagem)

			},

			cache: false,
			contentType: false,
			processData: false,

		});
	});
</script>

<!-- SCRIPT DO DATATABLE -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			"ordering": false
		});
	});
</script>

