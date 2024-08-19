import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Inputmask from 'inputmask';

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

