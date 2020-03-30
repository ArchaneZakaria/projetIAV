function form_show_resultst(handler, message_type, message, with_close) {
   switch(message_type){
      case 'danger' :
       case 'success' :
       case 'warning' :
       case 'info' :

    if (handler.hasClass('alert-danger'))
      handler.removeClass('alert-danger');
    if (handler.hasClass('alert-success'))
      handler.removeClass('alert-success');
    if (handler.hasClass('alert-warning'))
      handler.removeClass('alert-warning');
    if (handler.hasClass('alert-info'))
      handler.removeClass('alert-info');

    break;

    default :
         alert('default show');
    break;
  }


  handler.addClass('alert-' + message_type);
    if (handler.find('button').length > 0)
        handler.find('button').remove();
    if (with_close === true)
        handler.prepend('<button type="button" class="close close_by_js">&times;</button>');
    handler.find('span').html(message);
    handler.fadeIn().delay(4000).fadeOut();
    handler.toggleClass('hide', false);


}




function form_btn_reset(btn_handler, btn_class, text_btn_value) {
    btn_handler.removeAttr('disabled');
    if (btn_handler.hasClass('btn-danger'))
        btn_handler.removeClass('btn-danger').addClass(btn_class).attr('value', text_btn_value);
}


function form_hide_result(handler){
    handler.hide();
}



/* loading button*/
function form_btn_loading(btn_handler) {
    btn_handler.attr('disabled', 'disabled');
    /*var btn_class = 'btn-success';
    if (btn_handler.hasClass('btn-default')) {
        btn_class = 'btn-default';
    } else if (btn_handler.hasClass('btn-primary'))
        btn_class = 'btn-primary';
    else if (btn_handler.hasClass('btn-info'))
        btn_class = 'btn-info';
    var results = {
        'text_btn_value': btn_handler.attr('value'),
        'btn_class': btn_class
    };
    btn_handler.removeClass(btn_class).addClass('btn-danger').attr('value', 'Traitement ...');
    return results;*/
    btn_handler.addClass('btn-danger');
}


function loading_img(div_liste){
    var code = '<img class="img-responsive center-block" src="' + site_url + 'assets/img/gif-load.gif" alt="" />';
    $(div_liste).html(code);
}

