<template>
  <CRow alignHorizontal="center">
    <CCol col="12">
      <CCard>
        <CCardHeader>
          <CRow>
            <CCol>
              <div class="text-primary">
                <h4>Products</h4>
              </div>
            </CCol>
            <CCol>
              <div class="text-right">
                <CButton color="primary" @click="$router.push({name: 'AddProduct'})">Add Product</CButton>
              </div>
            </CCol>
          </CRow>
        </CCardHeader>
        <CCardBody>
          <CDataTable
              :tableFilter='{ external: true, lazy: false }'
              hover
              :sorter='{ external: true, resetable: false }'
              striped
              :items="items"
              :fields="fields"
              clickable-rows
              @update:sorter-value="sortChanged"
              @update:table-filter-value="filterChanged"
          >
            <template #id="data">
              <td>
                <CButtonGroup>
                  <CButton color="info" @click="$router.push({name: 'EditProduct', params: { id: data.item.id } })">
                    Edit
                  </CButton>
                  <CButton color="danger" @click="deleteClicked(data.item.id)">Delete</CButton>
                </CButtonGroup>
              </td>
            </template>
          </CDataTable>
          <CPagination
              :activePage.sync="activePage"
              :pages="pages"
              @update:activePage="pageChanged"
          ></CPagination>
          <CModal
              title="Are you sure?"
              color="danger"
              centered
              :show.sync="warningModal">
            Are you sure, you want to delete this item?
            <template #footer>
              <CButton @click="warningModal = false">Cancel</CButton>
              <CButton @click="deleteItem" color="danger">Accept</CButton>
            </template>
          </CModal>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import api from '../../repository/api'

export default {
  name: 'Products',
  data() {
    return {
      items: [],
      fields: [
        {key: 'name', label: 'Name', _classes: 'font-weight-bold'},
        {key: 'code'},
        {key: 'product_category'},
        {key: 'retail_price'},
        {key: 'whole_sale_price'},
        {key: 'id', label: 'Action'},
      ],
      activePage: 1,
      offset: 0,
      limit: 10,
      total: 0,
      itemPerPage: 10,
      totalDisplay: 0,
      search: '',
      order: 'name',
      direction: 'asc',
      warningModal: false,
      selectedDeleteItemId: 0,
    }
  },

  mounted() {
    this.getProducts();
  },
  computed: {
    pages: function () {
      return (this.totalDisplay / this.itemPerPage)
          + (this.totalDisplay % this.itemPerPage > 0 ? 1 : 0);
    }
  },
  watch: {
    activePage: function (val) {
      this.offset = (val - 1) * this.itemPerPage;
      this.getProducts();
    },
  },
  methods: {
    pageChanged(pageNumber) {
      this.activePage = pageNumber;
      this.getProducts();
    },
    sortChanged(val) {
      this.order = val.column;
      this.direction = val.asc ? "asc" : "desc";
      this.getProducts();
    },
    filterChanged(val) {
      this.search = val;
      this.getProducts();
    },
    deleteClicked(val) {
      this.warningModal = true;
      this.selectedDeleteItemId = val;
    },
    deleteItem() {
      var self = this;
      api
          .delete('business/product/' + this.selectedDeleteItemId, {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            var status = response.data.status;

            if (status === "success") {
              self.getProducts();
            }
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          });
      this.warningModal = false;
    },
    getProducts() {
      var self = this;
      api
          .get('business/product', {
            params: {
              search: this.search,
              offset: this.offset,
              limit: this.limit,
              order: this.order,
              direction: this.direction
            },
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            self.items = response.data.data;
            self.total = response.data.recordsTotal;
            self.totalDisplay = response.data.recordsFiltered;
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
  },
}
</script>
