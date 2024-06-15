
$(function() {
    $("form[name='prijava']").validate({
      rules: {
        username: {
          required: true,
          minlength: 3,
          maxlength: 32,
        
      },
        password: {
          required: true,
          
        },
      },

      messages: {
        username: {
          required: "Korisničko ime ne smije biti prazno",
          minlength: "Korisničko ime ne smije biti kraće od 3 znaka",
          maxlength: "Korisničko ime ne smije biti duže od 32 znaka",
        },
        password: {
          required: "Lozinka ne smije biti prazna",
          maxlength: "Lozinka ne smije biti duža od 255 znakova",
        },
     },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });