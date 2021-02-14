var $ = function (selector) {
    return document.querySelector(selector);
};
function updateTextInput(e) {
    $('#rangeValue').value = e.value
}

function removeCard(e) {
    e.closest('.card').remove()
}

function calculate(event){
    event.preventDefault()
    let userValue = $('#value').value
    let taxPercentage = $('#taxPercentage').value
    let installments = $('#installments').value
    let data = {
        'value': userValue,
        'tax': taxPercentage,
        'installments': installments
    }
    fetch('/backend/api.php', {
        method: 'POST',
        headers: {
            'Accept': 'json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then((res) => {
        return res.json()
    })
    .then(function (data) { 
        $('#value').value = 100;
        $('#taxPercentage').value = 0;
        $('#installments').value = 1;
        $('#rangeValue').value = 0;

        let card = $('.card.example').cloneNode(true)
        card.classList.remove('d-none')
        //Seting headers
        for (let i = 1; i <= installments; i++) {
            let head_node = document.createElement("th")
            head_node.setAttribute('scope', 'col')
            head_node.innerText = i + ' installment'
            card.querySelector('thead tr').append(head_node)
        }
        
        let estimatedValue = card.querySelector('tbody .estimated-value')
        let basePremium = card.querySelector('tbody .base-premium')
        let commission = card.querySelector('tbody .commission')
        let tax = card.querySelector('tbody .tax')
        let totalCost = card.querySelector('tbody .total')
        
        let body_node = document.createElement("td")
        body_node.innerText = userValue
        estimatedValue.append(body_node)
        
        body_node = document.createElement("td")
        body_node.innerText = value
        basePremium.querySelector('th').innerText += ' ('+ data.basePercent +'%)'
        
        body_node = document.createElement("td")
        body_node.innerText = value
        commission.querySelector('th').innerText += ' (' + data.commissionPercent + '%)'

        body_node = document.createElement("td")
        body_node.innerText = value
        tax.querySelector('th').innerText += ' (' + data.taxPercent + '%)'

        data.basePriceArray.forEach(element => {
            body_node = document.createElement("td")
            body_node.innerText = element
            basePremium.append(body_node)
        });
        data.commissionArray.forEach(element => {
            body_node = document.createElement("td")
            body_node.innerText = element
            commission.append(body_node)
        });
        data.taxArray.forEach(element => {
            body_node = document.createElement("td")
            body_node.innerText = element
            tax.append(body_node)
        });
        data.totalCostArray.forEach((element, index) => {
            body_node = document.createElement("td")
            if(index == 0) {
                let strong = document.createElement("strong")
                strong.innerText = element
                body_node.append(strong)
            }else{
                body_node.innerText = element
            }
            totalCost.append(body_node)
        });

        $('#cardContent').append(card);
    })


    return false;
}
function valueControl(e) {
    let value = e.value
    if(value < 100){
        e.value = 100;
    }
    if(value > 100000){
        e.value = 100000;
    }
}