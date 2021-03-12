Vue.component('user-order', {
    template: `
        <div class="col-md-12">
        <div class="card card-maroon">
            <div class="card-header">
                <h3 class="card-title">Pie chart</h3>
            </div>
            <div class="card-body">
                <date-picker :lang="config.lang" :range="config.range" v-model="date"></date-picker>
                <button type="button" class="btn btn-default" @click="filter">
                    <i class="fa fa-check-circle"></i>
                </button>

                  <div class="row mt-2">
                      <div class="col-md-6 border p-2"  v-for="(item,index) in data.data" >
                          <h2 class="text-center pt-2">{{item.creator}}</h2>
                          <pie2-chart  :key="index" v-bind:data="item"   style="margin-top: 20px"></pie2-chart>
                      </div>

                  </div>
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
            show: true,
            date: []
        }
    },
    mounted() {
        this.filter()
    },
    methods: {
        filter: function () {

            this.$http.get('/dashboard/statistic/users-singleUserOrdersGroupByStatus', {
                params: {
                    date: this.date ?? []
                }
            })
                .then((response) => {
                    this.data = response.data;
                    this.show = true;

                }).catch((error) => {
            })
        }

    }
})
