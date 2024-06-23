<template>
  <div>
    <JcLoader :load="load"></JcLoader>
    <AdminTemplate :page="page" :modulo="modulo">
      <div slot="body">
        <div class="row justify-content-end">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="py-0 px-1">#</th>
                      <th class="py-0 px-1">NOMBRE</th>
                      <th class="py-0 px-1">CODEBAR</th>
                      <th class="py-0 px-1">MARCA</th>
                      <th class="py-0 px-1">CATEGORIA</th>
                      <th class="py-0 px-1">STOCK</th>
                      <th class="py-0 px-1">INVERSION</th>
                      <th class="py-0 px-1">VALORIZADO</th>
                      <th class="py-0 px-1">GANANCIA</th>
                      <th class="py-0 px-1"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(m, i) in list" :key="m.id">
                      <td class="py-0 px-1">{{ i + 1 }}</td>
                      <td class="py-0 px-1">{{ m.nombre }}</td>
                      <td class="py-0 px-1">{{ m.barra }}</td>
                      <td class="py-0 px-1">{{ m.marca.nombre }}</td>
                      <td class="py-0 px-1">{{ m.categoria.nombre }}</td>
                      <td class="py-0 px-1">
                        <span
                          class="badge"
                          :class="[
                            m.stock <= m.stock_minimo
                              ? 'badge-danger'
                              : 'badge-success',
                          ]"
                        >
                          {{ m.stock }} {{ m.medida.codigo }}
                        </span>
                      </td>
                      <td class="py-0 px-1">
                        {{ Number(m.inversion).toFixed(2) }}
                      </td>
                      <td class="py-0 px-1">
                        {{ Number(m.valorizado).toFixed(2) }}
                      </td>
                      <td class="py-0 px-1">
                        {{ Number(m.ganancia).toFixed(2) }}
                      </td>
                      <td class="py-0 px-1">
                        <div class="btn-group">
                          <nuxt-link
                            :to="url_editar + m.id"
                            class="btn btn-info btn-sm py-1 px-2"
                          >
                            <i class="fas fa-eye"></i>
                          </nuxt-link>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
  head() {
    return {
      title: this.modulo,
    };
  },

  data() {
    return {
      load: true,
      list: [],
      apiUrl: "inventarios",
      page: "Inventario",
      modulo: "General",
      url_editar: "/inventario/kardex/",
    };
  },
  methods: {
    async GET_DATA(path) {
      try {
        const res = await this.$api.$get(path);
        console.log("Datos obtenidos:", res);
        return res;
      } catch (error) {
        console.error("Error al obtener datos:", error);
        return [];
      }
    },
    async EliminarItem(id) {
      this.load = true;
      try {
        const res = await this.$api.$delete(this.apiUrl + "/" + id);
        console.log(res);
        this.list = await this.GET_DATA(this.apiUrl);
      } catch (e) {
        console.log(e);
      } finally {
        this.load = false;
      }
    },
    Eliminar(id) {
      let self = this;
      this.$swal
        .fire({
          title: "Deseas Eliminar?",
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: "Eliminar",
          cancelarButtonText: `Cancelar`,
        })
        .then(async (result) => {
          if (result.isConfirmed) {
            await self.EliminarItem(id);
          }
        });
    },
    removeDuplicates(data) {
      const uniqueData = [];
      const seen = new Set();

      data.forEach((item) => {
        if (!seen.has(item.id)) {
          uniqueData.push(item);
          seen.add(item.id);
        }
      });

      return uniqueData;
    },
  },
  async mounted() {
    try {
      const data = await this.GET_DATA(this.apiUrl);
      console.log("Lista de artículos antes de eliminar duplicados:", data);
      this.list = this.removeDuplicates(data);
      console.log(
        "Lista de artículos después de eliminar duplicados:",
        this.list
      );
    } catch (e) {
      console.log(e);
    } finally {
      this.load = false;
    }
  },
};
</script>
