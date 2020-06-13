<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Add New CMS Page</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/dashboard"><a>Home</a></router-link></li>
        <li class="breadcrumb-item"><router-link to="/cms"><a>CMS</a></router-link></li>
        <li class="breadcrumb-item active">New CMS Page</li>
      </ol>
    </div>
    <div class="card">
      <!-- <div class="card-header">
                        <h6>Required Information</h6>
                    </div> -->
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="submit">

          <div class="form-row">
            <div class="form-group col-md-12">
              <div class="form-group">
                <label for="inputTitle">Title<span class="lable-star">*</span></label>
                <input
                  id="inputTitle"
                  :class="{ 'is-invalid' : $v.form.title_english.$error }"
                  v-model.trim="form.title_english"
                  type="text"
                  class="form-control"
                  required
                  placeholder="CMS Title"
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
                    <p class="text-danger">title have maximum {{ $v.form.title_english.$params.maxLength.max }} letters.</p>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label for="inputTitle">Page Content<span class="lable-star">*</span></label>
                <template>
                  <div id="app">
                    <vue-editor :class="{ 'is-invalid' : $v.form.page_html_content.$error }"
                                v-model.trim="form.page_html_content"
                                @input="$v.form.page_html_content.$touch()"
                    />
                    <div v-if="$v.form.page_html_content.$error">
                      <span v-if="!$v.form.page_html_content.required" class="help-block help-block-error">
                        <p class="text-danger"> Page Content is required.</p>
                      </span>
                    </div>
                  </div>
                </template>
              </div>

              <div class="col form-group"/>

              <div class="form-row">
                <div class="col form-group">
                  <label for="inputSlug">Slug<span class="lable-star">*</span></label>
                  <input
                    id="inputSlug"
                    :class="{'is-invalid' : $v.form.slug.$error}"
                    v-model.trim="form.slug"
                    type="text"
                    class="form-control"
                    required
                    placeholder="Slug"
                    @input="$v.form.slug.$touch()"
                  >
                  <div v-if="$v.form.slug.$error">
                    <span v-if="!$v.form.slug.required" class="help-block help-block-error">
                      <p class="text-danger"> Slug is required.</p>
                    </span>
                  </div>
                </div>

              </div>

            </div>
          </div>
          <button :disabled="$v.form.$invalid" type="submit" class="btn btn-primary" >{{ form.submitBtn }}</button>
          <b-button type="button" @click.prevent="cancel" >Cancel</b-button>
        </form>
      </div>
    </div> <!--card-->
  </div>
</template>
<script src="https://unpkg.com/@johmun/vue-tags-input/dist/vue-tags-input.js"></script>
<script type="text/babel">
import { required, sameAs, minLength, maxLength, between } from "vuelidate/lib/validators";
import Multiselect from 'vue-multiselect';
import { VueEditor } from "vue2-editor";
import VueTagsInput from '@johmun/vue-tags-input';
// Advanced Use - Hook into Quill's API for Custom Functionality

export default {
    components: {
      VueEditor,
      VueTagsInput,
   },
  data() {
    return {
       form: {
        tag: '',
        page_html_content: "",
        title_english: "",
        slug: "",
        submitBtn: "Submit",
        selected: "",

      }
    };
  },
  validations: {
   form: {
      slug: {
        required
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
        let response = await window.axios.post('/api/admin/cms/add', {
            data: this.form,
            status: this.form.value
            });
        window.toastr['success'](response.data.ResponseHeader.ResponseMessage, 'Success')
        this.$router.push('/Cms')
        } catch (error) {
        if (error) {
          window.toastr['error'](response.data.ResponseHeader.ResponseMessage, 'Error')
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
