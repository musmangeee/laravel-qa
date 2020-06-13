<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Edit CMS Page</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/Cms"><a>CMS</a></router-link></li>
        <li class="breadcrumb-item active">Edit Page</li>
      </ol>
    </div>
    <div class="card">
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="submit">
          <div class="form-row">
            <div class="form-group col-md-8">
              <div class="form-group">
                <label for="inputTitle">Title<span class="lable-star">*</span></label>
                <input
                  id="inputTitle"
                  :class="{ 'is-invalid' : $v.form.title_english.$error }"
                  v-model.trim="form.title_english"
                  type="text"
                  class="form-control"
                  placeholder="Title"
                  required
                  @input="$v.form.title_english.$touch()"
                >
                <div v-if="$v.form.title_english.$error">
                  <span v-if="!$v.form.title_english.required" class="help-block help-block-error">
                    Field is required
                  </span>
                  <span v-if="!$v.form.title_english.minLength" class="help-block help-block-error">
                    <p class="text-danger">title must have at least {{ $v.form.title_english.$params.minLength.min }} letters.</p>
                  </span>
                  <span v-if="!$v.form.title_english.maxLength" class="help-block help-block-error">
                    <p class="text-danger">title must have at least {{ $v.form.title_english.$params.maxLength.max }} letters.</p>
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label for="inputTitle">Page Content<span class="lable-star">*</span></label>
                <template>
                  <div id="app">
                    <vue-editor :class="{ 'is-invalid' : $v.form.page_html_content.$error }"
                                v-model.trim="form.page_html_content"
                                @input="$v.form.page_html_content.$touch()" />

                    <div v-if="$v.form.page_html_content.$error">
                      <span v-if="!$v.form.page_html_content.required" class="help-block help-block-error">
                        <p class="text-danger"> Page Content is required.</p>
                      </span>
                    </div>
                  </div>
                </template>
              </div>

              <div class="form-row">
                <div class="col form-group">
                  <label for="inputSlug">Slug<span class="lable-star">*</span></label>
                  <input
                    id="inputSlug"
                    v-model.trim="form.slug"
                    type="text"
                    class="form-control"
                    placeholder="Slug"
                    required
                    readonly @input="$v.form.slug.$touch()"
                  >
                </div>
              </div>
            </div>
          </div>

          <button :disabled="$v.form.$invalid" type="submit" class="btn btn-primary" >{{ form.submitBtn }}</button>
          <b-button type="button" @click.prevent="cancel" >Cancel</b-button>

        </form>
      </div>
    </div>
  </div>
</template>

<script src="https://unpkg.com/@johmun/vue-tags-input/dist/vue-tags-input.js"></script>
<script type="text/babel">

import { required, sameAs, minLength, maxLength, between } from "vuelidate/lib/validators";
import Multiselect from 'vue-multiselect';
import { VueEditor } from "vue2-editor";
import VueTagsInput from '@johmun/vue-tags-input';

export default {
   mounted: function() {
    this.getCms();
  },
    components: {
      VueEditor,
      VueTagsInput
   },

  data() {
    return {
      ar_keywords:'',
      form: {
         Id : '',
        page_html_content:"",
        title_english: "",
        slug: "",
        status:"",
        submitBtn: "Update",
        selected:""

      }
    };
  },
  validations: {
   form: {
      slug: {
      },
      title_english: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(20)
      },
      page_html_content: {
        required
      }
    }
  },
  methods: {
      async submit() {
        this.$v.form.$touch();

        if(this.$v.form.$error) return;
          try {
          this.form.Id = this.$route.params.cmsId;
          let response = await window.axios.post('/api/admin/cms/update', {
            data: this.form             });
          window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')

          this.$router.push('/Cms')
        } catch (error) {

        if (error) {
            window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
          }
        }
      },
      async getCms () {

      try {
        let pageId = this.$route.params.cmsId;
        const response = await axios.get(`/api/admin/cms/edit/${pageId}`)
        this.form.title_english =  response.data.title_english;
        this.form.page_html_content =  response.data.page_html_content;
        this.form.slug =  response.data.slug;

        console.log(response.data);

        // if(response.data.keywords !== ''){
        // this.ar_keywords =  response.data.keywords.split(",");
        // }
        // let arrayfortag= [];
        // this.ar_keywords.forEach(function(entry) {
        // var obj = {
        //     text : entry ,
        //     tiClasses : ['valid']
        // }
        // arrayfortag.push(obj);
        // });
        // this.form.keywords = arrayfortag;
        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

       async cancel()
      {
           this.$router.push('/Cms')
      },
    }
};
</script>
