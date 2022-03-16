require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.querySelectorAll('.text-grade').forEach(function (grade) {
    if (parseInt(grade.innerHTML) < 10) {
        grade.classList.add('text-nu-red');
    } else if (parseInt(grade.innerHTML) < 12) {
        grade.classList.add('text-nu-orange');
    } else {
        grade.classList.add('text-nu-green');
    }
})

document.querySelectorAll('.bg-grade').forEach(function (grade) {
    if (parseInt(grade.innerHTML) < 10) {
        grade.classList.add('bg-nu-red/50');
    } else if (parseInt(grade.innerHTML) < 12) {
        grade.classList.add('bg-nu-orange/50');
    } else {
        grade.classList.add('bg-nu-green/50');
    }
})
