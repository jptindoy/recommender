<template>
    <div>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">Pending Request</span>
                        <span class="info-box-number">
                         {{widget.countallRequest}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ban"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">Disapproved Request</span>
                        <span class="info-box-number">
                         {{widget.countcancelled}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">Approved Request</span>
                        <span class="info-box-number">
                          {{widget.countapproved}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
              <!-- /.info-box -->

            </div>   
        </div> 
        <div class="row mb-5">
            
            <div class="col-3">
                <label for="search"> Search Request</label>
                <form @submit.prevent="editRequest(input)">
                    <div class="input-group input-group-sm">
                        <input type="number" v-model="input" @input="searchNumber" list="po-number" name=""  class="form-control" placeholder="search PO Number" required>
                        <datalist id="po-number">
                            <option v-for="item in searchItem" :key="item.id">{{item.po_number}}</option>
                        </datalist>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-info btn-flat" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-search"></i></button>
                        </span>
                        
                    </div>
                    <br>
                    <a href="/request" class="btn btn-primary">Create Request</a>       
                </form>
            </div> 

            
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">
                            Pending Request
                        </h5>
                    </div>
                    <div class="card-body">
                        <div v-if="widget.allRequest == ''" class="text-center">
                            <h5>No Records</h5>
                        </div>
                        <table v-else class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>PO Number</td>
                                    <td>Date Created</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in widget.allRequest" :key="item.id">
                                    <td>{{item.po_number}}</td>
                                    <td>{{item.updated_at}}</td>
                                    <td>
                                        <button @click="editRequest(item.po_number)" class="btn btn-info" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-eye"></i></button>
                                        <button @click="disapprovedRequest(item)" class="btn btn-primary" title="Aprove this request!"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">
                            Disapproved Request
                        </h5>
                    </div>
                    <div class="card-body">
                        <div v-if="widget.cancelled == ''" class="text-center">
                            <h5>No Records</h5>
                        </div>
                        <table v-else class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>PO Number</td>
                                    <td>Date Update</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in widget.cancelled" :key="item.id">
                                    <td>{{item.po_number}}</td>
                                    <td>{{item.updated_at}}</td>
                                    <td>
                                        <button @click="editRequest(item.po_number)" class="btn btn-info" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-eye"></i></button>
                                        <button @click="approvedRequest(item)" class="btn btn-primary" title="Approve this request!"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
            <div class="col-xs-12 col-md-4">
              <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">
                            On Proccess Request
                        </h5>
                    </div>
                    <div class="card-body">
                        <div v-if="widget.approved == ''" class="text-center">
                            <h5>No Records</h5>
                        </div>
                        <table v-else class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>PO Number</td>
                                    <td>Date Update</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in widget.approved" :key="item.id">
                                    <td>{{item.po_number}}</td>
                                    <td>{{item.updated_at}}</td>
                                    <td>
                                        <button @click="editRequest(item.po_number)" class="btn btn-info" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-eye"></i></button>
                                        <button @click="disapprovedRequest(item)" class="btn btn-danger" title="Disapprove this request!"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
        </div> 
        <div class="row">
            <!-- Modal -->
            <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <request-item :editId="editId" ></request-item>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data() {
            return {
                widget : [],
                editId: null,
                update: {},
                searchItem :[],
                po_number : null,
                input : null,
            }
        },

        created() {
            Event.$on('widget', (e) => {
                this.getWidget();
            });
            this.getWidget();
        },

        methods: {
            getWidget() {
                fetch('api/request-widget')
                .then(res => res.json())
                .then(res => {
                    this.widget = res
                })
                .catch(err => toastr.err(err))
            },

            editRequest(id){
                this.editId = id
                Event.$emit('editRequest', this.editId);
                
            },

            approvedRequest(id) {
                this.update.PO_number = id.po_number;
                this.update.dateNeeded = id.date_needed;
                this.update.action = 'approved';
                fetch('api/update-request', {
                    method:'POST',
                    body: JSON.stringify(this.update),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {            
                    this.getWidget();               
                    toastr[res.type](res.msg);              
                })
                .catch(err => toastr.error(err))
            },

            disapprovedRequest(id) {
                this.update.PO_number = id.po_number;
                this.update.dateNeeded = id.date_needed;
                this.update.action = 'disapproved';
                fetch('api/update-request', {
                    method:'POST',
                    body: JSON.stringify(this.update),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {            
                    this.getWidget(); 
                    toastr[res.type](res.msg);          
                })
                .catch(err => toastr.error(err))
            },

            searchNumber(event){
                if(event.target.value != ''){
                    fetch(`api/search-request/${event.target.value}`)
                    .then(res => res.json())
                    .then(res => {
                        this.searchItem = res.items
                        this.po_number = event.target.value
                    })
                    .catch(err => toastr.err(err))
                }             
            }
        }
    }

</script>
