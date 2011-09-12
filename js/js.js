$(document).ready(function() {

    $('#getPaymentMethods').click(function(){
        var toLoad = 'ajax.php?page=topUp&amount=' + $('#topUpAmount').val();

        $('#topUpContent').html("<center><img src='img/loading.gif'></center>");

        loadContent();
        
        function loadContent() {
                $('#topUpContent').load(toLoad,'',showNewContent())
        }
        function showNewContent() {
                $('#topUpContent').show('normal');
        }

        return false;
    });

    $('#changePassword').click(function(){
        if ($('#newPassword1').val() != $('#newPassword2').val()) {
            alert('New passwords are not equal');
        } else {
            $('#changePasswordForm').submit();
        }

        return false;
    });

    $('#registration').click(function(){
        if (
            $('#email').val() == '' ||
            $('#phone').val() == '' ||
            $('#firstname').val() == '' ||
            $('#lastname').val() == ''
        ) {
                alert('Some fields are empty.');
        } else {
            $('#registrationForm').submit();
        }

        return false;
    })

    $('#passwordRecovery').click(function(){
        if ($('#email').val() == '') {
                alert('Field is empty.');
        } else {
            $('#passwordRecoveryForm').submit();
        }

        return false;
    })
    
    $('#firstNumber').blur(function() {
        getCallPrice();
    })
    
    $('#secondNumber').blur(function() {
        getCallPrice();
    })
});

function getCallPrice() {
    var firstNumber = $('#firstNumber').val()
    var secondNumber = $('#secondNumber').val()
    
    if (firstNumber != '' && secondNumber != '') {
        $.getJSON(
            'ajaxJSON.php',  
            {firstNumber: firstNumber, secondNumber: secondNumber},  
            function(json) {
                if (json.status == 'ok') {
                    $('#callPrice').attr('value', json.data.price);
                } else {
                    if (json.data.error == 'firstNumber') {
                        $('#firstNumber').attr('class', 'inputError');
                    } else if (json.data.error == 'secondNumber') {
                        $('#secondNumber').attr('class', 'inputError');
                    } else {
                        $('#firstNumber').attr('class', 'inputError');
                        $('#secondNumber').attr('class', 'inputError');
                    }
                }
            }  
        );
    }
}

function setPaymentAmounts() {
    $('#finalAmount').attr('value', finalPaymentAmounts[$('#paymentMethodSelect').val()]);
    $('#finalAmountValue').attr('value', finalPaymentValues[$('#paymentMethodSelect').val()]);
}

function postPaymentForm() {
    if ($('#paymentMethodSelect').val() == '') {
        alert('Payment method is empty!!!');
    } else {
        $('#paymentForm').submit();
    }

    return false;
}