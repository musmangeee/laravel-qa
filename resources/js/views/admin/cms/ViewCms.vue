<template>
  <div class="main-content my-cms-content">
    <div class="page-header">
      <h3 class="page-title"/>

      <div class="page-actions"/>
    </div>
    <div class="">
      <div class="col-sm-12">
        <div class="cms-font-style">

          <!-- <p>{{ form.title_english }}</p> -->
          <p v-html="form.page_html_content"/>

        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { VueEditor } from 'vue2-editor'
import { TableComponent, TableColumn } from 'vue-table-component'

export default {
  components: {
    TableComponent,
    TableColumn
  },
  data () {
    return {
      form: {
        page_html_content: '',
        title_english: ''
      }
    }
  },
  mounted () {
    this.$utils.setLayout('default')
    this.getCms()
  },

  methods: {
    async getCms () {
      try {
        let testSlug = this.$route.params.testSlug
        // alert(testSlug)
        const response = await axios.get(
          `/api/slugGet/get/` + testSlug
        )
        this.form.title_english = response.data[0].title_english
        this.form.page_html_content = response.data[0].page_html_content
      } catch (error) {
        if (error) {
          // window.toastr["error"]("There was an error", "Error");
        }
      }
    }
  }
}
</script>
