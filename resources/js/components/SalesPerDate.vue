<template>
    <div class="card card-secondary">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Sales Report With Corresponding Products</h3>
            
            </div>
        </div>
        <div class="card-body">
            <div v-if="date.from" class="text-center">
                <h3>Sales from {{moment(date.from).format('MMMM D')}} to {{moment(date.to).format('MMMM D')}}</h3>
                <p class="text-danger"><i>The graph show's the total sales per day in selected dates.</i></p>
            </div>
            <div v-else class="text-center">
                    <h3>Sales for this Month</h3>
                <p class="text-danger"><i>The graph show's the total sales per day in the whole month.</i></p>
            </div>
                    
            <form @submit.prevent="getSearch" method="post">         
                <div class="row">        
                    <div class="form-group mr-2">
                        <label for="">Date From:</label>
                        <input type="date" class="form-control" v-model="date.from" required>
                    </div>  
                    <div class="form-group mr-2">
                        <label for="">Date To:</label>
                        <input type="date" class="form-control" v-model="date.to" required>
                    </div>                                                 
                    
                    <div class="form-group mr-2">      
                        <label for="">Action</label>                     
                        <button type="submit" class="btn btn-primary form-control">Search</button>
                    </div>
                    <div class="form-group float-right">    
                        <label for="">Export This Report</label>  
                        <br>             
                        <a :href="'api/export-sales?from='+ date.from +'&&to='+ date.to" target="_blank" class="btn btn-success text-white">Export to Excel <i class="fas fa-file-export"></i></a>
                    </div>
                    
                </div>          
            </form>
                
             <div v-if="searching" class="text-center mt-5">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading items...</p>
            </div>
            <!-- <div v-if="noRecord" class="text-center mt-5">
                <h1>No sales found on the selected dates.</h1>
            </div> -->
            <div v-else>
                <div class="position-relative mb-5">
                <line-chart
                    v-if="loaded"
                    :chartdata="lineChartData"
                    :options="lineChartOptions"
                    @getChart="lineChartData = lineChartData"/>
                </div>
                
                <div class="height mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Total QTY</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in itemSales" :key="item.id">
                                <td>{{item.product_name}}</td>
                                <td>{{item.qty}}</td>
                                <td>{{item.sales}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
            </div>            
            
        </div>
    </div>
</template>

<script>
    import LineChart from './LineChart.vue';
    import moment from 'moment';
    export default {
        components: { LineChart },
        props: {
            items: String
        },

        data() {
            return {
                loaded : false,
                itemSales : [],
                lineChartData: [],
                lineChartOptions: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : 'index',
                        intersect: true
                    },
                    hover              : {
                        mode     : 'index',
                        intersect: true
                    },
                    legend             : {
                        display: false
                    },
                    
                },
                date : {
                    from: null,
                    to: null,
                },
                searching: false,
                noRecord: false,
            }
        },
        
        created(){
            this.getChart();
        },

        methods: {
            moment,
            getChart() {
                this.loaded = false
                fetch('api/sales',{
                    method: 'POST',
                    body: JSON.stringify(this.date),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    
                    this.lineChartData = res.sales
                    this.itemSales = res.itemSales
                   
                    
                    this.loaded = true
                })
                .catch(err => toastr.error(err))
            },

            getSearch() {
                if(this.date.from > this.date.to){
                    toastr.error('Error Date Selection! <br> "Date To" must be ahead in "Date From"');
                } else {
                    this.getChart();
                }
            },

            exportSales(){
                axios.post('api/export-sales', {
                    body: JSON.stringify(this.date),
                }, {
                    responseType: 'blob'
                }).then((response) => {
                    const url = URL.createObjectURL(new Blob([response], {
                        type: 'application/vnd.ms-excel'
                    }))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', 'user.csv')
                    document.body.appendChild(link)
                    link.click()
                });

                // fetch('api/export-sales',{
                //     method: 'POST',
                //     body: JSON.stringify(this.date),
                //     headers: {
                //         'Content-type' : 'Application/text/csvjson'
                //     }
                // })
                // .then(res => {
                //     const blob = new Blob([res], { type: 'text/csv' })
                //     const link = document.createElement('a')
                //     link.href = URL.createObjectURL(blob)
                //     link.download = 'sales.csv'
                //     link.click()
                //     URL.revokeObjectURL(link.href)
                // })
                // .catch(err => toastr.error(err))
            },
        }
    }
</script>
<style  scoped>
.height {
    max-height: 500px;
    overflow: auto;
}
</style>