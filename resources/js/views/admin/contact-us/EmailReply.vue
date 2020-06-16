<template>
  <div   class="main-content">
    <div class="page-header">
      <h3 class="page-title">Contact Us</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link to="/contact-us">
            <a>Contact Us</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">Reply</li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            Reply to " {{form.username}} "
          </div>
          <div class="card-body">
            <form >
              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="inputUserName">To:</label>
                  <input
                    :disabled= "true"
                    id="inputUserName"
                    class="form-control"
                    placeholder="Complainer Phone"
                    v-model.trim="form.email"
                  />
                </div>
                  
              </div>
              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="inputUserName">Subject:</label>
                  <input
                  :disabled= "true"
                    id="inputUserName"
                    type="text"
                    class="form-control"
                    placeholder="Complaint About"
                    v-model.trim="form.subject"
                  />
                </div>
              </div>

              <div class="form-group">
                <label for="inputDescription">Message:</label>
                <b-form-textarea
                  id="inputDescription"
                  type="text"
                  class="form-control"
                  rows="4"
                  max-rows="6"
                  placeholder="Message Text"
                  v-model.trim="form.message"
                  :class="{ 'iinvalid': $v.form.message.$error }"
                  @input="$v.form.message.$touch()"
                ></b-form-textarea>
                  <div v-if="$v.form.message.$error">
                    <span v-if="!$v.form.message.required" class="help-block help-block-error">
                      Field is required
                    </span>
                    <span v-if="!$v.form.message.minLength" class="help-block help-block-error">
                      Message Body must have at least {{ $v.form.message.$params.minLength.min }} letters.
                    </span>
                </div>
              </div>
              

              <button 
              @click.prevent="submit"
                class="btn btn-primary"
                :disabled="$v.form.$invalid"
              >Reply</button>
              <b-button type="button" @click.prevent="cancel">Cancel</b-button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- <div class="form-group col-md-6">
                 
                    <img  @error="onImageLoadFailure($event)"  height="27" :src="imageLink + form.phone" />
                  </div> -->
      </div>
    </div>
  </div>
</template>
<script type="text/babel">
import { required, sameAs, minLength, between } from "vuelidate/lib/validators";
import Ls from "../../../services/ls";


export default {

  data() {
    return {
      contactId: "",
      form: {
        email: '',
        subject: '',
        message: '',
        username: '',
      }
      
    };
  },
    validations: {
    form: {
      message: {
        required,
        minLength: minLength(10)
      },
    } 
  },

  mounted() {
    this.getComplaint();
  },
  methods: {
    async submit() {
      try {
        // let response = await window.axios.post(
        //   "/api/admin/contact-us/reply",
        //   { data: this.form }
        // );
        alert('Email service is not active yet')
        window.toastr["success"](
          'Replied Successful',
          "Success"
        );
        this.$router.push("/contact-us");
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
       async getComplaint () {
         let contactId = this.$route.params.contactId;
           try {
        const response = await axios.get(`/api/admin/contact-us/edit/${contactId}`);        
        this.form.email = response.data.user.email
        this.form.subject = 'Reply to - ' + response.data.subject
        this.form.username = response.data.user.user_name
        this.form.id = response.data.id

        } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
      
    },
    async cancel() {
      this.$router.push("/contact-us");
    },
  }
};
</script>
