<template>
    <div v-if="draft" class="card card-secondary draft">
        <div class="card-header">
            <h3 class="card-title">Item in Request</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="container">
                <div v-for="item in items" :key="item.id" class="alert alert-info alert-dismissible fade show" role="alert">
                    {{item.product_name}}
                </div>
            </div>            
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
            <a href="request" class="btn btn-primary">Proceed Request</a>
            <button @click="deleteDraft" class="btn btn-secondary">Cancel</button>
        </div>
        <!-- /.card-footer -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                draft : false,
                items : [],
            }
        },

        created() {
            Event.$on('draft', (draft) => {
                this.draft = true;
                this.getDraftItem();
            });
        },

        methods: {
            getDraftItem() {
               fetch('api/draft-item')
               .then(res => res.json())
               .then(res => {
                   this.items = res.items;
               })
               .catch(err => toastr.error(err))
            },

            deleteDraft(){
               fetch('api/delete-draft')
               .then(res => res.json())
               .then(res => {
                   this.draft = false;
                    Event.$emit('cancelled');
                   toastr.success('Request cancelled!')
               })
               .catch(err => toastr.error(err))
            }
        }
    }
</script>

<style scoped>
    .draft {
        position: fixed;
        bottom: 0;
        right: 0;        
        
    }
    .card-body {
        width: 500px;
        height: 450px;
        overflow: auto;
    }
</style>