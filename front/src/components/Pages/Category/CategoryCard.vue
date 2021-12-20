<template>
  <section>
    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="card-text col-sm-10 d-flex align-items-center">
                      <h5 class="">{{category.name}}</h5>  
                    </div>
                    <div class="card-actiion col-sm-2 d-flex justify-content-end align-items-center">
                        <button class="btn btn-success fa fa-pencil mr-3" @click="edit(category.id, category.name)"></button>
                        <button class="btn btn-danger fa fa-remove" @click="remove(category.id)"></button>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
  </section>
</template>

<script>

export default {
    props: ['category'],
    emits: ['requestEdit', 'requestRemove'],
    methods: {
        remove(id) {
            this.$emit('requestRemove', id);
        },
        edit(id, name) {
            this.$emit('requestEdit', id, name);
        }
    },
};
</script>

<style scoped>
    .card {
        box-shadow: rgba(5, 1, 51, 0.5) 0px 3px 6px, rgba(3, 2, 53, 0.5) 0px 3px 6px;
    }
</style>
