<template>
    <div class="row">
        <!-- PRODUCT LIST -->
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of User Role</h3>
                    <div class="float-right">                
                                      
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <tbody v-for="role in roles" v-bind:key="role.r_id">
                            <tr>
                                <td>{{role.r_category}}</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-success" @click="editRole(role)" title="click to update info..."><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-info" @click="showRole(role.r_id)" title="click to show info..."><i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" @click="deleteRole(role.r_id)" title="click to delete..."><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                            
                <div class="card-footer text-center">      
                    
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="#" aria-label="Previous" @click="fetchRoles(pagination.prev_page_url)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="#">{{pagination.current_page}} of {{pagination.last_page}}</a></li>
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="#" aria-label="Next" @click="fetchRoles(pagination.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul> 
                    <form @submit.prevent="addRole()" role="form">       
                        <div class="input-group input-group-sm" style="width:70%;">
                            <input type="text" class="form-control" v-model="role.r_category" required>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-info btn-flat">Save</button>
                            </span>
                        </div> 
                    </form>            
                    
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>


        <!-- Note -->
        <div class="col-8">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username mb-2 mt-3">{{r_category}} Account</h3>
                    <h5 class="widget-user-desc"><i class="fas fa-th-list mr-1"></i> List of Module Management</h5>
                </div>
                
                <div class="card-footer">                       
                   
                    <table class="table table-bordered mt-3">
                    <thead>                  
                        <tr>
                            <th style="width: 30%">Module</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Add</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="mod in modules" v-bind:key="mod.m_id">
                            <td>{{mod.m_name}}</td>
                            <td class="text-center">
                                <div v-if="mod.m_view == true" class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view" checked>
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                                <div v-else class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view">
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div v-if="mod.m_add == true" class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view" checked>
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                                <div v-else class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view">
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div v-if="mod.m_edit == true" class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view" checked>
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                                <div v-else class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view">
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div v-if="mod.m_delete == true" class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view" checked>
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                                <div v-else class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" id="view">
                                    <label class="custom-control-label" for="view"></label>
                                </div>
                            </td>
                        
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
    </div>
    
</template>

<script>
    export default {
        data() {
            return {
                modules: [],
                mod: {
                    m_id: '',
                    m_category: '',
                    m_name: '',
                    m_view: '',
                    m_add: '',
                    m_edit: '',
                    m_delete: ''
                },
                roles: [],
                role: {
                    r_id: '',
                    r_category: ''
                },
                edit: false,
                module_id: '',
                role_id: '',
                pagination: {},
                r_category: ''
            }
        }, 

        props: {
            userId: Number,
        },

        created() {
            this.fetchRoles();
            this.showRole(this.userId);
        },
        
        methods: {
            fetchRoles(page_url) {
                let vm = this;
                page_url = page_url || 'api/roles'
                fetch(page_url)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.roles = res.data;
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

            deleteRole(id) {
                // if(confirm('Are you sure?')) {
                //     fetch(`api/role/${id}`, {
                //         method: 'DELETE'
                //     })
                //     .then(res => res.json())
                //     .then(data => {
                //         alert('User Removed!');
                //         this.fetchRoles();
                //     })
                //     .catch(err => console.log(err));
                // }

                fetch(`api/role/${id}`, {
                        method: 'DELETE'
                    })
                    .then(res => res.json())
                    .then(data => {
                        // alert('User Removed!');
                        this.fetchRoles();
                    })
                    .catch(err => console.log(err));
            },

            addRole() {
                if(this.edit === false) {
                    fetch('api/role',{
                        method: 'POST',
                        body: JSON.stringify(this.role),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    // .then(text => console.log(text))
                    .then( data => {
                        this.role.r_category = '';
                        this.fetchRoles();
                        //alert('User Added!');
                    })
                    .catch(err => console.log(err));
                } else {
                    // Update
                    fetch('/api/role',{
                        method: 'PUT',
                        body: JSON.stringify(this.role),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    //.then(text => console.log(text))
                    .then( data => {
                        this.edit = false;
                        this.role.r_category = '';
                        this.fetchRoles();
                        //alert('User Added!');
                    })
                    .catch(err => console.log(err));
                }
            },

            showRole(id){
                fetch(`api/module/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                // .then(text => console.log(text))
                .then(res => {
                    this.modules = res.data;
                    // this.r_category = res.data.r_category;
                })
                .then(data => {})
                .catch(err => console.log(err));

                /////////////////////////////////////

                fetch(`api/role/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                // .then(text => console.log(text))
                .then(res => {
                    this.r_category = res.data.r_category;
                    // this.r_category = res.data.r_category;
                })
                .then(data => {})
                .catch(err => console.log(err));
            },

            editRole(role) {
                this.edit = true;
                this.role.r_id = role.r_id;
                this.role.role_id = role.r_id;
                this.role.r_category = role.r_category;
            }
        }
    }
</script>