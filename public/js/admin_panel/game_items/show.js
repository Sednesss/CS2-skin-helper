let statusChangePath = '/api/v1/game-items/statusChange';
let skinsPaginationPath = '/api/v1/skins/pagination';
let skinsDestroyPath = '/api/v1/skins/destroy';
let skinsUpdatePath = '/api/v1/skins/update';

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // status
    let gameItemForm = $('#game_item-form');
    let statusGroup = gameItemForm.find('#game_item-status');
    let statusInput = statusGroup.find('#status');

    statusInput.change(function () {
        let statusValue = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: statusChangePath,
            type: 'POST',
            data: {
                game_item_id: gameItem.id,
                status: statusValue
            },
            success: function (response) {
            },
            error: function () {
            }
        });
    });

    // import menu
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

    // skins
    let gameItemSkinsData = gameItemSkins.find('#game_item_skins-data');
    let gameItemSkinsTable = gameItemSkinsData.find('#game_item_skins-table');
    let gameItemSkinsTableBody = gameItemSkinsTable.find('#game_item_skins-table_body');

    let gameItemSkinsPageMap = gameItemSkins.find('#game_item_skins-page_map');
    let gameItemSkinsPageTableInfo = gameItemSkinsPageMap.find('.dataTables_info');
    let gameItemSkinsPagePaginationButtons = gameItemSkinsPageMap.find('.dataTables_paginate .pagination .paginate_button');

    let skinsPainationData = null;
    let currentPageNumber = 1;
    let skinsCancellationValue = {};
    gameItemSkinsPagePaginationButtons.find('button').on('click', function (e) {
        let selectedPageNumber = $(this).attr('data-page-number');

        updateSkinsTable(selectedPageNumber);
    });

    addHandlerSkinActions();

    //
    // helper functions
    //

    // update skins table
    function updateSkinsTable(page, isHasBlankPage = false) {
        if (isHasBlankPage) {
            deleteSkinPaginationLastPage();
        }

        $.ajax({
            type: 'POST',
            url: skinsPaginationPath,
            data: {
                game_item_id: gameItem.id,
                page: page
            },
            success: function (response) {
                currentPageNumber = page;
                skinsPainationData = {
                    totalPage: response.data.totalPages,
                    totalItems: response.data.totalItems,
                    startItem: response.data.startItemNumber,
                    endItem: response.data.endItemNumber,
                    itemsPerPage: response.data.itemsPerPage
                };
                gameItemSkinsTableBody.empty();

                // table
                response.data.skins.forEach(function (skin, index) {
                    gameItemSkinsTableBody.append(`<tr class="odd">
                        <td class="col-1 align-middle py-1 skin_element-index">${index + response.data.startItemNumber}</td>
                        <td class="col-1 align-middle py-1 skin_element-id">${skin.id}</td>
                        <td class="col-4 align-middle py-1 text-nowrap skin_element-pattern">${skin.pattern}</td>
                        <td class="col-4 align-middle py-1 text-nowrap skin_element-float">${skin.float}</td>
                        <td class="col-2 align-middle py-1 text-center skin_element-actions">
                            <button class="btn btn-transparent btn-icon game_item_skins-button_edit" data-skin-id="${skin.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-transparent btn-icon game_item_skins-button_delete" data-skin-id="${skin.id}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-transparent btn-icon disabled d-none game_item_skins-button_save" data-skin-id="${skin.id}">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-transparent btn-icon disabled d-none game_item_skins-button_cancel" data-skin-id="${skin.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>`);
                });

                // info
                gameItemSkinsPageTableInfo.text(`Showing ${response.data.startItemNumber} to ${response.data.endItemNumber} of ${response.data.totalItems} entries`);

                // dataTables_paginate page
                gameItemSkinsPagePaginationButtons.not('.previous').not('.next').each(function () {
                    let paginationButton = $(this).find('button');
                    let pageNumber = paginationButton.attr('data-page-number');
                    if (pageNumber == currentPageNumber) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
                });

                // dataTables_paginate page previous
                let gameItemSkinsPagePaginationButtonPrevious = gameItemSkinsPagePaginationButtons.filter('.previous');
                gameItemSkinsPagePaginationButtonPrevious.find('button').attr('data-page-number', currentPageNumber - 1);

                if (currentPageNumber <= 1) {
                    gameItemSkinsPagePaginationButtonPrevious.addClass('disabled');
                } else {
                    gameItemSkinsPagePaginationButtonPrevious.removeClass('disabled');
                }

                // dataTables_paginate page next
                let gameItemSkinsPagePaginationButtonNext = gameItemSkinsPagePaginationButtons.filter('.next');
                gameItemSkinsPagePaginationButtonNext.find('button').attr('data-page-number', parseInt(currentPageNumber) + 1);

                if (currentPageNumber >= response.data.totalPages) {
                    gameItemSkinsPagePaginationButtonNext.addClass('disabled');
                } else {
                    gameItemSkinsPagePaginationButtonNext.removeClass('disabled');
                }

                addHandlerSkinActions();
            }
        });
    }

    // add handler to skins delete buttons
    function addHandlerSkinActions() {
        let gameItemSkinsDeleteButtons = gameItemSkinsTableBody.find('.game_item_skins-button_delete');
        gameItemSkinsDeleteButtons.on('click', skinDeleteButtonHandler);

        let gameItemSkinsEditButtons = gameItemSkinsTableBody.find('.game_item_skins-button_edit');
        gameItemSkinsEditButtons.on('click', skinEditButtonHandler);

        let gameItemSkinsSaveButtons = gameItemSkinsTableBody.find('.game_item_skins-button_save');
        gameItemSkinsSaveButtons.on('click', skinSaveButtonHandler);

        let gameItemSkinsCancelButtons = gameItemSkinsTableBody.find('.game_item_skins-button_cancel');
        gameItemSkinsCancelButtons.on('click', skinCancelButtonHandler);
    }

    // delete skin pagination last page
    function deleteSkinPaginationLastPage() {
        $('#game_item_skins')
            .find('#game_item_skins-page_map .dataTables_paginate .pagination .paginate_button')
            .not('.previous')
            .not('.next')
            .last()
            .remove();
    }

    //
    // button handlers
    //

    // skin delete button handler
    function skinDeleteButtonHandler() {
        let skinId = $(this).attr('data-skin-id');

        $.ajax({
            type: 'POST',
            url: skinsDestroyPath,
            data: {
                skin_id: skinId,
            },
            success: function (response) {
                let isHasBlankPage = false;
                let showPageNumber = currentPageNumber;

                if (skinsPainationData !== null && typeof skinsPainationData === 'object') {
                    // if a blank page appears when deleting
                    if (Math.ceil((skinsPainationData.totalItems - 1) / skinsPainationData.itemsPerPage) < skinsPainationData.totalPage) {
                        isHasBlankPage = true;
                    }

                    // if the last page is open & if there are no elements on the current page 
                    if (
                        isHasBlankPage
                        && skinsPainationData.totalPage == currentPageNumber
                        && skinsPainationData.startItem == skinsPainationData.totalItems
                    ) {
                        showPageNumber = currentPageNumber - 1;
                    }
                }

                updateSkinsTable(showPageNumber, isHasBlankPage);
            }
        });
    }

    // skin edit button handler
    function skinEditButtonHandler() {
        let skinId = $(this).attr('data-skin-id');
        let skinDataRow = $(this).closest('tr');
        let skinActions = skinDataRow.find('.skin_element-actions');
        let skinButtonEdit = skinActions.find('.game_item_skins-button_edit');
        let skinButtonDelete = skinActions.find('.game_item_skins-button_delete');
        let skinButtonSave = skinActions.find('.game_item_skins-button_save');
        let skinButtonCancel = skinActions.find('.game_item_skins-button_cancel');

        skinButtonEdit.addClass('disabled').addClass('d-none');
        skinButtonDelete.addClass('disabled').addClass('d-none');
        skinButtonSave.removeClass('disabled').removeClass('d-none');
        skinButtonCancel.removeClass('disabled').removeClass('d-none');

        let skinPattern = skinDataRow.find('.skin_element-pattern');
        let skinFloat = skinDataRow.find('.skin_element-float');
        let skinPatternValue = skinPattern.text();
        let skinFloatValue = skinFloat.text();
        skinsCancellationValue[skinId] = {
            pattern: skinPatternValue,
            float: skinFloatValue
        };

        skinPattern.empty();
        skinFloat.empty();
        skinPattern.append(`<input type="number" class="form-control" value="${skinPatternValue}" min="1" max="999">`);
        skinFloat.append(`<input type="number" class="form-control" value="${skinFloatValue}" min="0" max="1" step="0.000001">`);
    }

    // skin save button handler
    function skinSaveButtonHandler() {
        let skinId = $(this).attr('data-skin-id');
        let skinDataRow = $(this).closest('tr');
        let skinActions = skinDataRow.find('.skin_element-actions');
        let skinButtonEdit = skinActions.find('.game_item_skins-button_edit');
        let skinButtonDelete = skinActions.find('.game_item_skins-button_delete');
        let skinButtonSave = skinActions.find('.game_item_skins-button_save');
        let skinButtonCancel = skinActions.find('.game_item_skins-button_cancel');

        let skinPattern = skinDataRow.find('.skin_element-pattern');
        let skinFloat = skinDataRow.find('.skin_element-float');
        let skinPatternValue = skinPattern.find('input').val();
        let skinFloatValue = skinFloat.find('input').val();

        $.ajax({
            type: 'POST',
            url: skinsUpdatePath,
            data: {
                skin_id: skinId,
                pattern: skinPatternValue,
                float: skinFloatValue
            },
            success: function (response) {
                skinButtonEdit.removeClass('disabled').removeClass('d-none');
                skinButtonDelete.removeClass('disabled').removeClass('d-none');
                skinButtonSave.addClass('disabled').addClass('d-none');
                skinButtonCancel.addClass('disabled').addClass('d-none');

                skinPattern.empty();
                skinFloat.empty();
                skinPattern.text(skinPatternValue);
                skinFloat.text(skinFloatValue);
            }
        });
    }

    // skin cancel button handler
    function skinCancelButtonHandler() {
        let skinId = $(this).attr('data-skin-id');
        let skinDataRow = $(this).closest('tr');
        let skinActions = skinDataRow.find('.skin_element-actions');
        let skinButtonEdit = skinActions.find('.game_item_skins-button_edit');
        let skinButtonDelete = skinActions.find('.game_item_skins-button_delete');
        let skinButtonSave = skinActions.find('.game_item_skins-button_save');
        let skinButtonCancel = skinActions.find('.game_item_skins-button_cancel');

        skinButtonEdit.removeClass('disabled').removeClass('d-none');
        skinButtonDelete.removeClass('disabled').removeClass('d-none');
        skinButtonSave.addClass('disabled').addClass('d-none');
        skinButtonCancel.addClass('disabled').addClass('d-none');

        let skinPattern = skinDataRow.find('.skin_element-pattern');
        let skinFloat = skinDataRow.find('.skin_element-float');
        let skinPatternValue = skinsCancellationValue[skinId].pattern;
        let skinFloatValue = skinsCancellationValue[skinId].float;

        skinPattern.empty();
        skinFloat.empty();
        skinPattern.text(skinPatternValue);
        skinFloat.text(skinFloatValue);
    }
});