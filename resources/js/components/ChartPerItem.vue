<template>
<div>
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
                                        <button class="btn btn-info" @click="showGraph(item.product_name)"><i class="fa fa-arrow-right"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-xs-12 col-md-9">
            <div class="text-center">
                <h1>Chart Per Item</h1>
                <p>To show the chart, select product in the left side tab.</p>
            </div>
            <item-chart></item-chart>
        </div>
    </div> 
    
</div>
    
</template>

<script>
    import moment from 'moment';

    export default {
        props: {
            requestId: Number,
            userRole: Number,
            userId: Number,
        },
        data() {
            return {
                itemList : [],
                isLoading: true,
                search : '',                
                items : [],      
                  
                chartItem : null,
            }
        },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
        created() {
            this.getItemList();
        },

        methods: {
            moment,
            getItemList() {
                fetch('api/item-list')
                .then(res => res.json())
                .then(res => {
                    this.itemLists = res.itemlist;
                    this.isLoading = false;
                    Event.$emit('get-chart', res.itemlist[0].product_name)
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

            showGraph(id) {
                this.chartItem = id;
                console.log(this.chartItem)
                Event.$emit('get-chart', this.chartItem);
                
            },
    
        }
    }
</script>

<style scoped>
    .item-list {
        max-height: 500px;
        overflow: auto;
    }
</style>