var lastResult, countResults = 0;
var resultContainer, template;

function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function process(decodedText){
    ++countResults;
    var clone = template.cloneNode(true);
    clone.id = decodedText;
    clone.querySelector('.counter').textContent = countResults;
    clone.querySelector('.value').textContent = decodedText;
    clone.querySelector('.product_code').value = decodedText;
    clone.classList.remove("d-none");
    resultContainer.append(clone);
}

function increaseQuantity(row)
{
    let quantity = parseInt(row.querySelector('.quantity').value);
    row.querySelector('.quantity').value = quantity+1;
}

function decreaseQuantity(row)
{
    let quantity = parseInt(row.querySelector('.quantity').value);
    if(quantity>0)
        quantity = quantity-1;
    row.querySelector('.quantity').value = quantity;
}

document.addEventListener( 'click', function( e ) {
    if ( e.target.classList.contains('decrease') ) {
        decreaseQuantity(e.target.parentNode.parentNode.parentNode);
    }
    if ( e.target.classList.contains('increase') ) {
        increaseQuantity(e.target.parentNode.parentNode.parentNode);
    }
});

docReady(function() {

    resultContainer = document.getElementById('results');
    template = document.getElementById('row-template');
    
    document.getElementById('product_code').onchange = function() {
        var decodedText = this.value;
        process(decodedText);
        this.value = "";
    };

    
    document.getElementById('save').onclick = function() {
        document.getElementById("scan-form").submit();
    };

    const formatsToSupport = [
        Html5QrcodeSupportedFormats.QR_CODE,
        Html5QrcodeSupportedFormats.UPC_A,
    ];

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", 
        { 
            fps: 10,
            qrbox: {width:250,height:200},
            //formatsToSupport: formatsToSupport,
            experimentalFeatures: {
                useBarCodeDetectorIfSupported: true
            },
            rememberLastUsedCamera: true
        });
    
    function onScanSuccess(decodedText, decodedResult) {
        process(decodedText);
    }
    
    // Optional callback for error, can be ignored.
    function onScanError(qrCodeError) {
        // This callback would be called in case of qr code scan error or setup error.
        // You can avoid this callback completely, as it can be very verbose in nature.
    }
    
    html5QrcodeScanner.render(onScanSuccess, onScanError);
});