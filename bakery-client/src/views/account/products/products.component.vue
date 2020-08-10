<template>
  <div>
    <div class="d-flex flex-wrap justify-center align-center">
      <base-text-field
        hide-details
        label="Search"
        full-width
        prepend-inner-icon="mdi-magnify"
        :outlined="false"
        class="width-100 mb-3"
        :value.sync="ProductService.Search"
      />
      <base-btn
        v-for="(item, i) in ProductCategories"
        :key="i"
        class="ma-2"
        small
        :outlined="ProductService.SelectedProductCategory !== item.Id"
        @click="ProductService.SelectedProductCategory = item.Id"
      >{{ item.Title }}</base-btn>
    </div>
    <v-row>
      <v-col cols="12" md="4" v-for="(product, i) in Products" :key="i">
        <v-card class="pa-3 app-bg-gradient big-shadow round-15" dark>
          <div class="d-flex justify-space-between align-center">
            <h2 class="no-select">{{ product.Title }}</h2>
            <base-tooltip #default="{on}" :msg="`Add to cart +RS. ${(+product.Price).toFixed(2)}`">
              <v-icon
                @click.stop="CartItemService.addToCart(product.Id, undefined, 'Product added to cart successfully!')"
                class="pa-1"
                v-on="on"
              >mdi-cart-plus</v-icon>
            </base-tooltip>
          </div>
          <v-card-text
            class="product-categories-details text-justify pr-0 pt-2"
          >{{ product.Description }}</v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script lang="ts" src="./products.component.ts" />

<style lang="scss" scoped>
.product-categories-details {
  overflow: scroll;
  color: rgba(0, 0, 0, 0) !important;
  text-shadow: 0 0 #fff;
  transition: color 0.4s ease-in-out;
  height: 100px;
  &:hover {
    color: rgba(255, 255, 255, 0.7) !important;
  }
  &::-webkit-scrollbar,
  &::-webkit-scrollbar-thumb {
    width: 26px !important;
    height: 0px;
    border-radius: 13px;
    background-clip: padding-box;
    border: 10px solid transparent;
  }
  &::-webkit-scrollbar-thumb {
    box-shadow: inset 0 0 0 10px;
  }
}
</style>