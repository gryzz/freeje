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
});

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