$(function () {
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

                    if(!nmTarefa) {
                        $('.aviso').removeClass('d-none');
                        return false;
                    }

                    dialog.close();
                    criarTarefa(nmTarefa);
                }
            }]
        });
    });
});

function criarTarefa(nmTarefa)
{
    BootstrapDialog.show({
        title: `<h4 class="text-dark">${nmTarefa}</h4>`,
        id: 'modalCadAtv',
        closable: false,
        message: function (dialog) {
            var loading = '<div id="divLoad" class="text-center"><i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i><br><b>Carregando</b></div>';
            return $(`<div>${loading}</div>`).load('view/modalCad.php', {tarefa: nmTarefa});
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
            cssClass: 'btn-success btn-size-4 mr-02 text-center',
            action: function (dialog) {
                
            }
        }]
    });
}