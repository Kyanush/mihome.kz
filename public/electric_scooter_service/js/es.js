/*
/*
/*
es_resize_elements_with_parent_height()
es_resize_absolute_square()
es_exchange_element_positions(el1,el2)
es_isValidDate(s)
es_getAnswer(data,par_name)
es_show_bg(bg_color)
es_remove_bg()
es_move_temp_window_element_back(element)
es_close_temp_window()
es_AppendToTempModuleWindow(element)
es_FitTempWindowOnDisplay()
es_show_temp_window(element,properties)
es_IsEmail(EmailName)
minimize_es_placeholder_area(placeholder_area)
build_es_placeholder_area(parent_field)
show_es_placeholders()
*/

function es_parallax_height_settings()
{
    jQuery('.es_parallax')
        .each(
            function(index, element)
            {
                es_parallax_height_percentage     = jQuery(this).attr('es_parallax_height_percentage');
                if (typeof es_parallax_height_percentage == 'undefined')
                {
                    es_parallax_height_percentage = jQuery(this).attr('class');
                    if (es_parallax_height_percentage.indexOf('es_parallax_height_percentage-')>-1)
                    {
                        es_parallax_height_percentage = es_parallax_height_percentage.substr(es_parallax_height_percentage.indexOf('es_parallax_height_percentage-'));
                        if (es_parallax_height_percentage.indexOf(' ')>-1)
                            es_parallax_height_percentage = es_parallax_height_percentage.substr(0,es_parallax_height_percentage.indexOf(' '))
                        es_parallax_height_percentage = es_parallax_height_percentage.substr(es_parallax_height_percentage.indexOf('-')+1);
                    }
                }
                if (es_parallax_height_percentage)
                {
                    es_parallax_height = (window.innerWidth/100)*es_parallax_height_percentage;
                    es_prallax_parrent_div = jQuery(this).parents('div').first();
                    jQuery(es_prallax_parrent_div)
                        .height(es_parallax_height);
                }
            });


}

function es_parallax_switch_on()
{
    jQuery('.es_parallax')
        .each(
            function(index, element)
            {
                es_element_position_top = jQuery(element).offset().top;

                jQuery(this)
                    .css('position','absolute')
                    .css('z-index',-1)
                    .css('width','100%')
                    .attr('es_paralax_initial_position_top',es_element_position_top);

                jQuery(window)
                    .scroll(
                        function()
                        {
                            es_paralax_initial_position_top = Number(jQuery(element).attr('es_paralax_initial_position_top'));
                            window_scrollTop = jQuery(window).scrollTop();
                            es_element_top = ((window_scrollTop/100)*50)+es_paralax_initial_position_top;
                            jQuery(element)
                                .css('top',es_element_top)
                        });
            });

}


function es_parallax()
{
    if (window.innerWidth>400)
    {
        es_parallax_height_settings();

        es_parallax_switch_on();

        jQuery(window)
            .resize(
                function()
                {
                    es_parallax_height_settings();
                });
    }
}

function es_resize_elements_with_parent_height()
{
    jQuery('.es_parent_height')
        .each(
            function(index, element)
            {
                parent_selector = jQuery(this).attr('parent_selector');
                if(typeof parent_selector == 'undefined')
                    parent_selector = '';
                if (parent_selector!='')
                {
                    parent_element = jQuery(this).parents(parent_selector).first();
                }
                else
                {
                    parent_element = jQuery(this).parent();
                }
                parent_innerHeight = jQuery(parent_element).innerHeight();
                jQuery(this).height(parent_innerHeight);
            }
        );
}

function es_resize_absolute_square()
{
    jQuery('.es_absolute_square')
        .each(
            function(index, element)
            {
                element_width = jQuery(this).width();
                jQuery(this).height(element_width);
            });
}


function es_exchange_element_positions(el1,el2)
{


    jQuery(el1)
        .clone()
        .insertAfter(el1)
        .css('visibility','hidden');

    jQuery(el1)
        .css('left',jQuery(el1).position().left)
        .css('top', jQuery(el1).position().top)
        .css('position','absolute')
        .css('background','#CCC')
        .addClass('es_temp_element');

    jQuery(el2)
        .clone()
        .insertAfter(el2)
        .css('visibility','hidden');

    jQuery(el2)
        .css('left',jQuery(el2).position().left)
        .css('top', jQuery(el2).position().top)
        .css('position','absolute')
        .css('background','#CCC')
        .addClass('es_temp_element');

    jQuery(el1)
        .animate({
            left : jQuery(el2).position().left,
            top  : jQuery(el2).position().top
        },1000);

    jQuery(el2)
        .animate({
                left : jQuery(el1).position().left,
                top  : jQuery(el1).position().top
            },1000,
            function()
            {

            });

}

function es_isValidDate(s)
{
    var bits = s.split('.');
    var d = new Date(bits[2], bits[1] - 1, bits[0]);
    return d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]);
}



function es_getAnsware(data,par_name)
{
    start_pos = data.indexOf('['+par_name+']');
    final_pos = data.indexOf('[/'+par_name+']');
    if ((final_pos>start_pos)&&((start_pos==-1)||(final_pos==-1)))
    {
        return false;
    }else
    {
        par_length = par_name.length;
        start_pos  = start_pos + par_length+2;
        sub_lengt  = final_pos - start_pos;
        result = data.substr(start_pos,sub_lengt);
        return result;
    }
}

function es_getAnswer(data,par_name)
{
    return es_getAnsware(data,par_name);
}


function es_getAnswer(data,par_name)
{
    return es_getAnsware(data,par_name);
}
function es_show_bg(bg_color)
{
    if (jQuery('#es_bg').length==0)
    {
        jQuery('html,body').css('overflow','hidden');
        jQuery('body').first().append('<div id="es_bg"></div>');
        jQuery('#es_bg').css('position','fixed')
            .css('background','rgba(0,0,0,0.5)')
            .css('width',window.innerWidth+'px')
            .css('height',window.innerHeight+'px')
            .css('left','0px')
            .css('top','0px')
            .css('z-index','100');
    }
}

function es_remove_bg()
{
    jQuery('#es_bg')
        .animate({opacity:'0'},700,
            function()
            {
                jQuery('#es_bg').remove();
            });
    jQuery('html,body').css('overflow','visible');
}

function es_move_temp_window_element_back(element)
{
    tw_name = jQuery(element).attr('tw_name');
    old_element_place = jQuery('#'+tw_name);
    jQuery('#es_temp_window')
        .find('[tw_name="'+tw_name+'"]')
        .insertBefore(old_element_place);
    jQuery(old_element_place).remove();
}

function es_close_temp_window()
{
    jQuery('#es_temp_window')
        .animate({opacity:'0'}, 100,
            function()
            {
                on_close_action = jQuery(this).attr('on_close_action');
                if (on_close_action)
                    eval(on_close_action);

                jQuery('#es_temp_window')
                    .find("[tw_name]")
                    .each(
                        function(index, element)
                        {
                            es_move_temp_window_element_back(this);
                            content_hiding_way = jQuery(this).attr('content_hiding_way');
                            if (content_hiding_way == 'display')
                            {
                                jQuery(this).css('display','none');
                                jQuery(this).removeAttr('content_hiding_way');
                            }

                        });
                jQuery('#es_temp_window').remove();


            });
    es_remove_bg();
}

function es_AppendToTempModuleWindow(element)
{
    jQuery(element).before('<div id="'+tw_name+'" tw_name="'+tw_name+'"></div>');
    jQuery(element).attr('tw_name',tw_name);
    jQuery(element).appendTo(jQuery('#es_temp_window'));
}

function es_AppendTempWindow_onCloseAction(on_close_action)
{
    curr_on_close_action = jQuery('#es_temp_window').attr('on_close_action');
    if (typeof curr_on_close_action == 'undefined')
        curr_on_close_action = '';
    jQuery('#es_temp_window').attr('on_close_action',curr_on_close_action+' '+on_close_action);
}

function es_FitTempWindowOnDisplay()
{

}

function isMobile() {
    return /Android|webOS|iPhone|iPod|iPad|BlackBerry/i.test(navigator.userAgent);
}


function es_show_temp_window(element,properties)
{
    if (jQuery('#es_temp_window').length==0)
    {

        if (typeof properties.content_hiding_way == 'undefined')
            content_hiding_way = '';
        else
            content_hiding_way = properties.content_hiding_way;

        if ((content_hiding_way=='')&&(jQuery(element).css('display')=='none'))
        {
            content_hiding_way='display';
        }

        if (typeof properties.on_close_action == 'undefined')
            on_close_action = '';
        else
            on_close_action = properties.on_close_action;


        maxwidth = properties.maxwidth;
        if (typeof maxwidth == 'undefined')
            maxwidth = '800px';

        if(isMobile())
            maxwidth = '90%';

        background = properties.background;
        if (typeof background == 'undefined')
            background = '#FFF';

        padding = properties.padding;
        if (typeof padding == 'undefined')
            padding = '20px 20px 30px';

        vertical_align = properties.vertical_align;
        if (typeof vertical_align == 'undefined')
            vertical_align = 'middle';

        es_show_bg();
        tw_name = 'tw_'+Math.round(Math.random(1000)*1000)+'_'+Math.floor(Date.now() / 1000);
        jQuery('#es_bg').append('<div id="es_temp_window"></div>');
        jQuery('#es_temp_window')
            .css('background',background)
            .css('max-width',maxwidth)
            .css('width','auto')
            .css('display', 'table')
            .css('border-radius','10px')
            .css('margin','-50px auto 0px auto')
            .css('padding',padding)
            .css('z-index','101')
            .css('opacity','0')
            .attr('original_width','');


        es_AppendTempWindow_onCloseAction(on_close_action);
        es_AppendToTempModuleWindow(element);
        if (jQuery('#es_temp_window #close_button').length==0)
        {
            jQuery('#es_temp_window').prepend('<table width="100%"><tr><td></td><td width="200px" align="right" style="text-align: right;"><div id="close_button">Закрыть X</div></td><tr></table>');
            jQuery('#es_temp_window #close_button')
                .css('display','inline-block')
                .css('cursor','pointer');
        }
        jQuery('#es_bg').css('overflow','scroll');
        jQuery('#es_temp_window #close_button')
            .on('click',function ()
            {
                es_close_temp_window();
            });

        on_open_action = properties.on_open_action;

        if (typeof on_open_action == 'undefined')
        {
            on_open_action = '';
        }
        else
        {
            eval(on_open_action);
        };

        setTimeout(
            function()
            {
                if (vertical_align=='middle')
                {
                    w_h = window.innerHeight;
                    tw_h = jQuery('#es_temp_window').height();
                    if (w_h>tw_h)
                    {
                        new_margin_top = Math.round((((w_h-tw_h)/100)*40))-40;
                    }else
                    {
                        new_margin_top = '40';
                    }
                }

                if (vertical_align=='top')
                {
                    new_margin_top = '40';
                }

                if (content_hiding_way == 'display')
                {
                    jQuery(element)
                        .css('display','')
                        .attr('content_hiding_way',content_hiding_way);

                }

                jQuery('#es_temp_window')
                    .animate(
                        {marginTop:new_margin_top+'px',opacity:'1'},
                        1000,
                        function()
                        {
                            on_open_action2 = properties.on_open_action2;
                            if (typeof on_open_action2 == 'undefined')
                            {
                                on_open_action2 = '';
                            }
                            else
                            {
                                eval(on_open_action2);
                            };
                        });
            },100);
    }
}

function es_IsEmail(EmailName)
{
    regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(EmailName);
}

jQuery( window ).resize(
    function()
    {

        w_h = window.innerHeight;
        w_w = window.innerWidth;
        jQuery( "#es_bg" ).css('width',w_w+'px')
            .css('height',window.innerHeight+'px');
        tw_w = jQuery('#es_temp_window').width();
        tw_h = jQuery('#es_temp_window').height();
        tw_original_width = jQuery('#es_temp_window').attr('original_width');
        if (tw_original_width=='')
        {
            jQuery('#es_temp_window').attr('original_width',tw_w);
        }

        new_width = (w_w-(w_w/5));
        if (w_h>tw_h)
        {
            new_margin_top = Math.round((((w_h-tw_h)/100)*40)) -40;
            jQuery('#es_temp_window').css('margin-top', new_margin_top+'px');
        }
        if (new_width > tw_original_width)
        {
            new_width = tw_original_width;
        }

        jQuery('#es_temp_window').width(new_width);


        //if (tw_original_width)
    });

function minimize_es_placeholder_area(placeholder_area)
{
    jQuery(placeholder_area)
        .animate({marginTop     : '-22px',
            fontSize      : '12px',
            paddingTop    : '0px',
            paddingBottom : '0px',
            paddingLeft   : '0px',
            paddingRight  : '0px'},500);
}

function build_es_placeholder_area(parent_field)
{
    jQuery(parent_field).css('display','');
    es_placeholder = jQuery(parent_field).attr('es_placeholder');
    element = jQuery('<div class="es_placeholder" >'+es_placeholder+'</div>');
    jQuery(element).insertBefore(parent_field);
    jQuery(element).css('position','absolute');
    el_height = jQuery(parent_field).innerHeight();
    display = jQuery(parent_field).css('display');
    jQuery(element)
        .css('font-size',(el_height/2).round()+'px')
        .css('padding',(el_height/5).round()+'px');
    var parent_field = parent_field;
    var es_placeholder_area = jQuery(parent_field).prev('.es_placeholder');
    jQuery(element)
        .on('click',
            function()
            {
                minimize_es_placeholder_area(es_placeholder_area);
                jQuery(parent_field).focus();
            });
    jQuery(parent_field)
        .on('focus',
            function()
            {
                minimize_es_placeholder_area(es_placeholder_area);
            });

}

function show_es_placeholders()
{
    jQuery('input[es_placeholder]')
        .each(
            function(index, elem)
            {
                if (jQuery(this).css('display')!='none')
                    build_es_placeholder_area(elem);
            });
}



jQuery( document )
    .ready(function()
    {
        show_es_placeholders();
        es_parallax();
    });