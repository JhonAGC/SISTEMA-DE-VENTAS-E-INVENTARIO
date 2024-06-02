<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-center">
          <div class="col-sm-8 col-12">
            <div class="card">
              <div class="card-header">
                <h3>Actualizar</h3>
              </div>
              <div class="card-body">
                <CrudUpdate :model="model" :apiUrl="apiUrl">
                  <div slot="body" class="row">
                    <div class="form-group col-12">
                      <label for="">Nombre</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.nombre"
                        class="form-control"
                        id=""
                      />
                    </div>

                    <div class="form-group col-12">
                      <label for="">Apellido Paterno</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.apePaterno"
                        class="form-control"
                        id=""
                      />
                    </div>

                    <div class="form-group col-12">
                      <label for="">Apellido Materno</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.apeMaterno"
                        class="form-control"
                        id=""
                      />
                    </div>

                    <div class="form-group col-12">
                      <label for="">DNI</label>
                      <input
                        type="text"
                        name=""
                        v-model="model.dni"
                        class="form-control"
                        id=""
                      />
                    </div>
                  </div>
                </CrudUpdate>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminTemplate>
  </div>
</template>

<script>
export default {
  name: "IndexPage",
  head() {
    return {
      title: "Cliente",
    };
  },
  data() {
    return {
      load: true,

      model: {
        nombre: "",
        apePaterno: "",
        apeMaterno: "",
        dni: "",
      },
      apiUrl: "clientes",
      page: "Clientes",
      modulo: "Cliente",
    };
  },
  methods: {
    async GET_DATA(path) {
      const res = await this.$api.$get(path);
      return res;
    },
  },
  mounted() {
    this.$nextTick(async () => {
      try {
        await Promise.all([
          this.GET_DATA(this.apiUrl + "/" + this.$route.params.id),
        ]).then((v) => {
          this.model = v[0];
        });
      } catch (e) {
        console.log(e);
      } finally {
        this.load = false;
      }
    });
  },
};
</script>
