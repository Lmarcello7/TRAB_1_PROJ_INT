$(function () {
    $('#btnCadastro').click(function () {
        BootstrapDialog.show({
            title: '<h4 class="text-dark">Cadastro de Produtos</h4>',
            id: 'modalCadAtv',
            message: function (dialog) {
                var loading = '<div id="divLoad" class="text-center"><i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i><br><b>Carregando</b></div>';
                return $(`<div>${loading}</div>`).load('../view/modalCad.php');
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
    });
});