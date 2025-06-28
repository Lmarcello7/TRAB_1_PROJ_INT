$(function () {
	getTarefasCadastradas();
	getTarefasFinalizadas();

	/* MODAL DE CADASTRO DA TAREFA */
	$('#btnCadastro').click(function () {
		BootstrapDialog.show({
			title: '<h4 class="text-dark">Criar nova tarefa</h4>',
			message: function (dialog) {
				return $(`
                    <div class="row">
                        <div class="col-12">
                            <input type="text" name="nmTarefa" id="nmTarefa" class="form-control form-control-sm" placeholder="Nome da tarefa" />
                            <small class="aviso d-none text-danger">*Nome Invalido, tente novamente!</small>
                        </div>
                    </div>`
				);
			},
			buttons: [{
				label: 'Cancelar',
				cssClass: 'btn-light btn-size-4 mr-02 text-center',
				action: function (dialog) {
					dialog.close();
				}
			},
			{
				label: 'Criar Tarefa',
				cssClass: 'btn-success btn-size-4 mr-02 text-center',
				action: function (dialog) {
					let nmTarefa = $('#nmTarefa').val().trim();

					if (!nmTarefa) {
						$('.aviso').removeClass('d-none');
						return false;
					}

					dialog.close();
					criarTarefa(nmTarefa);
				}
			}]
		});
	});

	$('[pointer]').click(function () {
		const $icon = $(this);
		const $card = $icon.closest('.card');
		const $corpo = $card.find('.corpo-tarefa');

		// Alternar ícone
		$icon.toggleClass('fa-angle-down fa-angle-up');

		// Alternar visibilidade do corpo
		if ($corpo.hasClass('d-none')) {
			$corpo.removeClass('d-none').addClass('d-flex justify-content-center');
		} else {
			$corpo.removeClass('d-flex justify-content-center').addClass('d-none');
		}
	});
});

function formValido() {
	let valido = true;

	$('input[name="descTarefa"]').each(function () {
		const $elemAtu = $(this);

		if ($elemAtu.val().trim() == '') {
			$elemAtu.addClass('is-invalid');
			valido = false;
		} else {
			$elemAtu.removeClass('is-invalid');
		}
	});

	return valido;
}

function mostrarLoader() {
	$('.loader-overlay').fadeIn(300);
}

function esconderLoader() {
	$('.loader-overlay').fadeOut(300);
}

/* FUNCAO PARA CRIAR OU EDITAR ATIVIDADE */
function criarTarefa(nmTarefa, idTarefa) {

	console.log(idTarefa);
	BootstrapDialog.show({
		title: `<h4 class="text-dark">${nmTarefa}</h4>`,
		id: 'modalCadAtv',
		closable: false,
		message: function (dialog) {
			var loading = '<div id="divLoad" class="text-center"><i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i><br><b>Carregando</b></div>';
			return $(`<div>${loading}</div>`).load('view/modalCad.php', { tarefa: nmTarefa, id: idTarefa });
		},
		buttons: [{
			label: 'Fechar',
			cssClass: 'btn-light btn-size-4 mr-02 text-center',
			action: function (dialog) {
				dialog.close();
			}
		},
		{
			label: 'Salvar',
			id: 'btnSaveCadastro'
,			cssClass: 'btn-success btn-size-4 mr-02 text-center',
			action: function (dialog) {
				if ($('#assunto').val().trim() == '') {
					alertModal('Favor preencher o campo de assunto!');
					return;
				}

				if (!formValido()) {
					alertModal('Favor preencher os campos destacados!');
					return;
				}

				let arrInfo = [];
				$('#tableItensTarefa > tbody > tr').each(function () {
					const $trAtual = $(this);

					arrInfo.push({
						status: $trAtual.find('[name="stTarefa"]').is(':checked'),
						desc: $trAtual.find('[name="descTarefa"]').val().trim(),
						id: $trAtual.attr('rec') || ''
					});
				});

				let objData = {};
				objData.formData = $('#formInfo').serialize();
				objData.data = arrInfo;

				$.ajax({
					url: 'api/api.php',
					type: 'POST',
					dataType: 'json',
					data: {
						function: 'cadastraTarefa',
						data: JSON.stringify(objData)
					},
					success: function (resposta) {
						if (!resposta.ok) {
							alertModal(resposta.msg);
							return;
						}

						let legenda = idTarefa ? 'editada' : 'cadastrada';
						alertModal(`Tarefa ${legenda} com sucesso!`);
						dialog.close();
						getTarefasCadastradas();
					},
					error: function (erro) {
						console.error('Erro:', erro);
					}
				});
			}
		}]
	});
}

function alertModal(mensagem) {
	BootstrapDialog.show({
		title: 'Atenção',
		message: mensagem,
		buttons: [{
			label: 'OK',
			cssClass: 'btn-primary',
			action: function (dialog) {
				dialog.close();
			}
		}]
	});
}

function converteData(data) {
	return `${data.substr(6, 2)}/${data.substr(4, 2)}/${data.substr(0, 4)}`;
}

function getTarefasFinalizadas() {
	$.ajax({
		url: 'api/api.php',
		type: 'POST',
		dataType: 'json',
		data: {
			function: 'getTarefasFinalizadas',
			data: ''
		},
		success: function (objData) {
			if (!$.isEmptyObject(objData.data)) {
				let $div = '';
				$(objData.data).each(function (i, v1) {
					$div +=
						`<div class="card-finalizadas card w-100 mb-2">
							<div class="card-body">
								<h5 class="card-title d-flex justify-content-between align-items-center">
									<span>
										<input type="checkbox" name="finTask" title="Finalizar Tarefa" checked onclick="finalizarTarefa('${v1.nome_tarefa}', ${v1.id_tarefa}, $(this))"> ${v1.nome_tarefa}
									</span>
									<small class="text-muted">Finalizado em ${converteData(v1.data_finalizacao)}</small>
								</h5>
								<h6 onclick="criarTarefa('${v1.nome_tarefa}', ${v1.id_tarefa || ''})">${v1.assunto}</h6>
							</div>
						</div>`;
				});

				$('.card-finalizadas').remove();
				$('#tarefasFin').append($div);
				$('#alertFin').addClass('d-none');
			} else {
				$('#alertFin').removeClass('d-none');
			}

		},
		error: function (erro) {
			console.error('Erro:', erro);
		}
	});
}

function finalizarTarefa(nmTarefa, idTarefa, $divAt) {
	$.ajax({
		url: 'api/api.php',
		type: 'POST',
		dataType: 'json',
		data: {
			function: 'finalizarTarefa',
			data: JSON.stringify({ idTarefa: idTarefa, acao: $divAt.is(':checked') })
		},
		success: function (resposta) {
			if (!resposta.ok) {
				alertModal('Ocorreu um erro ao finalizar tarefa!');
				return;
			}

			$divAt.closest('.card-tarefa').fadeOut(500, function () {
				$(this).remove();
			});

			$divAt.closest('.card-finalizadas').fadeOut(500, function () {
				$(this).remove();
			});

			getTarefasFinalizadas();
			getTarefasCadastradas();
		},
		error: function (erro) {
			console.error('Erro:', erro);
		}
	});
}

function getTarefasCadastradas() {
	$.ajax({
		url: 'api/api.php',
		type: 'POST',
		dataType: 'json',
		data: {
			function: 'getTarefas',
			data: ''
		},
		success: function (objData) {
			if (!$.isEmptyObject(objData.data)) {
				let $div = '';
				$(objData.data).each(function (i, v1) {
					$div +=
						`<div class="card-tarefa card w-100 mb-2">
							<div class="card-body">
								<h5 class="card-title d-flex justify-content-between align-items-center">
									<span>
										<input type="checkbox" name="finTask" title="Finalizar Tarefa" onclick="finalizarTarefa('${v1.nome_tarefa}', ${v1.id_tarefa}, $(this))"> ${v1.nome_tarefa}
									</span>
									<small class="text-muted">Cadastrado em ${converteData(v1.data_cad)}</small>
								</h5>
								<h6 onclick="criarTarefa('${v1.nome_tarefa}', ${v1.id_tarefa || ''})">${v1.assunto}</h6>
							</div>
						</div>`;
				});

				$('.card-tarefa').remove();
				$('#tarefasPend').append($div);
				$('#alertPend').addClass('d-none');
			} else {
				$('#alertPend').removeClass('d-none');
			}

		},
		error: function (erro) {
			console.error('Erro:', erro);
		}
	});
}