<template>
  <div class="profile-page tx-13">
    <button
      class="btn btn-primary float-right"
      data-toggle="modal"
      data-target="#exampleModal"
    >
      Add Selected Leads To Manage Leads
    </button>
    <div class="row profile-body">
      <div class="col-lg-12 col-xl-12 middle-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin">
            <div class="card rounded">
              <div class="card-body">
                <h6>Find Active Small Business Leads</h6>
                <h6>And Places On Google Maps</h6>
                <br />
                <form class="forms-sample form-inline" action="">
                  <div class="row">
                    <div class="col">
                      <input
                        type="text"
                        id="search"
                        @click="initMap"
                        autocomplete="off"
                        placeholder="Business"
                        name="business_search"
                        class="form-control"
                      />
                      <!---->
                    </div>
                    <div id="map"></div>

                    <div class="col">
                      <input
                        type="text"
                        id="location_search"
                        autocomplete="off"
                        placeholder="Location"
                        name="location_search"
                        class="form-control"
                      />
                      <!---->
                    </div>
                  </div>
                  <div class="col">
                    <button
                      type="submit"
                      class="btn btn-primary btn-sm"
                      @click.prevent="initMap"
                    >
                      Search
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Add Leads To Manage Leads
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="campaign_id">Target Campaign</label>
              <select
                class="js-example-basic-single w-100"
                name="campaign_id"
                id="campaign_id"
              >
                <option v-for="campaign in campaigns" :key="campaign.id">
                  {{ campaign.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Add</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6" v-for="map in mapDetails" :key="map.id">
        <div class="card rounded mb-3">
          <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="ml-2">
                  <h6 class="d-inline-block">
                    {{ map.name }}
                  </h6>
                  <span class="badge badge-success">{{
                    map.business_status
                  }}</span>
                </div>
              </div>
              <input type="checkbox" name="" id="" />
            </div>
          </div>
          <div class="card-body">
            <button type="submit" class="btn btn-primary mr-2 float-right">
              Save Lead
            </button>
            <p class="mb-3 tx-14">
              {{ map.rating }} <b>Rating:</b
              ><star-rating
                :increment="0.5"
                :star-size="20"
                :disabled="true"
                :rating="map.rating"
              />
            </p>
            <p>
              <mail-icon
                size="1.1x"
                class="custom-class"
                style="color: #727cf5"
              ></mail-icon>
              <b> Email:</b>
              abc@gmail.com
            </p>
            <p>
              <b>
                <phone-call-icon
                  size="1.1x"
                  class="custom-class"
                  style="color: #727cf5"
                ></phone-call-icon>
                Telephone:</b
              >
              {{ map.phone_number }}
            </p>
            <p>
              <paperclip-icon
                size="1.1x"
                class="custom-class"
                style="color: #727cf5"
              ></paperclip-icon>
              <b>Website:</b> {{ map.website }}
            </p>
            <p>
              <map-pin-icon
                size="1.1x"
                class="custom-class"
                style="color: #727cf5"
              ></map-pin-icon>
              <b>Address:</b> {{ map.address }}
            </p>
            <p>
              <b>
                <image-icon
                  size="1.1x"
                  class="custom-class"
                  style="color: #727cf5"
                ></image-icon>
                GMB Photos:
              </b>
              <span v-if="map.photos"> {{ map.photos }} photos </span>
              <span v-else> No photos available </span>
            </p>
            <p>
              <file-text-icon
                size="1.1x"
                class="custom-class"
                style="color: #727cf5"
              ></file-text-icon>
              <b>Reviews:</b>
              {{ map.reviews ? map.reviews + " review" : "No reviews" }}
            </p>
            <!-- <p><b>Business Status:</b> {{ map.business_status }}</p> -->
            <!-- <img
                  class="img-fluid"
                  src="https://via.placeholder.com/513x342"
                  alt=""
                /> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import StarRating from "vue-star-rating";

import {
  MailIcon,
  PhoneCallIcon,
  PaperclipIcon,
  MapPinIcon,
  ImageIcon,
  FileTextIcon,
} from "vue-feather-icons";

export default {
  components: {
    StarRating,
    MailIcon,
    PhoneCallIcon,
    PaperclipIcon,
    MapPinIcon,
    ImageIcon,
    FileTextIcon,
  },
  data: () => ({
    mapDetails: [],
    campaigns: [],
  }),
  methods: {
    async leadCreate() {
      await this.form.post("/api/leads");
      this.$router.push({ name: "campaignLeadList" });
    },

    initMap() {
      // Default location
      var defaultLoc = { lat: 53.3808279, lng: -1.4708821 };

      // Center map on default location
      var map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLoc,
        zoom: 15,
      });

      // Link search input to UI element.
      var input = document.getElementById("search");
      var searchBox = new google.maps.places.SearchBox(input);
      var infowindow = new google.maps.InfoWindow();

      // Bias the SearchBox results towards current map's viewport.
      google.maps.event.addListener(map, "bounds_changed", function () {
        searchBox.setBounds(map.getBounds());
      });

      // Location entered into search box
      var markers = [];
      searchBox.addListener("places_changed", () => {
        // Set global list
        var list = [];
        // Get places
        var places = searchBox.getPlaces();
        if (places.length === 0) {
          return;
        }

        // Clear out old markers
        markers.forEach(function (marker) {
          marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(async (place) => {
          // Nothing found
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }

          // Icon
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25),
          };

          // Create a marker for each place.
          var marker = new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location,
          });

          // Place details
          var request = { reference: place.reference };
          var details = new google.maps.places.PlacesService(map);

          details.getDetails(request, (details, status) => {
            // console.log(this);
            // Add to object
            var obj = {
              name: place.name,
              address: place.formatted_address,
              website: "",
              phone_number: "",
              emails: "",
              business_status: "",
              latitude: "",
              longitude: "",
              rating: "",
              photos: "",
              reviews: "",
            };
            // E-Mails
            var emails = "";
            if (details != null) {
              if (details.website != null) {
                var emailList = [];
                $.get(
                  "https://api.hunter.io/v2/domain-search?api_key=" +
                    hunter_key +
                    "&domain=" +
                    details.website,
                  (data) => {
                    $.each(data.data.emails, function (index, value) {
                      emails +=
                        '<a href="mailto:' +
                        value.value +
                        '">' +
                        value.value +
                        "</a><br>";
                      emailList.push(value.value);
                    });
                  }
                );
                obj.website = details.website;
                obj.emails = emailList;
              }

              if (details.formatted_phone_number != null) {
                obj.phone_number = details.formatted_phone_number;
              }

              if (details.business_status != null) {
                obj.business_status = details.business_status;
              }

              if (details.rating != null) {
                obj.rating = details.rating;
              }

              if (details.photos != null) {
                obj.photos = details.photos.length;
              }
              if (details.reviews != null) {
                obj.reviews = details.reviews.length;
              }

              if (details.geometry.location.lat() != null) {
                obj.latitude = details.geometry.location.lat();
              }

              if (details.geometry.location.lng() != null) {
                obj.longitude = details.geometry.location.lng();
              }
              // console.log(details.geometry.location.lat());
              // console.log(details.geometry.location.lng());
            }
            // Push to master list
            list.push(obj);

            this.mapDetails = list;
            // If marker clicked
            google.maps.event.addListener(marker, "click", function () {
              // Set info bubble
              infowindow.setContent(
                "<div><h2>" +
                  place.name +
                  "</h2><br>" +
                  '<span class="title">Address</span><br>' +
                  place.formatted_address +
                  "<br><br>" +
                  (obj.phone_number === ""
                    ? ""
                    : '<span class="title">Phone Number</span><br>' +
                      obj.phone_number +
                      "<br><br>") +
                  (obj.website === ""
                    ? ""
                    : '<span class="title">Website</span><br><a target="_blank" href="' +
                      obj.website +
                      '" title="' +
                      obj.website +
                      '">' +
                      obj.website.substring(0, 50) +
                      "</a><br><br>") +
                  (emails.length > 0
                    ? '<span class="title">E-Mail(s)</span><br>' + emails
                    : "") +
                  "</div>"
              );
              infowindow.open(map, this);
            });
          });

          // Add to markers
          markers.push(marker);

          // Viewport
          if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });

        map.fitBounds(bounds);
      });
    },
  },
  created() {
    fetch("api/campaigns")
      .then((response) => response.json())
      .then((res) => {
        this.campaigns = res;
      });
  },
};
</script>
<style scoped>
.vue-star-rating-rating-text {
  display: none !important;
}
</style>