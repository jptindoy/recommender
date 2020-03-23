<template>
    <div class="card" id="app">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Sales</h3>
                <a href="javascript:void(0);">View Report</a>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <p class="d-flex flex-column">
                <span class="text-bold text-lg">$18,230.00</span>
                <span>Sales Over Time</span>
                </p>
                <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 33.1%
                </span>
                <span class="text-muted">Since last month</span>
                </p>
            </div>
        <!-- /.d-flex -->

            <div class="position-relative mb-4">
               <bar-chart v-if="loaded" :datacollection="datacollection" id="sales-chart"></bar-chart>
            </div>

            <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                <i class="fas fa-square text-primary"></i> This year
                </span>

                <span>
                <i class="fas fa-square text-gray"></i> Last year
                </span>
            </div>
        </div>
    </div>
    <!-- /.card -->
</template>

<script>
    import BarChart from './Chart.vue'
    export default {
      components: { BarChart },
       data() {
           return{
                datacollection: null,
            loaded: false,
           }
           
        },

        async mounted () {
            this.loaded = false
            try {
                await fetch('/api/month-sales')
                .then(res => res.json())
                .then(res => {
                    this.datacollection = res
                    this.loaded = true                    
                })
                .catch(err => toastr.error(err))          
            
            } catch (e) {
            console.error(e)
            }
            console.log(this.datacollection)
        }
    }
</script>
