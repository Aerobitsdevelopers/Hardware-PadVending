let size = 'regular';
let qty = 1;

function chooseQty(sizeIn) {
    document.getElementById("pad-size").style.display = 'none';
    var element = document.getElementById("pad-qty");
    element.style.display = 'flex';
    size = sizeIn;
    switch (sizeIn) {
        case 'regular':
            element.style.backgroundColor = '#c5dcc2';
            break;
        case 'large':
            element.style.backgroundColor = '#91b38e';
            break;
        case 'night':
            element.style.backgroundColor = '#5a855f';
            break;
        default:
            element.style.backgroundColor = '#c5dcc2';

    }
}

function increaseQty() {
    if (qty < 3) {
        qty++;
        document.querySelector('#pad-qty input').value = qty;
    }
}

function decreaseQty() {
    if (qty > 1) {
        qty--;
        document.querySelector('#pad-qty input').value = qty;
    }
}

function checkout() {
    document.getElementById("pad-qty").style.display = 'none';
    var element = document.getElementById("pad-pay");
    document.querySelector('#pad-pay .size').innerHTML = "Size : " + size;
    document.querySelector('#pad-pay .qty').innerHTML = "Quantity : " + qty;
    element.style.display = 'flex';
}

function choosePay(type) {
    if (type === 'rfid') {
        window.location.href = './rfid?size=' + size + '&qty=' + qty;
    } else {
        window.location.href = './pay?size=' + size + '&qty=' + qty;
    }
}

function scanRFID() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/scanRFID", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);

            // Log the id and rfid_text
            console.log("ID:", response.id);
            var size = getUrlParameter("size");
            var qty = getUrlParameter("qty");
            if (response.id === 540541603618) {
                dispensePad(size, qty, 'rfid', response.id)
            }
            console.log("RFID Text:", response.rfid_text);
        }
    };
    xhr.send();
}

function QRPay() {
    var size = getUrlParameter("size");
    var qty = getUrlParameter("qty");
    setTimeout(dispensePad, 4000, size, qty, 'payment', 'dummy')
}

function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name)
}

function dispensePad(size, qty, type, id) {
    var xhr = new XMLHttpRequest();

    // API endpoint URL
    const apiUrl = 'https://hygieia.life/TEST/padVending/inventory.php?size=' + size + '&qty=' + qty + '&payment=' + type + '_' + id;

    fetch(apiUrl, {
        method: 'GET',
    })
        .then(response => {
            if (response.ok) {
                switch (size) {
                    case 'regular':
                        xhr.open("GET", "/controlMotor1", true);
                        break;
                    case 'large':
                        xhr.open("GET", "/controlMotor2", true);
                        break;
                    case 'night':
                        xhr.open("GET", "/controlMotor3", true);
                        break;
                    default:
                        return null

                }
                xhr.send();

                window.location.href = './';
            } else {
                console.error('API call failed:', response.status, response.statusText);
            }
        })
        .catch(error => {
            console.error('Error during API call:', error);
        });
}