$(".alert-dismissible").fadeTo(5000, 500).slideUp(500, function () {
    $(".alert-dismissible").alert('close');
});

function getWordCount(wordString) {
    var words = wordString.split(" ");
    words = words.filter(function (words) {
        return words.length > 0
    }).length;
    return words;
}

jQuery.validator.addMethod("wordCount",
    function (value, element, params) {
        var count = getWordCount(value);
        if (count <= params[0]) {
            return true;
        }
    },
    jQuery.validator.format("you can't add more than {0} words")
);

$(function () {
    var report = $('#report');
    if (report.length) {
        report.validate({
            rules: {
                buyer: {
                    required: true,
                    maxlength: 20
                },
                items: {
                    required: true,
                    maxlength: 255
                },
                amount: {
                    required: true,
                    text: false,
                    number: true,
                    maxlength: 10
                },
                buyer_email: {
                    required: true,
                    email: true,
                    maxlength: 50
                },
                receipt_id: {
                    required: true,
                    maxlength: 20
                },
                phone: {
                    required: true,
                    maxlength: 20,
                    text: false,
                    number: true
                },
                city: {
                    required: true,
                    maxlength: 20,
                },
                entry_by: {
                    required: true,
                    text: false,
                    number: true,
                    maxlength: 10
                },
                note: {
                    required: true,
                    wordCount: [30]
                }
            }
        })
    }
})