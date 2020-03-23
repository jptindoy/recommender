<template>
    <!-- Widget: user widget style 1 -->
    <div v-if="show" class="card card-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-info">
            <h3 class="widget-user-username">{{profile.fname}} {{profile.lname}}</h3>
            <h5 class="widget-user-desc">{{profile.role}}</h5>
        </div>
        <div class="widget-user-image">
            <img v-bind:src="'/storage/img/profile-img/' + profile.image" class="img-circle elevation-2" alt="User Avatar">
        </div>
        <div class="card-footer">

            <div class="row">
            <div class="col-sm-4 border-right">
                <div class="description-block">
                <h5 class="description-header">{{profile.email}}</h5>
                <span class="description-text">Email</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
                <div class="description-block">
                <h5 class="description-header">
                    <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                        <input type="checkbox" class="custom-control-input" @change="updateUser(profile)" :id="'status' + profile.active"  v-model="profile.active" v-bind:value="profile.active" checked-value="true" unchecked-value="false">
                            <label class="custom-control-label" :for="'status' + profile.active"></label>
                    </div>
                </h5>
                <span class="description-text">Satus</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
                <div class="description-block">
                <h5 class="description-header">{{moment(profile.created_at).format('MMMM D, YYYY')}}</h5>
                <span class="description-text">Date Created</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->


        <div class="form-group">

        </div>

        <hr>
        <strong><i class="fas fa-th-list mr-1"></i> Logs</strong>
        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th style="width: 30%">Date</th>
                <th>Sission ID</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="log in logs" v-bind:key="log.id">
                <td>{{moment(log.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                <td>{{log.session_id}}</td>
            </tr>
            </tbody>
        </table>
            <ul class="pagination pagination-sm">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Previous" @click="getUserLog(pagination.prev_page_url)">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                <li class="page-item disabled"><a class="page-link" href="#">{{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Next" @click="getUserLog(pagination.next_page_url)">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>   
        </div>
    </div>
    <!-- /.widget-user -->    
</template>

<script>    
    import moment from 'moment';

    export default {
        props: {
            userId: Number,
        },

        data() {
            return {
                profile: [],
                logs: [],
                show: false,          
                pagination: {},  
                status:{
                    active: null,
                id: null,
                }               
                             
            }
        },

        created(){
            Event.$on('profile', (profile) => {
               this.fetchProfile(this.userId);
            })
            Event.$on('checkProfile', (id) =>{
                this.fetchProfile(id);
                this.getUserLog(id);
            })
            this.fetchProfile(this.userId);
            this.getUserLog(this.userId);
        },

        methods: {
            moment,

            fetchProfile(id){                
                
                fetch( `/api/user/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.profile = res.data;                    
                })
                .then(data => {
                    this.show = true;
                })
                .catch(err => toastr.error(err));
            },

            getUserLog(page_url) {
                let vm = this;
                if(!isNaN(page_url)){
                    page_url = `/api/log/${page_url}`;
                } else {
                    page_url = page_url;
                }
                fetch(page_url,{
                    method: 'GET',
                    headers: {
                        'Content-Type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res =>{
                    this.logs = res.data;
                    vm.profilePagination(res);
                })
                .then(data => {})
                .catch(err => toastr.error(err));
            },
            
            profilePagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url
                };

                this.pagination = pagination;    
            },

            updateUser(profile) {
                this.status.active = profile.active;
                this.status.id     = profile.id;
                fetch(`api/user/${this.status.id}`,{
                        method: 'PUT',
                        body: JSON.stringify(this.status),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    //.then(text => console.log(text))
                    .then( data => {
                        // this.clearForm();
                        Event.$emit('showUsers');
                        //alert('User Added!');
                        toastr.success("Status updated!");
                    })
                    .catch(err => toastr.error(err));
            },
        }

    }
</script>
