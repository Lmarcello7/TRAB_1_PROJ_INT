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
	<div class="container-fluid mt-3">
		<div class="card">
			<h5 class="card-header text-center">To-do List</h5>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<button type="button" id="btnCadastro" class="btn btn-sm alert-success"><i class="fa fa-plus-square-o"></i> Criar nova tarefa</button>
					</div>
				</div>
				<div class="row mt-2">
					<!-- TAREFAS EM ANDAMENTO -->
					<div class="col-5">
						<div class="card">
							<h5 class="card-header">Tarefas em andamento <i class="fa fa-angle-down" aria-hidden="true"></i></h5>
							<div class="card-body d-flex justify-content-center">
								<div class="card-tarefa card d-inline-block w-75">
									<div class="card-body">
										<h5 class="card-title"><input type="checkbox" name="finTask" id="finTask" title="Finalizar Tarefa"> Titulo tarefa</h5>
										<h6>Descrição da tarefa</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-2"></div>
					<!-- TAREFAS CONCLUIDAS -->
					<!-- <div class="col-5">
						<div class="card">
							<h5 class="card-header">Tarefas em Finalizadas <i class="fa fa-angle-down" aria-hidden="true"></i></h5>
							<div class="card-body">
								<div class="card-tarefa card w-75">
									<div class="card-body">
										<h5 class="card-title"><input type="checkbox" name="finTask" id="finTask" title="Finalizar Tarefa"> Titulo tarefa</h5>
										<h6>Descrição da tarefa</h6>
									</div>
								</div>
							</div>
						</div>
					</div> -->
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