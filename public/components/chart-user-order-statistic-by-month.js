Vue.component('chart-user-order-statistic-by-month', {
    extends: VueChartJs.Bar,
    props: ['data'],
    data: function () {

        return {
            chartData: {
                labels: [],
                datasets: []
            },
            options: {
                scales: {
                    yAxes: [{
                        stacked: true
                    }],
                    xAxes: [{
                        stacked: true,
                    }]
                },
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }

    },
    mounted() {

        this.chartData.labels = this.data.labels
        this.chartData.datasets = this.data.data


        this.renderChart(this.chartData, this.options)

    }
})
