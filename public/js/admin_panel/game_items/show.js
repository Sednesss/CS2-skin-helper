$(document).ready(function () {
    let gameItemForm = $('#game_item-form');
    let statusGroup = gameItemForm.find('#game_item-status');
    let statusInput = statusGroup.find('#status');
    statusInput.change(function () {
        let statusValue = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: '/',
            type: 'POST',
            data: { status: statusValue },
            success: function (response) {
                // Обработка успешного ответа
            },
            error: function () {
                // Обработка ошибки
            }
        });
    });

    let gameItemSkins = $('#game_item_skins');
    let gameItemSkinsActions = gameItemSkins.find('#game_item_skins-actions');
    let gameItemSkinsImport = gameItemSkinsActions.find('#game_item_skins-import');
    let gameItemSkinsButtonImport = gameItemSkinsImport.find('#game_item_skins-button_import_menu');
    let gameItemSkinsImportMenu = gameItemSkinsImport.find('#game_item_skins-import_menu');

    gameItemSkinsButtonImport.on('click', function () {
        gameItemSkinsImportMenu.toggle();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest(gameItemSkinsImportMenu).length && !$(e.target).closest(gameItemSkinsButtonImport).length) {
            gameItemSkinsImportMenu.hide();
        }
    });
});