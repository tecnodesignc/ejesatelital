<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="data-table table table-striped table-bordered dt-responsive nowrap"
                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th v-for="name in columns">@{{ name }}</th>
                    </tr>
                    </thead>


                    <tbody>

                    <tr v-for="(item, i) in items" :key="i">
                        <td>@{{ item.id }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.nit }}</td>
                        <td>@{{ item.phone }}</td>
                        <td>@{{ length.item.contacts }}</td>
                        <td>
                            <a class="btn btn-outline-secondary btn-sm edit" :href="item.links.edit" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-outline-danger btn-sm edit" :href="item.links.delete" title="Delete">
                                <i class="fas fa-tasks"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</template>

<script>


export default {
    name: "list",
    props: {},
    data() {
        return {
            data: {},
        }
    },
    methods:{
        getAcounts(){
            let params={

            }
            let route=''

            axios.get().then((response)=>{
                this.data=response.data
            })

        }
    },
    mounted: function () {
        this.$nextTick(function () {
            $(".data-table").DataTable(), $("#datatable-buttons").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf", "colvis"]
            }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")
        });
    }
    updated: function () {
        this.$nextTick(function () {
            $('.data-table').DataTable({
                'destroy': true,
                'stateSave': true,
            }).draw();

        })
    }

}
</script>

<style scoped>

</style>
