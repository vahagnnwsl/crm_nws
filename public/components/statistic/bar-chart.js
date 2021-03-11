Vue.component('bar-chart', {
    extends: VueChartJs.Bar,
    props:['data'],
    data: function () {
        return {
            datacollection: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

        }
    },
    watch: {
        chartData () {
            this.$data._chart.update()
        }
    },
    mounted() {
        this.setData(this.data);
    },
    methods: {
        setData: function (data) {
            this.datacollection.labels = data.labels
            this.datacollection.datasets = data.data
            this.renderChart(this.datacollection, this.options)
        }
    }
})
