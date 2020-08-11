<template>
  <v-row justify="center">
    <v-col cols="12" md="8">
      <v-card class="big-shadow round-15 pa-5 p-relative">
        <h1>
          Hi
          <span class="font-weight-bold primary--text">{{ DisplayName }}!</span>
        </h1>
        <base-form #default="{ invalid }" @submit="updateProfile">
          <v-row dense>
            <v-col cols="12" md="6">
              <base-text-field
                :value.sync="DisplayName"
                label="Display Name"
                autofocus
                rules="required"
              />
            </v-col>
            <v-col cols="12" md="6">
              <base-text-field
                label="Password"
                type="password"
                rules="max:36|min:8"
                :value.sync="Password"
              />
            </v-col>
            <v-col cols="12">
              <base-btn :disabled="invalid" block type="submit">Update Profile</base-btn>
            </v-col>
          </v-row>
        </base-form>
      </v-card>
    </v-col>
    <v-col cols="12" md="8">
      <v-card class="big-shadow round-15 pa-5 pb-0">
        <h1 class="font-weight-bold primary--text">Payment Cards</h1>
        <v-list dense nav class="pa-0 mb-3">
          <v-list-item
            link v-for="(account, i) in PaymentAccounts"
            :key="i"
            v-ripple="{ class: `primary--text` }"
          >
            <v-list-item-action class="ma-0 mr-3">
              <v-icon color="primary">mdi-id-card</v-icon>
            </v-list-item-action>
            <v-list-item-content>{{ account.PaymentCardNumber }}</v-list-item-content>
            <v-list-item-action class="ma-0">
              <base-btn
                icon
                color="error"
                @click="UserService.removePaymentAccount(account.PaymentCardNumber)"
              >
                <v-icon>mdi-delete-outline</v-icon>
              </base-btn>
            </v-list-item-action>
          </v-list-item>
        </v-list>
        <base-form ref="paymentAccountFormRef" #default="{ invalid}" @submit="addPaymentAccount">
          <v-row dense>
            <v-col cols="10">
              <base-text-field
                label="Payment Card Number"
                :value.sync="PaymentCardNumber"
                rules="required|digits:8"
              />
            </v-col>
            <v-col cols="2" style="margin-top: 2px;">
              <base-btn :disabled="invalid" block type="submit">Add</base-btn>
            </v-col>
          </v-row>
        </base-form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts" src="./profile.component.ts" />
