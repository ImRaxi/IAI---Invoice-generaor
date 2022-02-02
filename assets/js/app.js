
var nopass = false;
var letters = /^[a-zA-Z][a-z\s]*$/;

$( document ).ready(function() {

    if($('#buyer-company-name').val() !== '') {
        $('#buyer-nip').prop('disabled', false);
    }

    if($('#seller-company-name').val() !== '') {
        $('#seller-nip').prop('disabled', false);
    }

    $('#existing-buyer').on('change', function() {
        if($('#existing-buyer').val() !== -1) {
            $('#buyerid').val($('#existing-buyer').val());
        }

        $('#autofill-form').submit();
    })

    $('#existing-seller').on('change', function() {

        if($('#existing-seller').val() !== -1) {
            $('#sellerid').val($('#existing-seller').val());
        }

        $('#autofill-form').submit();
    })

    $('#fv-payment-method').on('change', function() {
        if($(this).val() === '2') {
            $('#fv-account-number').prop('disabled', true);
            $('#fv-account-number').val('');
        } else {
            $('#fv-account-number').prop('disabled', false);
        }
    })

    $('#fv-netto').on('change', function() {
        $('#fv-brutto').val(Math.round((parseInt($(this).val()) + (parseInt($(this).val()) * $('#fv-vat').val())) * 100) / 100)
        $('#fv-vat-price').val(Math.round((parseInt($(this).val()) * $('#fv-vat').val()) * 100) / 100)
    })

    $('#fv-brutto').on('change', function() {
        $('#fv-netto').val(Math.round((parseInt($(this).val()) - (parseInt($(this).val()) * $('#fv-vat').val())) * 100) / 100)
        $('#fv-vat-price').val(Math.round((parseInt($(this).val()) * $('#fv-vat').val()) * 100) / 100)
    })

    $('#fv-vat').on('change', function() {
        $('#fv-netto').val('');
        $('#fv-brutto').val('');
        $('#fv-vat-price').val('');
    })

    $('#buyer-company-name').on('keyup', function() {
        if($('#buyer-company-name').val() === '') {
            $('#buyer-nip').prop('disabled', true);
            $('#buyer-nip').val('')
        } else {
            $('#buyer-nip').prop('disabled', false);
        }
    })

    $('#buyer-postcode').on('keyup', function() {
        if($(this).val().length === 2) {
            $('#buyer-postcode').val($('#buyer-postcode').val() + '-')
        }
    })

    $('#seller-company-name').on('keyup', function() {
        if($('#seller-company-name').val() === '') {
            $('#seller-nip').prop('disabled', true);
            $('#seller-nip').val('')
        } else {
            $('#seller-nip').prop('disabled', false);
        }
    })

    $('#seller-postcode').on('keyup', function() {
        if($(this).val().length === 2) {
            $('#seller-postcode').val($('#seller-postcode').val() + '-')
        }
    })

    $('#fv-submit-btn').on('click', function() {
        nopass = false;
        // Dane nabywcy
        verifyLetters($('#buyer-name'), 3);
        verifyLetters($('#buyer-surname'), 3);

        if($('#buyer-company-name').val().includes('\'') || 
            $('#buyer-company-name').val().includes('\"') || 
            $('#buyer-company-name').val().includes('\-')) {
                mark($('#buyer-company-name'), false)
                nopass = true
        } else {
            mark($('#buyer-company-name'), true)
        }

        if($('#buyer-company-name').val() !== '') {
            if($('#buyer-nip').val().length !== 10 || !$.isNumeric($('#buyer-nip').val())) {
                mark($('#buyer-nip'), false)
                nopass = true
            } else {
                if(isValidNip(parseInt($('#buyer-nip').val()))) {
                    mark($('#buyer-nip'), true)
                } else {
                    mark($('#buyer-nip'), false)
                    nopass = true
                }
            }
        }

        if($('#buyer-address').val().includes('\'') || 
        $('#buyer-address').val().includes('\"') || 
        $('#buyer-address').val() === '' || 
        $('#buyer-address').val().length < 3) {
            mark($('#buyer-address'), false)
            nopass = true
        } else {
            mark($('#buyer-address'), true)
        }

        if($('#buyer-postcode').val().includes('\'') || 
        $('#buyer-postcode').val().includes('\"') || 
        $('#buyer-postcode').val() === '' || 
        $('#buyer-postcode').val().length < 5 || 
        $('#buyer-postcode').val().match(letters)) {
            mark($('#buyer-postcode'), false)
            nopass = true
        } else {
            mark($('#buyer-postcode'), true)
        }

        verifyLetters($('#buyer-city'), 3);

        //Dane sprzedawcy

        verifyLetters($('#seller-name'), 3);
        verifyLetters($('#seller-surname'), 3);

        if($('#seller-company-name').val().includes('\'') || 
            $('#seller-company-name').val().includes('\"') || 
            $('#seller-company-name').val().includes('\-')) {
                mark($('#seller-company-name'), false)
                nopass = true
        } else {
            mark($('#seller-company-name'), true)
        }

        if($('#seller-company-name').val() !== '') {
            if($('#seller-nip').val().length !== 10 || !$.isNumeric($('#buyer-nip').val())) {
                mark($('#seller-nip'), false)
                nopass = true
            } else {
                if(isValidNip(parseInt($('#seller-nip').val()))) {
                    mark($('#seller-nip'), true)
                } else {
                    mark($('#seller-nip'), false)
                    nopass = true
                }
            }
        }

        if($('#seller-address').val().includes('\'') || 
        $('#seller-address').val().includes('\"') || 
        $('#seller-address').val() === '' || 
        $('#seller-address').val().length < 3) {
            mark($('#seller-address'), false)
            nopass = true
        } else {
            mark($('#seller-address'), true)
        }

        if($('#seller-postcode').val().includes('\'') || 
        $('#seller-postcode').val().includes('\"') || 
        $('#seller-postcode').val() === '' || 
        $('#seller-postcode').val().length < 5 || 
        $('#seller-postcode').val().match(letters)) {
            mark($('#seller-postcode'), false)
            nopass = true
        } else {
            mark($('#seller-postcode'), true)
        }

        verifyLetters($('#seller-city'), 3);


        //Dane faktury

        verifyLetters($('#fv-place'));

        if($('#fv-date-issue').val() === '') {
            mark($('#fv-date-issue'), false);
            nopass = true;
        } else {
            mark($('#fv-date-issue'), true);
        }

        if($('#fv-date-sale').val() === '') {
            mark($('#fv-date-sale'), false);
            nopass = true;
        } else {
            mark($('#fv-date-sale'), true);
        }

        verifyLetters($('#fv-merch-name'));
        isNumber($('#fv-amount'));
        isNumber($('#fv-netto'));
        isNumber($('#fv-brutto'));
        
        if($('#fv-payment-method').val() === '1') {
            if($('#fv-account-number').val().length !== 26) {
                mark($('#fv-account-number'), false);
                nopass = true
            } else {
                mark($('#fv-account-number'), true);
            }
        }

        if(!$('#fv-account-number').is(':disabled')) {
            console.log('DASDASD');
            isNumber($('#fv-account-number'));
        }

        $('#fv-vat-price').prop('disabled', false);


        if(!nopass) {
            $('#fv-form').submit();
        }
    })

});

function verifyLetters(div, minChar) {
    var letters = /^[a-zA-Z][a-z\s]*$/;
    if(!div.val().match(letters) || div.val() === '' || div.val().length < minChar) {
        mark(div, false)
        nopass = true
    } else {
        mark(div, true)
    }
}

function mark(div, correct) {
    if(correct) {
        div.removeClass('wrong-input')
        div.addClass('correct-input')
    } else {
        div.removeClass('correct-input')
        div.addClass('wrong-input')
    }
}

function isValidNip(nip) {
    var reg = /^[0-9]{10}$/;

    var digits = ("" + nip).split("");
    var checksum = (6*parseInt(digits[0]) + 5*parseInt(digits[1]) + 7*parseInt(digits[2]) + 2*parseInt(digits[3]) + 3*parseInt(digits[4]) + 4*parseInt(digits[5]) + 5*parseInt(digits[6]) + 6*parseInt(digits[7]) + 7*parseInt(digits[8]))%11;
        
    return (parseInt(digits[9])==checksum);

}

function isNumber(div) {
    if(!$.isNumeric(div.val()) || div.val() === '') {
        mark(div, false);
        nopass = true;
    } else {
        mark(div, true);
    }
}