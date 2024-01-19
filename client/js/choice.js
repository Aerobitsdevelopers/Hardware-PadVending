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

function choosePay() {
    var xhr = new XMLHttpRequest();

    // API endpoint URL
    const apiUrl = 'https://hygieia.life/TEST/padVending/inventory.php?size=' + size + '&qty=' + qty + '&payment=rfid_3694';

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

                location.reload();
            } else {
                console.error('API call failed:', response.status, response.statusText);
            }
        })
        .catch(error => {
            console.error('Error during API call:', error);
        });
}
