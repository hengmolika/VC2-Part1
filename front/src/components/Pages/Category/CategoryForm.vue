<template>
  <section>
    <!-- Button to Open the Modal -->
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#myModal"
    >
      Open modal
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Create event category</h4>
            <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i>
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
              <input type="text" class="form-control" placeholder="Event category" v-model="namecategory" required>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer" id="btn-create">
            <button type="button" class="btn btn-block" @click="createCategory">Create</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
const url = "http://localhost:8000/";
export default {
    data() {
      return {
        categories: [],
        namecategory: "",
      };
    },
    methods: {
        createCategory() {
            let categories = {name: this.namecategory};
            axios.post(url, categories).then(() => {
                    window.location.reload()
                });
        }
    },
};
</script>
<style scoped>
h4 {
    color: #020269;
}
#btn-create button {
  background: #020269;
  color: white;
}
.btn-circle.btn-xl {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
}

.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}

</style>