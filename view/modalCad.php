<?php
sleep(1); /* PERMITE O JS CARREGAR CORRETAMENTE */

$dados = filter_var_array($_REQUEST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
?>

<style>
	.style-inp {
		border: 0;
		border-bottom: 1px solid #d4edda;
		border-radius: 0;
	}

	[type="checkbox"] { cursor: pointer; }

	input[name="descTarefa"]:focus{
		outline: none;
	}

	[disabled] { cursor: no-drop; }

	.through { text-decoration: line-through; }
</style>
<div class="container-fluid">
	<form id="formInfo">
		<input type="hidden" name="nmTarefa" value="<?= $dados['tarefa'] ?>">
		<input type="hidden" name="idTarefa" value="<?= $dados['id'] ?? '' ?>">
		<div class="row">
			<div class="col-12">
				<label for="assunto">Assunto</label>
				<input type="text" name="assunto" id="assunto" class="form-control form-control-sm" validar>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-2">
				<label for="dtVenc">Finalização</label>
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
	</form>
	<div class="row mt-3">
		<div class="col-2">
			<button type="button" class="btn btn-sm alert-info rounded-1 w-100" onclick="addTarefa()">
				<i class="fa fa-plus-square-o"></i> Adicionar Item
			</button>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-sm table-borderless" id="tableItensTarefa">
			<thead>
				<tr>
					<th width="5%">&nbsp;</th>
					<th width="90%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(function () {
		getRegistro();

		$('[name="stTarefa"]').change(function() {
			const $checkbox = $(this);
			const $tr = $checkbox.closest('tr');
			const $input = $tr.find('input[name="descTarefa"]');

			if ($checkbox.is(':checked')) {
				$tr.addClass('through');
				$input.prop('disabled', true);
			} else {
				$tr.removeClass('through');
				$input.prop('disabled', false);
			}
		});
	});

	function acaoCheck($elem) {
		const $checkbox = $elem;
		const $tr = $checkbox.closest('tr');
		const $input = $tr.find('input[name="descTarefa"]');

		if ($checkbox.is(':checked')) {
			$tr.addClass('through');
			$input.prop('disabled', true);
		} else {
			$tr.removeClass('through');
			$input.prop('disabled', false);
		}
	}

	function addTarefa() 
	{ 
		$('#tableItensTarefa > tbody').append(
			`<tr>
				<td class="text-center align-middle" title="Marcar como concluído">
					<input type="checkbox" name="stTarefa" onchange="acaoCheck($(this))">
				</td>
				<td>
					<input type="text" name="descTarefa" class="form-control form-control-sm style-inp" autocomplete="off">
				</td>
				<td class="text-center align-middle">
					<button type="button" class="btn btn-sm alert-danger" title="Deletar Item" onclick="deleteItem($(this))">
						<i class="fa fa-trash"></i>
					</button>
				</td>
			</tr>`
		);

		$('.style-inp').last().focus();
	}

	function deleteItem($elem) {
		$elem.closest('tr').fadeOut(2500).remove();
	}

	function preencherCampos(objData) {
		const dados = objData.dadosTarefa;
		$('#assunto').val(dados.assunto);
		$('#dtVenc').val(dados.finalizacao);
		$('#prioridade').val(dados.prioridade);
		$('#obsTarefa').val(dados.observacao);

		if(dados.status_tarefa == 'F') {
			$('#formInfo select, input[type="text"], input[type="date"], textarea').prop('disabled', true);
			$('#btnSaveCadastro').prop('disabled', true);
		}
	}

	function preencherItens(itens) {
		let $tr = '';
		$(itens).each(function(i, v1) {
			const ativo = v1.ativo == 'S';
			const classeTr = !ativo ? 'through' : '';

			$tr += 
				`<tr rec="${v1.id_item}" class="${classeTr}">
					<td class="text-center align-middle" title="Marcar como concluído">
						<input type="checkbox" name="stTarefa" ${!ativo ? 'checked' : ''}>
					</td>
					<td>
						<input type="text" name="descTarefa" class="form-control form-control-sm style-inp" autocomplete="off" ${!ativo ? 'disabled' : ''} value="${v1.desc_item}">
					</td>
					<td class="text-center align-middle">
						<button type="button" class="btn btn-sm alert-danger" title="Deletar Item" onclick="deleteItem($(this))">
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>`
		});

		$('#tableItensTarefa > tbody').append($tr);
	}

	function getRegistro() {
		const id = $('[name="idTarefa"]').val();
		if(id != '') {
			$.ajax({
				url: 'api/api.php',
				type: 'POST',
				async: false,
				dataType: 'json',
				data: {
					function: 'getTarefa',
					data: JSON.stringify(id)
				},
				success: function (resposta) {
					if(!$.isEmptyObject(resposta)) {
						preencherCampos(resposta);
						preencherItens(resposta.itens);
					}
				},
				error: function (erro) {
					console.error('Erro:', erro);
				}
			});
		}
	}
</script>