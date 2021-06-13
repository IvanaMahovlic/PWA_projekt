$(function () {
    $("form[name='unosclanka']").validate({

        rules: {
            name: {
                required: true,
                minlength: 5,
                maxlength: 30

            },
            date:{
                required: true
            },
            summary: {
                required: true,
                minlength: 10,
                maxlength: 100

            },
            article: {
                required: true
            },
            articleImage:{
                required: true
            },
            section:{
                required: true
            }

        },

        messages: {
            name: {
                required: "Ime clanka je obavezno",
                minlength: "Ime clanka mora imati barem 5 slova",
                maxlength: "Ime clanka mora imati najvise 30 slova"

            },
            date:{
                required: "Datum je obavezan"
            },
            summary: {
                required: "Sazetak je obavezan",
                minlength: "Sazetak clanka mora imati barem 10 slova",
                maxlength: "Sazetak clanka mora imati najvise 100 slova"

            },
            article: {
                required: "Tijelo clanka je obavezno"
            },
            articleImage:{
                required: "Slika clanka je obavezna"
            },
            section:{
                required: "Odabir sekcije je obavezan"
            }
        },


        submitHandler: function (form) {
            form.submit();
        }
    });
});