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
