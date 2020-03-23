<template>
    <div class="row">
        <!-- PRODUCT LIST -->
        <div class="col-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">List of User Roles</h3>
                    <div class="float-right">                
                                      
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <tbody v-for="role in roles" v-bind:key="role.id">
                            <tr>
                                <td>{{role.role}}</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-info" @click="editRole(role)" title="click to update info..."><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-dark" @click="showRole(role.id)" title="click to show info..."><i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" @click="deleteRole(role.id)" title="click to delete..."><i class="fas fa-trash"></i></a>
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

            <div class="card card-secondary">
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
                                <td>{{module_name.module}}</td>
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

        <!-- Note -->
        <div class="col-8">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username mb-2 mt-3">{{r_category.role}} Account</h3>
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
                        <tr v-for="mod in modules" v-bind:key="mod.id">
                            <td>{{mod.module}}</td>
                            <td class="text-center">
                                <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'view' + mod.id" @change="editModule(mod)" v-model="mod.view"  value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'view' + mod.id"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                 <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'add' + mod.id" @change="editModule(mod)" v-model="mod.create" value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'add' + mod.id"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                 <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'edit' + mod.id" @change="editModule(mod)" v-model="mod.update" value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'edit' + mod.id"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                 <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                    <input type="checkbox" class="custom-control-input" :id="'delete' + mod.id" @change="editModule(mod)" v-model="mod.delete" value="true" unchecked-value="false" >
                                    <label class="custom-control-label" :for="'delete' + mod.id"></label>
                                </div>
                            </td>
                        
                        </tr>
                    </tbody>                  
                    </table>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-module-right"> Add new user</button>
                    <ul class="pagination pagination-sm m-0 float-right">
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

            <form @submit.prevent="addModuleRight">        
                <div class="modal fade" id="modal-module-right" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>                            
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <select name="" id="" class="form-control mb-3" v-model="mod.m_name" required>
                                                <option v-for="module_name in module_names" v-bind:key="module_name.id" :value="module_name.id">{{module_name.module}}</option>
                                            </select>
                                        </div>
                                     </div>    
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger mb-5">
                                                <input type="checkbox" class="custom-control-input" id="view"    v-model="mod.m_view">
                                                <label class="custom-control-label" for="view">view</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger mb-5">
                                                <input type="checkbox" class="custom-control-input" id="create"   v-model="mod.m_add">
                                                <label class="custom-control-label" for="create">create</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger mb-5">
                                                <input type="checkbox" class="custom-control-input" id="update"   v-model="mod.m_edit">
                                                <label class="custom-control-label" for="update">update</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger mb-5">
                                                <input type="checkbox" class="custom-control-input" id="delete"   v-model="mod.m_delete">
                                                <label class="custom-control-label" for="delete">delete</label>
                                            </div>
                                        </div>
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
                    m_view: true,
                    m_add: true,
                    m_edit: true,
                    m_delete: true
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
                r_category: {},
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
                page_url_module = page_url_module || 'api/modules'
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

            showRole(page_url){
                let vm = this;
                if(!isNaN(page_url)){
                    this.mod.m_category = page_url;
                    this.thisRole(page_url);
                    page_url = `api/module-right/${page_url}`;                    
                } else {
                    page_url = page_url;
                }
                fetch(page_url, {
                    method: 'GET'
                })
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.modules = res.data;
                    vm.moduleRight(res);
                })
                .then(data => {})
                .catch(err => toastr.error(err));
                
            },
            
            thisRole(id){
                  
                fetch(`api/role/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                // .then(text => console.log(text))
                .then(res => {
                    this.r_category = res.data;
                    // console.log(this.r_category)
                    // this.r_category = res.data.r_category;
                })
                .then(data => {})
                .catch(err => toastr.error(err));

            },

            moduleRight(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url
                };

                this.pagination = pagination;    
            },

            editRole(role) {
                this.edit = true;
                this.role.r_id = role.id;
                this.role.role_id = role.id;
                this.role.r_category = role.role;
            },


            editModule(mod) {
                this.edit = true;
                this.mod.m_id = mod.id;
                this.mod.m_category = mod.role_id;
                this.mod.m_name = mod.module_id;
                this.mod.m_view = mod.view;
                this.mod.m_add = mod.create;
                this.mod.m_edit = mod.update;
                this.mod.m_delete = mod.delete;
                console.log(this.mod);
                this.updateModule();
            },

            updateModule() {
                
                fetch('/api/module-right',{
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
                this.module_name.module_name = module_name.module;
            },

            deleteModuleName(id) {
                fetch(`api/module/${id}`, {
                        method: 'DELETE'
                    })
                    .then(res => res.json())
                    .then(data => {
                        // alert('User Removed!');
                        this.showRole(this.mod.m_category);
                        this.fetchModules();
                        toastr.success("Module deleted!");
                    })
                    .catch(err => toastr.error(err));

            },

            addModuleName() {
                if(this.edit === false) {
                    fetch('/api/module',{
                        method: 'POST',
                        body: JSON.stringify(this.module_name),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    .then(res => {
                        if(res.err === true){
                            toastr.error(msg);
                        }else{
                            toastr.success("Module added!");
                        }
                    })
                    .then( data => {
                        this.module_name.id = null;
                        this.module_name.module_name = '';
                        this.fetchModules();
                        //alert('User Added!');
                        
                    })
                    .catch(err => toastr.error(err));
                } else {
                    // Update
                    fetch('/api/module',{
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
            },

            addModuleRight(){
                // console.log(this.mod);
                fetch('api/module-right', {
                    method: 'POST',
                    body: JSON.stringify(this.mod),
                    headers: {
                        'Content-Type': 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res =>{
                    if(res.data.err == true){
                        toastr.warning(res.data.msg)
                    } else {
                        this.showRole(this.mod.m_category);
                        toastr.success("Module Rights added!")
                    }
                    
                })
                .catch(err => toastr.error(err));
            }
        }
    }
</script>