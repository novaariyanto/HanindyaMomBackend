document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah sedang di halaman dashboard
    const currentPath = window.location.pathname;
    if (currentPath === '/dashboard') {
        // Inisialisasi chart dashboard
    }

    // Fungsi untuk mengecek keberadaan elemen
    function initializeChartIfElementExists(elementId, chartConfig) {
        const element = document.getElementById(elementId);
        if (element) {
            return new ApexCharts(element, chartConfig);
        }
        return null;
    }

    // Contoh penggunaan untuk chart
    const chartElement = initializeChartIfElementExists('yourChartId', {
        // konfigurasi chart
    });
    if (chartElement) {
        try {
            chartElement.render();
        } catch (error) {
            console.warn('Error initializing chart:', error);
            // Tambahkan fallback atau notifikasi jika diperlukan
        }
    }

    // ... kode lainnya ...
}); 