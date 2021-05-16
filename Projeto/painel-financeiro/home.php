<?php

require_once('../conexao.php');
require_once('verificar-permissao.php');

$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual . "-" . $mes_atual . "-01";


$entradas = 0;
$saidas = 0;
$saldo = 0;
$query = $pdo->query("SELECT * from movimentacoes where data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

	for ($i = 0; $i < $total_reg; $i++) {
		foreach ($res[$i] as $key => $value) {
		}


		if ($res[$i]['tipo'] == 'Entrada') {

			$entradas += $res[$i]['valor'];
		} else {

			$saidas += $res[$i]['valor'];
		}

		$saldo = $entradas - $saidas;

		$entradasF = number_format($entradas, 2, ',', '.');
		$saidasF = number_format($saidas, 2, ',', '.');
		$saldoF = number_format($saldo, 2, ',', '.');

		if ($saldo < 0) {
			$classeSaldo = 'text-danger';
		} else {
			$classeSaldo = 'text-success';
		}
	}
}


//BUSCAR ULTIMA MOVIMENTAÇÃO
$query = $pdo->query("SELECT * from movimentacoes order by id desc limit 1");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$valorMov = $res[0]['valor'];
$descricaoMov = $res[0]['descricao'];
$tipoMov = $res[0]['tipo'];
$valorMov = number_format($valorMov, 2, ',', '.');
if ($tipoMov == 'Entrada') {
	$classeMov = 'text-success';
} else {
	$classeMov = 'text-danger';
}

//BUSCA DE CONTAS
$query = $pdo->query("SELECT * from contas_receber where vencimento < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_receber_vencidas = @count($res);


$query = $pdo->query("SELECT * from contas_receber where vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_receber_hoje = @count($res);


$query = $pdo->query("SELECT * from contas_pagar where vencimento < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pagar_vencidas = @count($res);


$query = $pdo->query("SELECT * from contas_pagar where vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pagar_hoje = @count($res);





$entradasM = 0;
$saidasM = 0;
$saldoM = 0;
$query = $pdo->query("SELECT * from movimentacoes where data >= '$dataInicioMes' and data <= curDate() ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

	for ($i = 0; $i < $total_reg; $i++) {
		foreach ($res[$i] as $key => $value) {
		}


		if ($res[$i]['tipo'] == 'Entrada') {

			$entradasM += $res[$i]['valor'];
		} else {

			$saidasM += $res[$i]['valor'];
		}

		$saldoMes = $entradasM - $saidasM;

		$entradasMF = number_format($entradasM, 2, ',', '.');
		$saidasMF = number_format($saidasM, 2, ',', '.');
		$saldoMesF = number_format($saldoMes, 2, ',', '.');

		if ($saldoMesF < 0) {
			$classeSaldoM = 'text-danger';
		} else {
			$classeSaldoM = 'text-success';
		}
	}
}



$totalPagarM = 0;
$query = $pdo->query("SELECT * from contas_pagar where data >= '$dataInicioMes' and data <= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pagarMes = @count($res);
$total_reg = @count($res);
if ($total_reg > 0) {

	for ($i = 0; $i < $total_reg; $i++) {
		foreach ($res[$i] as $key => $value) {
		}

		$totalPagarM += $res[$i]['valor'];
		$pagarMesF = number_format($totalPagarM, 2, ',', '.');
	}
}


$totalReceberM = 0;
$query = $pdo->query("SELECT * from contas_receber where data >= '$dataInicioMes' and data <= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$receberMes = @count($res);
$total_reg = @count($res);
if ($total_reg > 0) {

	for ($i = 0; $i < $total_reg; $i++) {
		foreach ($res[$i] as $key => $value) {
		}

		$totalReceberM += $res[$i]['valor'];
		$receberMesF = number_format($totalReceberM, 2, ',', '.');
	}
}

?>





<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

<div class="container-fluid">
	<section id="minimal-statistics">
		<div class="row mb-2">
			<div class="col-12 mt-3 mb-1">
				<h4 class="text-uppercase">Estatísticas Financeiras</h4>

			</div>
		</div>

		<div class="row mb-4">

			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-cash text-success fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3> <span class="text-success">R$ <?php echo @$entradasF ?></span></h3>
									<span>Entradas do Dia</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-cash text-danger fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3> <span class="text-danger">R$ <?php echo @$saidasF ?></span></h3>
									<span>Saídas do Dia</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-cash <?php echo $classeSaldo ?> fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3> <span class="<?php echo $classeSaldo ?>">R$ <?php echo @$saldoF ?></span></h3>
									<span>Saldo do Dia</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-exclamation-triangle-fill <?php echo $classeMov ?> fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3>R$ <?php echo @$valorMov ?></h3>
									<span><?php echo $descricaoMov ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>






		<div class="row mb-4">

			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-calendar2-check-fill text-warning fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3> <span class=""><?php echo @$contas_pagar_hoje ?></span></h3>
									<span>Contas à Pagar (Hoje)</span>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-calendar-x-fill text-danger fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3> <span class="">
											<?php echo @$contas_pagar_vencidas ?></span></h3>
									<span>Contas à Pagar Vencidas</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-calendar2-check-fill text-warning fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3> <span class=""><?php echo @$contas_receber_hoje ?></span></h3>
									<span>Contas Receber (Hoje)</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-xl-3 col-sm-6 col-12">
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<div class="row">
								<div class="align-self-center col-3">
									<i class="bi bi-calendar-x-fill text-danger fs-1 float-start"></i>
								</div>
								<div class="col-9 text-end">
									<h3><?php echo @$contas_receber_vencidas ?></h3>
									<span>Contas à Receber Vencidas</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>



	</section>

	<section id="stats-subtitle">
		<div class="row mb-2">
			<div class="col-12 mt-3 mb-1">
				<h4 class="text-uppercase">Estatísticas Mensais</h4>

			</div>
		</div>

		<div class="row mb-4">

			<div class="col-xl-6 col-md-12">
				<div class="card overflow-hidden">
					<div class="card-content">
						<div class="card-body cleartfix">
							<div class="row media align-items-stretch">
								<div class="align-self-center col-1">
									<i class="bi-calendar2-date text-primary fs-1 mr-2"></i>
								</div>
								<div class="media-body col-6">
									<h4>Saldo Total</h4>
									<span>Saldo do Mês</span>
								</div>
								<div class="text-end col-5">
									<h2><span class="<?php echo $classeSaldoM ?>">R$ <?php echo $saldoMesF ?></h2></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-6 col-md-12">
				<div class="card overflow-hidden">
					<div class="card-content">
						<div class="card-body cleartfix">
							<div class="row media align-items-stretch">
								<div class="align-self-center col-1">
									<i class="bi bi-calendar-week-fill text-danger fs-1 mr-2"></i>
								</div>
								<div class="media-body col-6">
									<h4>Contas à Pagar</h4>
									<span>Total de <?php echo $pagarMes ?> Contas no Mês</span>
								</div>
								<div class="text-end col-5">
									<h2>R$ <?php echo @$pagarMesF ?></h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>


		<div class="row mb-4">

			<div class="col-xl-6 col-md-12">
				<div class="card overflow-hidden">
					<div class="card-content">
						<div class="card-body cleartfix">
							<div class="row media align-items-stretch">
								<div class="align-self-center col-1">
									<i class="bi bi-calendar-week-fill text-success fs-1 mr-2"></i>
								</div>
								<div class="media-body col-6">
									<h4>Contas à Receber</h4>
									<span>Total de <?php echo $receberMes ?> Contas no Mês</span>
								</div>
								<div class="text-end col-5">
									<h2>R$ <?php echo @$receberMesF ?></h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-6 col-md-12">
				<div class="card overflow-hidden">
					<div class="card-content">
						<div class="card-body cleartfix">
							<div class="row media align-items-stretch">
								<div class="align-self-center col-1">
									<i class="bi bi-calendar2-plus-fill text-success fs-1 mr-2"></i>
								</div>
								<div class="media-body col-6">
									<h4>Total de Vendas</h4>
									<span>Vendas do Mês em R$</span>
								</div>
								<div class="text-end col-5">
									<h2>R$ 00,00</h2>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>

		</div>


	</section>

<!--
	<section id="stats-subtitle">
		<div class="row mb-2">
			<div class="col-12 mt-3 mb-1">
				<h4 class="text-uppercase">Modelo de Gráficos</h4>

			</div>
		</div>



		<style type="text/css">
			#principal {
				width: 500px;
				height: 100%;
				margin-left: 10px;
				font-family: Verdana, Helvetica, sans-serif;
				font-size: 14px;

			}

			#barra {
				margin: 0 2px;
				vertical-align: bottom;
				display: inline-block;


			}

			.cor1,
			.cor2,
			.cor3,
			.cor4 {
				color: #FFF;
				padding: 5px;
			}

			.cor1 {
				background-color: #FF0000;
			}

			.cor2 {
				background-color: #0000FF;
			}

			.cor3 {
				background-color: #FF6600;
			}

			.cor4 {
				background-color: #009933;
			}
		</style>


		<?php
		// definindo porcentagem
		$height1 = '58px';
		$height2 = '89px';
		$height3 = '50px';
		$height4 = '25px';
		$total  = 4; // total de barras
		?>
		<div id="principal">
			<p>Vendas no Ano</p>
			<?php
			for ($i = 1; $i <= $total; $i++) {
				$height = ${'height' . $i};
			?>
				<div id="barra">
					<div class="cor<?php echo $i ?>" style="height:<?php echo $height ?>"> <?php echo $height ?> </div>
					<div>Janeiro</div>
				</div>
			<?php } ?>
		</div>

	</section>


</div>
-->