var default_per_page = typeof default_per_page !== 'undefined' ? default_per_page : 25;
var oTable;
var oTableArray = [];
var oTableMapping = [];
var examSS;
var oSpecial = null;
var oResizeLauched = false;
function supports_html5_storage() {
    try {
        JSON.parse("{}");
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}

function success_message(message) {
    $('#list-report-success').html(message);
    $('#list-report-success').slideDown();
}

function error_message(message) {
    $('#list-report-error').html(message);
    $('#list-report-error').slideDown();
}

var use_storage = supports_html5_storage();

var aButtons = [];
var bButtons = [];
var mColumns = [];

$(document).ready(function () {

    $('table.groceryCrudTable thead tr th').each(function (index) {
        if (!$(this).hasClass('actions')) {
            mColumns[index] = index;
        }
    });

    if (!unset_export) {
        bButtons.push({
            extend: 'copy',
            text: '<i class="far fa-clipboard"></i>',
            exportOptions: {
                columns: ['.printable']
            }
        },
            {
                extend: 'excel',
                text: '<i class="far fa-file-excel"></i>',
                exportOptions: {
                    columns: ['.printable']
                }
            });

    }

    if (!unset_print) {
        bButtons.push({
            extend: 'print',
            text: '<i class="fas fa-print"></i>',
            exportOptions: {
                columns: ['.printable']
            }
        });
    }

    //For mutliplegrids disable bStateSave as it is causing many problems
    if ($('.groceryCrudTable').length > 1) {
        use_storage = true;
    }

    $('.groceryCrudTable').each(function (index) {
        if (typeof oTableArray[index] !== 'undefined') {
            return false;
        }

        oTableMapping[$(this).attr('id')] = index;

        oTableArray[index] = loadDataTable(this);
    });

    $(".groceryCrudTable thead input").keyup(function () {
        oTable.fnFilter(this.value, parseInt($(this).attr('data-index')));
    });

    var search_values = localStorage.getItem('datatables_search_' + unique_hash);

    if (search_values !== null) {
        $.each($.parseJSON(search_values), function (num, val) {
            if (val !== '') {
                $(".groceryCrudTable thead tr th:eq(" + num + ")").children(':first').val(val);
            }
        });
    }

    $('.clear-filtering').click(function () {
        localStorage.removeItem('DataTables_' + unique_hash);
        localStorage.removeItem('datatables_search_' + unique_hash);

        //chosen_table = datatables_get_chosen_table($(this).closest('.groceryCrudTable'));

        //chosen_table.fnFilterClear();oTable.fnFilter
        $(".groceryCrudTable thead input").each(function () {
            $(this).val('');
            oTable.fnFilter('', parseInt($(this).attr('data-index')));
        });
    });

    loadListenersForDatatables();

    $('a.ui-button').on("mouseover mouseout", function (event) {
        if (event.type == "mouseover") {
            $(this).addClass('ui-state-hover');
        } else {
            $(this).removeClass('ui-state-hover');
        }
    });

    $('th.actions').unbind('click');
    $('th.actions>div .DataTables_sort_icon').remove();
    fix_table_size();
});

function loadListenersForDatatables() {

    $('.refresh-data').click(function () {

        location.reload();
     /*  var this_container = $(this).closest('.dataTablesContainer');

        var new_container = $("<div/>").addClass('dataTablesContainer');

        this_container.after(new_container);
        this_container.remove();

        $.ajax({
            url: $(this).attr('data-url'),
            success: function (my_output) {
                new_container.html(my_output);

                loadDataTable(new_container.find('.groceryCrudTable'));

                loadListenersForDatatables();
                after_draw_callback();
            }
        });
        */
    });
}



function loadDataTable(this_datatables) {
    return oTable = $(this_datatables).dataTable({
        "iDisplayLength": default_per_page,
        "responsive": true,
        "stateSave": true,
        //"sPaginationType": "full_numbers",
        //"bStateSave": true,
        ///"scrollX": true,
        "stateSaveCallback": function (oSettings, oData) {
            localStorage.setItem('DataTables_' + unique_hash, JSON.stringify(oData).replace('columns', 'colunms_disable'));
        },
        "stateLoadCallback": function (oSettings) {
            return JSON.parse(localStorage.getItem('DataTables_' + unique_hash));
        },
        
        "iDisplayLength": default_per_page,
		"aaSorting": datatables_aaSorting,
        "fnInitComplete": function () {
            if (oSpecial !== 0) {
                this.fnSetColumnVis(oSpecial, false);
            }
            ;
        },
        "oLanguage": {
            "sProcessing": list_loading,
            "sLengthMenu": show_entries_string,
            "sZeroRecords": list_no_items,
            "sInfo": displaying_paging_string,
            "sInfoEmpty": list_zero_entries,
            "sInfoFiltered": filtered_from_string,
            "sSearch": search_string + ":",
            "oPaginate": {
                "sFirst": paging_first,
                "sPrevious": paging_previous,
                "sNext": paging_next,
                "sLast": paging_last
            }
        },

        createdRow: function (row, data, dataIndex) {
            on_create_process(row, data);
        },

        "bDestory": true,
        "bRetrieve": true,
        "buttons": bButtons,
        "fnDrawCallback": function () {
            after_draw_callback();

        },
        "dom": '<"card-body"B<"float-right"f>t><"card-footer"lr<"float-right"p>i>'
    });
}

function datatables_get_chosen_table(table_as_object) {
    //chosen_table_index = oTableMapping[table_as_object.attr('id')];
    return oTable;//Array[chosen_table_index];
}

function reset_dataTable_filters(){
    

}

function delete_row(delete_url, row_id) {
    bootbox.confirm({
        message: message_alert_delete,
        buttons: {
            confirm: {
                label: list_delete + ' <i class="fas fa-trash-alt"></i>',
                className: 'btn-danger'
            },
            cancel: {
                label: list_cancel + ' <i class="fas fa-times"></i>',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    url: delete_url,
                    dataType: 'json',
                    success: function (data) {
                        if (data.success) {
                            chosen_table = datatables_get_chosen_table($('tr#row-' + row_id).closest('.groceryCrudTable'));

                            $('tr#row-' + row_id).addClass('row_selected');
                            var anSelected = fnGetSelected(chosen_table);
                            chosen_table.fnDeleteRow(anSelected[0]);
                            $(".refresh-data").trigger("click");
                        } else {
                            error_message(data.error_message);
                        }
                    }
                });
            }
        }
    });
    return false;
}

function fnGetSelected(oTableLocal) {
    var aReturn = new Array();
    var aTrs = oTableLocal.fnGetNodes();

    for (var i = 0; i < aTrs.length; i++) {
        if ($(aTrs[i]).hasClass('row_selected')) {
            aReturn.push(aTrs[i]);
        }
    }
    return aReturn;
}



$(window).on('resize', function () {
    //ok, I will wait all animations end
    $(window).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", fix_table_size);
});

function on_create_process(row, data) {
    if (oSpecial == null) {
        $(row).closest('div').find('thead')
            .find('input[data-index]')
            .each(function (e) {
                var a = $(this);
                var name = a.attr('name');
                if (name == 'jobStatus') {
                    oSpecial = a.attr('data-index')
                }
            });
    }
    if (oSpecial == null) {
        oSpecial = 0;
    }
    if (oSpecial in data) {
        if (data[oSpecial] == "red") {
            $(row).addClass('tr-red');
        } else if (data[oSpecial] == "green") {
            $(row).addClass('tr-green');
        } else if (data[oSpecial] == "yellow") {
            $(row).addClass('tr-yellow');
        } else if (data[oSpecial] == "blue") {
            $(row).addClass('tr-blue');
        } else {
            $(row).addClass("tr-gray");
        }
    }
}

function after_draw_callback() {
    //If there is no thumbnail this means that the fancybox library doesn't exist
    if ($('.image-thumbnail').length > 0) {
        $('.image-thumbnail').fancybox({
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 600,
            'speedOut': 200,
            'rotate': true,
            'buttons': [
                "zoom",
                "share",
                "slideShow",
                "fullScreen",
                "download",
                "thumbs",
                "close"
            ]
        });
    }
    $('.add-menu-class').each(function (e) {
        var sID = $(this).attr('data-row');
        var tmod = $('#row-' + sID + ' div.d-none a.black-text').text($(this).text());
        var timpH = $('#row-' + sID + ' div.d-none').html();
        $(this).html(timpH).attr('class', 'dropdown').removeAttr('data-row');
    });
    // $('td>div.invisible').remove();

    add_edit_button_listener();


    if (!$('.more-searchOption').length) {
        $('.dataTables_filter').addClass('d-inline').parent().append(' <a class="more-searchOption btn btn-default d-inline"><i class="fas fa-search-plus"></i></a>');
        $('.more-searchOption').click(function () {
            if ($('#multiSearchToggle').prop('hidden')) {
                $('#multiSearchToggle').prop('hidden', null);
                fix_table_size();
            } else {
                $('#multiSearchToggle').prop('hidden', true);
                fix_table_size();
            }
        });
        $('.dataTables_length').addClass('d-inline').append('&emsp;&emsp;');
        $('.dataTables_info').addClass('d-inline').append('&emsp;');
        setTimeout(function () {
            $(document).ready(function () {
                $('table.groceryCrudTable').removeClass('invisible');
            });
        }, 200);
    }
}

$(document).ready(function (l) {
    $('.ci_btOn').html(function (e) {
        $(this).parent().html('<span class="fas fa-check ci_btOn" style="color:#00a65a"><b class="invisible">' +
            $(this).text() + '</b></span>');
    });
    $('.ci_btOff').html(function (e) {
        $(this).parent().html('<span class="fas fa-times ci_btOff" style="color:#f56954"><b class="invisible">' +
            $(this).text() + '</b></span>');
    });
});

//Fancybox Hack https://github.com/fancyapps/fancybox/issues/1100#issuecomment-462074860 to add Rotate
var RotateImage = function (instance) {
    this.instance = instance;

    this.init();
};

$.extend(RotateImage.prototype, {
    $button_left: null,
    $button_right: null,
    transitionanimation: true,

    init: function () {
        var self = this;
        self.$button_right = $('<button data-rotate-right class="fancybox-button fancybox-button--rotate" title="">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
            '  <path d="M11.074,9.967a4.43,4.43,0,1,1-4.43-4.43V8.859l5.537-4.43L6.644,0V3.322a6.644,6.644,0,1,0,6.644,6.644Z" transform="translate(10.305 1) rotate(30)"/>' +
            '</svg>' +
            '</button>')
            .prependTo(this.instance.$refs.toolbar)
            .on('click', function (e) {
                self.rotate('right');
            });
        self.$button_left = $('<button data-rotate-left class="fancybox-button fancybox-button--rotate" title="">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
            '  <path d="M11.074,6.644a4.43,4.43,0,1,0-4.43,4.43V7.752l5.537,4.43-5.537,4.43V13.289a6.644,6.644,0,1,1,6.644-6.644Z" transform="translate(21.814 15.386) rotate(150)"/>' +
            '</svg>' +
            '</button>')
            .prependTo(this.instance.$refs.toolbar)
            .on('click', function (e) {
                self.rotate('left');
            });


    },

    rotate: function (direction) {
        var self = this;
        var image = self.instance.current.$image[0];
        var angle = parseInt(self.instance.current.$image.attr('data-angle')) || 0;

        if (direction == 'right') {
            angle += 90;
        } else {
            angle -= 90;
        }

        if (!self.transitionanimation) {
            angle = angle % 360;
        } else {
            $(image).css('transition', 'transform .3s ease-in-out');
        }

        self.instance.current.$image.attr('data-angle', angle);

        $(image).css('webkitTransform', 'rotate(' + angle + 'deg)');
        $(image).css('mozTransform', 'rotate(' + angle + 'deg)');
    }

});

function fix_table_size_real() {
   
        // put table in oversize
        $('table.groceryCrudTable').first().attr('style', 'width: ' + parseInt($('div.dataTablesContainer').first().width() - 40) + 'px');
        // fit table
        oTable.fnAdjustColumnSizing();
        // redraw table
        oTable.fnDraw();
}

function fix_table_size(force = false, timeout = 0) {
    if (!oResizeLauched || force) {
        if (!force) oResizeLauched = true;
        setTimeout(function () {
            $(window).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", fix_table_size_real);
            fix_table_size_real();
            if (!force) oResizeLauched = false;
        }, timeout);
    }
}

$(document).on('onInit.fb', function (e, instance) {
    if (!!instance.opts.rotate) {
        instance.Rotate = new RotateImage(instance);
    }
});

$(document).on('collapsed.lte.pushmenu', fix_table_size);
$(document).on('shown.lte.pushmenu', fix_table_size);
