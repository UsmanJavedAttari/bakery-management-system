<template>
  <v-row justify="center">
    <v-col cols="12" md="8" v-for="(item, i) in PaymentInvoices" :key="i">
      <v-card class="big-shadow round-15 pa-5 pb-12 p-relative" id="print">
        <h1>Invoice # {{ item.Id }}</h1>
        <h3 class="text-center">Products</h3>
        <v-list dense nav class="pa-0 mb-3">
          <v-list-item
            v-for="(orderDetail, index) in item.OrderDetails"
            :key="index"
            link
            v-ripple="{ class: `primary--text` }"
          >
            <div class="d-flex justify-space-between align-center width-100">
              <div>
                <v-icon color="primary" class="mt-n1 mr-1">mdi-package-variant</v-icon>
                <span>
                  {{ orderDetail.Product.Title }}
                  <span
                    class="primary--text"
                  >( {{ orderDetail.Quantity }} )</span>
                </span>
              </div>
              <span class="primary--text">
                RS. {{ (+orderDetail.UnitPrice).toFixed(2) }} X
                <span
                  class="font-weight-black"
                >{{ orderDetail.Quantity }}</span>
                = RS. {{ (+orderDetail.TotalCost).toFixed(2) }}
              </span>
            </div>
          </v-list-item>
        </v-list>
        <div class="text-right">
          <div>
            Payment At:
            <span class="primary--text">{{ formatDate(item.GeneratedAt) }}</span>
          </div>
          <div>
            Payment Card Number:
            <span class="primary--text">{{ item.PaymentCardNumber }}</span>
          </div>
          <div>
            Total Amount:
            <span class="primary--text">RS. {{ (+item.AmountCharged).toFixed(2) }}</span>
          </div>
        </div>
        <base-btn class="p-absolute" style="bottom: 10px; right: 10px;" small @click="print">Print</base-btn>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts" src="./payment-invoices.component.ts" />

<style lang="scss">
@media print {
  body * {
    visibility: hidden;
  }
  #print {
    position: absolute;
    left: 0;
    top: 0;
    visibility: visible;
    * {
      visibility: visible;
    }
  }
}
</style>