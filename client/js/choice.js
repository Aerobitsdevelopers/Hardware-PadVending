let size = 'regular';
let qty = 1;

function chooseQty(size) {
    document.getElementById("pad-size").style.display = 'none';
    var element = document.getElementById("pad-qty");
    element.style.display = 'flex';
    switch (size) {
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
    size = size;
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