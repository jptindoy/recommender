<template>
    <div class="card card-secondary">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Requested Item</h3>
            
            </div>
        </div>
        <div class="card-body">
            <div v-if="date.from" class="text-center">
                <h3>From {{moment(date.from).format('MMMM D')}} to {{moment(date.to).format('MMMM D')}}</h3>
                <p class="text-danger"><i>The graph show's of how many times the item requested on selected dates. Only in approved request</i></p>
            </div>
            <div v-else class="text-center">
                    <h3>Requested Item Over This Year</h3>
                <p class="text-danger"><i>The graph show's of how many times the item requested this year. Only in approved request.</i></p>
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
                        <a :href="'api/export-request?from='+ date.from +'&&to='+ date.to" target="_blank" class="btn btn-success text-white">Export to Excel <i class="fas fa-file-export"></i></a>
                    </div>
                    
                </div>          
            </form>
                
            <div v-if="searching" class="text-center mt-5">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading items...</p>
            </div>
            <!-- <div v-if="datacollection.datasets[0].data == ''" class="text-center mt-5">
                <h1>No request found on the selected dates.</h1>
            </div> -->
            <div v-else>
                <div class="position-relative mb-5">
                <bar-chart v-if="loaded" :datacollection="datacollection" :options="options" id="sales-chart"></bar-chart>
                </div>
                
            </div>            
            
        </div>
    </div>
</template>

<script>
    import BarChart from './HorizontalChart.vue';
    import moment from 'moment';
    export default {
        components: { BarChart },
        props: {
            items: String
        },

        data() {
            return {
                loaded : false,
                itemSales : [],
                datacollection: null,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    height: 200,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines: {
                                display: false
                            },
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true,
                        mode: 'single',
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return tooltipItems.xLabel + ' times';
                            }
                        }
                    },
                },
                date : {
                    from: null,
                    to: null,
                },
                searching: false,
            }
        },
        
        created(){
            this.getChart();
        },

        methods: {
            moment,
            getChart() {
                this.loaded = false
                fetch('api/requested',{
                    method: 'POST',
                    body: JSON.stringify(this.date),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.datacollection = res.requested
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
        }
    }
</script>
<style  scoped>
.height {
    max-height: 500px;
    overflow: auto;
}
</style>