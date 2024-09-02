import './bootstrap';

import Alpine from 'alpinejs';
import Inputmask from 'inputmask';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    var cpfMask = new Inputmask('999.999.999-99');
    cpfMask.mask(document.querySelector("#cpf"));

    var phoneNumberMask = new Inputmask("(99)99999-9999");
    phoneNumberMask.mask(document.querySelector("#phone_number"));
    
    var zipCodeMask = new Inputmask('99999-999');
    zipCodeMask.mask(document.querySelector("#zip_code"));
    
    var salaryMask = new Inputmask('R$ 999.999,99', { numericInput: true });
    salaryMask.mask(document.querySelector("#salary"));
    
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener('keyup', searchTable);
    }
});

function searchTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toUpperCase();
    const table = document.querySelector("table");
    const trs = table.querySelectorAll("tbody tr");

    trs.forEach((tr) => {
        let showRow = false;
        const tds = tr.querySelectorAll("td");

        tds.forEach((td) => {
            if (td.textContent.toUpperCase().includes(filter)) {
                showRow = true;
            }
        });

        tr.style.display = showRow ? "" : "none";
    });
}


