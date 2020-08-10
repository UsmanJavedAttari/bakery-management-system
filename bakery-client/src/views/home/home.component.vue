<template>
  <div>
    <v-row class="header ma-0">
      <v-col cols="12" class="header-content app-bg-gradient pa-0 pb-12">
        <v-container class="px-10">
          <v-toolbar flat color="transparent" dark>
            <v-toolbar-title>
              <router-link to="/" class="white--text font-weight-bold">Bake'n Eat</router-link>
            </v-toolbar-title>
            <v-spacer />
            <div v-if="ApiAuth.SessionValue && ApiAuth.SessionValue.Id">
              <base-btn text color="white" small to="/account/profile">Profile</base-btn>
            </div>
            <div v-else>
              <base-btn text color="white" small class="mr-1" to="/login">Login</base-btn>
              <base-btn text color="white" small to="/signup">Signup</base-btn>
            </div>
          </v-toolbar>
          <v-row justify="center" align="center" style="height: 40em;">
            <v-col cols="12" md="6" class="text-center text-md-left">
              <h2 class="font-weight-light mb-5">
                The Shop where you find,
                <br />Fresh Bakery Products
              </h2>
              <p>
                <strong>Bake'n Eat</strong> is an ultimate Marketplace for small
                bakers, large bakery giants, sellers, buyers, consumers,
                cakeries, bakeries, bloggers, food lovers and everyone :)
              </p>
              <base-btn
                large
                color="white"
                elevation="0"
                class="font-weight-bold view-bakery-products-btn"
                outlined
                :to="{name: 'Products'}"
              >
                View Bakery Products
                <v-icon class="ml-1">mdi-arrow-right</v-icon>
              </base-btn>
            </v-col>
            <v-col>
              <img class="header-image" src="/assets/svgs/header.svg" />
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <v-container>
      <v-row class="ma-0">
        <v-col cols="12">
          <div>
            <h1 class="text-center primary--text">Get In Touch</h1>
            <p class="text-center">
              Please fill out the following form and we will get back to you
              shortly.
            </p>
          </div>
          <v-row>
            <v-col cols="12" md="4" order="12" order-md="1">
              <div v-for="(Detail, Index) in ContactDetails" :key="Index">
                <h5>{{ Detail.Title }}:</h5>
                <p>{{ Detail.Value }}</p>
              </div>
            </v-col>
            <v-col cols="12" md="8" order="1" order-md="12">
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field label="Your Name" outlined hide-details dense />
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field label="Your Email" outlined hide-details dense />
                </v-col>
                <v-col cols="12">
                  <v-text-field label="Your Subject" outlined hide-details dense />
                </v-col>
                <v-col cols="12">
                  <v-textarea label="Your Message" outlined hide-details dense />
                </v-col>
                <v-col cols="12">
                  <base-btn block elevation="0" class="app-bg-gradient" dark>
                    Send Message
                    <v-icon>mdi-telegram</v-icon>
                  </base-btn>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
    <v-footer id="core-footer" padless>
      <v-row class="blue-grey darken-4 white--text ma-0 text-center">
        <v-col cols="12" class="py-5">
          <strong>
            © {{ new Date().getFullYear() }}
            <router-link to="/">&nbsp;Bake'n Eat</router-link>
          </strong>
          <br />Design and coded by
          <strong dropzone>Usman Dev</strong>
        </v-col>
      </v-row>
    </v-footer>
  </div>
</template>

<script lang="ts" src="./home.component.ts" />

<style lang="scss">
.header {
  filter: drop-shadow(-1px 1px 2px rgba(0, 0, 0, 0.5));
  max-width: 100%;
  .header-content {
    max-width: 100%;
    clip-path: polygon(0 0, 100% 0, 100% 87%, 0 100%);
    color: #fff;
    @media screen and (max-width: 960px) {
      clip-path: polygon(0 0, 100% 0, 100% 95%, 0 100%);
    }
    .v-toolbar__content {
      @media screen and (max-width: 960px) {
        padding-left: 0px !important;
        padding-right: 0px !important;
      }
    }
    .view-bakery-products-btn {
      transition: all 0.3s ease-in-out;
      &:hover i {
        margin-left: 20px !important;
      }
    }
    .header-image {
      max-width: 100%;
      pointer-events: none;
      user-select: none;
    }
  }
}
</style>
