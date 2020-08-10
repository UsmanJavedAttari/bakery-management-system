<template>
  <v-row justify="center" align="center">
    <v-col cols="12" md="4">
      <base-card>
        <div class="pa-5">
          <h1 class="mb-3 primary--text">Signup</h1>
          <base-form #default="{ invalid }" @submit="signup">
            <v-row dense>
              <v-col cols="12">
                <base-text-field
                  :value.sync="SignupData.DisplayName"
                  label="Display Name"
                  rules="required"
                  autofocus
                />
              </v-col>
              <v-col cols="12">
                <base-text-field
                  :value.sync="SignupData.Email"
                  label="Email"
                  rules="required|email"
                />
              </v-col>
              <v-col cols="12">
                <base-text-field
                  :value.sync="SignupData.Password"
                  label="Password"
                  type="password"
                  rules="required|min:8|max:36"
                />
              </v-col>
              <v-col cols="12">
                <base-text-field
                  :value.sync="SignupData.PaymentCardNumber"
                  label="Payment Card Number"
                  rules="required|digits:8"
                />
              </v-col>
              <v-col cols="12">
                <base-btn :disabled="invalid" block type="submit">Signup</base-btn>
              </v-col>
            </v-row>
          </base-form>
        </div>
        <p class="text-center">
          Already have an account?
          <router-link to="/login">Login</router-link>
        </p>
      </base-card>
    </v-col>
  </v-row>
</template>

<script lang="ts" src="./signup.component.ts" />
