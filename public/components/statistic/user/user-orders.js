Vue.component('user-orders', {
    template: `
        <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Pie chart</h3>
            </div>
            <div class="card-body">
                <date-picker :lang="config.lang" :range="config.range" v-model="date"></date-picker>
                <button type="button" class="btn btn-default" @click="filter">
                    <i class="fa fa-check-circle"></i>
                </button>
                <pie-chart v-if="show" v-bind:data="data" style="margin-top: 20px"></pie-chart>
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
        this.filter()
    },
    methods: {
        filter: function () {
            this.$http.get('/dashboard/statistic/users-orders', {
                params: {
                    date: this.date ?? []
                }
            })
                .then((response) => {
                    this.$emit('updateData', 22)
                    this.data = response.data;
                    bus.$emit('update-pie-chart', this.data)

                    this.show = true;
                }).catch((error) => {
            })
        }

    }
})
