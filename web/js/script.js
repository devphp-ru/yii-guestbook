
//предпросмотр сообщения
const seeMessage = function() {
  'use strict';
  $(document).on('click', '.see-message', function() {
    let username = $('#message_form #user_name').val();
    let useremail = $('#message_form #user_email').val();
    let homepage = $('#message_form #homepage').val();
    let text = $('#message_form #text').val();
    if ('' === username || '' === text || '' === useremail) {
      alert('Заполните обязательные поля.');
      return false;
    }

    $('#see-body .see-username').text(username);
    $('#see-body .see-useremail').text(useremail);
    $('#see-body .see-homepage').text(homepage);
    $('#see-body .see-text').text(text);
    $('.see-modal').modal('show');//открытие мод.окна
  });
};

$(document).ready(function() {
  $("#user_form").on('beforeSubmit', function (evtObj) {

    evtObj.preventDefault();
    let $form = $(this);

    $.ajax({
      url: $form.attr('action'),
      type: 'POST',
      data: new FormData(this),
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function (xhr, textStatus, errorObj) {
        //$('#user_preloader').show();
      },
      success: function (response) {
        if (response.success) {
          if (response.success) {
            $('#response').text('Изменения сохранены.');
            setTimeout(function () {
              $('#response').text('');
            }, 1000);
          }
        }
      },
      complete: function (xhr, TextStatus) {
        $('#user_preloader').hide();
      }
    });

    return false;
  });

  //предпросмотр сообщения
  seeMessage();

});

