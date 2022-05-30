var mdf_stat_data = new Array();
var mdf_operative_tables = null;
jQuery(".chosen_select").chosen({width: "50%"});
//***
jQuery(function ($) {
    mdf_stat_init_calendars();
});

function mdf_stat_get_request_snippets() {
    //*** assemble request_snippets
    var request_snippets = {};
    request_snippets.meta=jQuery('#mdf_stat_snippet_meta').val();
    request_snippets.tax=jQuery('#mdf_stat_snippet_tax').val();
    return request_snippets;
}

function mdf_stat_calculate() {

    var calendar_from = parseInt(jQuery('#mdf_stat_calendar_from').val(), 10);
    var calendar_to = parseInt(jQuery('#mdf_stat_calendar_to').val(), 10);
    var request_snippets = mdf_stat_get_request_snippets();

    jQuery('#chart_div_1').html("");
    jQuery('#chart_div_1_set').html("");
    jQuery('#woof_stat_print_btn').hide();

    if (calendar_from == 0 || calendar_to == 0) {
        alert(mdf_stat_vars.mdf_stat_sel_date_range);
        return false;
    }



    mdf_stat_data = new Array();
    jQuery('#mdf_stat_get_monitor').html("");
    mdf_stat_process_monitor( mdf_stat_vars. mdf_stat_get_oper_tbls);
    var curr_post_type=jQuery('#mdf_stat_post_type').val();
    var data = {
        action: "mdf_get_operative_tables",
        curr_post_type: curr_post_type,
        calendar_from: calendar_from,
        calendar_to: calendar_to
    };
    jQuery.post(ajaxurl, data, function (tables) {
        tables = jQuery.parseJSON(tables);
        if (tables.length > 0) {
             mdf_stat_process_monitor( mdf_stat_vars. mdf_stat_oper_tbls_prep);
            if (tables.length) {
                 mdf_stat_request_tables_data(0, tables);
            }
        } else {
             mdf_stat_process_monitor( mdf_stat_vars. mdf_stat_done);
            alert( mdf_stat_vars. mdf_stat_no_data);
        }
    });

    return false;
}

function mdf_stat_request_tables_data(index, tables) {
    var calendar_from = parseInt(jQuery('#mdf_stat_calendar_from').val(), 10);
    var calendar_to = parseInt(jQuery('#mdf_stat_calendar_to').val(), 10);
    var curr_post_type=jQuery('#mdf_stat_post_type').val();
    //console.log(index);
    mdf_stat_process_monitor(mdf_stat_vars.mdf_stat_getting_dftbls + ' ' + tables[index] + ' ...');
    var data = {
        action: "mdf_get_stat_data",
        curr_post_type: curr_post_type,
        table: tables[index],
        request_snippets: mdf_stat_get_request_snippets(),
        calendar_from: calendar_from,
        calendar_to: calendar_to
    };
    jQuery.post(ajaxurl, data, function (stat_data) {
        stat_data = jQuery.parseJSON(stat_data);
        mdf_stat_data.push(stat_data);
        //console.log(mdf_stat_data);
        //+++
        if ((index + 1) < tables.length) {
            mdf_stat_request_tables_data(index + 1, tables);
        } else {
            var templ_search=mdf_stat_get_request_snippets();
            if (templ_search.tax === null && templ_search.meta === null) {
                var data = {
                    action: "mdf_get_top_terms",
                    curr_post_type: curr_post_type,
                    mdf_stat_data: mdf_stat_data
                };
                jQuery.post(ajaxurl, data, function (stat_data) {
                    mdf_stat_data = jQuery.parseJSON(stat_data);
                    mdf_stat_process_monitor(mdf_stat_vars.mdf_stat_done);
                    mdf_stat_draw_graphs();
                });
            } else {
               
                mdf_stat_process_monitor(mdf_stat_vars.mdf_stat_done);
                mdf_stat_draw_graphs();
            }
        }
    });
}


function mdf_stat_process_monitor(text) {
    jQuery('#mdf_stat_get_monitor').prepend('<li>' + text + '</li>');
}

function mdf_stat_init_calendars() {
    jQuery(".mdf_stat_calendar").datepicker(
            {
                showWeek: true,
                firstDay: mdf_stat_vars.week_first_day,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                maxDate: 'today',
                //maxDate: new Date(2017, 11 - 1, 30), //comment it, for tests only
                onSelect: function (selectedDate, self) {
                    var date = new Date(parseInt(self.currentYear, 10), parseInt(self.currentMonth, 10), parseInt(self.currentDay, 10), 23, 59, 59);
                    var mktime = (date.getTime() / 1000);
                    var css_class = 'mdf_stat_calendar_from';
                    if (jQuery(this).hasClass('mdf_stat_calendar_from')) {
                        css_class = 'mdf_stat_calendar_to';
                        jQuery(this).parent().find('.' + css_class).datepicker("option", "minDate", selectedDate);
                    } else {
                        jQuery(this).parent().find('.' + css_class).datepicker("option", "maxDate", selectedDate);
                    }
                    jQuery(this).prev('input[type=hidden]').val(mktime);
                }
            }
    );
    jQuery(".mdf_stat_calendar").datepicker("option", "minDate", new Date( mdf_stat_vars.min_year,  mdf_stat_vars.min_month - 1, 1));
    jQuery(".mdf_stat_calendar").datepicker("option", "dateFormat",  mdf_stat_vars.calendar_date_format);
    jQuery(".mdf_stat_calendar").datepicker("option", "showAnim", 'fadeIn');
    //+++
    jQuery('body').on('keyup',".mdf_stat_calendar", function (e) {
        if (e.keyCode == 8 || e.keyCode == 46) {
            jQuery.datepicker._clearDate(this);
            jQuery(this).prev('input[type=hidden]').val("");
        }
    });

    jQuery(".mdf_stat_calendar").each(function () {
        var mktime = parseInt(jQuery(this).prev('input[type=hidden]').val(), 10);
        if (mktime > 0) {
            var date = new Date(mktime * 1000);
            jQuery(this).datepicker('setDate', new Date(date));
        }
    });

}

