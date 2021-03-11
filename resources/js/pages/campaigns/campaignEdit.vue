<template>
  <div>
    <div
      class="d-flex justify-content-between align-items-center flex-wrap grid-margin"
    >
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link :to="{ name: 'home' }">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link :to="{ name: 'campaignList' }">Campaign</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Create Campaign
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Campaign Form</h6>
            <form
              @submit.prevent="update"
              class="forms-sample"
              @keydown="form.onKeydown($event)"
            >
              <div class="form-group">
                <label for="name">Target Campaign Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                  id="name"
                  autocomplete="off"
                  placeholder="Campaign Name"
                  name="name"
                />
                <has-error :form="form" field="name" />
              </div>

              <v-button class="btn btn-primary mr-2">Submit</v-button>
              <router-link :to="{ name: 'campaignList' }" class="btn btn-light"
                >Cancel</router-link
              >
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";

export default {
  middleware: "auth",

  data: () => ({
    form: new Form({
      name: "",
    }),
    campaigns: [],
  }),
  created() {
    fetch("/api/campaigns/" + this.$route.query.id)
      .then((response) => response.json())
      .then((res) => {
        this.campaigns = res;
        this.form.name = res.name;
      });
  },
  methods: {
    async update() {
      await this.form.patch("/api/campaigns/" + this.$route.query.id);
      this.$router.push({ name: "campaignList" });
    },
  },
};
</script>
