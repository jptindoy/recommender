<template>
    <div class="row">
        <!-- PRODUCT LIST -->
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Users</h3>
                    <div class="float-right">                
                                   
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        <table class="table">
                            <tbody>
                                <tr v-for="user in users" v-bind:key="user.u_id">
                                    <td><a href="javascript:void(0)" @click="showUser(user)" title="click to expand.."><img v-bind:src="'storage/img/profile-img/' + user.u_image" alt="Product Image" class="img-size-50"></a></td>
                                    <td>
                                        <a href="javascript:void(0)" @click="showUser(user)" class="product-title" title="click to expand...">{{user.u_fname}} {{user.u_lname}}</a>
                                        <span v-if="user.u_status == true" class="badge badge-success float-right">Active</span>
                                        <span v-else class="badge badge-danger float-right">In Active</span>
                                        <span class="product-description">
                                            {{user.r_category}}
                                        </span>
                                    </td>
                                    <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-info" @click="editUser(user)" title="click to update info..."><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-success" @click="showUser(user)" title="click to show info..."><i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" @click="deleteUser(user.u_id)" title="click to delete..."><i class="fas fa-trash"></i></a>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </ul>
                        
                </div>
                <!-- /.card-body -->
                
                        
                <div class="card-footer">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="#" aria-label="Previous" @click="fetchUsers(pagination.prev_page_url)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="#">{{pagination.current_page}} of {{pagination.last_page}}</a></li>
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="#" aria-label="Next" @click="fetchUsers(pagination.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul>
                    <button class="btn btn-info btn-sm" v-on:click="add = true, 
                                                        isHidden = true,
                                                        edit = false,
                                                        show = false,
                                                        pass_reset = true,
                                                        clearForm()"> Add new user</button>
                    
                    
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>


        <!-- Note -->
        <!-- <div class="col-8" v-if="!isHidden">
            <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                Note: Only Administrator account has the acces to this page. 
            </div>
        </div> -->

        <!-- View Profile -->
        <div class="col-8" v-if="show">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">{{user.u_fname}} {{user.u_lname}}</h3>
                    <h5 class="widget-user-desc">{{user.u_role}}</h5>
                </div>
                <div class="widget-user-image">
                    <img v-bind:src="'storage/img/profile-img/' + user.u_image" class="img-circle elevation-2" alt="User Avatar">
                </div>
                <div class="card-footer">

                    <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">{{user.u_email}}</h5>
                        <span class="description-text">Email</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">
                            <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                <input type="checkbox" class="custom-control-input" @change="updateUser(user.u_id)" :id="'view' + user.u_status"  v-model="user.u_status" v-bind:value="user.u_status" checked-value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'view' + user.u_status"></label>
                            </div>
                        </h5>
                        <span class="description-text">Satus</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">{{moment(date_created).format('MMMM Do YYYY, h:mm:ss a')}}</h5>
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
                    <tr v-for="log in logs" v-bind:key="log.ul_id">
                      <td>{{moment(log.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                      <td>{{log.ul_session_id}}</td>                      
                    </tr>
                  </tbody>                  
                </table>
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
        </div>

        <!-- FORM -->
        <div class="col-8" v-if="add">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form @submit.prevent="addUser" role="form">
                    <div class="card-body">
                         <div class="form-group">
                            <label for="u-fname">Firstname *</label>
                            <input type="text" class="form-control" id="u-fname" placeholder="f name"   v-model="user.u_fname">
                            
                        </div>
                        <div class="form-group">
                            <label for="u-lname">Lastname *</label>
                            <input type="text" class="form-control" id="u-lname" placeholder="l name" v-model="user.u_lname">
                        </div>
                        <div class="form-group">
                            <label for="u-email">Email address *</label>
                            <input type="email" class="form-control" id="u-email" placeholder="@email" v-model="user.u_email">
                        </div>

                        <div class="form-group">
                            <label for="u-role">User role *</label>
                            <select class="form-control" name="u-role" id="u-role" v-model="user.u_role">
                                <option v-for="role in roles" v-bind:key="role.r_id" :value="role.r_id">{{role.r_category}}</option>
                                
                            </select>
                        </div>

                        <div class="form-group" v-if="pass_reset">
                            <label for="u-pass1">Password *</label>
                            <input type="password" class="form-control" id="u-pass1" placeholder="Password" v-model="user.u_password">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</template>

<script>

    import moment from 'moment'

    export default {
        data() {
            return {
                users: [],
                user: {
                    u_id: '',
                    u_fname: '',
                    u_lname: '',
                    u_email: '',
                    u_password: '',
                    u_role: '',
                    u_status: '',
                    u_image: ''
                    
                },
                user_id: '',                
                pagination: {},
                edit: false,
                show: false,
                isHidden: false,
                add: false,
                pass_reset: true,
                date_created: '',
                logs: '',
                roles: '',
            }
        }, 
        
        props: {
            userId: Number,
        },

        created() {
            this.fetchUsers();
            this.showProfile(this.userId);
            this.getUserLog(this.userId);
            this.getRole();
        },
        
        methods: {
            moment,

            fetchUsers(page_url) {
                let vm = this;
                page_url = page_url || 'api/users'
                fetch(page_url)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.users = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination = pagination;    
            },

            addUser() {
                
                if(this.edit === false) {

                    fetch('api/user',{
                        method: 'POST',
                        body: JSON.stringify(this.user),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    //.then(text => console.log(text))
                    .then( data => {
                        this.clearForm();
                        this.fetchUsers();
                        //alert('User Added!');
                    })
                    .catch(err => console.log(err));
                } else {
                    fetch('api/user',{
                        method: 'PUT',
                        body: JSON.stringify(this.user),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    //.then(text => console.log(text))
                    .then( data => {
                        this.clearForm();
                        this.fetchUsers();
                        //alert('User Added!');
                    })
                    .catch(err => console.log(err));
                }   
            },

            clearForm() {
                this.edit = false;
                this.user.u_id = null;
                this.user.user_id = null;
                this.user.u_fname = '';
                this.user.u_lname = '';                 
                this.user.u_email = '';                 
                this.user.u_role = '';                 
                this.user.u_password = '';                  
            },

            editUser(user) {
                this.edit = true;
                this.add = true;
                this.show = false;
                this.isHidden = true;
                this.pass_reset = false;
                this.user.u_id = user.u_id;
                this.user.user_id = user.u_id;
                this.user.u_fname = user.u_fname;
                this.user.u_lname = user.u_lname;
                this.user.u_email = user.email;
                this.user.u_image = user.u_image;
                this.user.u_role = user.u_role;
                this.r_category = user.r_category;
                this.r_id = user.u_role;
                this.date_created = user.created_at;
                
            },

            showUser(user) {
                this.edit = false;
                this.add = false;
                this.isHidden = true;
                this.show = true;
                this.user.u_id = user.u_id;
                this.user.user_id = user.u_id;
                this.user.u_fname = user.u_fname;
                this.user.u_lname = user.u_lname;
                this.user.u_email = user.email;
                this.user.u_image = user.u_image;
                this.user.u_role = user.r_category;
                this.user.r_id = user.r_role;
                this.date_created = user.created_at;
                this.date_created = user.created_at;
                this.user.u_status = user.u_status;
                this.getUserLog(user.u_id);
                
            },

            deleteUser(id) {
                fetch(`api/user/${id}`, {
                    method: 'DELETE'
                })
                .then(res => res.json())
                // .then(text => console.log(text))
                .then(data => {
                    // alert('Menu Removed');
                    this.fetchUsers();
                })
                .catch(err => console.log(err));
            },
            
            showProfile(id) {
                fetch(`api/user/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                .then(res => {
                    this.show = true;
                    this.user.u_id = res.data.u_id;
                    this.user.user_id = res.data.u_id;
                    this.user.u_fname = res.data.u_fname;
                    this.user.u_lname = res.data.u_lname;
                    this.user.u_email = res.data.email;
                    this.user.u_image = res.data.u_image;
                    this.user.u_role = res.data.r_category;
                    this.user.r_id = res.data.r_role;
                    this.date_created = res.data.created_at;
                    this.user.u_status = res.data.u_status;
                })
                
                .then(data => {
                    
                })
                .catch(err => console.log(err));
            },

            updateUser(id) {
                fetch(`api/user/${id}`,{
                        method: 'PUT',
                        body: JSON.stringify(this.user),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    //.then(text => console.log(text))
                    .then( data => {
                        // this.clearForm();
                        this.fetchUsers();
                        //alert('User Added!');
                    })
                    .catch(err => console.log(err));
            },
            
            getUserLog(id) {
                fetch(`api/log/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                .then(res =>{
                    this.logs = res.data;
                })
                .then(data => {})
                .catch(err => console.log(err));
            },

            getRole(){
                fetch('api/getrole',{
                    method: 'GET'
                })
                .then(res => res.json())
                .then(res => {
                    this.roles = res.data;
                })
                .then(data => {})
                .catch(err => console.log(err));
            },

        }
    }
</script>