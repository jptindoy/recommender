<template>
    <div class="row">
        <!-- PRODUCT LIST -->
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Users</h3>
                    <div class="float-right">                
                        <ul class="pagination pagination-sm">
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
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        <li class="item" v-for="user in users" v-bind:key="user.u_id">
                            <div class="product-img">
                                <img v-bind:src="'storage/img/' + user.u_image"  alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" @click="editUser()" class="product-title">{{user.u_fname}} {{user.u_lname}}
                                <span class="badge badge-success float-right">Active</span></a>
                                <span class="product-description">
                                    {{user.r_category}}
                                </span>
                            
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                    
                    <a href="javascript:void(0)" v-on:click="add = true, isHidden = true, edit = false" class="uppercase">Add new user</a>
                    
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>


        <!-- Note -->
        <div class="col-8" v-if="!isHidden">
            <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                Note: Only Administrator account has the acces to this page. 
            </div>
        </div>

        <!-- View Profile -->
        <div class="col-8" v-if="edit">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">Alexander Pierce</h3>
                <h5 class="widget-user-desc">Founder & CEO</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" v-bind:src="'storage/img/' + user.u_image" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
        </div>

        <!-- FORM -->
        <div class="col-8" v-if="add">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add User</h3>
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
                                <option value="1">Administrator</option>
                                <option value="2">Accountant</option>
                            </select>
                        </div>

                        <div class="form-group">
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
                    u_role: ''
                },
                user_id: '',
                pagination: {},
                edit: false,
                isHidden: false,
                add: false
            }
        }, 

        created() {
            this.fetchUsers();
        },
        
        methods: {
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

            deleteUser(u_id) {
                if(confirm('Are you sure?')) {
                    fetch(`api/user/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('User Removed!');
                        this.fetchUsers();
                    })
                    .catch(err => console.log(err));
                }
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

            editUser() {
                this.edit = true;
                this.add = false;
                this.isHidden = true;
                
            }

        }
    }
</script>