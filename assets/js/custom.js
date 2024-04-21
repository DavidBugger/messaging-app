
var ip = window.location.host, url;
if (ip == 'localhost' || ip == '::1') {
    url = window.location.protocol + "//" + window.location.host + "/messaging/";
} else {
    url = window.location.protocol + "//" + window.location.host + "/";
}

//set activeMessage to 0 so that activeMessages will only load when a session is active 
sessionStorage.setItem('activeMessage', 0);

let AESkey; // Declare key as a global variable
let AESiv;  // Declare iv as a global variable

document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: url + 'router',
        type: 'GET',
        data: { type: 'Controller::getSecurityKey' },
        dataType: 'json',
        success: function (data) {
            if (data.response_code == 0) {
                AESkey = CryptoJS.enc.Utf8.parse(data.key);
                AESiv = CryptoJS.enc.Utf8.parse(data.iv);

                // Now, key and iv are accessible globally
            }

        }
    });

    // You can access key and iv here, but they may not be set yet
});

// Encryption function

function encryptAES(data) {
    // Ensure that AESkey and AESiv are properly scoped as globals
    const key = CryptoJS.enc.Utf8.parse(AESkey);
    const iv = AESiv;
    // Convert the data to a WordArray object
    const dataWordArray = CryptoJS.enc.Utf8.parse(data);

    // Encrypt data using AES-256-CBC
    const ciphertext = CryptoJS.AES.encrypt(dataWordArray, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.ZeroPadding
    });

    // Convert the ciphertext to a Base64-encoded string
    return ciphertext.toString();
}

// Decryption function
function decryptAES(ciphertext) {
    const key = CryptoJS.enc.Utf8.parse(AESkey);
    const iv = AESiv;
    const decrypted = CryptoJS.AES.decrypt(ciphertext, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.ZeroPadding
    });
    return decrypted.toString(CryptoJS.enc.Utf8);
}

//handle conversion form
function nextpage(url, form) {
    if (url === null) {
        return Toast.fire({ icon: 'error', title: 'Invalid url parameter' });
    }

    // Attach the validation function to the form's submit event
    if (!validateForm(document.getElementById(form))) {
        return false
    }

    window.location.href = url + '?' + httpQueryBuild(form);
}
function prevpage(url, form) {
    if (url === null) {
        return Toast.fire({ icon: 'error', title: 'Invalid url parameter' });
    }

    window.location.href = url + '?' + form;
}

function httpQueryBuild(formId) {
    const formElement = document.getElementById(formId);
    const formData = new FormData(formElement);

    const queryString = new URLSearchParams(formData).toString();

    return objectToBase64(queryString);
}

function httpQueryBuild_main(formId) {
    const formElement = document.getElementById(formId);
    const formData = new FormData(formElement);

    const queryString = new URLSearchParams(formData).toString();

    return encryptAES(queryString, AESkey, AESiv); // Use AESkey and AESiv here
}


function objectToBase64(data) {
    const jsonString = JSON.stringify(data);
    const base64String = btoa(jsonString);
    return base64String;
}
//end of conversion form

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})


function number_format(d) {
    // Format the number with a specific locale and options
    const formattedNumber = new Intl.NumberFormat('en-US', {
        style: 'decimal', // Options: 'decimal', 'percent', 'currency'
        currency: 'USD', // Currency code (if style is 'currency')
        minimumFractionDigits: 2, // Minimum number of decimal places
        maximumFractionDigits: 2, // Maximum number of decimal places
    }).format(d);

    return formattedNumber;
}
// $('select').select2();
// $(document).ready(function (e) {
//     $("#exit-transaction").hide();
//     setTimeout(function () {
//         validateTransactionPIN();
//     }, 5000);
// })

var inactivityTime = function () {
    var time;
    window.onload = resetTimer;
    // DOM Events
    document.onmousemove = resetTimer;
    document.onkeydown = resetTimer;

    function lockscreen() {
        // alert("You are now logged out.")
        // $.blockUI();
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(lockscreen, 3000)
        // 1000 milliseconds = 1 second
    }
};
$(document).ready(() => {
    var str = sessionStorage.getItem('str'),
        divid = sessionStorage.getItem('divid'),
        pagid = sessionStorage.getItem('pageid'), val;
    val = (str == 0) ? 0 : 1;
    document.cookie = "pageid=" + val;
    // return console.log('loading: '+str);
    let pageid = document.cookie;
    if ((str != 0 && str != '0' && str != '' && str != null && str !== 'null')) {
        return getpage(str, divid, pagid);
    }

});


$('.brand, .logout').click(() => {
    sessionStorage.setItem('str', 0);
    sessionStorage.setItem('divid', 0);

    document.cookie = "pageid=0";

})
function anchor(d) {

    sessionStorage.setItem('str', 0),
        sessionStorage.setItem('divid', 0);
    sessionStorage.setItem('pageid', 0);
    document.cookie = "pageid=0";

    window.location = d;

}
function getActiveSession() {
    $.ajax({
        type: "get",
        url: url + 'router',
        data: { type: 'Controller::getActiveSession' },
        success: function (data) {
            if (data.response_code == 0) {
                return true;
            } else {
                window.location = url;
            }
        }
    });
}
function getpage(str, divid, pageid) {
    // getActiveSession();
    sessionStorage.setItem('str', str);
    sessionStorage.setItem('divid', divid);
    sessionStorage.setItem('pageid', pageid);
    document.cookie = "pageid=1";

    if (str != '#') {

        Swal.fire({
            title: 'Loading, please wait...',
            html: 'Ready in <b></b> seconds.',
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Math.round(Swal.getTimerLeft() / 1000)
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        });

        // $.blockUI();

        $.ajax({
            type: "POST",
            url: str,
            data: '',
            error: function (x, t, m) {
                $.blockUI({
                    message: 'Page not found'
                });
                setTimeout(function () { $.unblockUI() }, 2000);
            },
            success: function (msg) {
                setTimeout(function () {
                    $.unblockUI()
                    $('#' + divid).html(msg).animate();

                    $('.account-nav__list li').removeClass('account-nav__item--active');
                    $("#" + pageid).addClass('account-nav__item--active');

                }, 1000);
            }
        });

    }
}
function getdashboardpage(str, divid, pageid) {


    if (str != '#') {

        Swal.fire({
            title: 'Loading, please wait...',
            html: 'Ready in <b></b> seconds.',
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Math.round(Swal.getTimerLeft() / 1000)
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        });

        // $.blockUI();

        $.ajax({
            type: "POST",
            url: str,
            data: '',
            error: function (x, t, m) {
                // $.blockUI({
                //     message: 'Page not found'
                // });
                // setTimeout(function () { $.unblockUI() }, 2000);
            },
            success: function (msg) {
                setTimeout(function () {
                    // $.unblockUI()
                    $('#' + divid).html(msg).animate();

                    $('.account-nav__list li').removeClass('account-nav__item--active');
                    $("#" + pageid).addClass('account-nav__item--active');

                }, 1000);
            }
        });

    }
}
function loadDashboardModal(url, div) {
    getdashboardpage(url, div);
    $("#defaultModalPrimary").modal("show");
}

function getBeneficiary(d) {
    if ($("#account_no").is('input') && $("#account_no").val().length < 10) {
        return false;
    }
    var a = $("#baccount_name");
    a.addClass('loading');

    var data = {
        type: 'Controller::getBeneficiary',
        bank_code: d
    };
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: data,
        dataType: 'json',
        success: function (data) {
            if (data.response_code == 0) {
                setTimeout(() => {
                    a.removeClass('loading');
                    $("#account-name-section").removeClass('hide');
                    $("#account_no").attr('value', data.account_no);
                    $("#baccount_name").attr('value', data.account_name);
                    $("#account_name_1").attr('value', data.account_name);
                }, 5000);
            } else {
                swal_toast("warning", data.response_message)
            }
        },
        error: function () {
            swal_toast("danger", "Something doesn't seem right... Please, try again.")
        }
    })
}

$(document).on('keyup', '#account_no', function (e) {

    if ($(this).val() == "") {
        return false;
    }

    if ($(this).is('input') && $(this).val().length < 10) {
        return false;
    }

    var $t = $(e.currentTarget);
    $t.addClass('loading');
    $("#baccount_name").addClass('loading');
    $('#account_name_1, #baccount_name').val('');
    var data = {
        type: 'Controller::resolveAccountNumber',
        account_number: $(this).val(),
        bank_name: $("#bank_name").val()
    };
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: data,
        dataType: 'json',
        success: function (data) {
            $('.validate-status').hide();
            if (data.response_code == 0) {
                setTimeout(() => {

                    $t.removeClass('loading');
                    $("#account_name_1").removeClass('loading');
                    $("#baccount_name").removeClass('loading');
                    $("#account-name-section").removeClass('hide');

                    $("#account_name_1").prop('value', data.response_message);
                    $("#baccount_name").prop('value', data.response_message);
                    $(".beneficiary-section").show();
                }, 5000);
            } else {
                $(".beneficiary-section").hide();
                swal_toast('warning', data.response_message)
            }
        },
        error: function () {
            swal_toast('danger', "Oops! Something doesn't seem right... Please, try again.");
        }
    })
});


$('#loging-in-btn').hide();
$(document).on('keyup', '#password', function () {
    var password = $('#password').val();
    if (checkStrength(password) == false) {
        $('.signup').attr('disabled', false);
    }
});
$(document).on('blur', '#confirm-password', function () {
    if ($('#password').val() != $('#confirm-password').val()) {
        $('#popover-cpassword').removeClass('hide');
        $('.signup').attr('disabled', true);
    } else {
        $('.signup').removeAttr('disabled');
        $('#popover-cpassword').addClass('hide');
    }
});
$('#email').blur(function () {
    var email = $('#email').val();
    if (IsEmail(email) == false) {
        $('.signup').attr('disabled', true);
        $('#popover-email').removeClass('hide');
    } else {
        $('#popover-email').addClass('hide');
        $('.signup').removeAttr('disabled');
    }
});

$('.signup').hover(function () {
    if ($('.signup').prop('disabled')) {
        $('.signup').popover({
            html: true,
            trigger: 'hover',
            placement: 'below',
            offset: 20,
            content: function () {
                return $('.signup-popover').html();
            }
        });
    }
});

function togglePasswordVisibility(inputId) {
    var passwordInput = document.getElementById(inputId);
    var toggleIcon = document.querySelector("#" + inputId + "+ .toggle-icon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.add("show-password");
        toggleIcon.innerHTML = "<i class='fas fa-eye-slash'></i>";
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("show-password");
        toggleIcon.innerHTML = "<i class='fas fa-eye'></i>";
    }
}

$(document).on('click', '#create_account', function (e) {
    e.preventDefault();
    var payload = $("#register").serialize();
    // alert('hello');
    // alert(payload);
    console.log(url + 'router');
    $.ajax({
        url: url + 'router',
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('#create_account').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            // $('#create-account').html('Register now').attr('disabled', true);

            if (data.response_code == 0) {
                // $('#create-account').html('Register now');
                swal_toast('success', data.response_message);
                // setTimeout(function() {
                //     window.location = "sign-in";
                // }, 3000);

                if (data.verify == 1) {
                    window.location = url + data.page + '?' + data.data //verification

                }

            } else {
                $('.create-account').html('Register now').attr('disabled', false);
                swal_toast('warning', data.response_message);

            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('#create-account').html(' Register').attr('disabled', false);
            swal_toast('danger', 'Ooops! Something went wrong...');

        }
    });
});

$(document).on('click', '#sign_in', function (e) {
    e.preventDefault();
    var payload = $("#login").serialize();

    $.ajax({
        url: url + 'router',
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('#sign-in').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            // return console.log(data);
            if (data.response_code == 0) {
                $('form-bottom').hide();
                $('#sign_in').html('Logged in');
                $('#message-container').html("<i class='align-middle text-success fa fa-user-check'></i> " + data.response_message).addClass('p-2')

                setTimeout(function () {
                    if (data.status == 1) {// main value is 1
                        // window.location = url + 'dashboard/kyc?' + $("#payload").val();
                        window.location = url + 'dashboard/kyc';
                      
                    } else {
                        window.location = url + 'dashboard/?' + $("#payload").val();
                    }

                }, 2000);


            } else if (data.status == 101) {
                window.location = url + data.page + '?' + data.data; //2FA
            } else {
                $('.signin').html(' Login ').attr('disabled', false);
                swal_toast('warning', data.response_message);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('#signin').html(' Login ').attr('disabled', false);

            swal_toast('warning', 'Something went wrong...');
        }
    })
});

$(document).on('click', '.forgot-password', function (e) {

    e.preventDefault();
    var payload = $("#forgot-password").serialize();
    $.ajax({
        url: url + 'router',
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.forgot-password').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        success: function (data) {
            $('.forgot-password').html('Recover password');

            if (data.response_code == 0) {
                $('.msg').html("<i class='align-middle text-success fa fa-user-check'></i> " + data.response_message).addClass('p-2')

            } else {
                swal_toast('warning', data.response_message);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('.forgot-password').html('Recover password');
            swal_toast('danger', 'Something went wrong...');
        }
    })
});

$(document).on('click', '.reset-password', function (e) {

    e.preventDefault();
    var payload = $("#reset-password").serialize();
    $.ajax({
        url: url + 'router',
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.reset-password').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        success: function (data) {
            $('.reset-password').html('Reset password');

            if (data.response_code == 0) {
                swal_toast('success', data.response_message);

                setTimeout(() => {
                    window.location.href = url + 'login';
                }, 2000);

            } else {
                swal_toast('warning', data.response_message);

            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('.reset-password').html('Reset password');

            swal_toast('danger', 'Something went wrong...');

        }
    })
});


$(document).on('click', '.request-payment', function (e) {
    e.preventDefault();

    if ($('input[type="checkbox"]:not(:checked)').length) {
        // The checkbox is not checked
        return swal_toast('warning', 'Please, you need to check the boxes before you can continue');
    }

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Controller::initiateRequest' },
        dataType: 'json',
        beforeSend: function () {
            $('.request-payment').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
        },
        success: function (data) {
            $('.request-payment').html('Request payment');

            if (data.response_code == 0) {
                swal_toast('success', data.response_message);

                const queryString = new URLSearchParams(data.payload).toString();

                payload = objectToBase64(queryString);

                setTimeout(() => {
                    window.location.href = url + 'dashboard/request-submitted?' + payload;
                }, 2000);

            } else {
                swal_toast('warning', data.response_message);
            }
        },
        error: function () {
            $('.request-payment').html('Request payment');
            swal_toast('danger', 'Something went wrong...')

        }
    })
})

$(document).on('click', '.support', function (e) {
    e.preventDefault();

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#support").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.support').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
        },
        success: function (data) {
            $('.support').html('Submit');

            if (data.response_code == 0) {
                swal_toast('success', data.response_message);

                setTimeout(() => {
                    window.location.href = url + 'dashboard/';
                }, 2000);

            } else {
                swal_toast('warning', data.response_message);
            }
        },
        error: function () {
            $('.support').html('Submit');
            swal_toast('danger', 'Something went wrong...')

        }
    })
})


function mfa(d, value) {
    // console.log(value);

    if ($('#' + d).is(':checked')) {
        $.ajax({
            url: url + 'router',
            type: 'post',
            data: { type: 'Controller::secondLayerLogin', is_mfa: value },
            dataType: 'json',
            success: function (data) {
                if (data.response_code == 0) {
                    if (value == 0) {
                        $('.' + d).html('Enable 2-Factor Authentication').show('fast');
                        $('.' + d + '-text').html('Enabling this feature will prompt us to send activate a 2-Layers login feature for your account.').show('fast');
                    } else {
                        $('.' + d).html('Disable 2-Factor Authentication').show('fast');
                        $('.' + d + '-text').html('Disabling this feature will prompt us to deactivate a 2-Layer login feature for your account.').show('fast');
                    }
                    swal_toast('success', data.response_message);
                    location.reload()
                } else {
                    swal_toast('warning', data.response_message);
                }
            }
        })
    } else {

        $.ajax({
            url: url + 'router',
            type: 'post',
            data: { type: 'Controller::secondLayerLogin', is_mfa: value },
            dataType: 'json',
            success: function (data) {
                if (data.response_code == 0) {
                    if (value == 0) {
                        $('.' + d).html('Enable 2-Factor Authentication').show('fast');
                        $('.' + d + '-text').html('Enabling this feature will prompt us to send activate a 2-Layers login feature for your account.').show('fast');
                    } else {
                        $('.' + d).html('Disable 2-Factor Authentication').show('fast');
                        $('.' + d + '-text').html('Disabling this feature will prompt us to deactivate a 2-Layer login feature for your account.').show('fast');
                    }
                    swal_toast('success', data.response_message);
                    location.reload()
                } else {
                    swal_toast('warning', data.response_message);
                }
            }
        })
    }
}

$(document).on('keyup', '.walletInput', function () {

    var input, filter, ul, li, a, i, div;
    input = $(this).val();
    filter = input.toUpperCase();

    div = $(".walletDropdown");
    a = div[0].getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
})

$(document).on('keyup', '.bankInput', function () {

    var input, filter, ul, li, a, i, div;
    input = $(this).val();
    filter = input.toUpperCase();

    div = $(".bankDropdown");
    a = div[0].getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
})

$(document).on('keyup', '.transactionInput', function () {

    var input, filter, ul, li, a, i, div;
    input = $(this).val();
    filter = input.toUpperCase();

    div = $(".transactionDropdown");
    a = div[0].getElementsByClassName("single-user");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
})

function preventFutureDateSelection(d) {
    var datePicker = document.getElementById(d);
    var maxDate = datePicker.getAttribute("max");

    datePicker.addEventListener("input", function () {
        var selectedDate = new Date(this.value);
        var maxAllowedDate = new Date(maxDate);

        // if (selectedDate > maxAllowedDate) {
        //     this.value = maxDate;
        // }
    });
}

function preventPastDates(d) {
    // Get the current date in the format "YYYY-MM-DD"
    const currentDate = new Date().toISOString().split('T')[0];

    // Set the min attribute of the specified input element to the current date
    document.getElementById(d).setAttribute('min', currentDate);
}

$(document).on('click', '.close-md', function () {
    setTimeout(() => {
        $("#defaultModalPrimary").modal("hide");
    }, 3000);
})

$(document).on('click', '.del-benef', function () {
    var id = $(this).data('id'), source = $(this).data('type');
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Controller::deleteBeneficiary', id: id, source: source },
        dataType: 'json',
        beforeSend: function () {
            $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            if (data.response_code == 0) {
                Toast.fire({ icon: 'success', title: data.response_message })
            }
            else {
                Toast.fire({ icon: 'warning', title: data.response_message })
            }
        },
        error: function () {
            Toast.fire({ icon: 'error', title: 'Something went wrong...' })
        }
    })
})

function wallet_beneficiary(name, type) {
    if ($('#' + name).is(':checked')) {
        if (type == 'wallet') {
            $.ajax({
                url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
                type: 'post',
                data: { type: 'Controller::walletBeneficiary', account_no: $("#wallet-account_id").val(), name: $("#wallet-account_name_1").val() },
                dataType: 'json',
                success: function (data) {
                    if (data.response_code == 0) {
                        Toast.fire({ icon: 'success', title: data.response_message });
                        $('.' + name).html(data.response_message).show('fast');
                    } else {
                        Toast.fire({ icon: 'warning', title: data.response_message });
                    }
                }
            })
        } else if (type == 'bank') {

        }
    } else {
        if (type == 'bank') {
            $("#save_as_beneficiary").attr('value', 0);
            $("#beneficiary").attr('value', 0);


        }
    }

}

$(document).on('click', '#bank_beneficiary', function () {
    if ($('#bank_beneficiary').is(':checked')) {

        $("#beneficiary").attr('value', 1);
    } else {
        $("#beneficiary").attr('value', 0);
    }
})
function bank_beneficiary(name, type) {
    if ($('#' + name).is(':checked')) {
        if (type == 'bank') {
            $("#beneficiary").attr('value', 1);
            // $.ajax({
            //     url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
            //     type: 'post',
            //     data: { type: 'Controller::bankBeneficiary', is_beneficiary: 1 },
            //     dataType: 'json',
            //     success: function (data) {
            //         if (data.response_code == 0) {
            //             Toast.fire({ icon: 'success', title: data.response_message });
            //         } else {
            //             Toast.fire({ icon: 'warning', title: data.response_message });
            //         }
            //     }
            // })
        }
    } else {

        if (type == 'bank') {
            $("#beneficiary").attr('value', 0);
        }
    }

}

function validateTransactionPIN() {
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Controller::validatePIN' },
        dataType: 'json',
        success: function (data) {
            $("#pin-setup").attr('value', data.response_message);//transaction pin
            if (data.response_code == 20) {
                $("#transaction-pin-modal").modal("show");//transaction PIN has not been set
            }
        }
    })
}
function validateTransaction() {
    $("#transaction-pin-modal").modal("show");//transaction PIN has not been set

}

function transactionFilters(d) {
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Controller::transactionFilters', status: d },
        dataType: 'html',
        success: function (data) {
            $("#filtered-transaction").html(data);
            if (d != 'all') {
                $(".pagination").hide();
            }
        },
        error: function () {
            Toast.fire({ icon: 'warning', title: 'Something went wrong...' });
        }
    })
}

function copy_text(d) {
    let text = document.getElementById(d).innerHTML;
    const copyContent = async () => {
        try {
            await navigator.clipboard.writeText(text);
            Toast.fire({ icon: 'info', title: 'Copied to clipboard' });

        } catch (err) {
            Toast.fire({ icon: 'error', title: 'Text could not be copied to clipboard' });
        }
    }

    copyContent();
}

function copy_text2(d) {
    // Get the text from the element with the specified ID
    let text = document.getElementById(d).innerHTML;

    // Create a textarea element to temporarily hold the text
    const textarea = document.createElement('textarea');
    textarea.value = text;

    // Append the textarea to the document
    document.body.appendChild(textarea);

    // Select the text in the textarea
    textarea.select();

    try {
        // Copy the selected text to the clipboard
        document.execCommand('copy');
        swal_toast('info', 'Copied to clipboard');
        // Optionally, you can display a message to the user
        // alert('Text copied to clipboard');
    } catch (err) {
        swal_toast('dabger', 'Text could not be copied to clipboard');

        console.error('Error: ' + err);
        // Handle the error as needed
    } finally {
        // Clean up by removing the textarea
        document.body.removeChild(textarea);
    }
}

$(document).on('click', '.initiate-pin', function (e) {
    e.preventDefault();
    var trn = $(this).data('wallet');
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Controller::validatePIN' },
        dataType: 'json',
        beforeSend: function () {
            $(this).html('<i class="fa fa-spinner"></i>');
        },
        success: function (data) {
            if (data.response_code == 0) {
                return validateTransaction();
            } else {
                if (trn == 'bank') {

                    $("#transaction-pin-modal").modal("show");//transaction PIN has not been set
                }
            }
        }
    })
})
// Capture deposit amount
$(document).on('keyup', '#youSend', function () {
    $('#amount').attr('value', $(this).val());
})
// Capture deposit amount ends
// Transaction PIN Begins
$('.digit-group').find('input').each(function () {
    $(this).attr('maxlength', 1);
    $(this).on('keyup', function (e) {
        var parent = $($(this).parent());

        if (e.keyCode === 8 || e.keyCode === 37) {
            var prev = parent.find('input#' + $(this).data('previous'));

            if (prev.length) {
                $(prev).select();
            }
        } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) ||
            (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
            var next = parent.find('input#' + $(this).data('next'));

            if (next.length) {
                $(next).select();
            } else {

                if (parent.data('autosubmit')) {
                    parent.submit();
                }
            }
        }
    });
});

$(document).on('keyup', '#tpin-6', function (e) {
    var tpin = $('#tpin-1,#tpin-2,#tpin-3,#tpin-4,#tpin-5').map(function () { return $(this).val(); }).get().join('');

    if (!tpin.match(/^\d{5}$/)) {
        return false;
    }

    if ($('#pin-setup').val() == '1') {
        if ($('#pin-1').val() == '') {
            $('#pin-1').val(tpin);
            $('.transaction-pin-text').html('Confirm Transaction PIN');
            $('#tpin-1,#tpin-2,#tpin-3,#tpin-4,#tpin-5,#tpin-6').fadeIn('slow').val('').filter(':first').focus();
            return false;
        } else if ($('#pin-2').val() == '') {
            $('#pin-2').val(tpin);
        }
    }

    if ($(this).val() == '') {
        return false;
    }

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $('#hci-csrf-token-label').val(),
        type: 'post',
        data: $('#mtransaction-pin').serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('#loging-in-btn').show();
        },
        success: function (data) {
            $('#loging-in-btn').hide();
            if (data.response_code == 0) {
                if ($('#pin-setup').val() == '1') {
                    Toast.fire({ icon: 'success', title: data.response_message });
                    setTimeout(function () {
                        $('#transaction-pin-modal').modal('hide');
                    }, 2000);
                } else {
                    return initiateTransfer();
                }
            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('#loging-in-btn').hide();
            $('.msg').html('<div class="alert alert-danger alert-outline alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><div class="alert-icon"><i class="far fa-fw fa-bell"></i></div><div class="alert-message"><strong>Alert!' + "\n" + '</strong>' + xhr.status + ' ' + thrownError + '</div></div>');
        }
    });
});

// Transaction PIN Ends

$(document).on("click", ".initiate-transfer", function (e) {
    $("#transaction-pin-modal").modal("show");//enter transaction pin
})

function initiateTransfer() {

    payload = $("#form-send-money").serialize();

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.validate-payout').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $("#tpin-1").val('');
            $("#tpin-2").val('');
            $("#tpin-3").val('');
            $("#tpin-4").val('');
            $("#tpin-5").val('');
            $("#tpin-5").val('');
            $("#tpin-6").val('');
            $("#pin-1").val('');
            $('#loging-in-btn').hide();

            if (data.response_code == 0) {
                setTimeout(function () {
                    $("#transaction-pin-modal").modal("hide");//close transaction pin modal
                    getpage('send-money-success?id=' + data.reference, 'page', '3');
                    // getpage('send-money-success?' + payload, 'page', '3');
                }, 3000);
            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
                $("#transaction-pin-modal").modal("hide");//transaction PIN has not been set

            }
        }
    })

}

$(document).on("click", ".validate-payout", function (e) {
    e.preventDefault()
    var sect = $(this).data('type'), payload;
    payload = $("#" + sect + "-transfer").serialize();

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.validate-payout').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            if (data.response_code == 0) {
                setTimeout(function () {
                    getpage('send-money-confirm?' + payload, 'page', '3');
                }, 3000);
            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        }
    })
})

$(document).on("click", ".security-questions", function (e) {
    e.preventDefault()

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#securityQuestions").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.security-questions').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $('.security-questions').html('Save');
            if (data.response_code == 0) {
                $("#securityQuestions").reset();
                Toast.fire({ icon: 'success', title: data.response_message });
                setTimeout(() => {
                    $("#change-security-questions").modal('hide');
                }, 5000);

            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        },
        error: function () {
            $('.security-questions').html('Save');
            Toast.fire({ icon: 'error', title: 'Something went wrong...' });
        }
    })
})
$(document).on("click", ".notification-setup", function (e) {
    e.preventDefault()

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#notifications").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.notification-setup').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $('.notification-setup').html('Save Changes');
            if (data.response_code == 0) {
                swal_toast('success', data.response_message);
                setTimeout(() => {
                    location.reload()
                }, 2000);

            } else {
                swal_toast('warning', data.response_message);
            }
        },
        error: function () {
            $('.notification-setup').html('Save Changes');
            swal_toast('danger', 'Something went wrong...');
        }
    })
})
$(document).on("click", ".save-timezone", function (e) {
    e.preventDefault()

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#save-timezone").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.save-timezone').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $('.save-timezone').html('Save Changes');
            if (data.response_code == 0) {
                Toast.fire({ icon: 'success', title: data.response_message });
                setTimeout(() => {
                    $('#edit-account-settings').modal('hide');
                }, 2000);

            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        },
        error: function () {
            $('.save-timezone').html('Save Changes');
            Toast.fire({ icon: 'error', title: 'Something went wrong...' });
        }
    })
})
$(document).on("click", ".update-mobile_phone", function (e) {
    e.preventDefault()

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#update-mobile_phone").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.update-mobile_phone').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $('.update-mobile_phone').html('Save Changes');
            if (data.response_code == 0) {
                Toast.fire({ icon: 'success', title: data.response_message });
                setTimeout(() => {
                    $('#edit-phone').modal('hide');
                }, 2000);

            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        },
        error: function () {
            $('.update-mobile_phone').html('Save Changes');
            Toast.fire({ icon: 'error', title: 'Something went wrong...' });
        }
    })
})
$(document).on("click", ".personaldetails", function (e) {
    e.preventDefault()

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#personaldetails").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.personaldetails').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $('.personaldetails').html('Save Changes');
            if (data.response_code == 0) {
                swal_toast('success', data.response_message);
                setTimeout(() => {
                    $('#edit-personal-details').modal('hide');
                }, 2000);

            } else {
                swal_toast('warning', data.response_message);
            }
        },
        error: function () {
            $('.personaldetails').html('Save Changes');
            swal_toast('success', 'Something went wrong...');
        }
    })
})

$(document).on('change', '#bank_name', function (e) {
    var selected = $(this).children('option:selected').text();
    $("#bank").attr('value', selected);
})

$(document).on("click", ".add-account-no", function (e) {
    e.preventDefault()
    var payload = $("#add-account-no").serialize();

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.add-account-no').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            if (data.response_code == 0) {
                Toast.fire({ icon: 'success', title: data.response_message });

                setTimeout(function () {
                    $("#defaultModalPrimary").modal('hide');
                }, 3000);
            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        }
    })

})
$(document).on("click", ".add-card-details", function (e) {
    e.preventDefault()
    var payload = $("#add-card-details").serialize();
    var credit_card = 'type=Controller::manageCardDetails&id=' + $("#id").val() + '&issuer_info=' + $("#issuer_info").val() + '&issuing_country=' + $("#issuing_country").val() + '&action=' + $("#action").val() + '&card_number=' + $("#card_number").val() + '&valid_thru=' + $("#expiryDate").val() + '&card_holder=' + $("#card_holder").val() + '&card_type=' + $("#card_type").val() + '&card_cvv=' + $('#card_cvv').val();

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.add-card-details').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            if (data.response_code == 0) {

                sessionStorage.setItem('otp-text', data.response_message);
                $('#flw_ref').attr('value', data.flw_ref);
                $('#require_credit').attr('value', 0);
                loadModal('otp?info=' + data.response_message + '&ref=' + data.flw_ref + '&require_credit=0&' + credit_card, 'modal_div');

            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        }
    })

})

$(document).on("click", ".update-password", function (e) {
    e.preventDefault()
    var payload = $("#update-password").serialize();

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.update-password').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            if (data.response_code == 0) {
                Toast.fire({ icon: 'success', title: data.response_message });

                setTimeout(function () {
                    $("#defaultModalPrimary").modal('hide');
                }, 3000);

                Swal.fire({
                    title: data.remark,
                    html: 'Ready in <b></b> seconds.',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Math.round(Swal.getTimerLeft() / 1000)
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {

                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location = url + 'logout'; //log me out
                        console.log('I was closed by the timer')
                    }
                });
            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
                $('.update-password').html('Update password');

            }
        },
        error: function () {
            $('.update-password').html('Update password');
            Toast.fire({ icon: 'error', title: 'Something went wrong...' });
        }
    })

})


$(document).on('input', '#expiryDate', function () {
    var len = $(this).val().length;
    if (len === 2) {
        var newVal = $(this).val();
        newVal += '/';
        $(this).val(newVal);
    }
})
$(document).on('click', '.proceed-payment', function () {

    var currency, charge, amount, total, payload;
    currency = $(this).data('currency');
    amount = $(this).data('amount');
    charge = $(this).data('charge');
    total = $(this).data('total');

    payload = currency + '&' + amount + '&' + charge + '&' + total;
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Controller::maskPaymentData', payload: payload },
        dataType: 'json',
        beforeSend: function () {
            $('.proceed-payment').html('<i class="fa fa-spinner fa-spin"></i>');
            setTimeout(function () {
                $("#preloader").show();
            }, 5000);
        },
        success: function (data) {
            setTimeout(function () {
                $("#preloader").hide();
                // window.location = url+'dashboard/payment';
                getpage('payment', 'page', 0);
            }, 5000);
        }
    })

})


function pay() {

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#paymentForm").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.payment-btn').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            if (data.response_code == 0) {
                sessionStorage.setItem('otp-text', data.response_message);
                $('#flw_ref').attr('value', data.flw_ref);
                loadModal('otp?info=' + data.response_message + '&ref=' + data.flw_ref, 'modal_div');
            } else {
                $(".payment-msg").html(data.response_message).addClass('alert alert-warning');
            }
        }
    })
}

$('.toggle').click(function (e) {
    // toggle the type attribute
    var type = $('#password').attr('type');
    if (type == 'password') {
        $('#password').attr('type', 'text');
        $('.toggle').html('<i class="fas fa-eye-slash"></i>');
    } else if (type == 'text') {
        $('#password').attr('type', 'password');
        $('.toggle').html('<i class="fa fa-eye"></i>');
    }
    // toggle the eye / eye slash icon
});
$('.toggle-2').click(function (e) {
    // toggle the type attribute
    var type = $('#cpassword').attr('type');
    if (type == 'password') {
        $('#cpassword').attr('type', 'text');
        $('.toggle-2').html('<i class="fas fa-eye-slash"></i>');
    } else if (type == 'text') {
        $('#cpassword').attr('type', 'password');
        $('.toggle-2').html('<i class="fa fa-eye"></i>');
    }
    // toggle the eye / eye slash icon
});
function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

function checkStrength(password) {
    var strength = 0;
    //If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        strength += 1;
        $('.low-upper-case').addClass('text-success');
        $('.low-upper-case i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');


    } else {
        $('.low-upper-case').removeClass('text-success');
        $('.low-upper-case i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
    }

    //If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
        strength += 1;
        $('.one-number').addClass('text-success');
        $('.one-number i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');

    } else {
        $('.one-number').removeClass('text-success');
        $('.one-number i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
    }

    //If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
        $('.one-special-char').addClass('text-success');
        $('.one-special-char i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');

    } else {
        $('.one-special-char').removeClass('text-success');
        $('.one-special-char i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
    }

    if (password.length > 7) {
        strength += 1;
        $('.eight-character').addClass('text-success');
        $('.eight-character i').removeClass('fa-file-text').addClass('fa-check');
        $('#popover-password-top').addClass('hide');

    } else {
        $('.eight-character').removeClass('text-success');
        $('.eight-character i').addClass('fa-file-text').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
    }

    // If value is less than 2

    if (strength < 2) {
        $('#result').removeClass()
        $('#password-strength').addClass('progress-bar-danger');

        $('#result').addClass('text-danger').text('Very Week');
        $('#password-strength').css('width', '10%');
    } else if (strength == 2) {
        $('#result').addClass('good');
        $('#password-strength').removeClass('progress-bar-danger');
        $('#password-strength').addClass('progress-bar-warning');
        $('#result').addClass('text-warning').text('Week')
        $('#password-strength').css('width', '60%');
        return 'Week'
    } else if (strength == 4) {
        $('#result').removeClass()
        $('#result').addClass('strong');
        $('#password-strength').removeClass('progress-bar-warning');
        $('#password-strength').addClass('progress-bar-success');
        $('#result').addClass('text-success').text('Strong');
        $('#password-strength').css('width', '100%');

        return 'Strong'
    }

}
// Support Chat 
hideChat(0);

$(document).on('click', '#prime, .start-chat', function () {
    toggleFab();
    // $('.chat_body').show();
    // $('.chat_category').show();
});

//Toggle chat and links
function toggleFab() {
    $('.prime').toggleClass('zmdi-comment-outline');
    $('.prime').toggleClass('zmdi-close');
    $('.prime').toggleClass('is-active');
    $('.prime').toggleClass('is-visible');
    $('#prime').toggleClass('is-float');
    $('.chat').toggleClass('is-visible');
    $('.fab').toggleClass('is-visible');

}
$(document).on('click', '.get-chat-body', function (e) {
    hideChat(4);
    $("#subject").attr('value', $(this).text());
});
$(document).on('click', '.get-chat-form', function (e) {
    hideChat(3);
    $("#chatSend").attr('disabled', true);
    $("#section").attr('value', $(this).data('section'));
});

$(document).on('click', '#chat_first_screen,#chat_first_screen_back,.get-chat-live', function (e) {
    hideChat(1);
});

$('#chat_second_screen,.chat_second_screen').click(function (e) {
    hideChat(2);
});

$('#chat_third_screen,.chat_third_screen').click(function (e) {
    hideChat(3);
});

$('#chat_fourth_screen,.chat_fourth_screen').click(function (e) {
    hideChat(4);
});

$(document).on('click', '#chat_fullscreen_loader', function (e) {
    $('.fullscreen').toggleClass('zmdi-window-maximize');
    $('.fullscreen').toggleClass('zmdi-window-restore');
    $('.chat').toggleClass('chat_fullscreen');
    $('.fab').toggleClass('is-hide');
    $('.header_img').toggleClass('change_img');
    $('.img_container').toggleClass('change_img');
    $('.chat_header').toggleClass('chat_header2');
    $('.fab_field').toggleClass('fab_field2');
    $('.chat_converse').toggleClass('chat_converse2');


    $('#chat_converse').css('display', 'none');
    $('#chat_body').css('display', 'none');
    $('#chat_form').css('display', 'none');
    $('.chat_login').css('display', 'none');
    $('#chat_fullscreen').css('display', 'block');
});

function hideChat(hide) {
    switch (hide) {
        case 0:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'block');
            $('.chat_fullscreen_loader').css('display', 'none');
            $('#chat_fullscreen').css('display', 'none');
            break;
        case 1:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'block');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'none');
            $('.chat_fullscreen_loader').css('display', 'block');
            break;
        case 2:
            $('#chat_converse').css('display', 'block.');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'none');
            $('.chat_fullscreen_loader').css('display', 'block');
            break;
        case 3:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'block');
            $('.chat_login').css('display', 'none');
            $('.chat_fullscreen_loader').css('display', 'block');
            break;
        case 4:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'none');
            $('.attachment').css('display', 'block');
            $('.chat_header').css('display', 'block');
            $('.fab_field').css('display', 'block');
            $('.chat_fullscreen_loader').css('display', 'block');
            $('#chat_fullscreen').css('display', 'block');
            break;
    }
}

$(document).on('click', '#fab_send', function () {
    var append = '<span class="chat_msg_item chat_msg_item_user"> ' + $('#chatSend').val() + '</span><div class="status">Just now. Not seen yet</div>';

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Support.postMessages', content: $('#chatSend').val(), subject: $('#subject').val() },
        dataType: 'json',
        beforeSend: function () {
            $(this).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $(this).html('<i class="fas fa-paper-plane"></i>');
            if (data.response_code == 0) {
                $('#chatSend').val('')
                $('#chat_fullscreen').append(append);
            } else {
                Toast.fire({ icon: 'warning', title: data.response_message })
            }
        }
    });

})
$(document).on('click', '.send-support-mail', function () {

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Support.Ticket', content: $('#ticket_content').val(), subject: $('#ticket_type').val() },
        dataType: 'json',
        beforeSend: function () {
            $(this).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $(this).html('Send');
            if (data.response_code == 0) {
                $('#ticket_content').val('');
                Toast.fire({ icon: 'success', title: data.response_message });

            } else {
                Toast.fire({ icon: 'warning', title: data.response_message });
            }
        },
        error: function () {
            Toast.fire({ icon: 'error', title: 'Something went wrong...' });
        }
    });

})

// var max = document.getElementById('chatSend');
// //submit on enter key
// // Execute a function when the user releases a key on the keyboard
// max.addEventListener("keyup", function (event) {
//     // Number 13 is the "Enter" key on the keyboard
//     if (event.keyCode === 13) {
//         // Cancel the default action, if needed
//         event.preventDefault();
//         // Trigger the button element with a click
//         document.getElementById("fab_send").click();

//         max.value = '';
//     }
// });

$(document).on('blur', '#dateRange', function () {
    var daterange = $(this).val();
    $('#dateRange').addClass('loading');
    $('.icon-inside').hide();
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: { type: 'Controller::transactionFilters', daterange: daterange },
        dataType: 'html',
        success: function (data) {
            setTimeout(function () {
                $('#dateRange').removeClass('loading');
                $('.icon-inside').show();
                $("#filtered-transaction").html(data);
            }, 5000);

            $(".pagination").hide();
        },
        error: function () {
            Toast.fire({ icon: 'warning', title: 'Something went wrong...' });
        }
    })
    // console.log(daterange);
})

$(document).on('keypress', '#dateRange', function (e) {
    e.preventDefault();
    var daterange = $(this).val();
    $('.icon-inside').html('').addClass('loading');
    if (e.which === 13) { //enter key was pressed
        $.ajax({
            url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
            type: 'post',
            data: { type: 'Controller::transactionFilters', daterange: daterange },
            dataType: 'html',
            success: function (data) {
                $("#filtered-transaction").html(data);

                $(".pagination").hide();
            },
            error: function () {
                Toast.fire({ icon: 'warning', title: 'Something went wrong...' });
            }
        })
    }

})


// remove duplicates from select fields
// $('.biller_code').each(function() {
//     $('.biller_code:contains("' + $(this).text() + '"):gt(0)').remove();
// });

function importData() {
    let input = document.createElement('input');
    input.type = 'file';
    input.onchange = _ => {

        // you can use this method to get file and perform respective operations
        let file = Array.from(input.files);

        var upload = new FormData();
        // $.each(file, function (i, value) {
        upload.append('file[0]', file);
        // });
        console.log(upload);

        $.ajax({
            url: url + 'helper?type=Controller::processAttachment&hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
            type: 'post',
            data: upload,
            dataType: 'json',
            success: function (data) {
                if (data.response_code == 0) {
                    $('.attachment').html('<i class="fa fa-paperclip"></i> ' + data.file_name).show();
                } else {
                    $('.attachment').html(data.response_message).addClass('text-warning').show();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Toast.fire({ icon: 'error', title: 'Something went wrong...' })

            }
        });

    };
    input.click();

}

function deleteBankAccount(d) {
    Swal.fire({
        title: 'Remove Bank Account!',
        text: "Are you sure you want to remove " + d + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
                type: 'post',
                data: { type: 'Controller::deleteBankAccount', account_id: d },
                dataType: 'json',
                success: function (data) {
                    if (data.response_code == 0) {
                        Toast.fire({ icon: 'success', title: data.response_message });
                        $('.' + d).hide();
                    } else {
                        Toast.fire({ icon: 'warning', title: data.response_message });
                    }
                },
                error: function () {
                    Toast.fire({ icon: 'warning', title: 'Something went wrong...' });
                }
            })
        }
    })

}
function deleteCard(d) {
    Swal.fire({
        title: 'Remove Card!',
        text: "Are you sure you want to remove " + d + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
                type: 'post',
                data: { type: 'Controller::deleteCard', card_id: d },
                dataType: 'json',
                success: function (data) {
                    if (data.response_code == 0) {
                        Toast.fire({ icon: 'success', title: data.response_message });
                        $('.' + d).hide();
                    } else {
                        Toast.fire({ icon: 'warning', title: data.response_message });
                    }
                },
                error: function () {
                    Toast.fire({ icon: 'warning', title: 'Something went wrong...' });
                }
            })
        }
    });
}

$(document).on('click', '.withdraw-all', function () {
    var balance = $(this).data('full-amount');
    balance = parseFloat(balance.replace(/,/g, ''));

    $("#transfer-amount").attr('value', balance);
})

$(document).on('click', '.mobile-home-link', function () {
    var target = $(this).data('target');
    console.log(target);
    getpage(target, 'utility', 0);
})

function printDiv(d) {
    const receiptTemplate = `
    <!DOCTYPE html>
    <html>
      <head>
        <title>Transaction Receipt</title>
        <style>
          body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
          }
          .container {
            width: 600px;
            margin: 20px auto;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
          }
          h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 3px;
          }
          .transaction-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
          }
          .item-name {
            flex-basis: 60%;
            color: #555;
          }
          .item-price {
            text-align: right;
            flex-basis: 40%;
            color: #555;
          }
          .total {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-weight: bold;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
          }
          .total div:first-child {
            color: #555;
          }
          .total div:last-child {
            color: #2ecc71;
          }
        </style>
      </head>
      <body>
        <div class="container">
          <h1>Transaction Receipt</h1>
          <div class="transaction-details">
            <div class="item-name">Item 1</div>
            <div class="item-price">$10.00</div>
          </div>
          <div class="transaction-details">
            <div class="item-name">Item 2</div>
            <div class="item-price">$15.00</div>
          </div>
          <div class="transaction-details">
            <div class="item-name">Item 3</div>
            <div class="item-price">$20.00</div>
          </div>
          <div class="total">
            <div>Total:</div>
            <div>$45.00</div>
          </div>
        </div>
      </body>
    </html>
    `;

    const divContent = document.getElementById(d).innerHTML;
    const printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('</head><body >');
    printWindow.document.write(receiptTemplate);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    //   printWindow.close();
}

function capture(file, name) {
    // Hide elements with class name "hide-me"
    const hideElements = document.querySelectorAll('.hide-me');
    hideElements.forEach(element => {
        element.style.display = 'none';
    });

    // Get the HTML element you want to capture (in this case, the entire .row div)
    const element = document.querySelector(file);

    $(".d-grid").hide();
    // Use html2canvas to create a canvas element from the target element
    html2canvas(element).then(canvas => {
        // Convert the canvas to a data URL and set it as the source of an img element
        const img = document.createElement('img');
        img.src = canvas.toDataURL();

        // Create a download link for the image
        const link = document.createElement('a');
        link.download = name + '.png';
        link.href = canvas.toDataURL();
        link.click();
    });
}


function share(file, name) {
    if (navigator.share) {
        // Execute the sharing code here
        // Hide elements with class name "hide-me"
        const hideElements = document.querySelectorAll('.hide-me');
        hideElements.forEach(element => {
            element.style.display = 'none';
        });

        // Get the HTML element you want to capture (in this case, the entire .row div)
        const element = document.querySelector(file);
        // Use html2canvas to create a Canvas element from the target element
        html2canvas(element).then(canvas => {
            // Create a Blob object from the canvas element
            canvas.toBlob(blob => {
                // Use the Web Share API to allow users to share the image
                navigator.share({
                    title: 'Receipt for transaction [' + name + ']',
                    text: 'Transaction Receipt',
                    files: [new File([blob], name + '.png', { type: 'image/png' })],
                });
            }, 'image/png');
        });
    } else {
        // Web Share API is not supported
        console.log('Web Share API is not supported.');
    }

}
function logIssue(file, name, field) {

    var value = $(field).val();
    if (value == "") {
        return Toast.fire({ icon: 'warning', title: 'Please, specify the issue with this transaction' });
    }
    // Get the HTML element you want to capture (in this case, the entire .row div)
    const element = document.querySelector(file);
    // Use html2canvas to create a Canvas element from the target element
    html2canvas(element).then(canvas => {
        // Create a Blob object from the canvas element
        canvas.toBlob(blob => {
            // Use the Web Share API to allow users to share the image
            navigator.share({
                title: 'Receipt for transaction [' + name + ']',
                text: value,
                files: [new File([blob], name + '.png', { type: 'image/png' })],
            });
        }, 'image/png');
    });
}

$(document).on('click', '.print-btn', function () {
    $("#defaultModalPrimary").modal("hide");

})

function identity_type(name, type) {
    if ($('#' + name).is(':checked')) {
        if (type == 'nin') {
            $('#' + name).attr('value', 'bvn');
            $('#identity').attr({ 'name': 'bvn', 'placeholder': 'Enter your BVN' });
            $('.identification-text').text('BVN');
            $('.toggle-text').text('I have my NIN');
        } else if (type == 'bvn') {
            $('#identity').attr({ 'name': 'nin', 'placeholder': 'Enter your NIN' });
            $('#' + name).attr('value', 'nin');
            $('.identification-text').text('NIN');
            $('.toggle-text').text('I have my BVN');
        }
    } else {
        if (type == 'nin') {
            $('#' + name).attr('value', 'bvn');
            $('#identity').attr({ 'name': 'bvn', 'placeholder': 'Enter your BVN' });
            $('.identification-text').text('BVN');
            $('.toggle-text').text('I have my NIN');
        } else if (type == 'bvn') {
            $('#identity').attr({ 'name': 'nin', 'placeholder': 'Enter your NIN' });
            $('#' + name).attr('value', 'nin');
            $('.identification-text').text('NIN');
            $('.toggle-text').text('I have my BVN');
        }
    }

}

function getAccountBalance() {
    var payload = {
        type: 'Controller::getAccountBalance',
    }
    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: payload,
        dataType: 'json',
        success: function (data) {
            if (data.response_code == 0) {
                const number = parseFloat(data.response_message);
                const formattedNumber = number.toFixed(2).toLocaleString();
                $(".available-balance").text('NGN' + formattedNumber);
            }
        }
    });
}

function loadModal(url, div) {
    getpage(url, div);
    $("#defaultModalPrimary").modal("show");
}

var table = $("#transaction-datatable").DataTable({
    processing: true,
    columnDefs: [{
        orderable: true,
        targets: 0
    }],
    order: [[8, 'DESC']],//order by date dec
    serverSide: true,
    paging: true,
    oLanguage: {
        sEmptyTable: "No record was found, please try another query"
    },

    ajax: {
        url: url + 'helper?hci-csrf-token-label=' + $('#hci-csrf-token-label').val(),
        type: "POST",
        data: function (d, l) {
            d.type = "Transactions::getTransactions";
            d.action = 'list';
            d.li = Math.random();
            d.start_date = $("#startDate").val();
            d.end_date = $("#endDate").val();
            d.column = $("#column").val();
            d.value = $("#value").val();
        }
    }
});


var table_1 = $("#recipient-datatable").DataTable({
    processing: true,
    columnDefs: [{
        orderable: true,
        targets: 0
    }],
    order: [[5, 'DESC']],//order by date dec
    serverSide: true,
    paging: true,
    oLanguage: {
        sEmptyTable: "No record was found, please try another query"
    },

    ajax: {
        url: url + 'helper?hci-csrf-token-label=' + $('#hci-csrf-token-label').val(),
        type: "POST",
        data: function (d, l) {
            d.type = "Transactions::getRecipients";
            d.action = 'list';
            d.li = Math.random();
            d.keyword = $("#keyword").val();
        }
    }

});

function filter_table() {
    table.draw();
    table_1.draw();
}

$(document).on('click', '.delete-recipient', function (e) {
    e.preventDefault();
    var code = $(this).data('id');
    Swal.fire({
        title: 'Delete Recipient',
        text: "Are you sure you want to delete this recipient ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
                type: 'POST',
                data: { type: 'Transactions::deleteRecipient', code: code },
                dataType: 'json',
                beforeSend: function () {
                    $('.delete-recipient').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (data) {
                    $('.delete-recipient').html('<i class="fa fa-trash"></i> Delete');

                    if (data.response_code == 0) {
                        swal_toast('success', data.response_message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        swal_toast('warning', data.response_message);

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('.delete-recipient').html('<i class="fa fa-trash"></i> Delete');
                    swal_toast('danger', 'Error deleting recipient');
                }
            })
        }
    })
});

$(document).on('click', '.add-recipient', function (e) {
    e.preventDefault();

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'POST',
        data: $("#add-recipient").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.add-recipient').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $('.add-recipient').html('<i class="fa fa-plus"></i> Add Recipient');

            if (data.response_code == 0) {
                swal_toast('success', data.response_message);
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                swal_toast('warning', data.response_message);

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.add-recipient').html('<i class="fa fa-plus"></i> Add Recipient');
            swal_toast('danger', 'Error adding recipient');
        }
    })
});

    // Add this code to the kyc.php page to show the modal when the page loads
    // $(document).ready(function() {
    //     $('#modaldemo8').modal('show');
    // });

    

    // $(document).on('click', '#kyc_button', function (e) {
    //     e.preventDefault();
    //     // console.log('hello');
    //     // e.preventDefault();
    //     // var payload = $("#register").serialize();
    //     var upload = new FormData();
    //     $.each(jQuery('#onboarding input[type=file]'), function (i, value) {
    //         upload.append('filedata[' + i + ']', value.files[0]);
    //     });
    
    //     $.ajax({
    //         url: url + 'helper?' + $("#onboarding").serialize() + '&hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
    //         type: 'post',
    //         data: upload,
    //         dataType: 'json',
    //         processData: false,
    //         contentType: false,
    //         cache: false,
    //         beforeSend: function () {
    //             $('#kyc_button').html('<i class="fa fa-spinner fa-spin"></i>');
    //         },
    //         success: function (data) {
    //             $('#kyc_button').html('Save');
    
    //             if (data.response_code == 0) {
    
    //                 swal_toast('success', data.response_message);
    //                 document.getElementById('kyc_button').reset;
    //                 setTimeout(() => {
    //                     window.location = url + 'dashboard/';
    //                 }, 3000);
    //             } else {
    //                 swal_toast('warning', data.response_message);
    //             }
    //         },
    //         error: function (jqxhr, textStatus) {
    //             $('#kyc_button').html('Save');
    
    //             swal_toast('danger', 'Your request could not be processed');
    //         }
    //     })
    
    // });

    
// $(document).on('click', '#kyc_1', function () {
//     var upload = new FormData();

//     $.each(jQuery('#kyc input[type=file]'), function (i, value) {
//         upload.append('filedata[' + i + ']', value.files[0]);
//     });

//     $.ajax({
//         url: url + 'helper?' + $("#kyc").serialize() + '&hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
//         type: 'post',
//         data: upload,
//         dataType: 'json',
//         processData: false,
//         contentType: false,
//         cache: false,
//         beforeSend: function () {
//             $('.kyc').html('<i class="fa fa-spinner fa-spin"></i>');
//         },
//         success: function (data) {
//             $('.kyc').html('Save');

//             if (data.response_code == 0) {

//                 swal_toast('success', data.response_message);

//                 document.getElementById('kyc').reset;
//                 setTimeout(() => {
//                     window.location = url + 'dashboard/send';
//                 }, 3000);
//             } else {
//                 swal_toast('warning', data.response_message);

//             }
//         },
//         error: function (jqxhr, textStatus) {
//             $('.kyc').html('Save');

//             swal_toast('danger', 'Your request could not be processed');
//         }
//     })

// });
$(document).on('click', '.change-password', function () {

    $.ajax({
        url: url + 'helper?hci-csrf-token-label=' + $("#hci-csrf-token-label").val(),
        type: 'post',
        data: $("#change-password").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $('.change-password').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function (data) {
            $('.change-password').html('Save');

            if (data.response_code == 0) {

                swal_toast('success', data.response_message);

                document.getElementById('change-password').reset;
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            } else {
                swal_toast('warning', data.response_message);
            }
        },
        error: function (jqxhr, textStatus) {
            $('.change-password').html('Save');

            swal_toast('danger', 'Your request could not be processed');
        }
    })

})

function bootstrap_toast(type, message) {
    // Create the Bootstrap toast element
    const toastHTML = `
      <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
        <div class="toast" style="position: absolute; top: 75px !important; right: 0;">
          <div class="toast-body ${type}">
            ${message}
          </div>
        </div>
      </div>
    `;

    // Append the toast to the body
    $(document.body).append(toastHTML);

    // Select the toast element and trigger 'show' method
    const $toast = $('.toast');
    $toast.toast('show');

    // Fade in the toast
    $toast.fadeIn();

    return toastHTML;
}


function swal_toast(type, message) {
    // Define icon classes for different types
    const iconClasses = {
        success: 'fas fa-check-circle text-success fs-20',
        error: 'fas fa-times-circle fs-20',
        info: 'fas fa-info-circle text-info fs-20',
        warning: 'fas fa-exclamation-circle text-warning fs-20',
    };

    const messageContainer = $('#message-container');
    // Create the Swal-style toast element with an icon and dismiss button
    const toastHTML = `
      <div class="swal-toast swal-toast-${type}">
        <i class="${iconClasses[type]}"></i>
        ${message}
        &nbsp;&nbsp;
        <i class="swal-toast-dismiss fas fa-times" style="cursor: pointer" onclick="dismissToast(this)"></i>
      </div>
    `;

    // Append the toast to the body
    // $(document.body).append(toastHTML);
    messageContainer.html(toastHTML);

    // Add a class to trigger a fade-in animation
    const $toast = $('.swal-toast');
    $toast.addClass('swal-toast-show');

    // Automatically remove the toast after a delay (adjust as needed)
    let timeoutId;
    setTimeout(() => {
        timeoutId = $toast.remove();
    }, 3000);

    // Prevent automatic removal when the mouse is inside the toast
    $toast.on('mouseenter', () => {
        clearTimeout(timeoutId);
    });

    // Resume automatic removal when the mouse leaves the toast
    $toast.on('mouseleave', () => {
        timeoutId = setTimeout(() => {
            $toast.remove();
        }, 3000);
    });

    return toastHTML;
}

function dismissToast(button) {
    const $toast = $(button).closest('.swal-toast');
    $toast.remove();
}



function select_beneficiary(d, path) {
    $.ajax({
        url: url + 'router?' + path,
        type: 'post',
        data: { type: 'Controller::processPayload', recipientid: d, 'ajax': true },
        beforeSend: function () {
            $('.' + d).html('<i class="fa fa-spinner fa-spin"></i>')
        },
        success: function (data) {
            var data = JSON.parse(data);
            if (data.response_code == 0) {
                swal_toast('success', 'You\'ve selected ' + data.account_name + ' as the beneficiary of this transaction');
                $('.' + d).html('<i class="fa fa-double-check fa-fw"></i>');

                const queryString = new URLSearchParams(data.response_message).toString();

                payload = objectToBase64(queryString);

                window.location.href = 'select-beneficiary?' + payload;
            } else {
                swal_toast('danger', 'Something went wrong. Please try again');
            }

        }
    })

}

$(document).on('change', '#utility_type', function () {
    var selected = $(this).children('option:selected').text();
    $('.utility_document').text('Upload ' + selected);
});

$(document).on('change', '#kyc_type', function () {
    var selected = $(this).children('option:selected').text();
    $('.kyc_document').text('Upload ' + selected);
});



function contact(form) {
    // $(document).on('click','.contact-us',function (e) {
    //     e.preventDefault();

    if (!validateForm(document.getElementById(form))) {
        return false
    }

    var payload = $("#" + form).serialize();
    $.ajax({
        url: url + 'router',
        type: 'post',
        data: payload,
        dataType: 'json',
        beforeSend: function () {
            $('.contact-us').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        success: function (data) {
            $('.contact-us').html('Send Message');

            if (data.response_code == 0) {
                document.getElementById('contact-us').reset;

                swal_toast('success', data.response_message);

            } else {
                swal_toast('warning', data.response_message);

            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('.contact-us').html('Send Message');

            swal_toast('danger', 'Something went wrong...');

        }
    })
    // });
}

// Custom validation function
function validateForm(form) {
    var isValid = true;

    // Loop through form elements
    for (var i = 0; i < form.elements.length; i++) {
        var element = form.elements[i];

        if (element.type === "text" || element.tagName === "textarea") {
            var fieldName = element.name;
            if (element.value.trim() === '') {
                swal_toast('warning', element.placeholder);
                isValid = false;
            }
        } else if (element.type === "email") {
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (element.value.trim() === '') {
                swal_toast('warning', element.placeholder);
                isValid = false;
            } else if (!element.value.match(emailPattern)) {
                swal_toast('warning', 'Please enter a valid email address');
                isValid = false;
            }
            // Add more conditions for other fields as needed
        } else if (element.type === "tel") {
            var fieldName = element.name;
            if (element.value.trim() === '') {
                swal_toast('warning', element.placeholder);
                isValid = false;
            }
        } else if (element.type === "password") {
            var password = element.value;

            if (password.trim() === '') {
                swal_toast('warning', element.placeholder);
                isValid = false;
            } else if (password.length < 8) {
                swal_toast('warning', 'Password must be at least 8 characters long');
                isValid = false;
            }
        } else if (element.tagName === "SELECT") {
            if (element.selectedIndex === 0) {

                var defaultOption = element.options[0].text;
                var selectedOption = element.options[element.selectedIndex];

                if (!selectedOption.value || selectedOption.value.trim() === '') {
                    swal_toast('warning', defaultOption);
                    isValid = false;
                }
            }
        }
    }

    return isValid;
}

$("#upload-payslip").change(function () {
    $('span.fileup-upload').html('<i class="fa fa-upload fa-2x"></i>');
});

$(document).on('click', '.add-new-recipient', function () {
    $("#account_nos, #baccount_name_dddd, #account_name_1, #branchname, #recipientsemail, #recipientsphone").val('');
    $("#bank_name").append('<option value="" selected>Select Beneficiary Bank</option>');
    $("#fund_source").append('<option value="" selected>Select fund source</option>');
    $("#sendingreason").append('<option value="" selected>Select your reason for sending</option>');
})

// $('select').select2();
$(document).on('change', '#country', function () {
    var selected = $(this).children('option:selected').val();

    $.ajax({
        url: url + 'router',
        type: 'POST',
        dataType: 'json',
        data: {
            type: 'Controller::getStates',
            id: selected
        },
        beforeSend: function () {
            $("#state").html('');
        },
        success: function (data) {
            $("#state").html(data.options);
        }
    })
})

$(document).on('change', '#state', function () {
    var selected = $(this).children('option:selected').val();
    $.ajax({
        url: url + 'router',
        type: 'POST',
        dataType: 'json',
        data: {
            type: 'Controller::getCities',
            id: selected,
            country_id: $('#country').val()
        },
        beforeSend: function () {
            $("#city").html('');
        },
        success: function (data) {
            $("#city").html(data.options);
        }
    })
})
