<template>
    <div class="row">
        <div class="col-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">List of Users</h3>
                    <div class="float-right">                
                                    
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        <table class="table">
                            <tbody>
                                <tr v-for="user in users" v-bind:key="user.u_id">
                                    <td><a href="javascript:void(0)" @click="showUser(user.id)" title="click to expand.."><img v-bind:src="'storage/img/profile-img/' + user.image" alt="Product Image" class="img-size-50"></a></td>
                                    <td>
                                        <a href="javascript:void(0)" @click="showUser(user.id)" class="product-title" title="click to expand...">{{user.fname}} {{user.lname}}</a>
                                        <span v-if="user.active == true" class="badge badge-success float-right">Active</span>
                                        <span v-else class="badge badge-danger float-right">In Active</span>
                                        <span class="product-description">
                                            {{user.role}}
                                        </span>
                                    </td>
                                    <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-info" data-toggle="modal" data-target="#modal-user" @click="editUser(user)" title="click to update info..."><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-success" @click="showUser(user.id)" title="click to show info..."><i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" @click="deleteUser(user.id)" title="click to delete..."><i class="fas fa-trash"></i></a>
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
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-user" v-on:click="clearForm()"> Add new user</button>
                    
                    
                </div>
                <!-- /.card-footer -->
                <form @submit.prevent="addUser">        
                    <div class="modal fade" id="modal-user" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Create or Update User</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>                            
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="u-role">User role *</label>
                                            <select class="form-control" name="u-role" id="u-role" v-model="user.u_role" required>
                                                <option v-for="role in roles" v-bind:key="role.id" :value="role.id">{{role.role}}</option>                                
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="u-fname">Firstname *</label>
                                            <input type="text" class="form-control" id="u-fname" placeholder="f name"   v-model="user.u_fname" required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="u-lname">Lastname *</label>
                                            <input type="text" class="form-control" id="u-lname" placeholder="l name" v-model="user.u_lname" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="u-email">Email address *</label>
                                            <input type="email" class="form-control" id="u-email" placeholder="@email" v-model="user.u_email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password *</label>
                                            <input type="password" class="form-control" id="password" placeholder="password" v-model="user.u_password" required>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->        
                                        
                                </div>        
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" >Save changes</button>
                                </div>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->                
                </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-8">
            <profile-page :user-id="id" :user-role="userRole"></profile-page>
        </div>
    </div>
    
   
</template>

<script>
    import moment from 'moment';
    import Profile from './Profile.vue';

    export default {

        components: {
            'profile-page': Profile,
        },

        props: {
            userId: Number,
            userRole: Number,
        },

        data() {
            return {
                id: this.userId,
                users: [],
                user: {
                    u_id: null,
                    u_fname: '',
                    u_lname: '',
                    u_email: '',
                    u_password: '',
                    u_role: '',                  
                },
                roles: [],
                role: {
                    r_id: '',
                    r_category: ''
                },
                pagination: {},
                edit: false,
                hide_pass: false, 
            }
        },

        created() {
            Event.$on('showUsers', (show) => {
                this.fetchUsers();
            })
            this.fetchUsers();
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
                .catch(err => toastr.error(err));
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

            clearForm() {
                this.edit = false;
                this.user.u_id = null;
                this.user.u_fname = '';
                this.user.u_lname = '';                 
                this.user.u_email = '';                 
                this.user.u_role = '';                 
                this.user.u_password = '';                  
            },

            editUser(user) {
                this.edit = true;
                this.hide_pass = true;
                this.user.user_id = user.id;
                this.user.u_fname = user.fname;
                this.user.u_lname = user.lname;
                this.user.u_email = user.email;
                this.user.u_image = user.image;
                this.user.u_role = user.role;                
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
                .catch(err => toastr.error(err));
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
                        toastr.success("User aded!");
                    })
                    .catch(err => toastr.error(err));
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
                        toastr.success("Record updated!");
                    })
                    .catch(err => toastr.error(err));
                }   
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
                    toastr.success("User deleted!");
                })
                .catch(err => toastr.error(err));
            },

            showUser(id){
                this.id = id;
                Event.$emit('checkProfile', this.id);
            }
        }
    }
</script>
