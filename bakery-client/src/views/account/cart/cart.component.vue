<template>
  <div class="fill-height">
    <v-row v-if="CartItems.length" style="padding-bottom: 60px;">
      <v-col cols="12" v-for="(item, i) in CartItems" :key="i">
        <v-card class="big-shadow round-15 app-bg-gradient" dark>
          <div class="pa-5 d-flex align-center justify-space-between">
            <div class="d-flex flex-column">
              <h2 class="no-select">{{ item.Product.Title }}</h2>
              <span>
                RS. {{ (+item.Product.Price).toFixed(2) }} X
                <span
                  class="font-weight-black"
                >{{ item.Quantity }}</span>
                = RS. {{ (+item.TotalCost).toFixed(2) }}
              </span>
            </div>
            <div class="d-flex align-center">
              <v-icon @click.stop="CartItemService.addToCart(item.Product.Id)">mdi-plus</v-icon>
              <h3 class="mx-2 no-select">{{ item.Quantity }}</h3>
              <v-icon @click.stop="CartItemService.addToCart(item.Product.Id, true)">mdi-minus</v-icon>
            </div>
            <base-btn text color="white" @click="CartItemService.removeItem(item.Product.Id)">
              <v-icon>mdi-delete-outline</v-icon>Remove
            </base-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <h1 class="font-weight-light text-center" v-else>Cart is empty</h1>
    <v-footer
      v-if="CartItems.length"
      :style="`padding-left: ${CoreService.DrawerMode ? '315px' : '15px'}`"
      fixed
      elevation="5"
      class="d-flex justify-end white py-3 white"
    >
      <v-slide-y-reverse-transition>
        <base-btn block v-if="true" :to="{name: 'Payment'}">
          Checkout
          <v-icon class="ml-3">mdi-arrow-right</v-icon>
        </base-btn>
      </v-slide-y-reverse-transition>
    </v-footer>
  </div>
</template>

<script lang="ts" src="./cart.component.ts" />
