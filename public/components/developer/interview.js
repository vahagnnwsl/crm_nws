Vue.component('developer-interview', {

    template: `
        <div class="card card-info mt-2">
        <div class="card-header">
            <h3 class="card-title">Interview</h3>
        </div>
        <div class="card-body">
            <div class="card card-info w-100  collapsed-card">
                <div class="card-header">
                    <h4 class="card-title"> Create</h4>
                    <button type="button" class="btn btn-tool float-right" data-card-widget="collapse"
                            title="Collapse" style="margin-top: -4px!important;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="card-body" style="display: none">
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <label>Date *</label>
                            <input class="form-control" type="date" v-model="form.date" name="date"
                                   v-validate="'required'">
                            <span class="error invalid-feedback d-block"
                                  ref="attachment-error">{{ errors.first('date') }}</span>
                        </div>
                        <div class="form-group">
                            <label>Position *</label>
                            <select class="form-control" name="position" v-model="form.position"
                                    v-validate="'required'">
                                <option value="">Select one</option>
                                <option v-for="position in positions" :value="position">{{ position }}</option>
                            </select>
                            <span class="error invalid-feedback d-block"
                                  ref="attachment-error">{{ errors.first('position') }}</span>
                        </div>
                        <div class="form-group">
                            <label>Interviewer *</label>
                            <input class="form-control" type="text" v-model="form.interviewer" name="interviewer"
                                   v-validate="'required'">
                            <span class="error invalid-feedback d-block"
                                  ref="attachment-error">{{ errors.first('interviewer') }}</span>
                        </div>
                        <div class="form-group">
                            <label>Test name *</label>
                            <input class="form-control" type="text" v-model="form.test_name" name="test_name"
                                   v-validate="'required'">
                            <span class="error invalid-feedback d-block"
                                  ref="attachment-error">{{ errors.first('test_name') }}</span>
                        </div>

                        <div class="form-group">
                            <label>Test result *</label>
                            <textarea rows="3" class="form-control" type="text" v-model="form.test_result"
                                      name="test_result" v-validate="'required'"></textarea>
                            <span class="error invalid-feedback d-block"
                                  ref="attachment-error">{{ errors.first('test_result') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success float-right"><i class="fa fa-check-circle"></i>Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="form-group mt-2">

                <div class="row w-100 pt-2" style="max-height: 600px;overflow-y: auto"
                     v-if="developer.interviews.length">
                    <div class="col-12 pt-1 border ">
                        <div class="post" style="padding-bottom: 0!important;position: relative" :key="index"
                             v-for="(interview,index) in developer.interviews">

                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="/dist/img/avatar5.png" alt="user image">
                                <span class="username">
                                           {{ interview.interviewer }}
                                         </span>
                                <span class="description">   {{ interview.date }}</span>
                                <span class="description">
                                            {{ interview.position }}
                                        </span>
                            </div>
                            <p class="text-blue" style="font-size: 1.1rem">
                                {{ interview.test_name }}
                            </p>
                            <p>
                                {{ interview.test_result }}
                            </p>


                            <button @click="deleteInterview(interview.id)" type="button" class="btn btn-danger btn-sm"
                                    style="position: absolute;right: 5px;top: 5px"><i class="fa fa-trash-alt"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>
    `,

    data: function () {
        return {
            form: {
                position: '',
                date: '',
                interviewer: '',
                test_result: '',
                test_name: '',
            },
            interviews: []
        }
    },
    props: ['positions', 'developer'],
    mounted() {
        console.log(this.developer.interviews)
    },
    methods: {
        submit: function () {
            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$http.post(`/dashboard/developers/${this.developer.id}/interview`, this.form)
                        .then(() => {
                            location.reload();
                        }).catch((error) => {
                        this.$setErrorsFromResponse(error.response.data);
                    })
                }

            });
        },
        deleteInterview: function (id) {
           if (confirm('Confirm delete')){
               this.$http.delete(`/dashboard/developers/${this.developer.id}/interview/${id}`)
                   .then(() => {
                       location.reload();
                   }).catch(() => {
               })
           }
        }
    }
})
