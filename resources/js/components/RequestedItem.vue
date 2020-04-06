<template>
    <div>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">All Request</span>
                        <span class="info-box-number">
                         {{widget.countallRequest}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->

                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">
                            All Request
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
                                    <td>Date Needed</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in widget.allRequest" :key="item.id">
                                    <td>{{item.po_number}}</td>
                                    <td>{{item.date_needed}}</td>
                                    <td>{{item.action}}</td>
                                    <td>
                                        <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-primary"><i class="fas fa-clipboard-check"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ban"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">Cancelled Request</span>
                        <span class="info-box-number">
                         {{widget.countcancelled}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->

                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">
                            Cancelled Request
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
                                    <td>Date Needed</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in widget.cancelled" :key="item.id">
                                    <td>{{item.po_number}}</td>
                                    <td>{{item.date_needed}}</td>
                                    <td>{{item.action}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                                    <td>Date Needed</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in widget.approved" :key="item.id">
                                    <td>{{item.po_number}}</td>
                                    <td>{{item.date_needed}}</td>
                                    <td>{{item.action}}</td>
                                    <td>
                                        <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-danger"><i class="fas fa-ban"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
        </div> 

        <div class="row">

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                widget : [],
            }
        },

        created() {
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
            }
        }
    }
</script>
