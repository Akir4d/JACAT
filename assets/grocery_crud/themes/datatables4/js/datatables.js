var default_per_page = typeof default_per_page !== 'undefined' ? default_per_page : 25;
var oTable;
var oTableArray = [];
var oTableMapping = [];
var examSS;
var oResizeLauched = false;
var searchTimeout;
var numTemp = 0;
var fixTableTiemout;
var aButtons = [];
var bButtons = [];
var mColumns = [];

$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
    console.log(message);
};

function chooseId(id, type) {
    $('.choose-group-' + id + ' .sel').removeClass('btn-primary').addClass('btn-small  btn-default').removeClass('white');
    $('.choose-group-' + id + ' .' + type).removeClass('btn-small  btn-default').addClass('btn-primary');
    let value = $('.choose-group-' + id).parent().find('input').val();
    if (value.length > 6) {
        let column = getColumn($('.choose-group-' + id).parent());
        $('.choose-group-' + id).parent().unbind('click.DT');
        let compval = getId(column) + value;
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            oTable.fnSortListener($('.choose-group-' + id).parent(), column);
            oTable.api().column(column).search(compval).draw()
        }, 1000);
    }

}

function getId(id) {
    let res = '';
    $('th.th' + id + 'Nu .sel').each((i, e) => {
        if ($(e).hasClass('btn-primary') && e.classList.length == 4) {
            e.classList.forEach((g) => {
                if (g == 'equals' || g == 'greater' || g == 'less') res = g
            })
        }
    });
    switch (res) {
        case 'equals':
            return '=^';
        case 'greater':
            return '>^';
        case 'less':
            return '<^';
    }
    return res;
}

function isDateSupported(dt) {
    var input = document.createElement('input');
    var value = 'a';
    input.setAttribute('type', dt);
    input.setAttribute('value', value);
    return (input.value !== value);
};

function switchId(id) {
    let types = ['datetime-local', 'date', 'month'];
    let target = $('.choose-group-' + id).parent().find('input');
    let index = types.indexOf(target.attr('type'));
    index++;
    if (index == types.length) index = 0;
    if (isDateSupported(types[index])) {
        target.attr('type', types[index]);
    } else {
        target.attr('data-type', types[index]);
    }
    target.val('');
    updateValues(id);
}

function updateValues(id, val = '') {
    let column = getColumn($('.choose-group-' + id).parent());
    updateFilter(column, val);
}

function updateFilter(column, val) {
    clearTimeout(searchTimeout);
    oTable.api().column(column).search(val);
    searchTimeout = setTimeout(() => {
        oTable._fnDraw();
        setTimeout(() => oTable.fnSortListener($('th.th' + column + 'Nu'), column), 300);
    }, 1000);
}

function resetFilters(that) {
    oTable.api().search('');
    $('.groceryCrudTable').find('thead tr th input').val('');
    $('.groceryCrudTable').find('thead tr th').each((i, e) => {
        setTimeout(() => updateFilter(getColumn(e), ''), Math.floor(Math.random() * 10));
    });
}

function resetId(id) {
    $('.choose-group-' + id).parent().find('input').val('');
    updateValues(id);
    chooseId(id, 'equals');
}

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


function color_field(e) {
    setTimeout(() =>
        $('.tid' + e.primary_key_value).parent().parent().addClass('tr-' + e.jobStatus), 200);
}

function getColumn(query) {
    let result = 0;
    $(query).attr('class').split(' ').forEach((e) => {
        if (e.startsWith('th') && e.endsWith('Nu')) result = parseInt(e.replace('th', '').replace('Nu', ''))
    });
    return result;
}



function fix_table_size(force = false, timeout = 200) {
    clearTimeout(fixTableTiemout);
    if (!oResizeLauched || force) {
        if (!force) oResizeLauched = true;
        fixTableTiemout = setTimeout(function() {
            $(window).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", fix_table_size_real);
            fix_table_size_real();
            if (!force) oResizeLauched = false;
        }, timeout + Math.floor(Math.random() * 101));
    }
}



function loadListenersForDatatables() {
    $('.refresh-data').off('click').on('click', refreshTable);
}

function refreshTable() {
    bootbox.hideAll();
    setTimeout(() =>
        oTable._fnDraw(null, false), 1000);
}

function capture_span(input) {
    if (input !== null) {
        let res = JSON.stringify(input.replace((/  |\r\n|\n|\r|\t/gm), "")).replace(/[\\']+/g, '').match(/<span text.+?span>/g);
        if (res === null) {
            return input;
        } else {
            return strip_tags(res[0]);
        }
    } else {
        return '';
    }
}

function strip_tags(input, allowed) {
    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    if (input !== null) {
        return input.replace(commentsAndPhpTags, '').replace(tags, function($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    } else {
        return '';
    }
}

function format_fields(e, name) {
    if (name == "action") return actionButton(e.primary_key_value, e.action_urls);
    let value = e[name];
    if (typeof e[name] === 'object' && e[name] !== null) {
        switch (e[name].t) {
            case 'true_false':
                if (e[name].v !== null) {
                    let val = strip_tags(e[name].v);
                    if (val == 1) {
                        value = actionMenu(e.primary_key_value, '<i class="fas fa-check ci_btOn" style="color:#00a65a"><b class="invisible">1</b></i>', e.action_urls);
                    } else if (val == 0) {
                        value = actionMenu(e.primary_key_value, '<i class="fas fa-times ci_btOff" style="color:#f56954"><b class="invisible">0</b></i>', e.action_urls);
                    } else {
                        value = '';
                    }
                } else {
                    value = e[name].v;
                }
                break;
            default:
                value = actionMenu(e.primary_key_value, (e[name].v !== null) ? e[name].v : '', e.action_urls);
        }
    } else {
        if (value != null && (value.startsWith('<button') || value.startsWith('<a'))) {
            value = value.replaceAll('&nbsp;', ' ').replaceAll('&thinsp;', '&nbsp;');
        } else {
            value = actionMenu(e.primary_key_value, (value !== null) ? value : '', e.action_urls);
        }
    }

    return value;
}

function loadDataTable(this_datatables) {
    return oTable = $(this_datatables).dataTable(tableSettings());
}

function datatables_get_chosen_table(table_as_object) {
    //chosen_table_index = oTableMapping[table_as_object.attr('id')];
    return oTable; //Array[chosen_table_index];
}

function reset_dataTable_filters() {


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
                className: 'btn-small  btn-default'
            }
        },
        callback: function(result) {
            if (result) {
                $.ajax({
                    url: delete_url,
                    dataType: 'json',
                    success: function(data) {
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
    $('.add-menu-class').each(function(e) {
        var sID = $(this).attr('data-row');
        var tmod = $('#row-' + sID + ' div.d-none a.black-text').text($(this).text());
        var timpH = $('#row-' + sID + ' div.d-none').html();
        $(this).html(timpH).attr('class', 'dropdown').removeAttr('data-row');
    });
    // $('td>div.invisible').remove();

    //add_edit_button_listener();


    if (!$('.more-searchOption').length) {
        $('.dataTables_filter').addClass('d-inline').parent().append(`
			&nbsp;<a class="more-searchOption btn btn-default d-inline" data-toggle="tooltip" data-placement="right" title="` + list_search_all + `"><i class="fas fa-search-plus"></i></a>
                    <a class="clear-filtering btn btn-default d-inline" data-toggle="tooltip" data-placement="right" title="` + list_clear_filtering + `">
						<i class="fas fa-eraser"></i>
                    </a>
			`);
        $('.more-searchOption').on('click', () => {
            if (!isDateSupported('month')) $('.dt-ci-input-add .btn-outline-warning').addClass('d-none');
            if (!$('.form-control.dt-ci-input').first().hasClass('d-none')) {
                $('.form-control.dt-ci-input').addClass('d-none');
                $('div.dt-ci-input-add').addClass('d-none').removeClass('d-inline');
                $('br.dt-ci-input-add').addClass('d-none').removeClass('d-block');
                $('hr.dt-ci-input-add').addClass('d-none').removeClass('d-block');
                $('div.dt-ci-input-add-block').addClass('d-none');
            } else {
                $('.form-control.dt-ci-input').removeClass('d-none');
                $('div.dt-ci-input-add').removeClass('d-none').addClass('d-inline');
                $('br.dt-ci-input-add').removeClass('d-none').addClass('d-block');
                $('hr.dt-ci-input-add').removeClass('d-none').addClass('d-block');
                $('div.dt-ci-input-add-block').removeClass('d-none');
            }
            oTable._fnDraw();
        });
        $('.dataTables_length').addClass('d-inline').append('&emsp;&emsp;');
        $('.dataTables_info').addClass('d-inline').append('&emsp;');
        $('.dataTables_length select').append('<option value="-1">∞</option>');
    }
    $('.grocerycrud-container-spinner .progress-bar').css('width', '100%').attr('aria-valuenow', 100);
    setTimeout(() => {
        $('[data-toggle="tooltip"]').tooltip();
        $('.clear-filtering').on('click', () => {
            localStorage.removeItem('DataTables_' + unique_hash);
            localStorage.removeItem('datatables_search_' + unique_hash);
            resetFilters(this);
        });
        $('.grocerycrud-container-spinner').addClass('d-none');
        $('.dataTablesContainer').removeClass('invisible');
    }, 100);

}

//Fancybox Hack https://github.com/fancyapps/fancybox/issues/1100#issuecomment-462074860 to add Rotate
var RotateImage = function(instance) {
    this.instance = instance;

    this.init();
};

$.extend(RotateImage.prototype, {
    $button_left: null,
    $button_right: null,
    transitionanimation: true,

    init: function() {
        var self = this;
        self.$button_right = $('<button data-rotate-right class="fancybox-button fancybox-button--rotate" title="">' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
                '  <path d="M11.074,9.967a4.43,4.43,0,1,1-4.43-4.43V8.859l5.537-4.43L6.644,0V3.322a6.644,6.644,0,1,0,6.644,6.644Z" transform="translate(10.305 1) rotate(30)"/>' +
                '</svg>' +
                '</button>')
            .prependTo(this.instance.$refs.toolbar)
            .on('click', function(e) {
                self.rotate('right');
            });
        self.$button_left = $('<button data-rotate-left class="fancybox-button fancybox-button--rotate" title="">' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
                '  <path d="M11.074,6.644a4.43,4.43,0,1,0-4.43,4.43V7.752l5.537,4.43-5.537,4.43V13.289a6.644,6.644,0,1,1,6.644-6.644Z" transform="translate(21.814 15.386) rotate(150)"/>' +
                '</svg>' +
                '</button>')
            .prependTo(this.instance.$refs.toolbar)
            .on('click', function(e) {
                self.rotate('left');
            });


    },

    rotate: function(direction) {
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
    clearTimeout(fixTableTiemout);
    // put table in oversize
    if ($(window).width() > 720 && oTable._fnVisbleColumns() < 12) {
        $('table.groceryCrudTable').attr('style', 'width: 100%');
        $('table.groceryCrudTable').first().attr('style', 'width: 100%');
    } else {
        $('table.groceryCrudTable').attr('style', 'width: ' + parseInt($('div.dataTablesContainer').first().width() - 40) + 'px');
        $('table.groceryCrudTable').first().attr('style', 'width: ' + parseInt($('div.dataTablesContainer').first().width() - 40) + 'px');
    }
    // fit table
    oTable.fnAdjustColumnSizing();
    // redraw table
    oTable.fnDraw();
}

function setCookieDT(cname, cvalue, hour) {
    let d = new Date();
    let value = (cvalue == false || cvalue == 0) ? 0 : 1;
    d.setTime(d.getTime() + (hour * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = 'DT' + cname.replace(/[^A-Z0-9]/ig, "_") + "=" + value + ";" + expires + ";path=/";
}

function getCookieDT(cname) {
    let name = 'DT' + cname.replace(/[^A-Z0-9]/ig, "_") + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return 1;
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}

function showColumns(index, name, onOff, nofix = false, timeout = 310) {
    //disabled for now
    $('[name=vscolunm' + index + ']').prop('checked', onOff);
    target = 'th.th' + index + 'Nu';
    $(target).removeClass('printable');
    setCookieDT(name, onOff, 2);
    oTable.fnSetColumnVis(index, onOff);
    if (onOff == true) {
        if (!$(target).hasClass('actions')) $(target).addClass('printable');
    }
    if (!nofix) fix_table_size(true, timeout);
    if (!nofix) setTimeout(function() {
        $('tbody td[tabindex]').removeAttr('tabindex');
    }, timeout);
    oTable.fnDraw();
}
//bootbox.setLocale(moment.locale(navigator.language));
function ciBsOnHandler(el) {
    console.log($(el).closest('tr').attr('id'))
};

function ciBsOffHandler(el) {
    console.log($(el).closest('tr').attr('id'))
};
if (!footerCallbackOverride) {
    function footerCallbackOverride(row, data, start, end, display) {};
}
if (!domSettings) {
    var domSettings = '<"card-body"B<"float-right"f>t><"card-footer"lr<"float-right"p>i>';
}

function chooseExportButton(self, e, dt, button, config) {
    if (button[0].className.indexOf('buttons-copy') >= 0) {
        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
    } else if (button[0].className.indexOf('buttons-print') >= 0) {
        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
    }
}

function newexportaction(e, dt, button, config) {
    let self = this;
    if ($('#allPagesExport').prop('checked')) {
        let oldStart = oTable.fnSettings()._iDisplayStart;
        let oldLength = oTable.fnSettings()._iDisplayLength;
        oTable._fnLengthChange(-1);
        dt.one('preXhr', function(e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            dt.one('xhr', (unused1, unused2, unused3, xhr) => {
                xhr.then(() => {
                    chooseExportButton(self, e, dt, button, config);
                    setTimeout(() => {
                        oTable._fnLengthChange(oldLength);
                        data.start = oldStart;
                        dt.ajax.reload(null, false);
                    }, 500);
                })
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload(null, false);
    } else {
        chooseExportButton(self, e, dt, button, config);
    }
}

function changeExport() {

    $(`#allPagesExport`).prop(`checked`, !$(`#allPagesExport`).prop(`checked`));
    if ($(`#allPagesExport`).prop(`checked`)) {
        $(`#allPagesExportText`).attr('title', export_multiple).html('<i class="fas fa-copy"></i>').tooltip('dispose').tooltip();

        $(`#allPagesExport`).parent().removeClass('btn-outline-primary').addClass('btn-primary');
    } else {
        $(`#allPagesExportText`).attr('title', export_single).html('<i class="far fa-file"></i>').tooltip('dispose').tooltip();
        $(`#allPagesExport`).parent().addClass('btn-outline-primary').removeClass('btn-primary');
    }
}