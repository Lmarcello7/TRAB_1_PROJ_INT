<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>To-do List</title>
	<link rel="stylesheet" href="style/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/gh/GedMarc/bootstrap4-dialog/dist/css/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="style/style.css">
</head>

<body>
	<!-- Loader -->
	<div id="loader" class="loader-overlay d-none">
		<div class="loader-content text-center">
			<i class="fa fa-spinner fa-spin fa-3x text-primary"></i>
			<p class="mt-2 text-white">Carregando...</p>
		</div>
	</div>
	<div class="container-fluid mt-3">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-3"></div>
					<div class="col-6 text-center">
						<h5>To-do List</h5>
					</div>
					<div class="col-1"></div>
					<div class="col-2 text-right">
						<button type="button" id="btnCadastro" class="btn btn-sm alert-success">
							<i class="fa fa-plus-square-o"></i> Criar nova tarefa
						</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row mt-2 d-flex justify-content-around">
					<!-- TAREFAS EM ANDAMENTO -->
					<div class="col-5">
						<div class="card">
							<h5 class="card-header">Tarefas Pendentes <i class="fa fa-angle-down" pointer aria-hidden="true"></i></h5>
							<div class="card-body d-flex justify-content-center corpo-tarefa" id="tarefasPend">
								<div class="alert alert-danger text-center" id="alertPend">
									<i class="fa fa-info-circle"></i> Nenhuma tarefa Pendente!
								</div>
							</div>
						</div>
					</div>
					<div class="col-5">
						<div class="card">
							<h5 class="card-header">Tarefas Concluídas <i class="fa fa-angle-down" pointer aria-hidden="true"></i></h5>
							<div class="card-body d-flex justify-content-center corpo-tarefa" id="tarefasFin">
								<div class="alert alert-danger text-center" id="alertFin">
									<i class="fa fa-info-circle"></i> Nenhuma tarefa Finalizada!
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/GedMarc/bootstrap4-dialog/dist/js/bootstrap-dialog.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>