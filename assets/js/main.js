feather.replace();

var currencyInput = document.querySelector('input[type="currency"]')
var currency = 'IDR' // https://www.currency-iso.org/dam/downloads/lists/list_one.xml

if(currencyInput !== null) {
    // format inital value
    onBlur({
        target: currencyInput
    })
    
    // bind event listeners
    currencyInput.addEventListener('focus', onFocus)
    currencyInput.addEventListener('blur', onBlur)
}

function localStringToNumber(s) {
    return Number(String(s).replace(/[^0-9.-]+/g, ""))
}

function onFocus(e) {
    var value = e.target.value;
    e.target.value = value ? localStringToNumber(value) : ''
}

function onBlur(e) {
    var value = e.target.value

    var options = {
        maximumFractionDigits: 3,
        currency: currency,
        style: "currency",
        currencyDisplay: "symbol"
    }

    e.target.value = (value || value === 0) ?
        localStringToNumber(value).toLocaleString(undefined, options) :
        ''
}

function copy() {
    let element = document.getElementById('link_udunan');
    let elementText = element.textContent;
    copyText(elementText);
}

function copyText(text) {
    navigator.clipboard.writeText(text);
}


function printDiv(divID) {
    //Get the HTML of div
    var divElements = document.getElementById(divID).innerHTML;
    //Get the HTML of whole page
    var oldPage = document.body.innerHTML;

    //Reset the page's HTML with div's HTML only
    document.body.innerHTML =
        '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Atlantic-Pedia</title><link rel="stylesheet" href="assets/vendor/bootstrap-4.4.1-dist/css/bootstrap.min.css"><link rel="stylesheet" href="assets/css/style.css"><script src="https://unpkg.com/feather-icons"></script></head><body>' +
        divElements + '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"> </script><script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"> </script><script src="assets/vendor/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script><script src="assets/vendor/bootstrap-4.4.1-dist/js/bootstrap.js"></script><script src="assets/js/main.js"></script><script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script></body>';

    //Print Page
    window.print();

    //Restore orignal HTML
    document.body.innerHTML = oldPage;

}