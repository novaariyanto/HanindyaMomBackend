import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Configure CSRF token for AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Configure DataTables defaults
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
    },
    processing: true,
    serverSide: true,
    responsive: true
});
