<template>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
            <i class="far fa-bell"></i>
            <span v-if="noti.length > 0" class="badge badge-danger navbar-badge">{{noti.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">{{noti.length}} New Notificaiton</span>
            <div v-if="noti.length > 0">
                <div v-for="item in noti" :key="item.id">
                    <div class="dropdown-divider"></div>
                    <a :href="'show-request?id='+ item.po_number" class="dropdown-item active">
                        <i class="fas fa-envelope mr-2"></i> {{item.message}}
                        <span class="float-right  text-sm">{{item.po_number}}</span>
                    </a>
                </div>
            </div>
            <div v-for="item in prevNoti"  :key="item.id">
                <div class="dropdown-divider"></div>
                <a :href="'show-request?id='+ item.po_number"  class="dropdown-item">
                    <i class="fas fa-envelope-open mr-2"></i> {{item.message}}
                    <span class="float-right text-muted text-sm">{{item.po_number}}</span>
                </a>
            </div>
            <div class="dropdown-divider"></div>
            <a href="/requested" class="dropdown-item dropdown-footer">See All</a>
        </div>
    </li>
</template>

<script>
    export default {
        props : {
            userId: Number,
        },
        data() {
           return {
               noti : [],
               prevNoti : [],
           }
        },

        created() {
            this.getNotification(this.userId)
        },

        methods: {
           getNotification(id) {
               fetch(`api/notification/${id}`)
               .then(res => res.json())
               .then(res => {
                   this.noti = res.data;
                   this.prevNoti = res.all.data
               })
               .catch(err => toastr.error(err))
           },
           
        }
    }
</script>
