<?php
$pag = 'compras';
@session_start();

require_once('../conexao.php');
require_once('verificar-permissao.php')

?>

<div class="mt-4" style="margin-right:25px">
	<?php
	$query = $pdo->query("SELECT * from compras order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if ($total_reg > 0) {
	?>
		<small>
			<table id="example" class="table table-hover my-4" style="width:100%">
				<thead>
					<tr>
                        <th>Pago</th>
                        <th>Produto</th>
						<th>Quantidade</th>
						<th>Valor Unitario </th>
						<th>Valor Total</th>
						<th>Data</th>
                        <th>Usuario</th>
                        <th>Fornecedor</th>
                        <th>Tel Fornecedor</th>
					</tr>
				</thead>
				<tbody>

					<?php
					for ($i = 0; $i < $total_reg; $i++) {
						foreach ($res[$i] as $key => $value) {
						}

                        //BUCAR DADOS DO PRODUTO
						$id_prod = $res[$i]['produto'];
						$query_f = $pdo->query("SELECT * from produtos where id ='$id_prod'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if ($total_reg_f > 0) {
							$nome_produto = $res_f[0]['nome'];
						} else {
							$nome_produto = 'NENHUM CADASTRADO';
						}

                        //BUCAR DADOS DO USUARIO
						$id_usu = $res[$i]['usuario'];
						$query_f = $pdo->query("SELECT * from usuarios where id ='$id_usu'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if ($total_reg_f > 0) {
							$nome_usuario = $res_f[0]['nome'];
						} else {
							$nome_usuarios = 'NENHUM CADASTRADO';
						}

                        //BUCAR DADOS DO FORNECEDOR
						$id_forn = $res[$i]['fornecedor'];
						$query_f = $pdo->query("SELECT * from fornecedores where id ='$id_forn'");
						$res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
						$total_reg_f = @count($res_f);
						if ($total_reg_f > 0) {
							$nome_forn = $res_f[0]['nome'];
							$tel_forn = $res_f[0]['telefone'];
						} else {
							$nome_forn = 'NENHUM CADASTRADO';
							$tel_forn = 'NENHUM CADASTRADO';
						}

                        if($res[$i]['pago'] == 'Sim'){
                             $classe = 'text-success';   
                        }else{
                            $classe = 'text-danger';
                        }
					?>

						<tr>
							<td>
                                <i class="bi bi-square-fill <?php echo $classe ?>"></i>
                            </td>
                            <td><?php echo $nome_produto ?></td>
							<td><?php echo $res[$i]['quantidade'] ?></td>
                            <td>R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($res[$i]['total'], 2, ',', '.'); ?></td>
                            <td> <?php echo $data = implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></td>
                            <td><?php echo $nome_usuario ?></td>
                            <td><?php echo $nome_forn ?></td>
                            <td><?php echo $tel_forn ?></td>

						</tr>

					<?php } ?>

				</tbody>

			</table>
		</small>
	<?php } else {
		echo '<p>Não existem dados para serem exibidos!!';
	} ?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			"ordering": false
		});
	});
</script>
