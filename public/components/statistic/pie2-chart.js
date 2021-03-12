Vue.component('pie2-chart', {
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
    watch: {
        data: function (data) {
            this.setData(data);
        }
    },
    mounted() {
        this.setData(this.data);
    },
    methods: {
        setData: function (data) {
            this.chartData.datasets[0].backgroundColor = data.backgroundColor;
            this.chartData.datasets[0].data = data.data;
            this.chartData.labels = data.labels;
            this.renderChart(this.chartData, this.options)
        }
    }
})
