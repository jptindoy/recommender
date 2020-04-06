<template>
    <div>
        <div class="row">
            <div class="col-6">
                <form @submit.prevent="importFile" method="post">
                    <div class="form-group">
                        <label for="">File to import:</label>
                    </div>
                    <hr>
                    <p>File to be upload is .csv format only. <br>
                        A file's name must end in .[csv]. Example: .csv</p>
                    <div class="form-group">
                        <p>Browse your computer:</p>
                        <input type="file" ref="file" @change="fileToImport" accept=".csv" required>
                    </div>
                    <!-- <div class="form-group">
                        <p>Date of Sales:</p>
                        <input type="date" class="form-control" v-model="fileImport.date" style="width: 50%;" required>
                    </div> -->
                    <!-- <div v-if="uploading" class="progress mb-2">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" :style="{width: progress +'%'}">{{progress}}%</div>
                    </div> -->
                    <button v-if="uploading" class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Importing...
                    </button>
                    <button v-else type="submit" class="btn btn-primary">Import</button>
                </form>
                
            </div>
            <div class="col-6">
                <label for="">NOTE:</label>
                <p><i>Data must be imported everyday to get the accurate data to be recommended by the system.</i> </p>
            </div>
            
        </div>
        <br>
        <div class="row">
            <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Previous" @click="importedData(pagination.prev_page_url)">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                <li class="page-item disabled"><a class="page-link" href="#">{{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Next" @click="importedData(pagination.next_page_url)">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>
            <br><br>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <td>Invoce No.</td>
                        <td>Date</td>
                        <td>Barcode</td>
                        <td>Product Name</td>
                        <td>Sales</td>
                        <td>Quantity</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in datas" :key="data.id">
                        <td>{{data.invoice}}</td>
                        <td>{{data.date}}</td>
                        <td>{{data.barcode}}</td>
                        <td>{{data.product_name}}</td>
                        <td>{{data.sales}}</td>
                        <td>{{data.qty}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fileImport: {
                    file: null,
                    date: '',
                },
                uploading: false,
                progress: 0,
                datas:[],
                pagination: {},
            }
        },

        created() {
            this.importedData();
        },

        methods: {
            fileToImport(e){
                this.fileImport.file = e.target.files[0];
                console.log(this.fileImport.file);
            },

            importFile(){
                let formData = new FormData();
                /*
                    Add the form data we need to submit
                */
                formData.append('file', this.fileImport.file);
                formData.append('date', this.fileImport.date);
                
                axios.post('api/import', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function( progressEvent ) {
                        this.uploading = true;
                        this.progress = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                    }.bind(this)
                    
                })
                // .then(res => res.json())
                .then(res => {
                    if(res.status === 200 || res.status === 201){
                        this.uploading = false;
                        this.$refs.file.value = '';
                        this.fileImport.date = '';
                        this.importedData();
                        toastr.success('import successful!')           
                    }
                })
                .catch(err => toastr.error(err));
            },

            importedData(page_url) {
                let vm = this;
                page_url = page_url || 'api/imported'
                fetch(page_url)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.datas = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => toastr.error(err));
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination = pagination;    
            },
        }
    }
</script>

