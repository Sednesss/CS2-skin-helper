let statusChangePath = '/api/v1/game-items/statusChange';
let skinsPaginationPath = '/api/v1/skins/pagination';
let skinsDestroyPath = '/api/v1/skins/destroy';

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
    gameItemSkinsPagePaginationButtons.find('button').on('click', function (e) {
        let selectedPageNumber = $(this).attr('data-page-number');

        updateSkinsTable(selectedPageNumber);
    });

    addHandlerSkinDeleteButtons();

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
                        <td class="col-1 align-middle py-1">${index + response.data.startItemNumber}</td>
                        <td class="col-1 align-middle py-1">${skin.id}</td>
                        <td class="col-4 align-middle py-1 text-nowrap">${skin.pattern}</td>
                        <td class="col-4 align-middle py-1 text-nowrap">${skin.float}</td>
                        <td class="col-2 align-middle py-1 text-center">
                            <button class="btn btn-transparent btn-icon game_item_skins-button_edit" data-skin-id="${skin.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-transparent btn-icon game_item_skins-button_delete" data-skin-id="${skin.id}">
                                <i class="fas fa-trash-alt"></i>
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

                addHandlerSkinDeleteButtons();
            }
        });
    }

    // add handler to skins delete buttons
    function addHandlerSkinDeleteButtons() {
        let gameItemSkinsDeleteButtons = gameItemSkinsTableBody.find('.game_item_skins-button_delete');
        gameItemSkinsDeleteButtons.on('click', skinDeleteButtonHandler);
    }

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

    // delete skin pagination last page
    function deleteSkinPaginationLastPage() {
        $('#game_item_skins')
            .find('#game_item_skins-page_map .dataTables_paginate .pagination .paginate_button')
            .not('.previous')
            .not('.next')
            .last()
            .remove();
    }
});