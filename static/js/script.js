$('.ajaxForm').on('submit', function (event) {
  return validateForm(event.target);
});
$('input,select').on('keyup.formvalidator', function () {
  $(this).removeClass('is-invalid');
});

function validateForm(form) {
  var valid = true;
  $.each($(form).find('input'), function () {
    var validator = $(this).data('validator');
    var value = $(this).val().trim();
    if (this.required && value === '') {
      valid = false;
      showInputError(this, 'This field can not be empty');
      return;
    }
    switch (validator) {
      case 'email':
        var mailReqex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Zа-яА-Я\-0-9]+\.)+[a-zA-Zа-яА-Я]{2,}))$/;
        if (!mailReqex.test(value)) {
          valid = false;
          showInputError(this, 'Incorrect E-mail, please enter your working E-mail');
        }
        break;
      case 'password':
        if (value.length < 6) {
          valid = false;
          showInputError(this, 'Minimum password length is 6 characters');
        }
        break;
      case 'passwordRepeat':
        if (value !== $(this.form).find('[name="' + $(this).data('validatorParams').passwordField + '"]').val()) {
        valid = false;
        showInputError(this, 'Passwords do not match');
        }
        break;
      case 'characters':
        if (!/^[a-zA-Zа-яА-Я0-9 \.]+$/.test(value)) {
          valid = false;
          showInputError(this, 'The field can not contain special characters');
        }
        break;
      case 'image':
        if (this.files.length > 0 && ['image/gif', 'image/jpeg', 'image/png'].indexOf(this.files[0].type) === -1) {
          valid = false;
          showInputError(this, 'Only image files are allowed (gif, jpg, png)');
        }
        break;
    }
  });
  return valid;
}

function showInputError(input, text) {
  text = i18n.validator[text] !== undefined ? i18n.validator[text] : text;
  var container = $(input).parent();
  container.find('.invalid-feedback').remove();
  container.append($('<div></div>', {
    class: 'invalid-feedback'
  }).text(text));
  $(input).addClass('is-invalid');
}