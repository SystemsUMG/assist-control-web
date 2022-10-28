<template>
    <Bar :chart-options="chartOptions" :chart-data="chartData"/>
</template>
<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, LinearScale, PointElement, CategoryScale, Filler } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, LinearScale, PointElement, CategoryScale, Filler)

export default {
    components: { Bar },
    props: ['labels', 'values'],
    computed: {
        chartData() {
            return {
                labels: this.labels,
                datasets: [{
                    label: "Asistencias",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: '#5e72e4',
                    data: this.values,
                    maxBarThickness: 20
                }]
            }
        },
        chartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            display: true,
                            padding: 10,
                            beginAtZero: true,
                            padding: 10,
                            color: '#67748E',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#67748E',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                }
            }
        }
    }
}
</script>
