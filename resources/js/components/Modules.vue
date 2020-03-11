<template>
    <div class="row">
        <!-- PRODUCT LIST -->
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of User Roles</h3>
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
                                        <a href="javascript:void(0)" class="btn btn-info" @click="editRole(role)" title="click to update info..."><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-dark" @click="showRole(role.r_id)" title="click to show info..."><i class="fas fa-eye"></i></a>
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
                        <li class="page-item" v-bind:class="[{disabled: !role_pagination.prev_page_url}]">
                        <a class="page-link" href="javascript:void(0)" aria-label="Previous" @click="fetchRoles(role_pagination.prev_page_url)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">{{role_pagination.current_page}} of {{role_pagination.last_page}}</a></li>
                        <li class="page-item" v-bind:class="[{disabled: !role_pagination.next_page_url}]">
                        <a class="page-link" href="javascript:void(0)" aria-label="Next" @click="fetchRoles(role_pagination.next_page_url)">
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
        <div class="col-6">
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
                            <td>{{mod.module_name}}</td>
                            <td class="text-center">
                                <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'view' + mod.m_id" @change="editModule(mod)" v-model="mod.m_view" v-bind:value="mod.m_view" checked-value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'view' + mod.m_id"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                 <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'add' + mod.m_id" @change="editModule(mod)" v-model="mod.m_add" value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'add' + mod.m_id"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                 <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'edit' + mod.m_id" @change="editModule(mod)" v-model="mod.m_edit" value="false" unchecked-value="true" >
                                    <label class="custom-control-label" :for="'edit' + mod.m_id"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                 <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'delete' + mod.m_id" @change="editModule(mod)" v-model="mod.m_delete" value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'delete' + mod.m_id"></label>
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

        
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Modules</h3>
                    <div class="float-right">                
                                      
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <tbody v-for="module_name in module_names" v-bind:key="module_name.id">
                            <tr>
                                <td>{{module_name.module_name}}</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-info" @click="editModuleName(module_name)" title="click to update info..."><i class="fas fa-edit"></i></a>
                                       
                                        <a href="javascript:void(0)" class="btn btn-danger" @click="deleteModuleName(module_name.id)" title="click to delete..."><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                            
                <div class="card-footer text-center">      
                    
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item" v-bind:class="[{disabled: !module_name_pagination.prev_page_url}]">
                        <a class="page-link" href="javascript:void(0)" aria-label="Prev" @click="fetchModules(module_name_pagination.prev_page_url)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">{{module_name_pagination.current_page}} of {{module_name_pagination.last_page}}</a></li>
                        <li class="page-item" v-bind:class="[{disabled: !module_name_pagination.next_page_url}]">
                        <a class="page-link" href="javascript:void(0)" aria-label="Nex" @click="fetchModules(module_name_pagination.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul> 
                    <form @submit.prevent="addModuleName()" role="form">       
                        <div class="input-group input-group-sm" style="width:70%;">
                            <input type="text" class="form-control" v-model="module_name.module_name" required>
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
                module_pagination: {},
                roles: [],
                role: {
                    r_id: '',
                    r_category: ''
                },
                role_pagination: {},
                module_names: [],
                module_name:{
                    id: '',
                    module_name: ''
                },
                module_name_pagination: {},
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
            this.fetchModules();
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
                    vm.rolePagination(res.meta, res.links);
                })
                .catch(err => toastr.error(err));
            },

            rolePagination(meta, links) {
                let role_pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.role_pagination = role_pagination;    
            },

            fetchModules(page_url_module) {
                let vm = this;
                page_url_module = page_url_module || 'api/module-names'
                fetch(page_url_module)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.module_names = res.data;
                    vm.module_name_Pagination(res.meta, res.links);
                })
                .catch(err => toastr.error(err));
            },

            module_name_Pagination(meta, links) {
                let module_name_pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.module_name_pagination = module_name_pagination;    
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
                        toastr.success("Role deleted!");
                    })
                    .catch(err => toastr.error(err));
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
                        toastr.success("Role added!");
                    })
                    .catch(err => toastr.error(err));
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
                        this.role.r_id = null;
                        this.role.r_category = '';
                        this.fetchRoles();
                        toastr.success("Role Updated!");
                    })
                    .catch(err => toastr.error(err));
                }
            },

            showRole(id){
                fetch(`api/module/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.modules = res.data;
                    // this.r_category = res.data.r_category;
                })
                .then(data => {})
                .catch(err => toastr.error(err));

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
                .catch(err => toastr.error(err));
            },

            showPagination(meta, links) {
                let modulepagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination = pagination;    
            },

            editRole(role) {
                this.edit = true;
                this.role.r_id = role.r_id;
                this.role.role_id = role.r_id;
                this.role.r_category = role.r_category;
            },


            editModule(mod) {
                this.edit = true;
                this.mod.m_id = mod.m_id;
                this.mod.m_category = mod.m_category;
                this.mod.m_name = mod.m_name;
                this.mod.m_view = mod.m_view;
                this.mod.m_add = mod.m_add;
                this.mod.m_edit = mod.m_edit;
                this.mod.m_delete = mod.m_delete;
                                
                this.updateModule();
            },

            updateModule() {
                
                fetch('/api/module',{
                    method: 'PUT',
                    body: JSON.stringify(this.mod),
                    headers: {
                        'Content-type' : 'Application/json'
                    }

                })
                .then( res => res.json())
                //.then(text => console.log(text))
                .then( data => {
                    this.edit = false;
                    // this.role.r_category = '';
                    // this.fetchRoles();
                    //alert('User Added!');
                    toastr.success("Module updated!");
                })
                .catch(err => toastr.error(err));
            },

            editModuleName(module_name) {
                
                this.edit = true;
                this.module_name.id = module_name.id;
                this.module_name.module_name = module_name.module_name;
            },

            deleteModuleName(id) {
                fetch(`api/module-name/${id}`, {
                        method: 'DELETE'
                    })
                    .then(res => res.json())
                    .then(data => {
                        // alert('User Removed!');
                        this.fetchModules();
                        toastr.success("Module deleted!");
                    })
                    .catch(err => toastr.error(err));

            },

            addModuleName() {
                if(this.edit === false) {
                    fetch('/api/module-name',{
                        method: 'POST',
                        body: JSON.stringify(this.module_name),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    // .then(text => console.log(text))
                    .then( data => {
                        this.module_name.id = null;
                        this.module_name.module_name = '';
                        this.fetchModules();
                        //alert('User Added!');
                        toastr.success("Module added!");
                    })
                    .catch(err => toastr.error(err));
                } else {
                    // Update
                    fetch('/api/module-name',{
                        method: 'PUT',
                        body: JSON.stringify(this.module_name),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    //.then(text => console.log(text))
                    .then( data => {
                        this.edit = false;
                        this.module_name.id = null;
                        this.module_name.module_name = '';
                        this.fetchModules();
                        //alert('User Added!');
                        toastr.success("Module updated!");
                    })
                    .catch(err => toastr.error(err));
                }
            }
        }
    }
</script>