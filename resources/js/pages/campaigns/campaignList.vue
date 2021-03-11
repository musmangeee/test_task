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
          <li class="breadcrumb-item active" aria-current="page">Campaign</li>
        </ol>
      </nav>
      <div class="d-flex align-items-center flex-wrap text-nowrap">
        <router-link
          :to="{ name: 'campaignCreate' }"
          class="btn btn-primary btn-icon-text"
        >
          <i class="btn-icon-prepend" data-feather="plus"></i>
          Create Campaign
        </router-link>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Campaigns</h6>
            <p class="card-description">All the campaigns are listed here.</p>
            <div class="table-responsive">
              <table id="dataTableExample" class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Campaign Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="campaign in campaigns" :key="campaign.id">
                    <td>{{ campaign.id }}</td>
                    <td>{{ campaign.name }}</td>
                    <td>
                      {{
                        moment(campaign.created_at).startOf("hour").fromNow()
                      }}
                    </td>
                    <td>
                      {{
                        moment(campaign.updated_at).startOf("hour").fromNow()
                      }}
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <router-link
                          :to="'campaignEdit/?id=' + campaign.id"
                          class="btn btn-success"
                          >Edit</router-link
                        >

                        <button
                          class="btn btn-danger"
                          @click="deleteCampaign(campaign.id)"
                        >
                          Delete
                        </button>
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
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      campaigns: [],
      moment: moment,
    };
  },
  created() {
    fetch("api/campaigns")
      .then((response) => response.json())
      .then((res) => {
        this.campaigns = res;
      });
  },
  methods: {
    deleteCampaign(id) {
      fetch(`api/campaigns/${id}`, { method: "DELETE" }).then((response) => {
        let i = this.campaigns.map((data) => data.id).indexOf(id);
        this.campaigns.splice(i, 1);
      });
    },
  },
};
</script>
