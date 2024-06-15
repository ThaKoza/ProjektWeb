
$(function() {
    $("form[name='Dodavanje_clanka']").validate({
      rules: {
        naslov: {
          required: true,
          maxlength: 63000,
      },
        slika: {
          required: true,
          maxlength: 255,
          
        },
        sadrzaj:{
          required: true,
          maxlength: 63000,
        }
      },
      messages: {
        naslov: {
          required: "Morate upisati naslov",
          maxlength: "Maksimalno možete upisati 63000 karaktera",
        },
        slika: {
          required: "Morate upisati path slike",
          maxlength: "Podržavamo samo do 255 karaktera"
        },
        sadrzaj: {
            required: "Morate upisati sadržaj",
            maxlength: "Maksimalno možete upisati 63000 karaktera",
        },
     },

      submitHandler: function(form) {
        form.submit();
      }
    });
  });