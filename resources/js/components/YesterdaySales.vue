<template>
    <div class="card card-secondary">
        <div class="card-header border-0">
            <h3 class="card-title">Yesterday Sales</h3>            
            <div class="card-tools">
                <ul class="pagination pagination-sm float-right">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" href="javascript:void(0)" aria-label="Previous" @click="getYesterdaySales(pagination.prev_page_url)">
                        <span aria-hidden="true" style="color:black">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                    </li>
                    <li class="page-item disabled"><a class="page-link" href="#" style="color:black">{{pagination.current_page}} of {{pagination.last_page}}</a></li>
                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next" @click="getYesterdaySales(pagination.next_page_url)">
                        <span aria-hidden="true" style="color:black">&raquo;</span> 
                        <span class="sr-only">Next</span>
                    </a>
                    </li>
                </ul>   
            </div>
        </div>
        <div class="card-body p-0">
             <div v-if="yesterdaySales == ''" class="text-center">
                <h4 >No sales yesterday</h4>
            </div>
            <table v-else class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Sales</th>
                    </tr>
                </thead>  
                <tbody>                           
                    <tr v-for="item in yesterdaySales" :key="item.id">
                        <td>{{item.product_name}}</td>
                        <td>{{item.qty}} Sold</td>
                        <td>{{item.sales}}</td>
                    </tr>                
                </tbody>             
            </table>
        </div>
    </div>
    <!-- /.card -->
</template>

<script>
    export default {
        data() {
            return {
                    yesterdaySales: [],
                    pagination:{}
            }
        },

        created(){
            this.getYesterdaySales();
        },

        methods: {
            getYesterdaySales(page_url){
                let vm = this;
                page_url = page_url || 'api/top-sales'
                fetch(page_url)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.yesterdaySales = res.data
                    vm.Pagination(res);
                })
                .catch(err => toastr.error(err));
            },

            Pagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url
                };

                this.pagination = pagination;    
            },
        },
    }
</script>
