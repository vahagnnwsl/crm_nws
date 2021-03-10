Vue.component('chart-users-order-statistic-all-time', {
    extends: VueChartJs.Pie,
    props: ['data'],
    data: function () {
        return {
            chartData: {
                labels: [],
                datasets: [{
                    borderWidth: 1,
                    backgroundColor: [],
                    data: []
                }]
            },
            options: {
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }


    },
    mounted() {

        this.chartData.datasets[0].backgroundColor = this.data.backgroundColor;
        this.chartData.datasets[0].data = this.data.data;
        this.chartData.labels = this.data.labels;

        this.renderChart(this.chartData, this.options)
    }
})
