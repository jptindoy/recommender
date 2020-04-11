<template>
    <div class="row">
        <div class="col-xs-12 col-md-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <h5 class="card-title">Item List</h5>
                </div>            
                <div class="card-body">
                
                    <div class="row">
                        <div class="form-goup mb-3">
                            <input type="text" class="form-control" @keyup="searchItem" v-model="search" placeholder="Search Item...">
                        </div>
                    </div>
                    <div class="row  item-list">
                        <div v-if="isLoading" class="mx-auto mt-5">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Loading items...
                            </div>
                        <table v-else class="table table-bordered">
                            
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr v-for="item in itemLists" :key="item.id">
                                    <td>{{item.product_name}}</td>
                                    <td>
                                        <button class="btn btn-info" @click="addItem(item.product_name)"><i class="fa fa-arrow-right"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-9">
            <div class="card card-secondary">
            
                <div class="card-header">
                    <h5 class="card-title">Create Request</h5>
                </div>      
                <div v-if="items == ''" class="card-body text-center">
                    <h3>Make A Request</h3>
                    <p><i>To add request, click the arrow right on each item in the left corner to add list item.</i></p>
                </div>      
                <div v-else class="card-body">
                    <div class="float-right">
                        <div class="form-group">
                            <label for="">PO Number</label>
                            <input type="text" class="form-control" v-model="update.PO_number" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="">Date Needed</label>
                            <input type="date" class="form-control" v-model="update.dateNeeded"  required>
                        </div>                        
                    </div>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items" :key="item.id">
                                <td>{{item.product_name}}</td>
                                <td>
                                    <div class="row">
                                        <input type="number" @change="changeQty(item)" class="form-control" v-model="item.qty" style="width: 50%;">
                                        <select class="form-control" style="width: 50%;" @change="changeVariant(item)" v-model="item.variant">
                                            <option value="box">box</option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Litter">Litter</option>
                                            <option value="Bottle">Bottle</option>
                                            <option value="Pack">Pack</option>
                                            <option value="Kilo">Kilo</option>
                                        </select>
                                    </div>                                    
                                </td>
                                <td>
                                    <button @click="removeItem(item.id)" class="btn btn-danger" title="Remove Item!"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="items != ''" class="card-footer">
                    <div class="float-right">
                        <button v-if="edit" @click="updateItemList('approved')" class="btn btn-primary" data-dismiss="modal">Update & Approved</button>
                        <button v-if="edit" @click="updateItemList('disapproved')" class="btn btn-primary" data-dismiss="modal">Disaproved</button>
                        <button v-else @click="saveRequest" class="btn btn-primary">Save</button>
                        <button @click="deleteDraft" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                itemList : [],
                isLoading: true,
                search : '',                
                items : [],
                item : {
                    qty : '',
                    variant : '',
                },              
                  
                update: {
                    dateNeeded : null,
                    PO_number : null,
                },
                edit : false,
                editId : null,
                editAddItem : null,
            }
        },
        created() {
            this.getItemList();
            this.getDraftItem();
            
            Event.$on('editRequest', ($event) => {
                this.edit = true;
                this. editId = $event;
                this.editItemList($event);
            });
            
            
        },

        methods: {
            getItemList() {
                fetch('api/item-list')
                .then(res => res.json())
                .then(res => {
                    this.itemLists = res.itemlist;
                    this.isLoading = false;
                })
                .catch(err => toastr.error(err))
            },

            searchItem(){
                this.isLoading = true;
                fetch(`api/item-list/${this.search}`)
                .then(res => res.json())
                .then(res => {
                    this.itemLists = res.itemlist;
                    this.isLoading = false;
                })
                .catch(err => toastr.error(err))
            },

            getDraftItem() {
               fetch('api/draft-item')
               .then(res => res.json())
               .then(res => {
                   this.items = res.items;
                   this.update.PO_number += parseInt(res.poNumber) + 1
               })
               .catch(err => toastr.error(err))
            },

            deleteDraft(){
               fetch('api/delete-draft')
               .then(res => res.json())
               .then(res => {
                   this.getDraftItem();
                   this.update.PO_number = null;
                   toastr.success('Request cancelled!')
               })
               .catch(err => toastr.error(err))
            },

            changeQty(item) {
                this.item.qty = item.qty;
                fetch(`api/qty/${item.id}`,{
                    method: 'PATCH',
                    body: JSON.stringify(this.item),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
               .then(res => res.json())
               .then(res => {
                   
               })
               .catch(err => toastr.error(err))
            },

            changeVariant(item) {
                this.item.variant = item.variant;
                fetch(`api/variant/${item.id}`,{
                    method: 'PATCH',
                    body: JSON.stringify(this.item),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
               .then(res => res.json())
               .then(res => {
                   
               })
               .catch(err => toastr.error(err))
            },

            removeItem(id) {
                fetch(`api/delete-item-list/${id}`,{
                    method: 'DELETE'
                })
                .then(res => res.json())
                .then(res => {
                    if(this.edit === true){
                        this.editItemList(this.editId);
                    } else {
                        this.update.PO_number = null;
                        this.getDraftItem();
                    }
                    
                    toastr.success(res.msg);
                })
                .catch(err => toastr.error(err))
            },

            addItem(id) {
                if(this.edit === true) {
                    this.editAddItem = {
                        po: this.editId,
                        name: id, 
                    }
                    fetch('api/edit-request-draft', {
                        method:'POST',
                        body: JSON.stringify(this.editAddItem),
                        headers: {
                            'Content-type' : 'Application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {                          
                        this.editItemList(this.editId);                                               
                        toastr[res.type](res.msg);                    
                    })
                    .catch(err => toastr.error(err))
                } else {
                    fetch('api/request-draft', {
                        method:'POST',
                        body: JSON.stringify(id),
                        headers: {
                            'Content-type' : 'Application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {   
                       
                        this.update.PO_number = null;
                        this.getDraftItem();                        
                        toastr[res.type](res.msg);                    
                    })
                    .catch(err => toastr.error(err))
                }
                
                           
            },

            saveRequest() {
                if(this.update.dateNeeded === null) {
                    toastr.error('Don\'t leave the "Date Needed" empty!')
                } else {
                    fetch('api/save-request', {
                    method:'POST',
                    body: JSON.stringify(this.update),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {            
                    this.update.PO_number = null;
                    this.getDraftItem();        
                    toastr[res.type](res.msg);                    
                })
                .catch(err => toastr.error(err))
                }
            },

            editItemList(id) {
                fetch(`api/edit-request/${id}`)
                .then(res => res.json())
                .then(res => {
                   this.items = res.items;
                   this.update.PO_number = id;
                   this.update.dateNeeded = res.items[0].date_needed;
                })
               .catch(err => toastr.error(err))
            },
            
            updateItemList(id) {
                if(this.update.dateNeeded === null) {
                    toastr.error('Don\'t leave the "Date Needed" empty!')
                } else {
                    this.update.action = id;
                    fetch('api/update-request', {
                        method:'POST',
                        body: JSON.stringify(this.update),
                        headers: {
                            'Content-type' : 'Application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {            
                        this.update.PO_number = null;
                        this.getDraftItem();        
                        toastr[res.type](res.msg);      
                        Event.$emit('widget');              
                    })
                    .catch(err => toastr.error(err))
                }
            }
        }
    }
</script>

<style scoped>
    .item-list {
        max-height: 400px;
        overflow: auto;
    }
</style>