<template>
  <v-dialog persistent fullscreen transition="dialog-bottom-transition" :value="true">
    <v-card>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="$router.back()">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title>Payment</v-toolbar-title>
      </v-toolbar>
      <v-row justify="center" no-gutters class="mt-5">
        <v-col cols="12" md="8">
          <v-card class="big-shadow round-15 pa-5 pb-12" v-if="CartItems.length">
            <h3 class="text-center">Products</h3>
            <v-list dense nav class="pa-0 mb-5">
              <v-list-item
                link
                v-for="(cartItem, i) in CartItems"
                :key="i"
                v-ripple="{ class: `primary--text` }"
              >
                <div class="d-flex justify-space-between width-100 flex-wrap">
                  <div>
                    <v-icon color="primary" class="mt-n1 mr-1">mdi-package-variant</v-icon>
                    <span>
                      {{ cartItem.Product.Title }}
                      <span
                        class="primary--text"
                      >( {{ cartItem.Quantity }} )</span>
                    </span>
                  </div>
                  <span class="primary--text">
                    RS. {{ (+cartItem.Product.Price).toFixed(2) }} X
                    <span
                      class="font-weight-black"
                    >{{ cartItem.Quantity }}</span>
                    = RS. {{ (+cartItem.TotalCost).toFixed(2) }}
                  </span>
                </div>
              </v-list-item>
            </v-list>
            <div class="mb-5 text-right">
              Total Amount:
              <span class="primary--text">RS. {{ TotalAmount.toFixed(2) }}</span>
            </div>
            <div class="p-absolute width-100 px-5" style="bottom: 10px; right: 0px;">
              <base-form
                class="d-flex justify-space-between align-center"
                #default="{ invalid, validate }"
                @submit="CartItemService.checkout(PaymentAccount, $router)"
              >
                <base-select
                  @hook:mounted="validate('')"
                  :value.sync="PaymentAccount"
                  :items="PaymentAccounts"
                  item-text="PaymentCardNumber"
                  item-value="PaymentCardNumber"
                  placeholder="Select Payment Account"
                  hide-details
                  rules="required"
                />
                <base-btn :disabled="invalid" small type="submit">
                  Proceed
                  <v-icon class="ml-1" size="20">mdi-check-all</v-icon>
                </base-btn>
              </base-form>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-card>
  </v-dialog>
</template>

<script lang="ts" src="./payment.component.ts" />
