<?php
sleep(1); /* PERMITE O JS CARREGAR CORRETAMENTE */
?>

<div class="container-fluid">
	<form id="formInfo">
		<div class="row">
			<div class="col-2">
				<label for="dtVenc">Vencimento</label>
				<input type="date" name="dtVenc" id="dtVenc" class="form-control form-control-sm text-center">
			</div>
			<div class="col-8"></div>
			<div class="col-2">
				<label for="prioridade">Prioridade</label>
				<select name="prioridade" id="prioridade" class="form-control form-control-sm">
					<option value="B">Baixa</option>
					<option value="M">Média</option>
					<option value="A">Alta</option>
				</select>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-12">
				<label for="obsTarefa">Observações</label>
				<textarea name="obsTarefa" id="obsTarefa" class="form-control form-control-sm" cols="30" rows="4"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-12">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" id="showObs" name="showObs">
					<label class="form-check-label" for="showObs">
						Mostrar Observação no card
					</label>
				</div>
			</div>
		</div>
	</form>
</div>