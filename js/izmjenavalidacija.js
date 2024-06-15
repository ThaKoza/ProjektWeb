
$(function() {
    $("form[name='Dodavanje_clanka']").validate({
      rules: {
        title: {
          required: true,
          maxlength: 30,
          minlength: 5,
        },
        pphoto: {
          required: true,
        },
        content:{
          required: true,
        },
        about:{
            minlength: 10,
            maxlength: 100,
        }

      },
      messages: {
        title: {
          required: "Morate upisati naslov",
          maxlength: "Maksimalno možete upisati 30 znakova",
          minlength: "Minimalno morate upisati 5 znaka",
        },
        pphoto: {
          required: "Morate odabrati sliku",
        },
        content: {
            required: "Morate upisati sadržaj",
        },
        about:{
            minlength: 10,
            maxlength: 100,
        }
     },

      submitHandler: function(form) {
        form.submit();
      }
    });
  });