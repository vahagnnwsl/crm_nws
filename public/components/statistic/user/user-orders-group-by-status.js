Vue.component('user-orders-group-by-status', {
    template: `
        <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Group by status</h3>
            </div>
            <div class="card-body">
                <date-picker :lang="config.lang" :range="config.range" v-model="date"></date-picker>
                <button type="button" class="btn btn-default" @click="filter">
                    <i class="fa fa-check-circle"></i>
                </button>
                <bar-chart ref="barChart" v-if="show" v-bind:data="data" style="margin-top: 20px"></bar-chart>
            </div>

        </div>
        </div>
    `,
    data: function () {
        return {
            config: {
                lang: 'en',
                range: true,
            },
            data: [],
            show: false,
            date: []
        }
    },
    mounted() {


        let d = new Date()
        d.toLocaleDateString()
        d.setMonth(d.getMonth() - 4);

        this.date = [new Date(d.toLocaleDateString()), new Date()]


        this.filter();
    },
    methods: {
        filter: function () {
            this.$http.get('/dashboard/statistic/users-ordersGroupByStatus', {
                params: {
                    date: this.date ?? []
                }
            })
                .then((response) => {
                    this.data = response.data;
                    this.show = true;
                    this.$refs.barChart.setData(this.data)
                }).catch((error) => {
            })
        }

    }
})
