import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Laporan page loaded');

    const canvas = document.getElementById('laporanChart');
    if (!canvas) {
        console.error('❌ Canvas dengan id "laporanChart" tidak ditemukan!');
        return;
    }

    // Ambil data dari window object (dikirim dari controller)
    const chartData = window.chartData || { labels: [], data: [], label: 'Data' };

    console.log('📊 Data grafik:', chartData);

    // Cek apakah data valid
    if (!chartData.labels || chartData.labels.length === 0) {
        console.warn('⚠️ Tidak ada data untuk grafik');
        const ctx = canvas.getContext('2d');
        ctx.font = '16px Inter, sans-serif';
        ctx.fillStyle = '#9ca3af';
        ctx.textAlign = 'center';
        ctx.fillText('Tidak ada data untuk periode ini', canvas.width / 2, canvas.height / 2);
        return;
    }

    try {
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: chartData.label || 'Data',
                    data: chartData.data,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#6b7280',
                            font: { size: 12 }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af'
                        },
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#9ca3af',
                            maxTicksLimit: 15
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        console.log('✅ Grafik berhasil dibuat!');
    } catch (error) {
        console.error('❌ Error saat membuat grafik:', error);
        const ctx = canvas.getContext('2d');
        ctx.font = '14px Inter, sans-serif';
        ctx.fillStyle = '#ef4444';
        ctx.textAlign = 'center';
        ctx.fillText('Gagal memuat grafik: ' + error.message, canvas.width / 2, canvas.height / 2);
    }
});