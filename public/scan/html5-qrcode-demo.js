function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
} 

docReady(function() {

    var resultContainer = document.getElementById('results');
    var lastResult, countResults = 0;
    
    document.getElementById('product_code').onchange = function() {
        ++countResults;
        var decodedText = this.value;
        var type = "manual";
        resultContainer.innerHTML += `<tr><td>${countResults}</td><td>${decodedText}</td><td>${type}</td></tr>`;
        this.value = "";
    };

    // const formatsToSupport = [
    // Html5QrcodeSupportedFormats.QR_CODE,
    // Html5QrcodeSupportedFormats.UPC_A,
    // ];

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
        ++countResults;
        console.log(`Scan result = ${decodedText}`, decodedResult);
        var format = decodedResult.result.format.formatName;
        var type = "Barcode";
        if(format=='QR_CODE')
            type = "QrCode";

        resultContainer.innerHTML += `<tr><td>${countResults}</td><td>${decodedText}</td><td>${type}</td></tr>`;
    }
    
    // Optional callback for error, can be ignored.
    function onScanError(qrCodeError) {
        // This callback would be called in case of qr code scan error or setup error.
        // You can avoid this callback completely, as it can be very verbose in nature.
    }
    
    html5QrcodeScanner.render(onScanSuccess, onScanError);
});