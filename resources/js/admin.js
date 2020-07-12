
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}

require("admin-lte");

// Sweet Alert 2 Implementation Starts
import Swal from 'sweetalert2'

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

// Set Variables for Global Use
window.Swal = Swal; //Define Swal for Global Use
window.Toast = Toast; //Define Toast for Global Use
// Sweet Alert 2 Implementation Ends
